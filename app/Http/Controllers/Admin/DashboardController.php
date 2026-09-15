<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Artwork;
use App\Models\Event;
use App\Models\Exhibition;
use App\Models\Inquiry;
use App\Models\NewsPost;
use App\Models\Publication;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'stats' => [
                'artworks' => Artwork::count(),
                'artists' => Artist::count(),
                'events' => Event::count(),
                'exhibitions' => Exhibition::count(),
                'news' => NewsPost::count(),
                'publications' => Publication::count(),
                'inquiries' => Inquiry::where('status', 'new')->count(),
                'admins' => User::whereIn('role', ['admin', 'superadmin'])->count(),
            ],
            'recentInquiries' => Inquiry::latest()->take(5)->get(),
        ]);
    }
}
