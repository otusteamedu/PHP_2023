<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriberRequest;
use App\Models\EventType;
use App\Models\Subscriber;
use App\Services\SubscriberEventsProxy;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index()
    {
        return response()->json(Subscriber::all());
    }

    public function store(StoreSubscriberRequest $request)
    {
        $subscriber = Subscriber::create($request->all());
        $eventTypes = EventType::findMany($request->eventTypes);
        $subscriber->eventTypes()->attach($eventTypes);

        return response()->json($subscriber, 201);
    }

    public function show(Subscriber $subscriber)
    {
        return response()->json($subscriber);
    }

    public function update(Request $request, Subscriber $subscriber)
    {
        $subscriber->update($request->all());
        $subscriber->eventTypes()->sync($request->eventTypes);

        return response()->json($subscriber);
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return response()->json(null, 204);
    }

    public function events(Subscriber $subscriber, SubscriberEventsProxy $proxy)
    {
        return response()->json($proxy->getEvents()->toArray());
    }
}
