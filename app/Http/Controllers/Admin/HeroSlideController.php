<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Support\MediaUploader;
use Illuminate\Http\Request;

class HeroSlideController extends Controller
{
    public function index()
    {
        return view('admin.hero.index', [
            'items' => HeroSlide::orderByDesc('id')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.hero.form', ['item' => new HeroSlide]);
    }

    public function store(Request $request)
    {
        HeroSlide::create($this->payload($request));

        return redirect()->route('admin.hero.index')->with('success', 'Hero slide created.');
    }

    public function edit(HeroSlide $hero)
    {
        return view('admin.hero.form', ['item' => $hero]);
    }

    public function update(Request $request, HeroSlide $hero)
    {
        $hero->update($this->payload($request, $hero));

        return redirect()->route('admin.hero.index')->with('success', 'Hero slide updated.');
    }

    public function destroy(HeroSlide $hero)
    {
        $hero->delete();

        return back()->with('success', 'Hero slide deleted.');
    }

    protected function payload(Request $request, ?HeroSlide $hero = null): array
    {
        $data = $request->validate([
            'eyebrow' => ['nullable', 'string', 'max:180'],
            'title' => ['required', 'string', 'max:180'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'button_one_label' => ['nullable', 'string', 'max:80'],
            'button_one_url' => ['nullable', 'string', 'max:255'],
            'button_two_label' => ['nullable', 'string', 'max:80'],
            'button_two_url' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:8192'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        if ($request->hasFile('image')) {
            $data['image'] = MediaUploader::store($request->file('image'), 'hero');
        } elseif ($hero) {
            unset($data['image']);
        }

        return $data;
    }
}
