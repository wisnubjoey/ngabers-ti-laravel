<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $upcomingEvents = Event::where('status', 'upcoming')  // Event dengan status 'upcoming'
                          ->orderBy('event_date')         // Urutkan berdasarkan tanggal
                          ->with(['user', 'participants']) // Load relasi
                          ->get();

        $pastEvents = Event::whereIn('status', ['ongoing', 'completed'])->orderByDesc('event_date')->with(['user', 'participants'])->get();
        return view('events.index', compact('upcomingEvents', 'pastEvents'));
    }

    public function create()
    {
        return view('events.create');

    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date|after:now',
            'estimated_end_date' => 'required|date|after:event_date',
            'meeting_point' => 'required|string',
            'destination' => 'required|string',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        $event = auth()->user()->events()->create($request->all());
        return redirect()->route('events.show', $event)->with('success', 'Event created successfully');
    }

    public function show(Event $event)
    {
        $event->load(['user', 'participants']);
        $isJoined = $event->isJoinedBy(auth()->user());
        $canJoin = $event->canBeJoined();
        
        return view('events.show', compact('event', 'isJoined', 'canJoin'));
    }

    public function toggleJoin(Event $event)
{
    \Log::info('Toggle join attempt', [
        'user_id' => auth()->id(),
        'event_id' => $event->id
    ]);

    if ($event->isJoinedBy(auth()->user())) {
        \Log::info('User leaving event');
        $event->participants()->detach(auth()->id());
        $message = 'Anda telah membatalkan keikutsertaan.';
    } else {
        if (!$event->canBeJoined()) {
            return back()->with('error', 'Event tidak dapat diikuti.');
        }
        
        \Log::info('User joining event');
        $event->participants()->attach(auth()->id());
        $message = 'Anda telah bergabung dengan event!';
    }

    \Log::info('Toggle completed');
    return back()->with('success', $message);
}

public function markAsComplete(Event $event)
{
    // Pastikan hanya creator yang bisa menandai selesai
    if (auth()->id() !== $event->user_id) {
        return back()->with('error', 'Hanya creator yang dapat menandai event selesai.');
    }

    $event->update(['status' => 'completed']);
        return back()->with('success', 'Event telah ditandai selesai!');
    }
}
