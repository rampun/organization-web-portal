<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;
use Response;

class ProfileController extends ApiController
{
    use UserTrait;

    public function update()
    {
        $user = auth()->user();

        $userDetail = $this->getUser($user->id);

        return view('profile.edit')->with('userDetail', $userDetail);
    }

    public function changePassword(Request $request)
    {
        $userId = $request->input('userId');
        $currentPassword = $request->input('currentPassword');
        $newPassord1 = $request->input('newPassord1');
        $newPassord2 = $request->input('newPassord2');

        // get current password
        $user = User::find($userId);
        if(Hash::check( $currentPassword, $user->password )){
            if($newPassord1 != $newPassord2)
            {
                if ($request->wantsJson()) {
                    return $this->errorResponse('Password donot match', 404);
                }
                else 
                {
                    return back()->with('error', 'Passwords donot match')->withInput();
                }
            }
            else {
                User::where('id', $userId)
                    ->update([
                            'password' => bcrypt($newPassord1)
                        ]);

                if ($request->wantsJson())
                {
                    return $this->successResponse('Password updated', 200);
                }
                else 
                {
                    return back()->with('success', 'Password updated');
                }
            }
        }
        else {
            if ($request->wantsJson())
            {
                return $this->errorResponse('Incorrect Old Password', 200);
            }
            else 
            {
                return back()->with('error', 'Incorrect Old Password')->withInput();
            }
        }
    }

    // public function changeProfilePic(Request $request)
    // {

    // }
}
