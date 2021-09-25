<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends ApiController
{
    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;   
    }
    public function list(Request $request, $status='All')
    {
        $events = $this->event->getEvents($status);
        if($request->wantsJson())
        {
            $events = $this->event->getEvents('Publish');
            if(empty($events))
            {
                return $this->errorResponse('No Events', 200);
            }
            return $this->successResponse($events, 'Events List', 200);
        }

        $eventCount = $this->event->getEventStatusCount();

        return view('event.list', ['events'=> $events, 'status'=>$status, 'eventCount'=> $eventCount]);
    }

    public function create(Request $request)
    {
        return view('event.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'location' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ], [
            'title.required' => 'Required',
            'location.required' => 'Required',
            'description.required' => 'Required',
            'start_date.required' => 'Required',
            'end_date.required' => 'Required',
        ]);

              // save user meta
            $event['title'] = $request->input('title');
            $event['location'] = $request->input('location');
            $event['description'] = $request->input('description');
            $event['start_date'] = Carbon::parse($request->input('start_date'))->format('Y-m-d H:i');
            $event['end_date'] = Carbon::parse($request->input('end_date'))->format('Y-m-d H:i');
            $event['status'] = $request->input('event_status');

            // Member image handling
            if ($request->hasFile('photo')) {
                if ($request->file('photo')->isValid()) {
                    $event_photo_file_name = strval(str_replace(' ', '', time() . $request->input('start_date').'.'.$request->photo->extension()));
                    $request->photo->move(public_path('uploads/events/'), $event_photo_file_name);
                    $event['photo'] = url('/').'/uploads/events/'.$event_photo_file_name;
                }
            }


            $newEvent = Event::create($event);
            if($newEvent)
            {
                return redirect()->route('event.list', 'All')->with('success', 'Event created successfully.');;
            }
    }

    // Event update
    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        if(!empty($event))
        {
            return view('event.edit',['event'=>$event]);
        }
        else {
            return redirect()->route('event.list','All')->with('error', 'The event doesnot exist.');
        }
    }

    // Event Store after update
    public function updateEvent(Request $request)
    {
        $eventId = $request->input('id');
        $event['id'] = $eventId;
        $event['title'] = $request->input('title');
        $event['location'] = $request->input('location');
        $event['description'] = $request->input('description');
        $event['start_date'] = $request->input('start_date');
        $event['end_date'] = $request->input('end_date');
        $event['status'] = $request->input('event_status');

        // Event Image Handling
        if ($request->hasFile('photo')) {
            if ($request->file('photo')->isValid()) {
                $event_photo_file_name = strval(str_replace(' ', '',time() . $request->input('start_date').'.'.$request->photo->extension()));
                $request->photo->move(public_path('uploads/events/'), $event_photo_file_name);
                $event['photo'] = url('/').'/uploads/events/'.$event_photo_file_name;
            }
        }
        else {
            $singleEvent = $this->event->getEventSingle($eventId);
            $event['photo'] = $singleEvent->photo;
        }

       $updateEvent =  $this->event->updateEventItem($event);
       if($updateEvent)
       {
        return redirect()->route('event.list','All')->with('success', 'Event Updated successfully.');
       }
    }

    // Event Detail Page
    public function detail(Request $request, $id)
    {
        $event = Event::find($id);

        if($request->wantsJson())
        {
            if(empty($event))
            {
                return $this->errorResponse('Not Found', 404);
            }
            return $this->successResponse($event, 'Event Detail', 200);
        }
        return view('event.detail',['event'=>$event]);
    }

    // Delete Event
    public function delete(Request $request, $id)
    {
        $this->event->deleteEvent($id);
        return redirect()->route('event.list','All')->with('success', 'Event deleted successfully.');
    }

    // restore Event
    public function restore(Request $request, $id)
    {
        $this->event->restoreEvent($id);
        return redirect()->route('event.list','All')->with('success', 'Event restored successfully.');
    }

    // permanently delete Event
    public function permanentlyDelete(Request $request, $id)
    {
        $this->event->permanentlyDelete($id);
        return redirect()->route('event.list','All')->with('success', 'Event deleted permanently.');
    }
}
