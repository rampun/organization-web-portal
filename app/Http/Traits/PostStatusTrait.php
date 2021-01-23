<?php

namespace App\Http\Traits;

use App\Models\Activities;

trait PostStatusTrait {
    
    public function getPostByStatus($model, $status='All', $orderBy='id'){

        $NamespacedModel = '\App\Models\\' . $model;
        switch ($status)
        {
            case "All":
                $postData = $NamespacedModel::orderBy($orderBy, 'desc')->get();
                break;
            case "Publish":
                $postData = $NamespacedModel::orderBy($orderBy, 'desc')->where('status',$status)->get();
                break;
            case "Draft":
                $postData = $NamespacedModel::orderBy($orderBy, 'desc')->where('status',$status)->get();
                break;
            case "Trash":
                $postData = $NamespacedModel::orderBy($orderBy, 'desc')->onlyTrashed()->get();
                break;
            default:
                $postData = $NamespacedModel::orderBy($orderBy, 'desc')->get();
                break;
        }
        return $postData;
    }

    public function getPostStatusCount($model)
    {
        $NamespacedModel = '\App\Models\\' . $model;
        $allCount = $NamespacedModel::count();
        $publishCount = $NamespacedModel::where('status','Publish')->count();
        $draftCount = $NamespacedModel::where('status','Draft')->count();
        $trashCount = $NamespacedModel::onlyTrashed()->count();
        
        $postStatusCount = [
            'All' => $allCount,
            'Publish' => $publishCount,
            'Draft' => $draftCount,
            'Trash' => $trashCount
        ];
        
        return $postStatusCount;
    }

    // public function getPublish($id)
    // {
    //     // fetch published events from DB
    //     $events = Event::where('status','Publish')->get();
    //     return $events;
    // }
}