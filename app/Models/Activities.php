<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\PostStatusTrait;

class Activities extends Model
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

    public function getActivities($status){

        $activity = $this->getPostByStatus("Activities", $status);
        return $activity;
    }

    public function getActivitiesStatusCount()
    {
        $postStatusCount = $this->getPostStatusCount("Activities");
        return $postStatusCount;
    }


    public function getActivitySingle($id)
    {
        $event = Activities::find($id);
        return $event;
    }

    public function updateActivityItem($event)
    {
        $activityUpdate = Activities::where(
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

        if($activityUpdate)
        {
            return true;
        }
        else {
            return false;
        }
    }

    // Delete Activity
    public function deleteActivity($id)
    {
        $user = Activities::find($id);
        $user->delete();
    }

    // Restore Activity
    public function restoreActivity($id)
    {
        Activities::withTrashed()->find($id)->restore();
    }

    // Delete Permanently
    public function permanentlyDelete($id)
    {
        $event = Activities::withTrashed()->find($id);
        $event->forceDelete();        
    }
}
