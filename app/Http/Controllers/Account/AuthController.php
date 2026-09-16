<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('account.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Invalid email or password.']);
        }

        $request->session()->regenerate();

        $user = Auth::user();
        if (! $user->isCustomer() || ! $user->is_active) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'This account cannot access the customer dashboard. Use admin login if you are staff.',
            ]);
        }

        return redirect()->intended(route('account.dashboard'));
    }

    public function showRegister()
    {
        return view('account.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => ['nullable', 'string', 'max:40'],
            'city' => ['nullable', 'string', 'max:120'],
            'purchased_art_before' => ['nullable', 'in:yes,no'],
            'admired_artists' => ['nullable', 'string', 'max:2000'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone'] ?? null,
            'city' => $data['city'] ?? null,
            'purchased_art_before' => $data['purchased_art_before'] ?? null,
            'admired_artists' => $data['admired_artists'] ?? null,
            'role' => User::ROLE_CUSTOMER,
            'is_active' => true,
        ]);

        $this->notifySignupTeam($user, $data);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('account.dashboard')
            ->with('success', 'Account created. Welcome to ArtsDiva.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    protected function notifySignupTeam(User $user, array $data): void
    {
        $recipients = config('artsdiva.signup_notify_emails', []);
        if ($recipients === []) {
            return;
        }

        $purchased = match ($data['purchased_art_before'] ?? null) {
            'yes' => 'Yes',
            'no' => 'No',
            default => '— (skipped)',
        };

        $body = implode("\n", [
            'New ArtsDiva collector signup',
            '----------------------------',
            'Name: '.$user->name,
            'Email: '.$user->email,
            'Phone: '.($user->phone ?: '—'),
            'City: '.($user->city ?: '— (skipped)'),
            'Purchased art before: '.$purchased,
            'Artists admired: '.(($data['admired_artists'] ?? '') !== '' ? $data['admired_artists'] : '— (skipped)'),
            'User ID: '.$user->id,
            'Signed up at: '.$user->created_at,
        ]);

        try {
            Mail::raw($body, function ($message) use ($recipients, $user) {
                $message->to($recipients)
                    ->subject('ArtsDiva signup — '.$user->name)
                    ->replyTo($user->email, $user->name);
            });
        } catch (\Throwable $e) {
            Log::warning('Signup notify mail failed: '.$e->getMessage(), [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
        }
    }
}
