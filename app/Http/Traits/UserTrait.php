<?php

namespace App\Http\Traits;
use App\Models\User;
use App\Models\UserMeta;

trait UserTrait {
    public function index(){
        // fetch all the users from DB
        $users = User::all();
        return $users;
    }

    public function getUser($id)
    {
        // fetch singl user from DB
        $user = User::find($id);

        $member_detail = [];

        $member_info = UserMeta::where('user_id', $id)->first();
        $member_detail['id'] = $user->id;
        $member_detail['name'] = $user->name;
        $member_detail['email'] = $user->email;
        $member_detail['member_photo'] = $member_info->member_photo;
        $member_detail['mobile_no'] = $member_info->mobile_no;

        return $member_detail;
    }
}