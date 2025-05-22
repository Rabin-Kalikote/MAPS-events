<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Event::query();
        if ($search) {
            $query->where('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
        }
        $events = $query->orderBy('date')->get()->groupBy('status');
        return view('events.index', compact('events', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'thumbnail' => 'nullable|string',
            'thumbnail_upload' => 'nullable|image|max:2048',
            'title' => 'required|string',
            'description' => 'required|string',
            'location_x' => 'required|integer',
            'location_y' => 'required|integer',
            'date' => 'required|date',
            'status' => 'required|in:upcoming,happened,cancelled',
        ]);

        // Handle file upload
        if ($request->hasFile('thumbnail_upload')) {
            $path = $request->file('thumbnail_upload')->store('thumbnails', 'public');
            $validated['thumbnail'] = '/storage/' . $path;
        }

        Event::create($validated);
        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(['admin_password' => 'required|string']);
        if ($request->admin_password !== 'mapsadmin123') {
            return back()->withErrors(['admin_password' => 'Incorrect admin password.']);
        }
        $validated = $request->validate([
            'thumbnail' => 'nullable|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'location_x' => 'required|integer',
            'location_y' => 'required|integer',
            'date' => 'required|date',
            'status' => 'required|in:upcoming,happened,cancelled',
        ]);
        $event = Event::findOrFail($id);
        $event->update($validated);
        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $request->validate(['admin_password' => 'required|string']);
        if ($request->admin_password !== 'mapsadmin123') {
            return back()->withErrors(['admin_password' => 'Incorrect admin password.']);
        }
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
