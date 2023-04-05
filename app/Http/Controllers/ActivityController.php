<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Activities;
use Carbon\Carbon;

class ActivityController extends ApiController
{
    private $activities;

    public function __construct(Activities $activities)
    {
        $this->activities = $activities;
    }
    public function list(Request $request, $status = 'All')
    {
        $activities = $this->activities->getActivities($status);
        if ($request->wantsJson()) {
            $activities = $this->activities->getActivities('Publish');
            if (empty($activities)) {
                return $this->errorResponse('No Activities', 200);
            }
            return $this->successResponse($activities, 'Activity List', 200);
        }

        $activityCount = $this->activities->getActivitiesStatusCount();

        return view('activity.list', ['activityList' => $activities, 'status' => $status, 'activityCount' => $activityCount]);
    }

    public function create(Request $request)
    {
        return view('activity.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ], [
            'title.required' => 'Required',
            'description.required' => 'Required',
            'start_date.required' => 'Required',
            'end_date.required' => 'Required',
        ]);

        // save user meta
        $activity['title'] = $request->input('title');
        $activity['description'] = $request->input('description');
        $activity['start_date'] = Carbon::parse($request->input('start_date'))->format('Y-m-d H:i');
        $activity['end_date'] = Carbon::parse($request->input('end_date'))->format('Y-m-d H:i');
        $activity['status'] = $request->input('activity_status');

        // Member image handling
        if ($request->hasFile('photo')) {
            if ($request->file('photo')->isValid()) {
                $activity_photo_file_name = strval(str_replace(' ', '', time() . $request->input('start_date') . '.' . $request->photo->extension()));
                $request->photo->move(public_path('uploads/activities/'), $activity_photo_file_name);
                $activity['photo'] = url('/') . '/uploads/activities/' . $activity_photo_file_name;
            }
        }


        $newActivity = Activities::create($activity);
        if ($newActivity) {
            return redirect()->route('activity.list', 'All')->with('success', 'Activity created successfully.');;
        }
    }

    // Activities update
    public function update(Request $request, $id)
    {
        $activity = Activities::find($id);
        if (empty($activity)) {
            return redirect()->route('activity.list', 'All')->with('error', 'The activity doesnot exist.');
        }
        return view('activity.edit', ['activity' => $activity]);
    }

    // Activities Store after update
    public function updateActivity(Request $request)
    {
        $activityId = $request->input('id');
        $activity['id'] = $activityId;
        $activity['title'] = $request->input('title');
        $activity['description'] = $request->input('description');
        $activity['start_date'] = $request->input('start_date');
        $activity['end_date'] = $request->input('end_date');
        $activity['status'] = $request->input('activity_status');

        // Activities Image Handling
        if ($request->hasFile('photo')) {
            if ($request->file('photo')->isValid()) {
                $activity_photo_file_name = strval(str_replace(' ', '', time() . $request->input('start_date') . '.' . $request->photo->extension()));
                $request->photo->move(public_path('uploads/activities/'), $activity_photo_file_name);
                $activity['photo'] = url('/') . '/uploads/activities/' . $activity_photo_file_name;
            }
        } else {
            $singleActivities = $this->activities->getActivitySingle($activityId);
            $activity['photo'] = $singleActivities->photo;
        }
        $updateSingleActivity =  $this->activities->updateActivityItem($activity);
        if ($updateSingleActivity) {
            return redirect()->route('activity.list', 'All')->with('success', 'Activity updated successfully.');;
        }
    }

    // Activities Detail Page
    public function detail(Request $request, $id)
    {
        $activity = Activities::find($id);

        if ($request->wantsJson()) {
            if (empty($activity)) {
                return $this->errorResponse('Not Found', 404);
            }
            return $this->successResponse($activity, 'Activity Detail', 200);
        }
        return view('activity.detail', ['activity' => $activity]);
    }

    // Delete Activities
    public function delete(Request $request, $id)
    {
        $this->activities->deleteActivity($id);
        return redirect()->route('activity.list', 'All')->with('success', 'Activity deleted successfully.');
    }

    // restore Activity
    public function restore(Request $request, $id)
    {
        $this->activities->restoreActivity($id);
        return redirect()->route('activity.list', 'All')->with('success', 'Activity restored successfully.');
    }

    // permanently delete Activity
    public function permanentlyDelete(Request $request, $id)
    {
        $this->activities->permanentlyDelete($id);
        return redirect()->route('activity.list', 'All')->with('success', 'Activity deleted permanently.');
    }
}
