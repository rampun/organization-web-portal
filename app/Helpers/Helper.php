<?php
/**
 * Custom helper functions
 */

 namespace App\Helpers;

 use App\Models\User;
 use App\Models\UserMeta;

class Helper {

    // function to return placeholder image
    public static function getPlaceholderImage()
    {
        return  url('/') .'/images/pmshk-placeholder.jpg';
    }
}