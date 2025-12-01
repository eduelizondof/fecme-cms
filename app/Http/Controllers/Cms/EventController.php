<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EventController extends Controller
{
    public function index(): Response
    {
        $events = Event::query()
            ->orderBy('start_date')
            ->orderBy('sort_order')
            ->paginate(15);

        return Inertia::render('cms/events/Index', [
            'events' => $events,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('cms/events/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:events,slug',
            'type' => 'nullable|string|max:100',
            'image' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|string|max:10',
            'end_time' => 'nullable|string|max:10',
            'location' => 'nullable|array',
            'organizer' => 'nullable|string|max:255',
            'judges' => 'nullable|array',
            'breeds' => 'nullable|array',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'requirements' => 'nullable|array',
            'inscription_info' => 'nullable|array',
            'myths' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        Event::create($validated);

        return redirect()->route('cms.events.index')
            ->with('success', 'Evento creado correctamente.');
    }

    public function edit(Event $event): Response
    {
        return Inertia::render('cms/events/Edit', [
            'event' => $event,
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:events,slug,' . $event->id,
            'type' => 'nullable|string|max:100',
            'image' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|string|max:10',
            'end_time' => 'nullable|string|max:10',
            'location' => 'nullable|array',
            'organizer' => 'nullable|string|max:255',
            'judges' => 'nullable|array',
            'breeds' => 'nullable|array',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'requirements' => 'nullable|array',
            'inscription_info' => 'nullable|array',
            'myths' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $event->update($validated);

        return redirect()->route('cms.events.index')
            ->with('success', 'Evento actualizado correctamente.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('cms.events.index')
            ->with('success', 'Evento eliminado correctamente.');
    }
}


