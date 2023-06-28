<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
use App\Models\EventType;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return response()->json(Event::all());
    }

    public function store(StoreEventRequest $request)
    {
        $event = new Event($request->validated());
        $eventType = EventType::find($request->event_type_id);
        $event->type()->associate($eventType);
        $event->save();

        return response()->json($event, 201);
    }

    public function show(Event $event)
    {
        return response()->json($event, 200);
    }

    public function update(Request $request, Event $event)
    {
        $event->update($request->all());

        return response()->json($event, 200);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json(null, 204);
    }
}
