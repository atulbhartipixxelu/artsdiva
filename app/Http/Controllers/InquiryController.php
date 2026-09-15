<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Support\ArtworkRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function create(Request $request, ArtworkRepository $repo)
    {
        $prefillSlug = $request->query('artwork');
        $artwork = $prefillSlug ? $repo->findBySlug($prefillSlug) : null;

        return view('inquiry.create', [
            'artworks' => $repo->all(),
            'selectedArtwork' => $artwork,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:40'],
            'artwork' => ['required', 'string', 'max:180'],
            'lease_duration' => ['required', 'string', 'max:80'],
            'budget_range' => ['required', 'string', 'max:80'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        Inquiry::create($data + ['status' => 'new']);

        $to = config('artsdiva.inquiry_email');

        try {
            Mail::raw($this->buildBody($data), function ($message) use ($to, $data) {
                $message->to($to)
                    ->subject('ArtsDiva Leasing Inquiry — '.$data['name'])
                    ->replyTo($data['email'], $data['name']);
            });
        } catch (\Throwable $e) {
            Log::warning('Inquiry mail failed: '.$e->getMessage(), $data);
        }

        return redirect()
            ->route('inquiry.confirmation')
            ->with('inquiry', $data);
    }

    public function confirmation()
    {
        if (! session()->has('inquiry')) {
            return redirect()->route('inquiry.create');
        }

        return view('inquiry.confirmation', [
            'inquiry' => session('inquiry'),
        ]);
    }

    protected function buildBody(array $data): string
    {
        return implode("\n", [
            'New ArtsDiva leasing inquiry',
            '---------------------------',
            'Name: '.$data['name'],
            'Email: '.$data['email'],
            'Phone: '.($data['phone'] ?: '—'),
            'Artwork of interest: '.$data['artwork'],
            'Desired lease duration: '.$data['lease_duration'],
            'Budget range: '.$data['budget_range'],
            'Message: '.($data['message'] ?: '—'),
        ]);
    }
}
