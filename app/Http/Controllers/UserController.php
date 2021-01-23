<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\ChildrenMeta;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends ApiController
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function list(Request $request)
    {
        $members = $this->user->getMembers();
        $familyNames = $this->user->getAllFamilyName();
        $districtNp = $this->user->getNepalDistrict();
        $districtHk = $this->user->getHkDistrict();
        $jobs = $this->user->getAllJobs();

        // return response as JSON
        if ($request->wantsJson()) {
            $data = [
                'members' => $members,
                'filters' => [
                    'familyName' => $familyNames,
                    'districtNp' => $districtNp,
                    'districtHk' => $districtHk,
                    'jobs' => $jobs
                ]
            ];
            return $this->successResponse($data, 'Members List', 200);
        }
        return view('user.member-list', ['members_detail' => $members, 'familyNames' => $familyNames, 'districtNp' => $districtNp, 'districtHk' => $districtHk, 'jobs' => $jobs]);
    }

    public function create(Request $request)
    {
        // if($request->method() == 'GET')
        // {
        // }
        // else if($request->method() == 'POST')
        // {
        // }

        // read json file from storage > public
        $np_exists = Storage::disk('public')->exists('np_en.json');
        $np_province = [];
        if ($np_exists) {
            $contents = Storage::disk('public')->get('np_en.json');
            $np_province = json_decode($contents, true);
        }

        $hk_exists = Storage::disk('public')->exists('hk_en.json');
        $hk_regions = [];
        if ($hk_exists) {
            $contents = Storage::disk('public')->get('hk_en.json');
            $hk_regions = json_decode($contents, true);
        }

        return view('user.create', ['hk_regions' => $hk_regions, 'np_provinces' => $np_province]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'membership_type' => 'required',
            'membership_no' => 'required',
            'issue_date' => 'required',
            // 'family_name' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            // 'address_np' => 'required',
            // 'province_np' => 'required',
            // 'district_np' => 'required',
            // 'address_hk' => 'required',
            // 'district_hk' => 'required',
            // 'region_hk' => 'required',
            'document_type' => 'required',
            'document_no' => 'required',
            // 'mobile_no' => 'required',
            // 'member_photo' => 'file|mimes:jpg,jpeg,bmp,png',
        ], [
            'membership_type.required' => 'Required',
            'membership_no.required' => 'Required',
            'issue_date.required' => 'Required',
            // 'family_name.required' => 'Required',
            'name.required' => 'Required',
            'email.required' => 'Required',
            // 'address_np.required' => 'Required',
            // 'province_np.required' => 'Required',
            // 'district_np.required' => 'Required',
            // 'address_hk.required' => 'Required',
            // 'district_hk.required' => 'Required',
            // 'region_hk.required' => 'Required',
            'document_type.required' => 'Required',
            'document_no.required' => 'Required',
            // 'mobile_no.required' => 'Required',
        ]);

        // if($validatedData['password1'] != $validatedData['password2'])
        // {
        //     return back()->with('error', 'Password donot match')->withInput();
        // }

        $user_data['name'] = $validatedData['name'];
        $user_data['email'] = $validatedData['email'];
        $user_data['password'] = bcrypt(preg_replace('/[^A-Za-z0-9-]/', '', $validatedData['document_no']));

        // Add data to User table
        $user = User::create($user_data);

        // if user is saved; then save the usermetas
        if ($user) {
            // save user meta
            $user_meta['user_id'] = $user->id;
            $user_meta['membership_type'] = $request->input('membership_type');
            $user_meta['membership_no'] = $request->input('membership_no');
            $user_meta['issue_date'] = $request->input('issue_date');
            $user_meta['expiry_date'] = $request->input('expiry_date');
            $user_meta['family_name'] = $request->input('family_name');
            $user_meta['address_np'] = $request->input('address_np');
            $user_meta['province_np'] = $request->input('province_np');
            $user_meta['district_np'] = $request->input('district_np');
            $user_meta['address_hk'] = $request->input('address_hk');
            $user_meta['district_hk'] = $request->input('district_hk');
            $user_meta['region_hk'] = $request->input('region_hk');
            $user_meta['document_type'] = $request->input('document_type');
            $user_meta['document_no'] = Crypt::encryptString($request->input('document_no'));
            $user_meta['mobile_no'] = $request->input('mobile_no');
            $user_meta['telephone_no'] = $request->input('telephone_no');
            $user_meta['spouse_name'] = $request->input('spouse_name');
            $user_meta['job'] = $request->input('job');

            // Member image handling
            if ($request->hasFile('member_photo')) {
                if ($request->file('member_photo')->isValid()) {
                    $member_photo_fileName = time() . '_id_' . $user->id . '.' . $request->member_photo->extension();
                    $request->member_photo->move(public_path('uploads/members/' . $user->id), $member_photo_fileName);
                    $user_meta['member_photo'] = '/uploads/members/' . $user->id . '/' . strval($member_photo_fileName);
                }
            }


            // Member spouse image handling
            if ($request->hasFile('spouse_photo')) {
                if ($request->file('spouse_photo')->isValid()) {
                    $spouse_photo_fileName = time() . '_spouse_of_' . $user->id . '.' . $request->spouse_photo->extension();
                    $request->spouse_photo->move(public_path('uploads/members/' . $user->id), $spouse_photo_fileName);
                    $user_meta['spouse_photo'] = '/uploads/members/' . $user->id . '/' . strval($spouse_photo_fileName);
                }
            }


            // check the proper date of issue and expiry(if not empty)
            $date_dif = 1;
            if (!empty($user_meta['expiry_date'])) {
                $issue_date = date_create($user_meta['issue_date']);
                $expiry_date = date_create($user_meta['expiry_date']);
                $date_dif = date_diff($issue_date, $expiry_date);
                $date_dif = intval($date_dif->format("%R%a"));
            }

            //  check if expiry date is greater than issue date
            if ($date_dif > 0) {
                // Add data to User Meta table
                $user_info = UserMeta::create($user_meta);
                if ($user_info) {

                    // create children array
                    $children_data = [];
                    for ($i = 1; $i <= 3; $i++) {
                        // initiate empty variable
                        $child_photo_file_name = '';
                        // getting child photo file name here
                        $request_child_file_name = 'child_' . $i . '_photo';
                        if ($request->hasFile($request_child_file_name)) {
                            if ($request->file($request_child_file_name)->isValid()) {
                                $child_photo_fileName = time() . '_child_' . $i . '_of_' . $user->id . '.' . $request->$request_child_file_name->extension();
                                $request->$request_child_file_name->move(public_path('uploads/members/' . $user->id), $child_photo_fileName);
                                $child_photo_file_name = '/uploads/members/' . $user->id . '/' . strval($child_photo_fileName);
                            }
                        }

                        $child = [
                            'full_name' => $request->input('child_' . $i . '_name'),
                            'dob' => $request->input('child_' . $i . '_dob'),
                            'gender' => $request->input('child_' . $i . '_gender'),
                            'photo' => $child_photo_file_name,
                            'education_level' => $request->input('child_' . $i . '_education')
                        ];

                        // check if all values in current array is not empty
                        if (count(array_filter($child)) != 0) {
                            $child['user_id'] = $user->id;
                            array_push($children_data, $child);
                        }
                    }


                    $children_info = ChildrenMeta::insert($children_data);
                    if ($children_info) {
                        return back()->with('success', 'User created successfully.');
                    }
                } else {
                    $user->forceDelete();
                }
            } else {
                $user->forceDelete();
                return back()->with('error', 'Issue date cannot be greater than Expiry date.')->withInput();
            }
        }
    }

    // Member update
    public function update(Request $request, $id)
    {

        // read json file from storage > public
        $np_exists = Storage::disk('public')->exists('np_en.json');
        $np_province = [];
        if ($np_exists) {
            $contents = Storage::disk('public')->get('np_en.json');
            $np_province = json_decode($contents, true);
        }

        $hk_exists = Storage::disk('public')->exists('hk_en.json');
        $hk_regions = [];
        if ($hk_exists) {
            $contents = Storage::disk('public')->get('hk_en.json');
            $hk_regions = json_decode($contents, true);
        }

        $user = User::find($id);
        $user_info = UserMeta::firstWhere('user_id', $id);
        $children_info = ChildrenMeta::where('user_id', $id)->get();

        return view('user.edit', ['user' => $user, 'user_info' => $user_info, 'children_info' => $children_info, 'hk_regions' => $hk_regions, 'np_provinces' => $np_province]);
    }


    // store member updates
    public function storeUpdate(Request $request)
    {
        // get hidden field ; user id
        $userId = $request->input('user_id');
        $validatedData = $request->validate([
            'membership_type' => 'required',
            'membership_no' => 'required',
            'issue_date' => 'required',
            // 'family_name' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            // 'address_np' => 'required',
            // 'province_np' => 'required',
            // 'district_np' => 'required',
            // 'address_hk' => 'required',
            // 'district_hk' => 'required',
            // 'region_hk' => 'required',
            'document_type' => 'required',
            'document_no' => 'required',
            // 'mobile_no' => 'required',
            // 'member_photo' => 'file|mimes:jpg,jpeg,bmp,png',
        ], [
            'membership_type.required' => 'Required',
            'membership_no.required' => 'Required',
            'issue_date.required' => 'Required',
            // 'family_name.required' => 'Required',
            'name.required' => 'Required',
            'email.required' => 'Required',
            // 'address_np.required' => 'Required',
            // 'province_np.required' => 'Required',
            // 'district_np.required' => 'Required',
            // 'address_hk.required' => 'Required',
            // 'district_hk.required' => 'Required',
            // 'region_hk.required' => 'Required',
            'document_type.required' => 'Required',
            'document_no.required' => 'Required',
            // 'mobile_no.required' => 'Required',
        ]);




        $user = User::find($userId);
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        // if user basic info saved, then save the other info
        if ($user->save()) {
            $userInfo = UserMeta::where('user_id', $userId)->first();

            $userInfo->membership_type = $request->input('membership_type');
            $userInfo->membership_no = $request->input('membership_no');
            $userInfo->issue_date = $request->input('issue_date');
            $userInfo->expiry_date = $request->input('expiry_date');
            $userInfo->family_name = $request->input('family_name');
            $userInfo->address_np = $request->input('address_np');
            $userInfo->province_np = $request->input('province_np');
            $userInfo->district_np = $request->input('district_np');
            $userInfo->address_hk = $request->input('address_hk');
            $userInfo->district_hk = $request->input('district_hk');
            $userInfo->region_hk = $request->input('region_hk');
            $userInfo->document_type = $request->input('document_type');
            $userInfo->document_no = Crypt::encryptString($request->input('document_no'));
            $userInfo->mobile_no = $request->input('mobile_no');
            $userInfo->telephone_no = $request->input('telephone_no');
            $userInfo->job = $request->input('job');
            $userInfo->spouse_name = $request->input('spouse_name');

            // Member image handling
            if ($request->hasFile('member_photo')) {
                if ($request->file('member_photo')->isValid()) {
                    $member_photo_fileName = time() . '_id_' . $user->id . '.' . $request->member_photo->extension();
                    $request->member_photo->move(public_path('uploads/members/' . $user->id), $member_photo_fileName);
                    $oldFileMember = $userInfo->member_photo;
                    $userInfo->member_photo = '/uploads/members/' . $user->id . '/' . strval($member_photo_fileName);
                    //remove old file
                    Storage::delete($oldFileMember);
                }
            }


            // Member spouse image handling
            if ($request->hasFile('spouse_photo')) {
                if ($request->file('spouse_photo')->isValid()) {
                    $spouse_photo_fileName = time() . '_spouse_of_' . $user->id . '.' . $request->spouse_photo->extension();
                    $request->spouse_photo->move(public_path('uploads/members/' . $user->id), $spouse_photo_fileName);
                    $oldFileSpouse = $userInfo->spouse_photo;
                    $userInfo->spouse_photo = '/uploads/members/' . $user->id . '/' . strval($spouse_photo_fileName);
                    //remove old file
                    Storage::delete($oldFileSpouse);
                }
            }

            // check the proper date of issue and expiry(if not empty)
            $date_dif = 1;
            if (!empty($userInfo->expiry_date)) {
                $issue_date = date_create($userInfo->issue_date);
                $expiry_date = date_create($userInfo->expiry_date);
                $date_dif = date_diff($issue_date, $expiry_date);
                $date_dif = intval($date_dif->format("%R%a"));
            }

            //  check if expiry date is greater than issue date
            // if($date_dif > 0)
            // {
            // Update all user meta data to User Meta table
            // if all user meta are saved, then save their child
            if ($userInfo->save()) {

                $childrenInfo = ChildrenMeta::where('user_id', $userId)->get();
                if (!empty($childrenInfo)) {
                    $i = 1;

                    foreach ($childrenInfo as $cinfo) {
                        // initiate empty variable
                        $child_photo_file_name_save = '';
                        // getting child photo file name here
                        $child_file_name = 'child_' . $i . '_photo';
                        if ($request->hasFile($child_file_name)) {
                            if ($request->file($child_file_name)->isValid()) {
                                $child_photo_fileName = time() . '_child_' . $i . '_of_' . $user->id . '.' . $request->$child_file_name->extension();
                                $request->$child_file_name->move(public_path('uploads/members/' . $user->id), $child_photo_fileName);
                                $oldFileChild = $cinfo->photo;
                                $child_photo_file_name_save = '/uploads/members/' . $user->id . '/' . strval($child_photo_fileName);
                                //remove old file
                                Storage::delete($oldFileChild);
                            }
                        } else {
                            $child_photo_file_name_save = $cinfo->photo;
                        }

                        $cinfo->full_name = $request->input('child_' . $i . '_name');
                        $cinfo->dob = $request->input('child_' . $i . '_dob');
                        $cinfo->gender = $request->input('child_' . $i . '_gender');
                        $cinfo->photo = $child_photo_file_name_save;
                        $cinfo->education_level = $request->input('child_' . $i . '_education');

                        $cinfo->save();

                        $i++;
                    }
                } else {
                    return back()->with('success', 'User edited successfully.');
                }
                return back()->with('success', 'User edited successfully.');
            } else {
                $user->forceDelete();
            }
            // }
            // else {
            //     $user->forceDelete();
            //     return back()->with('error', 'Issue date cannot be greater than Expiry date.')->withInput();
            // }

        }
    }

    // Member Detail Page
    public function detail(Request $request, $id)
    {
        $user = User::find($id);
        $user_info = UserMeta::firstWhere('user_id', $id);
        $children_info = ChildrenMeta::where('user_id', $id)->get();

        if ($request->wantsJson()) {
            // prepare data for response
            $data = [
                'user' => $user,
                'user_info' => $user_info,
                'children_info' => $children_info
            ];
            return $this->successResponse($data, 'Member Detail', 200);
        }
        return view('user.detail', ['user' => $user, 'user_info' => $user_info, 'children_info' => $children_info]);
    }

    // Delete Member
    public function delete(Request $request, $id)
    {

        $user = User::find($id);
        $user->delete();
        $user_meta = UserMeta::find($user->id);
        $user_meta->delete();
        return redirect()->route('member.list')->with('success', 'User and User meta deleted successfully.');;
    }

    // Search Member
    public function search(Request $request)
    {
        $search_key = $request->input('search_key');
        $family_name = $request->input('family_name');
        $district_hk = $request->input('district_hk');
        $district_np = $request->input('district_np');
        $job = $request->input('job');

        $search_params = ['search_key' => $search_key, 'family_name' => $family_name, 'district_hk' => $district_hk, 'district_np' => $district_np, 'job' => $job];

        $search_result = (array) $this->user->searchMember($search_params);

        // return response()->json($search_result);
        return $this->successResponse($search_result, 'Search Result', 200);
    }

    // update child function
    public function addChild(Request $request)
    {
        $userId = $request->input('userId');
        // create children array
        $children_data = [];
        for ($i = 1; $i <= 3; $i++) {
            // initiate empty variable
            $child_photo_file_name = '';
            // getting child photo file name here
            $request_child_file_name = 'child_' . $i . '_photo';
            if ($request->hasFile($request_child_file_name)) {
                if ($request->file($request_child_file_name)->isValid()) {
                    $child_photo_fileName = time() . '_child_' . $i . '_of_' . $userId . '.' . $request->$request_child_file_name->extension();
                    $request->$request_child_file_name->move(public_path('uploads/members/' . $userId), $child_photo_fileName);
                    $child_photo_file_name = '/uploads/members/' . $userId . '/' . strval($child_photo_fileName);
                }
            }

            $child = [
                'full_name' => $request->input('child_' . $i . '_name'),
                'dob' => $request->input('child_' . $i . '_dob'),
                'gender' => $request->input('child_' . $i . '_gender'),
                'photo' => $child_photo_file_name,
                'education_level' => $request->input('child_' . $i . '_education')
            ];

            // check if all values in current array is not empty
            if (count(array_filter($child)) != 0) {
                $child['user_id'] = $userId;
                array_push($children_data, $child);
            }
        }

        $children_info = ChildrenMeta::insert($children_data);
        if ($children_info) {
            return back()->with('success', 'Child created successfully.');
        }
    }

    // API route- user login
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $successToken = $user->createToken('PMS Password Grant Client')->accessToken;
            //     return response()->json([
            //       'success' => true,
            //       'token' => $successToken,
            //       'user' => $user
            //   ]);


          $data = [
            'token' => $successToken,
            'user' => $user
            ];

          return $this->successResponse($data, 'Login success', 200);


        } else {
            return $this->errorResponse('Invalid Email or Password', 401);
        }
    }

    // API - user logout
    public function logout(Request $res)
    {
      if (Auth::user()) {
        $user = Auth::user()->token();
        $user->revoke();

    //     return response()->json([
    //       'success' => true,
    //       'message' => 'Logout successfully'
    //   ]);

      return $this->successResponse('', 'Logout success', 200);

      }else {
        // return response()->json([
        //   'success' => false,
        //   'message' => 'Unable to Logout'
        // ]);
        return $this->errorResponse('Unable to Logout', 401);
      }
     }
}
