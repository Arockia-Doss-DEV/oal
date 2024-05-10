<?php

namespace App\Helper;

use App\User;

class ViewHelper{

	final public static function findQuarterMonth(string $currentDate)
	{
		$currentDate = $currentDate;
		$months = [
            "January" => [
                "January",
                "February",
                "March"
            ],
                  
            "April" => [
                "April",
                "May",
                "June"
            ],

            "July" => [
                "July",
                "August",
                "September"
            ],

            "October" => [
                "October", 
                "November",
                "December"
            ],
        ];

        foreach ($months as $key => $month) {
        	if (in_array($currentDate, $month)) {

                $year = $key . date(' d Y');
                $payment_date = strtotime($year);
                $month_firstdate = strtotime(date("Y-m-d", $payment_date));
                $date = date("Y-m-d", $month_firstdate);

                // echo date('D\, jS  F Y', $month_firstdate);
                // echo $date = strtotime($todayDate);
            }
        }

        return $date;
	}

	final public static function getNotificationAdmin()
	{
		$getAdmins = User::where(['role_id' => 2, 'active' => 1])->get();
		return $getAdmins;
	}

	final public static function getDefaultGlobalNotificationAdmin()
	{
		$GlobalNotificationAdmin = User::where(['role_id' => 2, 'active' => 1, 'setdefault' => 1])->first();
		if (!empty($GlobalNotificationAdmin)) {
			return $DefaultGlobalNotificationAdmin = $GlobalNotificationAdmin['id'];
		} else {
			return $DefaultGlobalNotificationAdmin = "All";
		}
	}

	final public static function getNotificationUser()
	{
		$NotificationUser = User::where(['role_id' => 2, 'active' => 1, 'setdefault' => 1])->first();
		if (!empty($NotificationUser)) {
			return $NotificationReceiver = $NotificationUser->id;
		} else {
			return $NotificationReceiver = 1;	
		}
	}
}


// if (!function_exists('getNotificationAdmin')) {
	
// 	function getNotificationAdmin()
// 	{
// 		// $getAdmin = User::where(['role_id' => 2, 'active' => 1, 'setdefault' => 1])->first();

// 		$getAdmins = User::where(['role_id' => 2, 'active' => 1])->get();
// 		return $getAdmins;
// 	}
// }

// function getDefaultGlobalNotificationAdmin()
// {
// 	$GlobalNotificationAdmin = User::where(['role_id' => 2, 'active' => 1, 'setdefault' => 1])->first();
// 	if (!empty($GlobalNotificationAdmin)) {
// 		return $DefaultGlobalNotificationAdmin = $GlobalNotificationAdmin['id'];
// 	} else {
// 		return $DefaultGlobalNotificationAdmin = "All";
// 	}
// }

// function getNotificationUser()
// {
// 	$NotificationUser = User::where(['role_id' => 2, 'active' => 1, 'setdefault' => 1])->first();
// 	if (!empty($NotificationUser)) {
// 		return $NotificationReceiver = $NotificationUser->id;
// 	} else {
// 		return $NotificationReceiver = 1;	
// 	}
// }

