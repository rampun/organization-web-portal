<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\PostStatusTrait;
use Laravel\Passport\HasApiTokens;

use App\Models\UserMeta;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, PostStatusTrait;
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
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // one to many relation
    public function childrens()
    {
        return $this->hasMany('App\Models\ChildrenMeta');
    }

    public function getMembers(){
        $members = User::where('role','member')->orderBy('id','desc')->get();
        $members_detail = [];
        $i=0;
        foreach($members as $member)
        {
            $member_info = UserMeta::where('user_id', $member->id)->first();
            $members_detail[$i]['id'] = $member->id;
            $members_detail[$i]['name'] = $member->name;
            $members_detail[$i]['email'] = $member->email;
            $members_detail[$i]['family_name'] = $member_info->family_name;
            $members_detail[$i]['district_np'] = $member_info->district_np;
            $members_detail[$i]['district_hk'] = $member_info->district_hk;
            $members_detail[$i]['job'] = $member_info->job;
            $members_detail[$i]['mobile_no'] = $member_info->mobile_no;
            $members_detail[$i]['avatar'] = !empty($member_info->member_photo) ? url('/') . $member_info->member_photo : Helper::getPlaceholderImage();

            if(!empty($member_info->spouse_name))
            {
                $members_detail[$i]['spouse']['name'] = $member_info->spouse_name;
            }

            if(!empty($member_info->spouse_photo) )
            {
                $members_detail[$i]['spouse']['photo'] = url('/') . $member_info->spouse_photo;
            }

            
            $i++;
        }
        return $members_detail;
    }

    public function searchMember($search_params){

        $search_key = !empty($search_params['search_key'])?$search_params['search_key']:'';
        $family_name = !empty($search_params['family_name'])?$search_params['family_name']:'';
        $district_hk = !empty($search_params['district_hk'])?$search_params['district_hk']:'';
        $district_np = !empty($search_params['district_np'])?$search_params['district_np']:'';
        $job = !empty($search_params['job'])?$search_params['job']:'';

        $members = User::where('role','member')->where('name', 'like', '%' . $search_key . '%')->orderBy('id','desc')->get();
        $members_detail = [];
        $i=0;
        foreach($members as $member)
        {
            $member_info = UserMeta::where('user_id', $member->id);
            
            if(!empty($family_name))
            {
                $member_info->where('family_name', 'like', $family_name);
            }
            if(!empty($district_hk))
            {
                $member_info->where('district_hk', 'like', $district_hk);
            }
            if(!empty($district_np))
            {
                $member_info->where('district_np', 'like', $district_np);
            }
            if(!empty($job))
            {
                $member_info->where('job', 'like', $job);
            }
            
            $member_info = $member_info->first();
            if(!empty($member_info))
            {
                $members_detail[$i]['id'] = $member->id;
                $members_detail[$i]['name'] = $member->name;
                $members_detail[$i]['email'] = $member->email;
                $members_detail[$i]['family_name'] = $member_info->family_name;
                $members_detail[$i]['district_hk'] = $member_info->district_hk;
                $members_detail[$i]['district_np'] = $member_info->district_np;
                $members_detail[$i]['job'] = $member_info->job;
                $members_detail[$i]['mobile_no'] = $member_info->mobile_no;
                $members_detail[$i]['member_photo'] = $member_info->member_photo;
                $i++;
            }
        }
        return $members_detail;
    }

    // get unique family name
    public function getAllFamilyName()
    {
        $familyNames = UserMeta::whereNotNull('family_name')->distinct('family_name')->pluck('family_name');
        return $familyNames;
    }

    // get unique Nepal District
    public function getNepalDistrict()
    {
        $districtNp = UserMeta::whereNotNull('district_np')->distinct('district_np')->pluck('district_np');
        return $districtNp;
    }

    // get unique Hong Kong District
    public function getHkDistrict()
    {
        $districtHk = UserMeta::whereNotNull('district_hk')->distinct('district_hk')->pluck('district_hk');
        return $districtHk;
    }

    // get unqiue jobs from DB
    public function getAllJobs()
    {
        $jobs = UserMeta::whereNotNull('job')->distinct('job')->pluck('job');
        return $jobs;
    }
}
