<?php

namespace App\Http\Controllers;

use App\Models\Page;

class PageViewController extends Controller
{
    public function show(string $slug = 'about')
    {
        $page = Page::published()->where('slug', $slug)->firstOrFail();

        return view('pages.dynamic', compact('page'));
    }
}
