<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\PostStatusTrait;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;
    use PostStatusTrait;


     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'photo',
        'start_date',
        'end_date',
        'status'
    ];

    public function getEvents($status){
        $events = $this->getPostByStatus("Event", $status);
        return $events;
    }

    public function getEventStatusCount()
    {
        $postStatusCount = $this->getPostStatusCount("Event");
        return $postStatusCount;
    }

    public function getEventSingle($id)
    {
        $event = Event::find($id);
        return $event;
    }

    public function updateEventItem($event)
    {
        $eventUpdate = Event::where(
            'id', $event['id']
        )
        ->update([
            'title' => $event['title'],
            'description' => $event['description'],
            'photo' => $event['photo'],
            'start_date' => $event['start_date'],
            'end_date' => $event['end_date'],
            'status' => $event['status']
        ]);

        if($eventUpdate)
        {
            return true;
        }
        else {
            return false;
        }
    }

    // Soft Delete Event
    public function deleteEvent($id)
    {
        $event = Event::find($id);
        $event->delete();
    }

    // Restore Event
    public function restoreEvent($id)
    {
        Event::withTrashed()->find($id)->restore();
    }

    // Delete Permanently
    public function permanentlyDelete($id)
    {
        $event = Event::withTrashed()->find($id);
        $event->forceDelete();        
    }
}
