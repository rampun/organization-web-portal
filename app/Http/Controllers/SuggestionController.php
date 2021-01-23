<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Suggestion;

class SuggestionController extends ApiController
{
    public function create(Request $request)
    {
        if(empty($request->input('description')))
        {
            return $this->errorResponse('Please fill in suggestion', 404);
        }
        else {
            $suggestion['description'] = $request->input('description');
            $newSuggestion = Suggestion::create($suggestion);
            if(!$newSuggestion)
            {
                return $this->errorResponse('Suggestion not added', 404);
            }
            return $this->successResponse('', 'Suggestion added successfully', 200);
        }
    }

    public function list(Request $request)
    {
        $suggestions = Suggestion::orderBy('id', 'desc')->get();
        return view('suggestion.list')->with('suggestions', $suggestions);
    }

    // Suggestion Update - markRead
    public function markReadUnread(Request $request, $id, $action)
    {
        if($action == 'read')
        {
            $updateSuggestion = Suggestion::where('id', $id) 
            ->update([
                'status' => 'Read',
            ]);
            if($updateSuggestion)
            {
                return back()->with('success', 'Suggestion marked as Read successfully.');
            }
        }
        else if ($action == 'unread')
        {
            $updateSuggestion = Suggestion::where('id', $id) 
            ->update([
                'status' => 'Unread',
            ]);
            if($updateSuggestion)
            {
                return back()->with('success', 'Suggestion marked as Unread successfully.');
            }
        }
    }
}
