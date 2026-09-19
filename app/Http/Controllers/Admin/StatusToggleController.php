<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Artwork;
use App\Models\Event;
use App\Models\Exhibition;
use App\Models\HeroSlide;
use App\Models\NewsPost;
use App\Models\Page;
use App\Models\Publication;
use App\Models\User;
use Illuminate\Http\Request;

class StatusToggleController extends Controller
{
    protected array $map = [
        'artworks' => [Artwork::class, 'is_published', 'Artwork published'],
        'artwork-visibility' => [Artwork::class, 'is_visible', 'Artwork visibility'],
        'artists' => [Artist::class, 'is_published', 'Artist'],
        'hero' => [HeroSlide::class, 'is_published', 'Hero slide'],
        'exhibitions' => [Exhibition::class, 'is_published', 'Exhibition'],
        'events' => [Event::class, 'is_published', 'Event'],
        'news' => [NewsPost::class, 'is_published', 'News post'],
        'publications' => [Publication::class, 'is_published', 'Publication'],
        'pages' => [Page::class, 'is_published', 'Page'],
        'users' => [User::class, 'is_active', 'User'],
    ];

    public function __invoke(Request $request, string $type, int $id)
    {
        abort_unless(isset($this->map[$type]), 404);

        if ($type === 'users' && ! $request->user()?->isSuperAdmin()) {
            abort(403);
        }

        [$class, $field, $label] = $this->map[$type];
        $item = $class::query()->findOrFail($id);

        if ($type === 'users' && (int) $item->id === (int) $request->user()->id) {
            return back()->withErrors(['user' => 'You cannot deactivate your own account.']);
        }

        $item->{$field} = ! (bool) $item->{$field};
        $item->save();

        $state = $item->{$field} ? 'activated' : 'deactivated';

        return back()->with('success', $label.' '.$state.'. Inactive items stay hidden on the frontend.');
    }
}
