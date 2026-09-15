<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Support\MediaUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        return view('admin.events.index', [
            'items' => Event::orderByDesc('id')->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.events.form', ['item' => new Event]);
    }

    public function store(Request $request)
    {
        Event::create($this->payload($request));

        return redirect()->route('admin.events.index')->with('success', 'Event created.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.form', ['item' => $event]);
    }

    public function update(Request $request, Event $event)
    {
        $event->update($this->payload($request, $event));

        return redirect()->route('admin.events.index')->with('success', 'Event updated.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return back()->with('success', 'Event deleted.');
    }

    protected function payload(Request $request, ?Event $event = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:180'],
            'tags' => ['nullable', 'string', 'max:255'],
            'date_label' => ['nullable', 'string', 'max:120'],
            'time_label' => ['nullable', 'string', 'max:120'],
            'location' => ['nullable', 'string', 'max:180'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
        $data['slug'] = Str::slug($data['slug'] ?: $data['title']);
        $data['tags'] = collect(explode(',', (string) ($data['tags'] ?? '')))
            ->map(fn ($t) => trim($t))
            ->filter()
            ->values()
            ->all();
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        if ($request->hasFile('image')) {
            $data['image'] = MediaUploader::store($request->file('image'), 'events');
        } elseif ($event) {
            unset($data['image']);
        }

        return $data;
    }
}
