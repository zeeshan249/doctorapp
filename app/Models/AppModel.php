<?php

namespace App\Models;

use DateTime;
use DB;
use Exception;
use function PHPUnit\Framework\isEmpty;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppModel extends Model
{
    use HasFactory;
    /*==================================================Common=========================== */
    // To check User Status
    public function checkUserStatus($userId, $roleId)
    {
        if ($roleId == "1") {
            // For customer
            $getQuery = DB::table('dm_user')
                ->leftJoin('dm_customer_personal_details', 'dm_user.user_id', '=', 'dm_customer_personal_details.user_id')
                ->leftJoin('dm_family_member', 'dm_user.user_id', '=', 'dm_family_member.user_id')
                ->where('dm_user.user_id', '=', $userId)
                ->where('dm_family_member.is_self', '=', 1)

                ->select([
                    'dm_user.user_id',
                    'dm_user.role_id',
                    'dm_user.user_firebase_id',
                    'dm_user.user_is_active',
                    'dm_user.logout_user',
                    'dm_user.user_mobile',
                    DB::raw('DATE_FORMAT(dm_user.user_created_at, "%d-%m-%Y") as user_created_at', "%d-%m-%Y"),
                    'dm_customer_personal_details.customer_first_name',
                    'dm_customer_personal_details.customer_last_name',
                    'dm_customer_personal_details.customer_full_name',
                    'dm_customer_personal_details.customer_profile_image',
                    'dm_family_member.family_member_id',

                ])
                ->get();
        } else if ($roleId == "2") {
            // For clinic
            $getQuery = DB::table('dm_user')
                ->leftJoin('dm_clinic', 'dm_user.user_id', '=', 'dm_clinic.user_id')
                ->where('dm_user.user_id', '=', $userId)

                ->select([
                    'dm_user.user_id',
                    'dm_user.role_id',
                    'dm_user.user_firebase_id',
                    'dm_user.user_is_active',
                    'dm_user.logout_user',
                    'dm_user.user_mobile',
                    DB::raw('DATE_FORMAT(dm_user.user_created_at, "%d-%m-%Y") as user_created_at', "%d-%m-%Y"),
                    'dm_clinic.clinic_first_name',
                    'dm_clinic.clinic_last_name',
                    'dm_clinic.clinic_full_name',
                    'dm_clinic.clinic_profile_image',
                    'dm_clinic.clinic_id',

                ])
                ->get();
        } else if ($roleId == "3") {
            // For doctor
            $getQuery = DB::table('dm_user')
                ->leftJoin('dm_doctor', 'dm_user.user_id', '=', 'dm_doctor.user_id')
                ->where('dm_user.user_id', '=', $userId)
                ->select([
                    'dm_user.user_id',
                    'dm_user.role_id',
                    'dm_user.user_firebase_id',
                    'dm_user.user_is_active',
                    'dm_user.logout_user',
                    'dm_user.user_mobile',
                    DB::raw('DATE_FORMAT(dm_user.user_created_at, "%d-%m-%Y") as user_created_at', "%d-%m-%Y"),
                    'dm_doctor.doctor_first_name',
                    'dm_doctor.doctor_last_name',
                    'dm_doctor.doctor_full_name',
                    'dm_doctor.doctor_profile_image',
                    'dm_doctor.doctor_id',

                ])
                ->get();
        }

        $getResult = $getQuery->toArray();
        return $getResult;
    }

    // To check Mobile Number
    public function checkMobileNumber($mobileNumber)
    {

        $getRoleQuery = DB::table('dm_user')
            ->where('dm_user.user_mobile', '=', $mobileNumber)
            ->get();

        if ($getRoleQuery->count() > 0) {
            $getRoleResult = $getRoleQuery->toArray();
            if ($getRoleResult[0]->role_id == "1") {
                // For Customer
                $getQuery = DB::table('dm_user')
                    ->leftJoin('dm_customer_personal_details', 'dm_user.user_id', '=', 'dm_customer_personal_details.user_id')
                    ->leftJoin('dm_family_member', 'dm_user.user_id', '=', 'dm_family_member.user_id')
                    ->where('dm_user.user_mobile', '=', $mobileNumber)
                    ->where('dm_family_member.is_self', '=', 1)
                    ->select([
                        'dm_user.user_id',
                        'dm_user.role_id',
                        'dm_user.user_firebase_id',
                        'dm_user.user_is_active',
                        'dm_user.logout_user',
                        'dm_user.user_mobile',
                        DB::raw('DATE_FORMAT(dm_user.user_created_at, "%d-%m-%Y") as user_created_at', "%d-%m-%Y"),
                        'dm_customer_personal_details.customer_first_name',
                        'dm_customer_personal_details.customer_last_name',
                        'dm_customer_personal_details.customer_full_name',
                        'dm_customer_personal_details.customer_profile_image',
                        'dm_family_member.family_member_id',
                    ])
                    ->get();
            } else if ($getRoleResult[0]->role_id == "2") {
                // For Clinic
                $getQuery = DB::table('dm_user')
                    ->leftJoin('dm_clinic', 'dm_user.user_id', '=', 'dm_clinic.user_id')
                    ->where('dm_user.user_mobile', '=', $mobileNumber)
                    ->select([
                        'dm_user.user_id',
                        'dm_user.role_id',
                        'dm_user.user_firebase_id',
                        'dm_user.user_is_active',
                        'dm_user.logout_user',
                        'dm_user.user_mobile',
                        DB::raw('DATE_FORMAT(dm_user.user_created_at, "%d-%m-%Y") as user_created_at', "%d-%m-%Y"),
                        'dm_clinic.clinic_first_name',
                        'dm_clinic.clinic_last_name',
                        'dm_clinic.clinic_full_name',
                        'dm_clinic.clinic_profile_image',
                        'dm_clinic.clinic_id',

                    ])
                    ->get();
            } else if ($getRoleResult[0]->role_id == "3") {
                // For Doctor
                $getQuery = DB::table('dm_user')
                    ->leftJoin('dm_doctor', 'dm_user.user_id', '=', 'dm_doctor.user_id')
                    ->where('dm_user.user_mobile', '=', $mobileNumber)
                    ->select([
                        'dm_user.user_id',
                        'dm_user.role_id',
                        'dm_user.user_firebase_id',
                        'dm_user.user_is_active',
                        'dm_user.logout_user',
                        'dm_user.user_mobile',
                        DB::raw('DATE_FORMAT(dm_user.user_created_at, "%d-%m-%Y") as user_created_at', "%d-%m-%Y"),
                        'dm_doctor.doctor_first_name',
                        'dm_doctor.doctor_last_name',
                        'dm_doctor.doctor_full_name',
                        'dm_doctor.doctor_profile_image',
                        'dm_doctor.doctor_id',

                    ])
                    ->get();
            }
            $getResult = $getQuery->toArray();
            return $getResult;
        } else {
            return [];
        }

    }

    // To check login
    public function checkLogin($mobile, $password, $userDeviceToken)
    {

        $getBcryptPasswordQuery = DB::table('dm_user')
            ->where('user_mobile', '=', $mobile)
            ->select(['password', 'role_id'])
            ->get();
        if ($getBcryptPasswordQuery->count() > 0) {
            $bcryptPassword = $getBcryptPasswordQuery[0]->password;
            if (password_verify($password, $bcryptPassword)) {

                if ($getBcryptPasswordQuery[0]->role_id == "1") {
                    // For Customer
                    $getQuery = DB::table('dm_user')
                        ->leftJoin('dm_customer_personal_details', 'dm_user.user_id', '=', 'dm_customer_personal_details.user_id')
                        ->leftJoin('dm_family_member', 'dm_user.user_id', '=', 'dm_family_member.user_id')
                        ->where('dm_user.user_mobile', '=', $mobile)
                        ->where('dm_family_member.is_self', '=', 1)
                        ->select([
                            'dm_user.user_id',
                            'dm_user.role_id',
                            'dm_user.user_firebase_id',
                            'dm_user.user_is_active',
                            'dm_user.logout_user',
                            'dm_user.user_mobile',
                            DB::raw('DATE_FORMAT(dm_user.user_created_at, "%d-%m-%Y") as user_created_at', "%d-%m-%Y"),
                            'dm_customer_personal_details.customer_first_name',
                            'dm_customer_personal_details.customer_last_name',
                            'dm_customer_personal_details.customer_full_name',
                            'dm_customer_personal_details.customer_profile_image',
                            'dm_family_member.family_member_id',
                        ])
                        ->get();
                } else if ($getBcryptPasswordQuery[0]->role_id == "2") {
                    // For Clinic
                    $getQuery = DB::table('dm_user')
                        ->leftJoin('dm_clinic', 'dm_user.user_id', '=', 'dm_clinic.user_id')
                        ->where('dm_user.user_mobile', '=', $mobile)
                        ->select([
                            'dm_user.user_id',
                            'dm_user.role_id',
                            'dm_user.user_firebase_id',
                            'dm_user.user_is_active',
                            'dm_user.logout_user',
                            'dm_user.user_mobile',
                            DB::raw('DATE_FORMAT(dm_user.user_created_at, "%d-%m-%Y") as user_created_at', "%d-%m-%Y"),
                            'dm_clinic.clinic_first_name',
                            'dm_clinic.clinic_last_name',
                            'dm_clinic.clinic_full_name',
                            'dm_clinic.clinic_profile_image',
                            'dm_clinic.clinic_id',

                        ])
                        ->get();
                } else if ($getBcryptPasswordQuery[0]->role_id == "3") {
                    // For Doctor
                    $getQuery = DB::table('dm_user')
                        ->leftJoin('dm_doctor', 'dm_user.user_id', '=', 'dm_doctor.user_id')
                        ->where('dm_user.user_mobile', '=', $mobile)
                        ->select([
                            'dm_user.user_id',
                            'dm_user.role_id',
                            'dm_user.user_firebase_id',
                            'dm_user.user_is_active',
                            'dm_user.logout_user',
                            'dm_user.user_mobile',
                            DB::raw('DATE_FORMAT(dm_user.user_created_at, "%d-%m-%Y") as user_created_at', "%d-%m-%Y"),
                            'dm_doctor.doctor_first_name',
                            'dm_doctor.doctor_last_name',
                            'dm_doctor.doctor_full_name',
                            'dm_doctor.doctor_profile_image',
                            'dm_doctor.doctor_id',

                        ])
                        ->get();
                }

                $getResult = $getQuery->toArray();
                $this->updateDeviceToken($getResult[0]->user_id, $userDeviceToken);
                return $getResult;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

// Update Device Token
    public function updateDeviceToken($userId, $userDeviceToken)
    {
        DB::table('dm_user')
            ->where('user_id', $userId)
            ->update(['device_token' => $userDeviceToken]);

        $getResult['result'] = "success";
        return $getResult;
    }
    // To get city
    public function getCity($pageNumber, $itemToLoad, $searchText)
    {
        $pageNumber = $pageNumber;
        $itemToLoad = $itemToLoad;
        if ($pageNumber == 1) {
            $pageNumber = 0;
        } else {
            $pageNumber = $itemToLoad * $pageNumber;
            $pageNumber = $pageNumber - $itemToLoad;
        }

        $getQuery = DB::table('dm_city')
            ->where('city_is_active', '=', 1)
            ->where('city_name', 'like', '%' . $searchText . '%')
            ->select(['city_id',
                'city_name',
            ])
            ->limit($itemToLoad)
            ->offset($pageNumber)
            ->orderBy('city_name', 'asc')
            ->get();

        $data_response = array();
        if (count($getQuery) <= 0) {
            array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
        } else {
            array_push($data_response, array('data_status' => 'ok'));
            array_push($data_response, array('data' => $getQuery->toArray()));
            echo json_encode($data_response);
        }
    }

// To send password
    public function sendPassword($mobileNumber)
    {
        try {
            $getQuery = DB::table('dm_user')->where('user_mobile', $mobileNumber)->get();
            if ($getQuery->count() == 0) {
                $resultData['result'] = "MobileInvalid";
            } else {
                $resultData['result'] = "success";
                $this->sendSMSPassword($mobileNumber, $getQuery[0]->password_normal);
            }
        } catch (Exception $ex) {
            $resultData['result'] = "Exception";
        }

        return $resultData;
    }
// SMS Password
    public function sendSMSPassword($mobile, $password)
    {
        try
        {
            $smstext = rawurlencode("Your password is: " . $password . " .Team DocsMeet");
            $ch = curl_init("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=V6dw6TBazEGoT3a3exO8UA&senderid=ODILAS&channel=2&DCS=0&flashsms=0&number=$mobile&text=$smstext&route=1");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 2);
            $result = curl_exec($ch);
            if (curl_error($ch)) {
                $result = curl_errno($ch);
            }
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }

        return response()->json($result);
    }

// To get area
    public function getArea($pageNumber, $itemToLoad, $searchText, $cityId)
    {
        $pageNumber = $pageNumber;
        $itemToLoad = $itemToLoad;
        if ($pageNumber == 1) {
            $pageNumber = 0;
        } else {
            $pageNumber = $itemToLoad * $pageNumber;
            $pageNumber = $pageNumber - $itemToLoad;
        }

        $getQuery = DB::table('dm_area')
            ->where('area_is_active', '=', 1)
            ->where('city_id', '=', $cityId)
            ->where('area_name', 'like', '%' . $searchText . '%')
            ->select(['area_id',
                'city_id',
                'area_name',
            ])
            ->limit($itemToLoad)
            ->offset($pageNumber)
            ->orderBy('area_name', 'asc')
            ->get();

        $data_response = array();
        if (count($getQuery) <= 0) {
            array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
        } else {
            array_push($data_response, array('data_status' => 'ok'));
            array_push($data_response, array('data' => $getQuery->toArray()));
            echo json_encode($data_response);
        }
    }

    // To get the slider
    public function getSlider($sliderPosition, $areaId, $cityId)
    {

        if ($areaId == "0") {
            $getQuery = DB::table('dm_slider')
                ->whereRaw("FIND_IN_SET($sliderPosition,slider_position)")
                ->whereRaw("FIND_IN_SET($cityId,city_id)")
                ->where('slider_is_active', '=', 1)
                ->whereRaw('now() between slider_active_from and slider_active_to')
                ->select(['slider_id',
                    'slider_image',
                    'vendor_id',

                ])
                ->orderBy('slider_preference_order', 'desc')
                ->get();
        } else {
            $getQuery = DB::table('dm_slider')
                ->where('slider_position', '=', $sliderPosition)
                ->whereRaw("FIND_IN_SET($areaId,area_id)")
                ->whereRaw("FIND_IN_SET($cityId,city_id)")
                ->where('slider_is_active', '=', 1)
                ->whereRaw('now() between slider_active_from and slider_active_to')
                ->select(['slider_id',
                    'slider_image',
                    'vendor_id',

                ])
                ->orderBy('slider_preference_order', 'desc')
                ->get();
        }

        $getResult = $getQuery->toArray();
        return $getResult;
    }

    // To get the disease category
    public function getDiseaseCategory($pageNumber, $itemToLoad, $searchText, $cityId, $areaId, $position)
    {
        $pageNumber = $pageNumber;
        $itemToLoad = $itemToLoad;
        if ($pageNumber == 1) {
            $pageNumber = 0;
        } else {
            $pageNumber = $itemToLoad * $pageNumber;
            $pageNumber = $pageNumber - $itemToLoad;
        }
        if ($areaId == "0") {
            $getQuery = DB::table('dm_disease_category')
                ->rightJoin('dm_doctor', 'dm_disease_category.disease_category_id', '=', 'dm_doctor.disease_category_id')
                ->whereRaw("FIND_IN_SET($position,dm_disease_category.dm_disease_category_position)")
                ->where('dm_disease_category.disease_category_active', '=', 1)
                ->whereRaw("FIND_IN_SET($cityId,dm_disease_category.city_id)")
                ->where('dm_disease_category.disease_category_name', 'like', '%' . $searchText . '%')
                ->select(['dm_disease_category.disease_category_id',
                    'dm_disease_category.disease_category_name',
                    'dm_disease_category.disease_category_image',
                ])
                ->limit($itemToLoad)
                ->offset($pageNumber)
                ->inRandomOrder()
                ->groupBy('dm_disease_category.disease_category_id')
                ->get();

        } else {
            $getQuery = DB::table('dm_disease_category')
                ->rightJoin('dm_doctor', 'dm_disease_category.disease_category_id', '=', 'dm_doctor.disease_category_id')
                ->whereRaw("FIND_IN_SET($position,dm_disease_category.dm_disease_category_position)")
                ->where('dm_disease_category.disease_category_active', '=', 1)
                ->whereRaw("FIND_IN_SET($cityId,dm_disease_category.city_id)")
                ->whereRaw("FIND_IN_SET($areaId,dm_disease_category.area_id)")
                ->where('dm_disease_category.disease_category_name', 'like', '%' . $searchText . '%')
                ->select(['dm_disease_category.disease_category_id',
                    'dm_disease_category.disease_category_name',
                    'dm_disease_category.disease_category_image',
                ])
                ->limit($itemToLoad)
                ->offset($pageNumber)
                ->inRandomOrder()
                ->groupBy('dm_disease_category.disease_category_id')
                ->get();
        }

        $data_response = array();
        if (count($getQuery) <= 0) {
            array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
        } else {
            array_push($data_response, array('data_status' => 'ok'));
            array_push($data_response, array('data' => $getQuery->toArray()));
            echo json_encode($data_response);
        }
    }

    // To get the all health tips
    public function getHealthTips($pageNumber, $itemToLoad, $userId, $roleId)
    {
        $pageNumber = $pageNumber;
        $itemToLoad = $itemToLoad;
        if ($pageNumber == 1) {
            $pageNumber = 0;
        } else {
            $pageNumber = $itemToLoad * $pageNumber;
            $pageNumber = $pageNumber - $itemToLoad;
        }
        $getQuery = DB::table('dm_health_tips')
            ->leftJoin('dm_user', 'dm_user.user_id', '=', 'dm_health_tips.user_id')
            ->where('dm_health_tips.health_tip_is_active', '=', 1)
            ->select([
                'dm_health_tips.health_tip_id',
                'dm_health_tips.user_id',
                'dm_health_tips.health_tip_title',
                'dm_health_tips.health_tip_content',
                'dm_health_tips.health_tip_image',
                'dm_health_tips.health_tip_has_url',
                'dm_health_tips.health_tip_url',
                'dm_health_tips.user_first_name',
                'dm_health_tips.user_last_name',
                'dm_health_tips.user_full_name',
                'dm_health_tips.user_profile_image',

                DB::raw('DATE_FORMAT(dm_health_tips.health_tip_created_at, "%d-%m-%Y") as health_tip_created_at', "%d-%m-%Y"),
                DB::raw("(SELECT count(*) FROM dm_health_tips_like  where dm_health_tips.health_tip_id=
         dm_health_tips_like.health_tip_id
) as total_like"),
                DB::raw("(SELECT group_concat(dm_health_tips_like.user_id)
     FROM dm_health_tips_like
     where  dm_health_tips.health_tip_id=dm_health_tips_like.health_tip_id
and
dm_health_tips_like.user_id=$userId
) as all_liked_users"),
                DB::raw("(SELECT count(*) FROM dm_health_tips_comment
          where dm_health_tips.health_tip_id=dm_health_tips_comment.health_tip_id

) as total_comment"),
                DB::raw("(SELECT group_concat(dm_health_tips_comment.user_id)
      FROM dm_health_tips_comment
       where  dm_health_tips.health_tip_id=dm_health_tips_comment.health_tip_id
and dm_health_tips_comment.user_id=$userId
) as all_comment_users"),
            ])

            ->limit($itemToLoad)
            ->offset($pageNumber)
            ->orderBy(DB::raw("DATE_FORMAT(dm_health_tips.health_tip_created_at,'%d-%m-%Y %h:%i:%s')"), 'desc')
            ->get();

        $data_response = array();
        if (count($getQuery) <= 0) {
            array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
        } else {
            array_push($data_response, array('data_status' => 'ok'));
            array_push($data_response, array('data' => $getQuery->toArray()));
            echo json_encode($data_response);
        }
    }

    //To insert  health tips like
    public function saveHealthTipsLike($userId, $healthTipsId, $userFirstName,
        $userLastName, $userFullName, $userProfileImage) {
        $getQuery = DB::table('dm_health_tips_like')
            ->where('health_tip_id', $healthTipsId)
            ->where('user_id', $userId)
            ->get();
        if ($getQuery->count() > 0) {
            DB::table('dm_health_tips_like')
                ->where('health_tip_id', $healthTipsId)
                ->where('user_id', $userId)->delete();

            $resultData['result'] = "delete";
        } else {
            $insertQuery = DB::table('dm_health_tips_like')->insertGetId(
                ['health_tip_id' => $healthTipsId,
                    'user_id' => $userId,
                    'user_first_name' => $userFirstName,
                    'user_last_name' => $userLastName,
                    'user_full_name' => $userFullName,
                    'user_profile_image' => $userProfileImage,

                ]
            );
            if ($insertQuery > 0) {
                $resultData['result'] = "success";
            } else {
                $resultData['result'] = "fail";
            }
        }
        return $resultData;
    }

    //To insert  post like
    public function deleteHealthTips($healthTipsId, $healthTipsImage)
    {

        DB::table('dm_health_tips')
            ->where('health_tip_id', $healthTipsId)
            ->delete();

        if (file_exists(storage_path('app/public/health_tip_image/' . $healthTipsImage))) {
            unlink(storage_path('app/public/health_tip_image/' . $healthTipsImage));
        }
        $resultData['result'] = "delete";

        return $resultData;
    }

    // To get the all post
    public function getHealthTipComment($healthTipsId, $pageNumber, $itemToLoad)
    {
        $pageNumber = $pageNumber;
        $itemToLoad = $itemToLoad;
        if ($pageNumber == 1) {
            $pageNumber = 0;
        } else {
            $pageNumber = $itemToLoad * $pageNumber;
            $pageNumber = $pageNumber - $itemToLoad;
        }
        $getQuery = DB::table('dm_health_tips_comment')

            ->where('dm_health_tips_comment.health_tip_id', '=', $healthTipsId)
            ->where('dm_health_tips_comment.health_tip_comment_is_active', '=', 1)
            ->select([
                'dm_health_tips_comment.health_tip_comment_id',
                'dm_health_tips_comment.health_tip_comment_text',
                'dm_health_tips_comment.user_first_name', 'dm_health_tips_comment.user_last_name',
                'dm_health_tips_comment.user_full_name', 'dm_health_tips_comment.user_profile_image',
                DB::raw('(UNIX_TIMESTAMP(health_tip_comment_date)*1000) as health_tip_comment_date', "%d-%m-%Y"),
                DB::raw("(SELECT count(*) FROM dm_health_tips_comment  where dm_health_tips_comment.health_tip_id=$healthTipsId
          ) as total_comment_count"),
            ])

            ->limit($itemToLoad)
            ->offset($pageNumber)
            ->orderBy(DB::raw("DATE_FORMAT(dm_health_tips_comment.health_tip_comment_date,'%d-%m-%Y')"), 'desc')
            ->get();
        $data_response = array();
        if (count($getQuery) <= 0) {
            array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
        } else {
            array_push($data_response, array('data_status' => 'ok'));
            array_push($data_response, array('data' => $getQuery->toArray()));
            echo json_encode($data_response);
        }
    }

    //To insert  comment
    public function saveHealthTipcomment($healthTipsId, $userId, $comment, $userFirstName,
        $userLastName, $userFullName, $userProfileImage) {

        $insertQuery = DB::table('dm_health_tips_comment')->insertGetId(
            ['health_tip_id' => $healthTipsId, 'user_id' => $userId,
                'health_tip_comment_text' => $comment,
                'user_first_name' => $userFirstName,
                'user_last_name' => $userLastName,
                'user_full_name' => $userFullName,
                'user_profile_image' => $userProfileImage,

            ]
        );
        if ($insertQuery > 0) {
            $resultData['result'] = "success";
        } else {
            $resultData['result'] = "fail";
        }

        return $resultData;
    }

    /*==================================================Customer=========================== */
    // Customer
    //To register  user
    public static function registerCustomer($firstName, $lastName, $mobile, $password, $deviceToken)
    {
        DB::beginTransaction();
        try {
            $getQuery = DB::table('dm_user')->where('user_mobile', $mobile)->get();
            if ($getQuery->count() == 0) {
                $saveQuery = DB::table('dm_user')->insertGetId(
                    [
                        'role_id' => 1,
                        'user_mobile' => $mobile,
                        'password' => bcrypt($password),
                        'password_normal' => $password,
                        'device_token' => $deviceToken,

                    ]
                );

                DB::table('dm_customer_personal_details')->insertGetId(
                    [
                        'user_id' => $saveQuery,
                        'customer_first_name' => ucfirst($firstName),
                        'customer_last_name' => ucfirst($lastName),
                        'customer_full_name' => ucfirst($firstName) . " " . ucfirst($lastName),
                        'customer_mobile_number' => $mobile,
                    ]
                );

                DB::table('dm_family_member')->insertGetId(
                    [

                        'family_member_first_name' => ucfirst($firstName),
                        'family_member_last_name' => ucfirst($lastName),
                        'family_member_full_name' => ucfirst($firstName) . " " . ucfirst($lastName),
                        'family_member_mobile_number' => $mobile,
                        'user_id' => $saveQuery,
                        'is_self' => 1,
                    ]
                );

                $getRewardAmountQuery = DB::table('dm_reward_amount_description')->where('reward_amount_description_id', 1)->get();
                $saveRewardQuery = DB::table('dm_reward')->insertGetId(
                    [
                        'user_id' => $saveQuery,
                        'reward_balance' => $getRewardAmountQuery[0]->reward_amount,

                    ]
                );

                DB::table('dm_reward_transaction')->insertGetId(
                    [
                        'reward_id' => $saveRewardQuery,
                        'user_id' => $saveQuery,
                        'reward_transaction_balance' => $getRewardAmountQuery[0]->reward_amount,
                        'reward_transaction_remarks' => $getRewardAmountQuery[0]->reward_amount_description,
                        'is_reward_balance_added' => 1,

                    ]
                );

            } else {
                $resultData['result'] = "MobileExists";
                return $resultData;
            }
            DB::commit();
            $resultData['result'] = $saveQuery;
            $resultData['user_created_at'] = date('d-m-Y');
            return $resultData;
        } catch (Exception $ex) {

            DB::rollback();
            $resultData['result'] = "Exception";
            return $resultData;
        }

    }

    // search doctor clinic speciality
    public function searchDoctorClinicSpeciality($searchText, $pageNumber, $itemToLoad
        , $cityId, $areaId) {
        $pageNumber = $pageNumber;
        $itemToLoad = $itemToLoad;
        if ($pageNumber == 1) {
            $pageNumber = 0;
        } else {
            $pageNumber = $itemToLoad * $pageNumber;
            $pageNumber = $pageNumber - $itemToLoad;
        }
        if ($areaId == "0") {
            $getQuery = DB::select("SELECT dm_clinic.clinic_id as id, dm_clinic.clinic_full_name as name,dm_clinic_image.clinic_image as image,
            'clinic' as type FROM dm_clinic left join dm_clinic_image on dm_clinic_image.clinic_id=dm_clinic.clinic_id
                WHERE dm_clinic.clinic_full_name LIKE '%" .
                $searchText . "%'
            and dm_clinic.clinic_is_active=1 and dm_clinic_image.clinic_image_type=1
            and FIND_IN_SET($cityId,city_id)

                       UNION
                       (SELECT dm_doctor.doctor_id, dm_doctor.doctor_full_name ,dm_doctor.doctor_profile_image as image,'doctor' as type FROM dm_doctor WHERE
                       dm_doctor.doctor_full_name LIKE '%" .
                $searchText . "%'  and dm_doctor.doctor_is_active=1
                and FIND_IN_SET($cityId,city_id))
                       UNION
                        (SELECT dm_disease_category.disease_category_id, dm_disease_category.disease_category_name,
                        dm_disease_category.disease_category_image as image,
                        'speciality'
                        as type FROM dm_disease_category
                        WHERE
                       dm_disease_category.disease_category_name LIKE '%" .
                $searchText . "%'  and dm_disease_category.disease_category_active=1
                 and FIND_IN_SET($cityId,city_id))
           limit  $itemToLoad offset $pageNumber ");
        } else {
            $getQuery = DB::select("SELECT dm_clinic.clinic_id as id, dm_clinic.clinic_full_name as name,dm_clinic_image.clinic_image as image,
            'clinic' as type FROM dm_clinic left join dm_clinic_image on dm_clinic_image.clinic_id=dm_clinic.clinic_id
                WHERE dm_clinic.clinic_full_name LIKE '%" .
                $searchText . "%'
            and dm_clinic.clinic_is_active=1 and dm_clinic_image.clinic_image_type=1
            and FIND_IN_SET($areaId,area_id) and FIND_IN_SET($cityId,city_id)

                       UNION
                       (SELECT dm_doctor.doctor_id, dm_doctor.doctor_full_name ,dm_doctor.doctor_profile_image as image,'doctor' as type FROM dm_doctor WHERE
                       dm_doctor.doctor_full_name LIKE '%" .
                $searchText . "%'  and dm_doctor.doctor_is_active=1
                and FIND_IN_SET($areaId,area_id) and FIND_IN_SET($cityId,city_id))
                       UNION
                        (SELECT dm_disease_category.disease_category_id, dm_disease_category.disease_category_name,
                        dm_disease_category.disease_category_image as image,
                        'speciality'
                        as type FROM dm_disease_category
                        WHERE
                       dm_disease_category.disease_category_name LIKE '%" .
                $searchText . "%'  and dm_disease_category.disease_category_active=1  and FIND_IN_SET($areaId,area_id) and FIND_IN_SET($cityId,city_id))
           limit  $itemToLoad offset $pageNumber ");
        }

        $data_response = array();
        if (count($getQuery) <= 0) {
            array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
        } else {
            array_push($data_response, array('data_status' => 'ok'));
            array_push($data_response, array('data' => $getQuery));
            echo json_encode($data_response);
        }
    }

    // To get the clinic list
    public function getClinicList($pageNumber, $itemToLoad, $searchText, $cityId, $areaId, $position)
    {
        $pageNumber = $pageNumber;
        $itemToLoad = $itemToLoad;
        if ($pageNumber == 1) {
            $pageNumber = 0;
        } else {
            $pageNumber = $itemToLoad * $pageNumber;
            $pageNumber = $pageNumber - $itemToLoad;
        }
        if ($areaId == "0" && $cityId == "0") {
            $getQuery = DB::table('dm_clinic')
                ->leftJoin('dm_user', 'dm_user.user_id', '=', 'dm_clinic.user_id')
                ->leftJoin('dm_clinic_image', 'dm_clinic.clinic_id', '=', 'dm_clinic_image.clinic_id')
                ->whereRaw("FIND_IN_SET($position,dm_clinic.clinic_position)")
                ->where('dm_clinic.clinic_is_active', '=', 1)
                ->where('dm_clinic.clinic_full_name', 'like', '%' . $searchText . '%')
                ->where('dm_clinic_image.clinic_image_type', '=', 1)
                ->where('dm_clinic.clinic_is_approved', '=', 1)
                ->select([
                    'dm_clinic.clinic_first_name',
                    'dm_clinic.clinic_last_name',
                    'dm_clinic.clinic_full_name',
                    'dm_clinic.clinic_mobile_number',
                    'dm_clinic.clinic_id',
                    'dm_clinic.clinic_address',
                    'dm_clinic_image.clinic_image',
                ])
                ->limit($itemToLoad)
                ->offset($pageNumber)
                ->orderBy('dm_clinic.clinic_full_name')

                ->get();
        } else if ($areaId == "0") {
            $getQuery = DB::table('dm_clinic')
                ->leftJoin('dm_user', 'dm_user.user_id', '=', 'dm_clinic.user_id')
                ->leftJoin('dm_clinic_image', 'dm_clinic.clinic_id', '=', 'dm_clinic_image.clinic_id')
                ->whereRaw("FIND_IN_SET($position,dm_clinic.clinic_position)")
                ->where('dm_clinic.clinic_is_active', '=', 1)
                ->whereRaw("FIND_IN_SET($cityId,city_id)")
                ->where('dm_clinic.clinic_full_name', 'like', '%' . $searchText . '%')
                ->where('dm_clinic_image.clinic_image_type', '=', 1)
                ->where('dm_clinic.clinic_is_approved', '=', 1)
                ->select([
                    'dm_clinic.clinic_first_name',
                    'dm_clinic.clinic_last_name',
                    'dm_clinic.clinic_full_name',
                    'dm_clinic.clinic_mobile_number',
                    'dm_clinic.clinic_id',
                    'dm_clinic.clinic_address',
                    'dm_clinic_image.clinic_image',
                ])
                ->limit($itemToLoad)
                ->offset($pageNumber)
                ->orderBy('dm_clinic.clinic_full_name')
                ->get();

        } else {
            $getQuery = DB::table('dm_clinic')
                ->leftJoin('dm_user', 'dm_user.user_id', '=', 'dm_clinic.user_id')
                ->leftJoin('dm_clinic_image', 'dm_clinic.clinic_id', '=', 'dm_clinic_image.clinic_id')
                ->whereRaw("FIND_IN_SET($position,dm_clinic.clinic_position)")
                ->where('dm_clinic.clinic_is_active', '=', 1)
                ->whereRaw("FIND_IN_SET($cityId,city_id)")
                ->whereRaw("FIND_IN_SET($areaId,area_id)")
                ->where('dm_clinic.clinic_full_name', 'like', '%' . $searchText . '%')
                ->where('dm_clinic_image.clinic_image_type', '=', 1)
                ->where('dm_clinic.clinic_is_approved', '=', 1)
                ->select([
                    'dm_clinic.clinic_first_name',
                    'dm_clinic.clinic_last_name',
                    'dm_clinic.clinic_full_name',
                    'dm_clinic.clinic_mobile_number',
                    'dm_clinic.clinic_id',
                    'dm_clinic.clinic_address',
                    'dm_clinic_image.clinic_image',

                ])
                ->limit($itemToLoad)
                ->offset($pageNumber)
                ->orderBy('dm_clinic.clinic_full_name')
                ->get();
        }

        $data_response = array();
        if (count($getQuery) <= 0) {
            array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
        } else {
            array_push($data_response, array('data_status' => 'ok'));
            array_push($data_response, array('data' => $getQuery->toArray()));
            echo json_encode($data_response);
        }
    }

    // To get the doctor list
    public function getDctorsList($pageNumber, $itemToLoad, $searchText, $cityId, $areaId, $position, $diseaseCategoryId)
    {
        $pageNumber = $pageNumber;
        $itemToLoad = $itemToLoad;
        if ($pageNumber == 1) {
            $pageNumber = 0;
        } else {
            $pageNumber = $itemToLoad * $pageNumber;
            $pageNumber = $pageNumber - $itemToLoad;
        }
        if ($areaId == "0") {
            if ($diseaseCategoryId == "0") {
                $getQuery = DB::table('dm_doctor')
                    ->leftJoin('dm_user', 'dm_user.user_id', '=', 'dm_doctor.user_id')
                    ->leftJoin('dm_specialization', 'dm_doctor.doctor_id', '=', 'dm_specialization.doctor_id')
                    ->leftJoin('dm_doctor_education', 'dm_doctor.doctor_id', '=', 'dm_doctor_education.doctor_id')

                    ->whereRaw("FIND_IN_SET($position,dm_doctor.doctor_position)")
                    ->where('dm_doctor.doctor_is_active', '=', 1)
                    ->whereRaw("FIND_IN_SET($cityId,city_id)")
                    ->where('dm_doctor.doctor_full_name', 'like', '%' . $searchText . '%')
                    ->where('dm_specialization.specialization_type', '=', 1)
                    ->where('dm_doctor_education.education_type', '=', 1)
                    ->select([
                        'dm_user.user_id',

                        'dm_doctor.doctor_first_name',
                        'dm_doctor.doctor_last_name',
                        'dm_doctor.doctor_full_name',
                        'dm_doctor.doctor_mobile_number',
                        'dm_doctor.doctor_profile_image',

                        'dm_specialization.specialization_name',
                        'dm_doctor.doctor_city',
                        'dm_doctor.doctor_id',
                        'dm_doctor.doctor_overall_experience',
                        'dm_doctor_education.education_name',
                    ])
                    ->limit($itemToLoad)
                    ->offset($pageNumber)
                    ->orderBy('dm_doctor.doctor_full_name')

                    ->get();
            } else {
                $getQuery = DB::table('dm_doctor')
                    ->leftJoin('dm_user', 'dm_user.user_id', '=', 'dm_doctor.user_id')
                    ->leftJoin('dm_specialization', 'dm_doctor.doctor_id', '=', 'dm_specialization.doctor_id')
                    ->leftJoin('dm_doctor_education', 'dm_doctor.doctor_id', '=', 'dm_doctor_education.doctor_id')
                    ->whereRaw("FIND_IN_SET($position,dm_doctor.doctor_position)")
                    ->where('dm_doctor.doctor_is_active', '=', 1)
                    ->whereRaw("FIND_IN_SET($cityId,city_id)")
                    ->where('dm_doctor.doctor_full_name', 'like', '%' . $searchText . '%')
                    ->where('dm_specialization.specialization_type', '=', 1)
                    ->where('dm_doctor.disease_category_id', '=', $diseaseCategoryId)
                    ->where('dm_doctor_education.education_type', '=', 1)

                    ->select([
                        'dm_user.user_id',

                        'dm_doctor.doctor_first_name',
                        'dm_doctor.doctor_last_name',
                        'dm_doctor.doctor_full_name',
                        'dm_doctor.doctor_mobile_number',
                        'dm_doctor.doctor_profile_image',

                        'dm_specialization.specialization_name',
                        'dm_doctor.doctor_city',
                        'dm_doctor.doctor_id',
                        'dm_doctor.doctor_overall_experience',
                        'dm_doctor_education.education_name',
                    ])
                    ->limit($itemToLoad)
                    ->offset($pageNumber)
                    ->orderBy('dm_doctor.doctor_full_name')
                    ->get();
            }

        } else {
            if ($diseaseCategoryId == "0") {
                $getQuery = DB::table('dm_doctor')
                    ->leftJoin('dm_user', 'dm_user.user_id', '=', 'dm_doctor.user_id')
                    ->leftJoin('dm_specialization', 'dm_doctor.doctor_id', '=', 'dm_specialization.doctor_id')
                    ->leftJoin('dm_doctor_education', 'dm_doctor.doctor_id', '=', 'dm_doctor_education.doctor_id')
                    ->whereRaw("FIND_IN_SET($position,dm_doctor.doctor_position)")
                    ->where('dm_doctor.doctor_is_active', '=', 1)
                    ->whereRaw("FIND_IN_SET($cityId,city_id)")
                    ->whereRaw("FIND_IN_SET($areaId,area_id)")
                    ->where('dm_doctor.doctor_full_name', 'like', '%' . $searchText . '%')
                    ->where('dm_specialization.specialization_type', '=', 1)
                    ->where('dm_doctor_education.education_type', '=', 1)
                    ->select([
                        'dm_user.user_id',

                        'dm_doctor.doctor_first_name',
                        'dm_doctor.doctor_last_name',
                        'dm_doctor.doctor_full_name',
                        'dm_doctor.doctor_mobile_number',
                        'dm_doctor.doctor_profile_image',

                        'dm_specialization.specialization_name',
                        'dm_doctor.doctor_city',
                        'dm_doctor.doctor_id',
                        'dm_doctor.doctor_overall_experience',
                        'dm_doctor_education.education_name',
                    ])
                    ->limit($itemToLoad)
                    ->offset($pageNumber)
                    ->orderBy('dm_doctor.doctor_full_name')
                    ->get();
            } else {
                $getQuery = DB::table('dm_doctor')
                    ->leftJoin('dm_user', 'dm_user.user_id', '=', 'dm_doctor.user_id')
                    ->leftJoin('dm_specialization', 'dm_doctor.doctor_id', '=', 'dm_specialization.doctor_id')
                    ->leftJoin('dm_doctor_education', 'dm_doctor.doctor_id', '=', 'dm_doctor_education.doctor_id')
                    ->whereRaw("FIND_IN_SET($position,dm_doctor.doctor_position)")
                    ->where('dm_doctor.doctor_is_active', '=', 1)
                    ->whereRaw("FIND_IN_SET($cityId,city_id)")
                    ->whereRaw("FIND_IN_SET($areaId,area_id)")
                    ->where('dm_doctor.doctor_full_name', 'like', '%' . $searchText . '%')
                    ->where('dm_specialization.specialization_type', '=', 1)
                    ->where('dm_doctor.disease_category_id', '=', $diseaseCategoryId)
                    ->where('dm_doctor_education.education_type', '=', 1)
                    ->select([
                        'dm_user.user_id',

                        'dm_doctor.doctor_first_name',
                        'dm_doctor.doctor_last_name',
                        'dm_doctor.doctor_full_name',
                        'dm_doctor.doctor_mobile_number',
                        'dm_doctor.doctor_profile_image',

                        'dm_specialization.specialization_name',
                        'dm_doctor.doctor_city',
                        'dm_doctor.doctor_id',
                        'dm_doctor.doctor_overall_experience',
                        'dm_doctor_education.education_name',
                    ])
                    ->limit($itemToLoad)
                    ->offset($pageNumber)
                    ->orderBy('dm_doctor.doctor_full_name')
                    ->get();
            }

        }

        $data_response = array();
        if (count($getQuery) <= 0) {
            array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
        } else {
            array_push($data_response, array('data_status' => 'ok'));
            array_push($data_response, array('data' => $getQuery->toArray()));
            echo json_encode($data_response);
        }
    }

// To Change password
    public function changeCustomerPassword($oldPassword, $newPassword, $userId)
    {
        try {
            $getQuery = DB::table('dm_user')
                ->where('user_id', '=', $userId)
                ->select(['password'])
                ->first();
            $bcryptPassword = $getQuery->password;
            if (password_verify($oldPassword, $bcryptPassword)) {

                DB::table('dm_user')
                    ->where('user_id', $userId)
                    ->update([
                        'password' => bcrypt($newPassword),
                        'password_normal' => $newPassword,

                    ]);

                $resultData['result'] = "success";
            } else {
                $resultData['result'] = "wrong";
            }
        } catch (Exception $ex) {
            $resultData['result'] = "exception";
        }

        return $resultData;
    }

    // Update profile image
    public function updateCustomerProfileImage($userId, $fileName)
    {
        try {
            DB::beginTransaction();
            DB::table('dm_customer_personal_details')
                ->where('user_id', $userId)
                ->update(['customer_profile_image' => $fileName]);

            DB::table('dm_family_member')
                ->where('user_id', $userId)
                ->where('is_self', '=', 1)
                ->update(['family_member_profile_image' => $fileName]);

            DB::commit();
            $resultData['result'] = "success";
        } catch (Exception $ex) {
            DB::rollback();
        }

        return $resultData;
    }
    // Remove profile image
    public function removeCustomerProfileImage($userId, $fileName)
    {
        try {
            DB::beginTransaction();
            DB::table('dm_customer_personal_details')
                ->where('user_id', $userId)
                ->update(['customer_profile_image' => null]);

            DB::table('dm_family_member')
                ->where('user_id', $userId)
                ->where('is_self', '=', 1)
                ->update(['family_member_profile_image' => null]);

            if (file_exists(storage_path('app/public/user_profile_pic/' . $fileName))) {
                unlink(storage_path('app/public/user_profile_pic/' . $fileName));
            }
            DB::commit();
            $resultData['result'] = "success";
        } catch (Exception $ex) {
            DB::rollback();
        }

        return $resultData;
    }

    // update first name
    public function updateCustomerFirstName($userId, $firstName, $fullName)
    {

        try {
            DB::beginTransaction();
            DB::table('dm_customer_personal_details')
                ->where('user_id', $userId)
                ->update(['customer_first_name' => ucfirst($firstName), 'customer_full_name' => $fullName]);

            DB::table('dm_family_member')
                ->where('user_id', $userId)
                ->where('is_self', '=', 1)
                ->update([
                    'family_member_first_name' => ucfirst($firstName),
                    'family_member_full_name' => $fullName,
                ]);

            DB::commit();
            $resultData['result'] = "success";
        } catch (Exception $ex) {
            DB::rollback();
        }

        return $resultData;
    }
    //update last name
    public function updateCustomerLastName($userId, $lastName, $fullName)
    {

        try {
            DB::beginTransaction();
            DB::table('dm_customer_personal_details')
                ->where('user_id', $userId)
                ->update(['customer_last_name' => ucfirst($lastName), 'customer_full_name' => $fullName]);

            DB::table('dm_family_member')
                ->where('user_id', $userId)
                ->where('is_self', '=', 1)
                ->update([
                    'family_member_last_name' => ucfirst($lastName),
                    'family_member_full_name' => $fullName,
                ]);

            DB::commit();
            $resultData['result'] = "success";
        } catch (Exception $ex) {
            DB::rollback();
        }

        return $resultData;
    }

    // update mobile number
    public function updateCustomerMobileNumber($userId, $mobileNumber)
    {

        $getQuery = DB::table('dm_user')->
            where('user_mobile', $mobileNumber)
            ->where('user_id', '!=', $userId)
            ->get();
        if ($getQuery->count() == 0) {
            try {

                DB::beginTransaction();
                DB::table('dm_user')
                    ->where('user_id', $userId)

                    ->update(['user_mobile' => $mobileNumber]);
                DB::table('dm_customer_personal_details')
                    ->where('user_id', $userId)

                    ->update(['customer_mobile_number' => $mobileNumber]);

                DB::table('dm_family_member')
                    ->where('user_id', $userId)
                    ->where('is_self', '=', 1)
                    ->update(['family_member_mobile_number' => $mobileNumber]);

                DB::commit();
                $resultData['result'] = "success";
            } catch (Exception $ex) {
                DB::rollback();
            }
        } else {
            $resultData['result'] = "exists";
        }
        return $resultData;
    }

    // to get the customer personal profile details
    public function getCustomerPersonalProfileDetails($userId)
    {
        $getQuery = DB::table('dm_customer_personal_details')
            ->where('user_id', '=', $userId)
            ->get();
        $getResult = $getQuery->toArray();
        return $getResult;
    }
    //update customer personal profile details
    public function updateCustomerPersonalProfileDetails($userId, $email, $dob, $gender,
        $bloodGroup, $martitalStatus, $height, $weight, $address) {
        if ($email != null || !isEmpty($email)) {
            $getQuery = DB::table('dm_customer_personal_details')->
                where('customer_email', $email)
                ->where('user_id', '!=', $userId)
                ->get();
            if ($getQuery->count() == 0) {
                $currentDate = null;
                $dateDiff = null;
                if ($dob != null || !isEmpty($dob)) {
                    $dob = new DateTime($dob);
                    $currentDate = new DateTime();
                    $dateDiff = $dob->diff($currentDate);
                }
                try {
                    DB::beginTransaction();
                    DB::table('dm_customer_personal_details')
                        ->where('user_id', $userId)

                        ->update(['customer_email' => $email,
                            'customer_dob' => $dob,
                            'customer_age' => $dateDiff != null ? $dateDiff->y . " years, " . $dateDiff->m . " months, " . $dateDiff->d . " days" : null,
                            'customer_gender' => $gender,
                            'customer_blood_group' => $bloodGroup,
                            'customer_marital_status' => $martitalStatus,
                            'customer_height' => $height,
                            'customer_weight' => $weight,
                            'customer_address' => $address,
                        ]);

                    DB::table('dm_family_member')
                        ->where('user_id', $userId)
                        ->where('is_self', '=', 1)
                        ->update(['family_member_email' => $email,
                            'family_member_dob' => $dob,
                            'family_member_age' => $dateDiff != null ? $dateDiff->y . " years, " . $dateDiff->m . " months, " . $dateDiff->d . " days" : null,
                            'family_member_gender' => $gender,
                            'family_member_blood_group' => $bloodGroup,
                            'family_member_marital_status' => $martitalStatus,
                            'family_member_height' => $height,
                            'family_member_weight' => $weight,
                            'family_member_address' => $address,
                        ]);

                    DB::commit();
                    $resultData['result'] = "success";
                } catch (Exception $ex) {
                    DB::rollback();
                }

            } else {
                $resultData['result'] = "exists";
            }

        } else {
            $currentDate = null;
            $dateDiff = null;
            if ($dob != null || !isEmpty($dob)) {
                $dob = new DateTime($dob);
                $currentDate = new DateTime();
                $dateDiff = $dob->diff($currentDate);
            }
            try {
                DB::beginTransaction();
                DB::table('dm_customer_personal_details')
                    ->where('user_id', $userId)
                    ->update([
                        'customer_email' => $email,
                        'customer_dob' => $dob,
                        'customer_age' => $dateDiff != null ? $dateDiff->y . " years, " . $dateDiff->m . " months, " . $dateDiff->d . " days" : null,
                        'customer_gender' => $gender,
                        'customer_blood_group' => $bloodGroup,
                        'customer_marital_status' => $martitalStatus,
                        'customer_height' => $height,
                        'customer_weight' => $weight,
                        'customer_address' => $address,
                    ]);

                DB::table('dm_family_member')
                    ->where('user_id', $userId)
                    ->where('is_self', '=', 1)
                    ->update([
                        'family_member_email' => $email,
                        'family_member_dob' => $dob,
                        'family_member_age' => $dateDiff != null ? $dateDiff->y . " years, " . $dateDiff->m . " months, " . $dateDiff->d . " days" : null,
                        'family_member_gender' => $gender,
                        'family_member_blood_group' => $bloodGroup,
                        'family_member_marital_status' => $martitalStatus,
                        'family_member_height' => $height,
                        'family_member_weight' => $weight,
                        'family_member_address' => $address,
                    ]);

                DB::commit();
                $resultData['result'] = "success";
            } catch (Exception $ex) {
                DB::rollback();
            }

        }

        return $resultData;
    }

// to get the clinic images
    public function getClinicImages($clinicId)
    {
        $getQuery = DB::table('dm_clinic_image')
            ->where('dm_clinic_image.clinic_id', '=', $clinicId)
            ->where('dm_clinic_image.clinic_image_is_active', '=', 1)

            ->select([
                'dm_clinic_image.clinic_image',
                'dm_clinic_image.clinic_image_id',
            ])
            ->get();
        $getResult = $getQuery->toArray();
        return $getResult;
    }

    // to get the individual clinic details
    public function getClinicDetails($clinicId)
    {
        $getQuery = DB::table('dm_clinic')
            ->leftJoin('dm_user', 'dm_user.user_id', '=', 'dm_clinic.user_id')
            ->where('dm_clinic.clinic_id', '=', $clinicId)
            ->select([
                'dm_clinic.clinic_first_name',
                'dm_clinic.clinic_last_name',
                'dm_clinic.clinic_full_name',
                'dm_clinic.clinic_mobile_number',
                'dm_clinic.clinic_profile_image',
                'dm_clinic.clinic_id',
                'dm_clinic.clinic_address',

                DB::raw('DATE_FORMAT(dm_clinic.clinic_setup_date, "%d-%m-%Y") as clinic_setup_date', "%d-%m-%Y"),
                'dm_clinic.clinic_license_number',
                'dm_clinic.clinic_email_id',
                'dm_clinic.clinic_secondary_mobile',
                'dm_clinic.clinic_whatsapp',
                'dm_clinic.clinic_facebook',
                'dm_clinic.clinic_instagram',
                'dm_clinic.clinic_description',
                'dm_clinic.clinic_longitude',
                'dm_clinic.clinic_latitude',

            ])
            ->get();
        $getResult = $getQuery->toArray();
        return $getResult;
    }

    // to get the clinic timing
    public function getClinicTiming($clinicId)
    {
        $getQuery = DB::table('dm_clinic_timing')
            ->where('dm_clinic_timing.clinic_id', '=', $clinicId)
            ->where('dm_clinic_timing.clinic_timing_is_active', '=', 1)

            ->select([
                'dm_clinic_timing.clinic_timing_id',
                'dm_clinic_timing.clinic_days',
                'dm_clinic_timing.clinic_timing',
                'dm_clinic_timing.clinic_open_closed',
            ])
            ->get();
        $getResult = $getQuery->toArray();
        return $getResult;
    }

    // to get the clinic service
    public function getClinicService($clinicId)
    {
        $getQuery = DB::table('dm_clinic_service')
            ->where('dm_clinic_service.clinic_id', '=', $clinicId)
            ->where('dm_clinic_service.clinic_service_is_active', '=', 1)

            ->select([
                'dm_clinic_service.clinic_service_id',
                'dm_clinic_service.clinic_service_name',
            ])
            ->get();
        $getResult = $getQuery->toArray();
        return $getResult;
    }

    // To get the doctor list clinic wise
    public function getDoctorsListClinicWise($pageNumber, $itemToLoad, $clinicId)
    {
        $pageNumber = $pageNumber;
        $itemToLoad = $itemToLoad;
        if ($pageNumber == 1) {
            $pageNumber = 0;
        } else {
            $pageNumber = $itemToLoad * $pageNumber;
            $pageNumber = $pageNumber - $itemToLoad;
        }

        $getQuery = DB::table('dm_doctor_clinic_wise')
            ->leftJoin('dm_doctor', 'dm_doctor.doctor_id', '=', 'dm_doctor_clinic_wise.doctor_id')
            ->leftJoin('dm_user', 'dm_doctor.user_id', '=', 'dm_user.user_id')
            ->leftJoin('dm_specialization', 'dm_doctor.doctor_id', '=', 'dm_specialization.doctor_id')
            ->leftJoin('dm_doctor_education', 'dm_doctor.doctor_id', '=', 'dm_doctor_education.doctor_id')

            ->where('dm_doctor.doctor_is_active', '=', 1)
            ->where('dm_doctor_clinic_wise.doctor_clinic_wise_is_active', '=', 1)
            ->where('dm_specialization.specialization_type', '=', 1)
            ->where('dm_doctor_clinic_wise.clinic_id', '=', $clinicId)
            ->where('dm_doctor_education.education_type', '=', 1)
            ->select([
                'dm_user.user_id',

                'dm_doctor.doctor_first_name',
                'dm_doctor.doctor_last_name',
                'dm_doctor.doctor_full_name',
                'dm_doctor.doctor_mobile_number',
                'dm_doctor.doctor_profile_image',

                'dm_specialization.specialization_name',
                'dm_doctor.doctor_city',
                'dm_doctor.doctor_id',
                'dm_doctor.doctor_overall_experience',
                'dm_doctor_education.education_name',
                'dm_doctor_clinic_wise.in_clinic_appointment_fee_is_visible',
                'dm_doctor_clinic_wise.video_consultation_fee_is_visible',
                'dm_doctor_clinic_wise.video_consultation_is_avialable',
                'dm_doctor_clinic_wise.in_clinic_appointment_fee',
                'dm_doctor_clinic_wise.in_clinic_service_fee',
                'dm_doctor_clinic_wise.video_consultation_service_fee',
                'dm_doctor_clinic_wise.video_consultation_fee',

                'dm_doctor_clinic_wise.in_clinic_consultation_is_avialable',
                'dm_doctor_clinic_wise.in_clinic_cancellation_days',
                'dm_doctor_clinic_wise.video_cancellation_days',
                'dm_doctor_clinic_wise.in_clinic_book_before_days',
                'dm_doctor_clinic_wise.video_book_before_days',
            ])
            ->limit($itemToLoad)
            ->offset($pageNumber)
            ->inRandomOrder()
            ->get();

        $data_response = array();
        if (count($getQuery) <= 0) {
            array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
        } else {
            array_push($data_response, array('data_status' => 'ok'));
            array_push($data_response, array('data' => $getQuery->toArray()));
            echo json_encode($data_response);
        }
    }

    // to get the doctor details
    public function getDoctorDetails($doctorId)
    {
        $getQuery = DB::table('dm_doctor')
            ->leftJoin('dm_user', 'dm_user.user_id', '=', 'dm_doctor.user_id')
            ->leftJoin('dm_specialization', 'dm_doctor.doctor_id', '=', 'dm_specialization.doctor_id')
            ->leftJoin('dm_doctor_education', 'dm_doctor.doctor_id', '=', 'dm_doctor_education.doctor_id')

            ->where('dm_doctor.doctor_is_active', '=', 1)
            ->where('dm_doctor.doctor_id', '=', $doctorId)
            ->where('dm_specialization.specialization_type', '=', 1)
            ->where('dm_doctor_education.education_type', '=', 1)
            ->select([
                'dm_user.user_id',

                'dm_doctor.doctor_first_name',
                'dm_doctor.doctor_last_name',
                'dm_doctor.doctor_full_name',
                'dm_doctor.doctor_mobile_number',
                'dm_doctor.doctor_profile_image',

                'dm_specialization.specialization_name',
                'dm_doctor_education.education_name',
                'dm_doctor.doctor_city',
                'dm_doctor.doctor_id',
                'dm_doctor.doctor_overall_experience',
                'dm_doctor.doctor_description',
                'doctor_registration_number',
            ])
            ->get();
        $getResult = $getQuery->toArray();
        return $getResult;
    }

    // to get the doctor associated clinic
    public function getDoctorAssociatedClinic($doctorId, $clinicId)
    {
        if ($clinicId == "0") {
            $getQuery = DB::table('dm_doctor_clinic_wise')
                ->leftJoin('dm_clinic', 'dm_clinic.clinic_id', '=', 'dm_doctor_clinic_wise.clinic_id')
                ->leftJoin('dm_user', 'dm_user.user_id', '=', 'dm_clinic.user_id')
                ->leftJoin('dm_clinic_image', 'dm_doctor_clinic_wise.clinic_id', '=', 'dm_clinic_image.clinic_id')

                ->where('dm_doctor_clinic_wise.doctor_clinic_wise_is_active', '=', 1)
                ->where('dm_doctor_clinic_wise.doctor_id', '=', $doctorId)
                ->where('dm_clinic_image.clinic_image_type', '=', 1)
                ->select([
                    'dm_user.user_id',

                    'dm_clinic.clinic_first_name',
                    'dm_clinic.clinic_last_name',
                    'dm_clinic.clinic_full_name',
                    'dm_clinic.clinic_mobile_number',
                    'dm_clinic.clinic_profile_image',
                    'dm_clinic.clinic_address',

                    'dm_doctor_clinic_wise.doctor_id',
                    'dm_doctor_clinic_wise.clinic_id',
                    'dm_doctor_clinic_wise.in_clinic_appointment_fee_is_visible',
                    'dm_doctor_clinic_wise.video_consultation_fee_is_visible',
                    'dm_doctor_clinic_wise.video_consultation_is_avialable',
                    'dm_doctor_clinic_wise.in_clinic_appointment_fee',
                    'dm_doctor_clinic_wise.video_consultation_fee',
                    'dm_doctor_clinic_wise.in_clinic_consultation_is_avialable',
                    'dm_doctor_clinic_wise.in_clinic_service_fee',
                    'dm_doctor_clinic_wise.video_consultation_service_fee',
                    'dm_doctor_clinic_wise.in_clinic_cancellation_days',
                    'dm_doctor_clinic_wise.video_cancellation_days',
                    'dm_doctor_clinic_wise.in_clinic_book_before_days',
                    'dm_doctor_clinic_wise.video_book_before_days',
                    'dm_clinic_image.clinic_image',

                ])
                ->get();
        } else {
            $getQuery = DB::table('dm_doctor_clinic_wise')
                ->leftJoin('dm_clinic', 'dm_clinic.clinic_id', '=', 'dm_doctor_clinic_wise.clinic_id')
                ->leftJoin('dm_user', 'dm_user.user_id', '=', 'dm_clinic.user_id')
                ->leftJoin('dm_clinic_image', 'dm_doctor_clinic_wise.clinic_id', '=', 'dm_clinic_image.clinic_id')

                ->where('dm_doctor_clinic_wise.doctor_clinic_wise_is_active', '=', 1)
                ->where('dm_doctor_clinic_wise.doctor_id', '=', $doctorId)
                ->where('dm_doctor_clinic_wise.clinic_id', '=', $clinicId)
                ->where('dm_clinic_image.clinic_image_type', '=', 1)
                ->select([
                    'dm_user.user_id',

                    'dm_clinic.clinic_first_name',
                    'dm_clinic.clinic_last_name',
                    'dm_clinic.clinic_full_name',
                    'dm_clinic.clinic_mobile_number',
                    'dm_clinic.clinic_profile_image',
                    'dm_clinic.clinic_address',

                    'dm_doctor_clinic_wise.doctor_id',
                    'dm_doctor_clinic_wise.clinic_id',
                    'dm_doctor_clinic_wise.in_clinic_appointment_fee_is_visible',
                    'dm_doctor_clinic_wise.video_consultation_fee_is_visible',
                    'dm_doctor_clinic_wise.video_consultation_is_avialable',
                    'dm_doctor_clinic_wise.in_clinic_appointment_fee',
                    'dm_doctor_clinic_wise.video_consultation_fee',
                    'dm_doctor_clinic_wise.in_clinic_consultation_is_avialable',
                    'dm_doctor_clinic_wise.in_clinic_service_fee',
                    'dm_doctor_clinic_wise.video_consultation_service_fee',
                    'dm_doctor_clinic_wise.in_clinic_cancellation_days',
                    'dm_doctor_clinic_wise.video_cancellation_days',
                    'dm_doctor_clinic_wise.in_clinic_book_before_days',
                    'dm_doctor_clinic_wise.video_book_before_days',
                    'dm_clinic_image.clinic_image',

                ])
                ->get();
        }

        $getResult = $getQuery->toArray();
        return $getResult;
    }

    // to get the doctor other details
    public function getDoctorOtherDetails($doctorId)
    {
        $getQuery = DB::table('dm_doctor')
            ->leftJoin('dm_doctor_awards_recognisition', 'dm_doctor.doctor_id', '=', 'dm_doctor_awards_recognisition.doctor_id')
            ->leftJoin('dm_doctor_experience', 'dm_doctor.doctor_id', '=', 'dm_doctor_experience.doctor_id')
            ->leftJoin('dm_membership', 'dm_doctor.doctor_id', '=', 'dm_membership.doctor_id')
            ->leftJoin('dm_specialization', 'dm_doctor.doctor_id', '=', 'dm_specialization.doctor_id')
            ->leftJoin('dm_doctor_education', 'dm_doctor.doctor_id', '=', 'dm_doctor_education.doctor_id')

            ->where('dm_doctor.doctor_id', '=', $doctorId)

            ->select([
                DB::raw("(SELECT  group_concat(distinct(dm_doctor_awards_recognisition.awards_recognisition_name))) as awards_recognisition_name"),
                DB::raw("(SELECT group_concat(distinct(dm_doctor_experience.experience_name))) as experience_name"),
                DB::raw("(SELECT group_concat(distinct(dm_membership.membership_name))) as membership_name"),
                DB::raw("(SELECT group_concat(distinct(dm_specialization.specialization_name))) as specialization_name"),
                DB::raw("(SELECT group_concat(distinct(dm_doctor_education.education_name))) as education_name"),
            ])
            ->get();
        $getResult = $getQuery->toArray();
        return $getResult;
    }

// to get the booking slot
    public function getInClinicBookingSlotDates($clinicId, $doctorId)
    {
        $currentDate = date('Y-m-d');
        $getQuery = DB::select("select `dm_doctor`.`doctor_full_name`,
        `dm_doctor`.`doctor_first_name`,`dm_doctor`.`doctor_last_name`,
        `dm_doctor`.`doctor_id`, `dm_doctor`.`doctor_profile_image`, `dm_clinic`.`clinic_id`,
        `dm_clinic`.`clinic_full_name`, `dm_clinic`.`clinic_address`, DATE_FORMAT(dm_in_clinic_slot_dates.in_clinic_slot_dates, '%D %M %Y')
        as in_clinic_slot_dates, DATE_FORMAT(dm_in_clinic_slot_dates.in_clinic_slot_dates, '%Y-%m-%d')
        as in_clinic_slot_dates_another_date_format, DATE_FORMAT(now(), '%Y-%m-%d')
        as server_current_date,`dm_in_clinic_slot_dates`.`in_clinic_slot_dates_id`, `dm_in_clinic_slot`.`in_clinic_slot_id`,
        `dm_in_clinic_slot`.`slot_name_id`, sum(distinct dm_in_clinic_slot_dates.in_clinic_max_slot_position_datewise) as in_clinic_max_slot_position_datewise,
        (select COUNT(dm_in_clinic_booking.in_clinic_slot_dates_id) from dm_in_clinic_booking where in_clinic_booking_is_active=1
        and doctor_id=dm_doctor.doctor_id and in_clinic_slot_dates_id= dm_in_clinic_slot_dates.in_clinic_slot_dates_id) AS booked_slot
         from `dm_in_clinic_slot_dates` left join `dm_in_clinic_slot`
         on `dm_in_clinic_slot`.`in_clinic_slot_id` = `dm_in_clinic_slot_dates`.`in_clinic_slot_id`
         left join `dm_doctor` on `dm_doctor`.`doctor_id` = `dm_in_clinic_slot`.`doctor_id`
         left join `dm_clinic` on `dm_clinic`.`clinic_id` = `dm_in_clinic_slot`.`clinic_id`
         left join dm_in_clinic_booking on dm_in_clinic_booking.in_clinic_slot_dates_id = dm_in_clinic_slot_dates.in_clinic_slot_dates_id
         where `dm_in_clinic_slot_dates`.`in_clinic_slot_dates_is_active` = 1
         and `dm_in_clinic_slot_dates`.`in_clinic_slot_dates` >= '$currentDate'
        and `dm_in_clinic_slot`.`clinic_id` = $clinicId and `dm_in_clinic_slot`.`doctor_id` = $doctorId
         group by `dm_in_clinic_slot_dates`.`in_clinic_slot_dates`");
        return $getQuery;

    }

    // To get the in clinic slot id and position date wise
    public function getInClinicSlotIdPositionDateWise($inClinicSlotBookingDate, $inClinicSlotId,
        $clinicId, $doctorId) {
        $inClinicSlotBookingDate = date("Y-m-d", strtotime($inClinicSlotBookingDate));
        $getQuery = DB::select("select dm_in_clinic_slot.in_clinic_slot_id,
        dm_in_clinic_slot.slot_name_id,dm_in_clinic_slot.clinic_id,dm_in_clinic_slot.doctor_id,
        dm_in_clinic_slot_dates.in_clinic_max_slot_position_datewise,
        dm_slot_name.slot_name,dm_in_clinic_slot_dates.in_clinic_slot_start_time,
        dm_in_clinic_slot_dates.in_clinic_slot_end_time
        from dm_in_clinic_slot_dates left join dm_in_clinic_slot on
         dm_in_clinic_slot.in_clinic_slot_id=dm_in_clinic_slot_dates.in_clinic_slot_id
         join dm_slot_name on dm_in_clinic_slot.slot_name_id=dm_slot_name.slot_name_id


        where dm_in_clinic_slot_dates.in_clinic_slot_dates='$inClinicSlotBookingDate' and
        dm_in_clinic_slot_dates.in_clinic_slot_dates_is_active=1
        and
        dm_in_clinic_slot.clinic_id=$clinicId and
        dm_in_clinic_slot.doctor_id=$doctorId
        ");
        return $getQuery;

    }

    // To get the in clinic slot id and position date wise
    public function getInClinicSlotIdPositionDateWiseForMyBooking($inClinicSlotBookingDate, $inClinicSlotId)
    {
        $inClinicSlotBookingDate = date("Y-m-d", strtotime($inClinicSlotBookingDate));
        $getQuery = DB::select("select dm_in_clinic_slot.in_clinic_slot_id,
        dm_in_clinic_slot.slot_name_id,dm_in_clinic_slot.clinic_id,dm_in_clinic_slot.doctor_id,
        dm_in_clinic_slot_dates.in_clinic_max_slot_position_datewise,
        dm_slot_name.slot_name,dm_in_clinic_slot_dates.in_clinic_slot_start_time,
        dm_in_clinic_slot_dates.in_clinic_slot_end_time
        from dm_in_clinic_slot_dates left join dm_in_clinic_slot on
         dm_in_clinic_slot.in_clinic_slot_id=dm_in_clinic_slot_dates.in_clinic_slot_id
         join dm_slot_name on dm_in_clinic_slot.slot_name_id=dm_slot_name.slot_name_id


        where dm_in_clinic_slot_dates.in_clinic_slot_dates='$inClinicSlotBookingDate' and
        dm_in_clinic_slot_dates.in_clinic_slot_dates_is_active=1 and
        dm_in_clinic_slot.in_clinic_slot_id=$inClinicSlotId
        ");
        return $getQuery;

    }

    // to get the booking slot position
    public function getInClinicBookingSlotPosition($inClinicSlotId,
        $inClinicBookingDate, $slotNameId, $clinicId, $doctorId, $inClinicMaxSlotPositionDateWise) {
        $inClinicBookingDate = date("Y-m-d", strtotime($inClinicBookingDate));
        $getQuery = DB::select("select in_clinic_booking_slot_position_master_position,in_clinic_booking_date,
        dm_in_clinic_booking.in_clinic_slot_id
        , ifnull(in_clinic_booking_slot_position,  'Free') as in_clinic_booking_slot_position ,
        (select distinct dm_in_clinic_slot_dates.in_clinic_slot_start_time
        from dm_in_clinic_slot_dates where
         dm_in_clinic_slot_dates.in_clinic_slot_id=$inClinicSlotId
         and dm_in_clinic_slot_dates.in_clinic_slot_dates='$inClinicBookingDate'
         )
        as in_clinic_slot_start_time,
        (select distinct dm_in_clinic_slot_dates.in_clinic_slot_end_time
        from dm_in_clinic_slot_dates
        where dm_in_clinic_slot_dates.in_clinic_slot_id=$inClinicSlotId
        and dm_in_clinic_slot_dates.in_clinic_slot_dates='$inClinicBookingDate'
        )
        as in_clinic_slot_end_time
        from dm_in_clinic_booking_slot_position_master

        left join dm_in_clinic_booking on
         dm_in_clinic_booking_slot_position_master.in_clinic_booking_slot_position_master_id
         = dm_in_clinic_booking.in_clinic_booking_slot_position

         and dm_in_clinic_booking.in_clinic_booking_date='$inClinicBookingDate'
         and dm_in_clinic_booking.slot_name_id=$slotNameId and
         clinic_id=$clinicId and doctor_id=$doctorId and
         dm_in_clinic_booking.in_clinic_slot_id=$inClinicSlotId

         and dm_in_clinic_booking.in_clinic_booking_is_active != 2
         order by in_clinic_booking_slot_position_master_position
         limit $inClinicMaxSlotPositionDateWise
         ");
        return $getQuery;

    }

    //update update family member
    public function saveUpdateFamilyMember($familyId, $userId, $firstName, $lastName, $mobileNumber,
        $profileImage, $email, $dob, $gender, $bloodGroup, $maritalStatus,
        $height, $weight, $address, $relation
    ) {
        try {

            DB::beginTransaction();

            $currentDate = null;
            $dateDiff = null;
            if ($dob != null || !isEmpty($dob)) {
                $dob = new DateTime($dob);
                $currentDate = new DateTime();
                $dateDiff = $dob->diff($currentDate);
            }
            if ($familyId == "0") {
                // insert
                DB::table('dm_family_member')->insertGetId(
                    [
                        'user_id' => $userId,
                        'family_member_first_name' => ucfirst($firstName),
                        'family_member_last_name' => ucfirst($lastName),
                        'family_member_full_name' => ucfirst($firstName) . " " . ucfirst($lastName),
                        'family_member_mobile_number' => $mobileNumber,
                        'family_member_profile_image' => $profileImage,
                        'family_member_email' => $email,
                        'family_member_dob' => $dob,
                        'family_member_age' => $dateDiff != null ? $dateDiff->y . " years, " . $dateDiff->m . " months, " . $dateDiff->d . " days" : null,
                        'family_member_gender' => $gender,
                        'family_member_blood_group' => $bloodGroup,
                        'family_member_marital_status' => $maritalStatus,
                        'family_member_height' => $height,
                        'family_member_weight' => $weight,
                        'family_member_address' => $address,
                        'family_member_relation' => $relation,
                    ]
                );
            } else {
                // update

                DB::table('dm_family_member')
                    ->where('family_member_id', $familyId)
                    ->update([
                        'family_member_first_name' => ucfirst($firstName),
                        'family_member_last_name' => ucfirst($lastName),
                        'family_member_full_name' => ucfirst($firstName) . " " . ucfirst($lastName),
                        'family_member_mobile_number' => $mobileNumber,
                        'family_member_profile_image' => $profileImage,
                        'family_member_email' => $email,
                        'family_member_dob' => $dob,
                        'family_member_age' => $dateDiff != null ? $dateDiff->y . " years, " . $dateDiff->m . " months, " . $dateDiff->d . " days" : null,
                        'family_member_gender' => $gender,
                        'family_member_blood_group' => $bloodGroup,
                        'family_member_marital_status' => $maritalStatus,
                        'family_member_height' => $height,
                        'family_member_weight' => $weight,
                        'family_member_address' => $address,
                        'family_member_relation' => $relation,

                    ]);
            }

            DB::commit();
            $resultData['result'] = "success";
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = $ex->getMessage();
        }

        return $resultData;
    }

    // to get the doctor other details
    public function getFamilyMemberList($userId)
    {
        $getQuery = DB::table('dm_family_member')

            ->where('user_id', '=', $userId)

            ->where('family_member_is_active', '=', 1)

            ->select([
                'is_self',
                'family_member_id',
                'user_id',
                'family_member_first_name',
                'family_member_last_name',
                'family_member_full_name',
                'family_member_mobile_number',
                'family_member_profile_image',
                'family_member_email',
                'family_member_dob',
                'family_member_gender',
                'family_member_blood_group',
                'family_member_marital_status',
                'family_member_height',
                'family_member_weight',
                'family_member_address',
            ])
            ->get();
        $getResult = $getQuery->toArray();
        return $getResult;
    }

    //save inclinic booking
    public function saveInClinicBooking($inClinicSlotId, $inClinicSlotDateId,
        $slotNameId, $clinicId, $doctorId, $bookingMadeByRoleId, $bookingMadeByUserId,
        $bookingMadeForFamilyId, $isBookingDoneForSelf, $bookingSlotPosition,
        $bookingDate, $inClinicPrice, $paymentMethodId,
        $rewardId, $rewardTransactionId, $offerId, $paidAmount, $offerPrice, $inClinicServiceFee,
        $inClinicCancellationDays
    ) {
        try {

            DB::beginTransaction();

            $getClinicQuery = DB::table('dm_clinic')->where('clinic_is_active', 1)
                ->where('clinic_id', $clinicId)
                ->get();
            $getClinicQueryResult = $getClinicQuery->toArray();

            $getDoctorQuery = DB::table('dm_doctor')->where('doctor_is_active', 1)
                ->where('doctor_id', $doctorId)
                ->get();
            $getDoctorQueryResult = $getDoctorQuery->toArray();

            $getUserQuery = DB::table('dm_family_member')->where('family_member_is_active', 1)
                ->where('family_member_id', $bookingMadeForFamilyId)
                ->get();
            $getUserQueryResult = $getUserQuery->toArray();

            $bookingCodePrefix = "IA" . date("ym");
            $bookingCode = IdGenerator::generate(['table' => 'dm_in_clinic_booking', 'field' => 'in_clinic_booking_code', 'length' => 12, 'prefix' => $bookingCodePrefix,
                'reset_on_prefix_change' => true]);

            $transactionCodePrefix = "IT" . date("ym");
            $transctionCode = IdGenerator::generate(['table' => 'dm_in_clinic_booking_transaction', 'field' => 'in_clinic_transaction_code', 'length' => 12, 'prefix' => $transactionCodePrefix,
                'reset_on_prefix_change' => true]);

            $bookingDate = date("Y-m-d", strtotime($bookingDate));
            $getGstQuery = DB::table('dm_gst')->where('gst_applicable_for', 1)
                ->where('gst_is_active', 1)
                ->whereRaw('now() between gst_valid_start_date and gst_valid_end_date')
                ->get();
            $getGstResult = $getGstQuery->toArray();

            $getBookingQuery = DB::table('dm_in_clinic_booking')->where('in_clinic_slot_dates_id', $inClinicSlotDateId)
                ->where('in_clinic_booking_slot_position', $bookingSlotPosition)
                ->where('slot_name_id', $slotNameId)
                ->where('in_clinic_booking_is_active', 1)
                ->where('clinic_id', $clinicId)
                ->where('doctor_id', $doctorId)

                ->get();
            if ($getBookingQuery->count() == 0) {

                $getFamilyQuery = DB::table('dm_in_clinic_booking')->where('in_clinic_slot_dates_id', $inClinicSlotDateId)
                    ->where('in_clinic_booking_made_for_family_id', $bookingMadeForFamilyId)
                    ->where('in_clinic_booking_is_active', 1)
                    ->where('clinic_id', $clinicId)
                    ->where('doctor_id', $doctorId)
                    ->get();

                if ($getFamilyQuery->count() == 0) {
                    $insertId = DB::table('dm_in_clinic_booking')->insertGetId(
                        [
                            'in_clinic_slot_id' => $inClinicSlotId,
                            'in_clinic_slot_dates_id' => $inClinicSlotDateId,
                            'slot_name_id' => $slotNameId,
                            'clinic_id' => $clinicId,
                            'doctor_id' => $doctorId,
                            'in_clinic_booking_made_by_role_id' => $bookingMadeByRoleId,
                            'in_clinic_booking_made_by_user_id' => $bookingMadeByUserId,
                            'in_clinic_booking_made_for_family_id' => $bookingMadeForFamilyId,
                            'in_clinic_is_booking_done_for_self' => $isBookingDoneForSelf,
                            'in_clinic_booking_slot_position' => $bookingSlotPosition,
							    'in_clinic_booking_current_slot_position'=> $bookingSlotPosition,
                            'in_clinic_booking_date' => $bookingDate,
                            'in_clinic_price' => $inClinicPrice,
                            'in_clinic_service_fee' => $inClinicServiceFee,
                            'in_clinic_booking_code' => $bookingCode,
                            'in_clinic_booking_cancellation_days' => $inClinicCancellationDays,
							'in_clinic_booking_appointment_time' => DB::raw("DATE_ADD((select in_clinic_slot_start_time from dm_in_clinic_slot_dates where in_clinic_slot_dates_id=$inClinicSlotDateId) ,
INTERVAL ((select in_clinic_slot_interval from dm_in_clinic_slot where in_clinic_slot_id=$inClinicSlotId) * ($bookingSlotPosition-1))  minute)") ,

'in_clinic_booking_reporting_time' =>DB::raw("date_add(DATE_ADD((select in_clinic_slot_start_time from dm_in_clinic_slot_dates where in_clinic_slot_dates_id=$inClinicSlotDateId) ,
INTERVAL ((select in_clinic_slot_interval from dm_in_clinic_slot where in_clinic_slot_id=$inClinicSlotId) * ($bookingSlotPosition-1))  minute), INTERVAL -15 minute)")


                        ]
                    );

                    DB::table('dm_in_clinic_booking_transaction')->insertGetId(
                        [
                            'in_clinic_booking_id' => $insertId,
                            'in_clinic_slot_id' => $inClinicSlotId,
                            'in_clinic_slot_dates_id' => $inClinicSlotDateId,
                            'slot_name_id' => $slotNameId,
                            'clinic_id' => $clinicId,
                            'doctor_id' => $doctorId,
                            'payment_method_id' => $paymentMethodId,
                            'reward_id' => $rewardId,
                            'reward_transaction_id' => $rewardTransactionId,
                            'offer_id' => $offerId,
                            'in_clinic_booking_made_by_role_id' => $bookingMadeByRoleId,
                            'in_clinic_booking_made_by_user_id' => $bookingMadeByUserId,
                            'in_clinic_booking_made_for_family_id' => $bookingMadeForFamilyId,
                            'in_clinic_is_booking_done_for_self' => $isBookingDoneForSelf,
                            'in_clinic_booking_slot_position' => $bookingSlotPosition,
                            'in_clinic_booking_date' => $bookingDate,
                            'in_clinic_price' => $inClinicPrice,
                            'in_clinic_service_fee' => $inClinicServiceFee,
                            'in_clinic_booking_paid_amount' => $paidAmount,
                            'in_clinic_booking_offer_price' => $inClinicServiceFee,
                            'in_clinic_booking_gst_price' => $paidAmount * $getGstResult[0]->gst_percentage / 100,
                            'in_clinic_booking_cgst_price' => $paidAmount * $getGstResult[0]->gst_cgst_percentage / 100,
                            'in_clinic_booking_sgst_price' => $paidAmount * $getGstResult[0]->gst_sgst_percentage / 100,
                            'in_clinic_booking_igst_price' => $paidAmount * $getGstResult[0]->gst_igst_percentage / 100,
                            'in_clinic_transaction_code' => $transctionCode,

                        ]
                    );
                    $smsBookingTextForCustomer = "Dear " . $getUserQueryResult[0]->family_member_full_name . " your booking has been confirmed for Dr.  " . $getDoctorQueryResult[0]->doctor_full_name . " dated " . $bookingDate . " with booking number " . $bookingSlotPosition . " . Please contact " . $getClinicQueryResult[0]->clinic_full_name;
                    DB::table('dm_sms_schedule_details')->insertGetId(
                        [
                            'mobile_number' => $getUserQueryResult[0]->family_member_mobile_number,
                            'sms_text' => $smsBookingTextForCustomer,
                            'sms_type' => 'Appointment Booking',

                        ]
                    );
                    $smsBookingTextForClinic = "Booking has made by " . $getUserQueryResult[0]->family_member_full_name . " for Dr.  " . $getDoctorQueryResult[0]->doctor_full_name . " dated " . $bookingDate . "";
                    DB::table('dm_sms_schedule_details')->insertGetId(
                        [
                            'mobile_number' => $getClinicQueryResult[0]->clinic_mobile_number,
                            'sms_text' => $smsBookingTextForClinic,
                            'sms_type' => 'Appointment Booking',

                        ]
                    );

                    DB::commit();
                    $resultData['result'] = "success";
                    $resultData['bookingCode'] = $bookingCode;

                } else {
                    $resultData['result'] = "bookedself";
                }

            } else {
                $resultData['result'] = "booked";
            }

        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] ="exception";
        }

        return $resultData;
    }

    public function sendBookingSMSForCustomer($clinicName, $clinicMobileNumber, $doctorName,
        $customerMobileNumber,
        $bookingDate, $customerName) {
        try
        {
            $smstext = rawurlencode("Dear " . $customerName . " your booking has been confirmed for Dr.  " . $doctorName . " dated " . $bookingDate . " . Please contact " . $clinicName);
            $ch = curl_init("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=V6dw6TBazEGoT3a3exO8UA&senderid=ODILAS&channel=2&DCS=0&flashsms=0&number=$customerMobileNumber&text=$smstext&route=1");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 2);
            $result = curl_exec($ch);
            if (curl_error($ch)) {
                $result = curl_errno($ch);
            }
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }

        return response()->json($result);
    }

    public function sendBookingSMSForClinic($clinicName, $clinicMobileNumber, $doctorName,
        $customerMobileNumber,
        $bookingDate, $customerName) {
        try
        {
            $smstext = rawurlencode("Booking has made by " . $customerName . " for Dr.  " . $doctorName . " dated " . $bookingDate . "");
            $ch = curl_init("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=V6dw6TBazEGoT3a3exO8UA&senderid=ODILAS&channel=2&DCS=0&flashsms=0&number=$clinicMobileNumber&text=$smstext&route=1");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 2);
            $result = curl_exec($ch);
            if (curl_error($ch)) {
                $result = curl_errno($ch);
            }
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }

        return response()->json($result);
    }

    public function getInClinicBookingList($bookigDoneByUserId,
        $bookigStatus, $pageNumber, $itemToLoad) {
        $pageNumber = $pageNumber;
        $itemToLoad = $itemToLoad;
        if ($pageNumber == 1) {
            $pageNumber = 0;
        } else {
            $pageNumber = $itemToLoad * $pageNumber;
            $pageNumber = $pageNumber - $itemToLoad;
        }

        $getFamilyQueryList = DB::table('dm_family_member')
            ->select([
                DB::raw("(SELECT group_concat(family_member_id)
                FROM dm_family_member
                 where family_member_is_active=1 and user_id=$bookigDoneByUserId
        ) as family_member_id"),

            ])
            ->where('user_id', '=', $bookigDoneByUserId)->get();

        $getQuery = DB::table('dm_in_clinic_booking')
            ->leftJoin('dm_in_clinic_slot', 'dm_in_clinic_slot.in_clinic_slot_id', '=', 'dm_in_clinic_booking.in_clinic_slot_id')
            ->leftJoin('dm_in_clinic_slot_dates', 'dm_in_clinic_slot_dates.in_clinic_slot_dates_id', '=', 'dm_in_clinic_booking.in_clinic_slot_dates_id')
            ->leftJoin('dm_slot_name', 'dm_slot_name.slot_name_id', '=', 'dm_in_clinic_booking.slot_name_id')
            ->leftJoin('dm_clinic', 'dm_clinic.clinic_id', '=', 'dm_in_clinic_booking.clinic_id')
            ->leftJoin('dm_doctor', 'dm_doctor.doctor_id', '=', 'dm_in_clinic_booking.doctor_id')
            ->leftJoin('dm_specialization', 'dm_doctor.doctor_id', '=', 'dm_specialization.doctor_id')
            ->leftJoin('dm_doctor_education', 'dm_doctor.doctor_id', '=', 'dm_doctor_education.doctor_id')

            ->leftJoin('dm_family_member', 'dm_family_member.family_member_id', '=', 'dm_in_clinic_booking.in_clinic_booking_made_for_family_id')
            ->leftJoin('dm_clinic_image', 'dm_clinic_image.clinic_id', '=', 'dm_clinic.clinic_id')

            ->whereIn('dm_in_clinic_booking.in_clinic_booking_made_for_family_id', explode(',', $getFamilyQueryList[0]->family_member_id))
            ->where('dm_in_clinic_booking.in_clinic_booking_is_active', '=', $bookigStatus)
            ->where('dm_clinic_image.clinic_image_type', '=', 1)
            ->where('dm_specialization.specialization_type', '=', 1)
            ->where('dm_doctor_education.education_type', '=', 1)
            ->select([
                'dm_clinic.clinic_id',
                'dm_clinic.clinic_first_name',
                'dm_clinic.clinic_last_name',
                'dm_clinic.clinic_full_name',
                'dm_clinic.clinic_mobile_number',
                'dm_clinic.clinic_profile_image',
                'dm_clinic_image.clinic_image',
                'dm_clinic.clinic_address',

                'dm_doctor.doctor_id',
                'dm_doctor.doctor_first_name',
                'dm_doctor.doctor_last_name',
                'dm_doctor.doctor_full_name',
                'dm_doctor.doctor_mobile_number',
                'dm_doctor.doctor_profile_image',
                'dm_specialization.specialization_name',
                'dm_doctor.doctor_overall_experience',
                'dm_doctor_education.education_name',

                'dm_family_member.family_member_id',
                'dm_family_member.user_id',
                'dm_family_member.family_member_first_name',
                'dm_family_member.family_member_last_name',
                'dm_family_member.family_member_full_name',
                'dm_family_member.family_member_mobile_number',
                'dm_family_member.family_member_profile_image',
                'dm_family_member.is_self',

                'dm_in_clinic_slot.in_clinic_slot_id',

                'dm_in_clinic_slot_dates.in_clinic_slot_dates_id',

                'dm_slot_name.slot_name_id',
                'dm_slot_name.slot_name',

                'dm_in_clinic_booking.in_clinic_booking_id',
                'dm_in_clinic_booking.in_clinic_booking_code',
                'dm_in_clinic_booking.in_clinic_booking_made_by_role_id',
                'dm_in_clinic_booking.in_clinic_booking_made_by_user_id',
                'dm_in_clinic_booking.in_clinic_booking_made_for_family_id',
                'dm_in_clinic_booking.in_clinic_is_booking_done_for_self',
                'dm_in_clinic_booking.in_clinic_booking_slot_position',
				   'dm_in_clinic_booking.in_clinic_booking_current_slot_position',
                'dm_in_clinic_booking.in_clinic_price',
                'dm_in_clinic_booking.in_clinic_service_fee',
                'dm_in_clinic_booking.in_clinic_booking_is_active',
                'dm_in_clinic_booking.in_clinic_booking_cancellation_days',
				 'dm_in_clinic_booking.in_clinic_booking_reporting_time',
                'dm_in_clinic_booking.in_clinic_booking_appointment_time',
				  DB::raw('timediff(dm_in_clinic_booking.in_clinic_booking_appointment_time,now()) as "waiting_time"'),

                DB::raw('if(DATE_sub(DATE_FORMAT(dm_in_clinic_booking.in_clinic_booking_date,"%Y-%m-%d"),
INTERVAL dm_in_clinic_booking.in_clinic_booking_cancellation_days DAY)>=date_format(now(),"%Y-%m-%d"),"1","0") as "booking_cancel_date_check"'),

                DB::raw('DATE_FORMAT(dm_in_clinic_booking.in_clinic_booking_date, "%d-%m-%Y") as in_clinic_booking_date', "%d-%m-%Y"),

            ])
            ->limit($itemToLoad)
            ->offset($pageNumber)
            ->orderBy('dm_in_clinic_booking.in_clinic_booking_date', 'desc')
            ->get();

        $data_response = array();
        if (count($getQuery) <= 0) {
            array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
        } else {
            array_push($data_response, array('data_status' => 'ok'));
            array_push($data_response, array('data' => $getQuery->toArray()));
            echo json_encode($data_response);
        }
    }

    //cancel in clinic booking
     public function cancelInClinicBooking($in_clinic_booking_id, $familyMobileNumber,
        $doctorName, $clinicName, $bookingDate,$inClinicSlotDatesId,$inClinicSlotId ) {
        try {

            DB::beginTransaction();

            DB::table('dm_in_clinic_booking')
                ->where('in_clinic_booking_id', $in_clinic_booking_id)
                ->update([
                    'in_clinic_booking_is_active' => 2, //rejected
                    'in_clinic_booking_updated_date' => now(),
                ]);

            DB::table('dm_in_clinic_booking_transaction')
                ->where('in_clinic_booking_id', $in_clinic_booking_id)
                ->update([
                    'in_clinic_booking_transaction_is_active' => 2, //rejected
                    'in_clinic_booking_transaction_update_date' => now(),

                ]);

                 DB::unprepared("DROP TEMPORARY TABLE IF EXISTS slot_temp;CREATE TEMPORARY TABLE slot_temp
AS
(SELECT  @a:=@a+1 rank,
        in_clinic_booking_id
FROM    dm_in_clinic_booking,
        (SELECT @a:= 0) AS a

        where in_clinic_slot_dates_id=$inClinicSlotDatesId and in_clinic_booking_is_active=1
        order by in_clinic_booking_id asc);

UPDATE dm_in_clinic_booking a, slot_temp b
SET a.in_clinic_booking_current_slot_position = b.rank,


in_clinic_booking_appointment_time =  DATE_ADD(current_time() ,
INTERVAL ((select in_clinic_slot_interval from dm_in_clinic_slot where in_clinic_slot_id=$inClinicSlotId) * (b.rank-1))  minute) ,

in_clinic_booking_reporting_time = date_add( DATE_ADD(current_time() ,
INTERVAL ((select in_clinic_slot_interval from dm_in_clinic_slot where in_clinic_slot_id=$inClinicSlotId) * (b.rank-1))  minute), INTERVAL -15 minute)


WHERE a.in_clinic_booking_id = b.in_clinic_booking_id

");


            $smsCancelBooking = "Your booking has been cancelled for Dr.  " . $doctorName . " dated " . $bookingDate . " . Please contact " . $clinicName;
            DB::table('dm_sms_schedule_details')->insertGetId(
                [
                    'mobile_number' => $familyMobileNumber,
                    'sms_text' => $smsCancelBooking,
                    'sms_type' => 'Cancel Booking',

                ]
            );

            DB::commit();

            $resultData['result'] = "success";
            // $this->cancelBookingSMS($familyMobileNumber, $doctorName, $clinicName, $bookingDate);
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
        }

        return $resultData;
    }

    // To get privacy policy
    public function getPrivacyPolicy($legalId)
    {

        $getQuery = DB::table('dm_legal')
            ->where('legal_id', '=', $legalId)
            ->where('legal_is_active', '=', 1)

            ->get();
        $getResult = $getQuery->toArray();
        return $getResult;
    }

    //clinic

    // Update profile image
    public function updateClinicProfileImage($clinicId, $fileName)
    {
        try {
            DB::beginTransaction();
            DB::table('dm_clinic')
                ->where('clinic_id', $clinicId)
                ->update(['clinic_profile_image' => $fileName]);

            DB::commit();
            $resultData['result'] = "success";
        } catch (Exception $ex) {
            DB::rollback();
        }

        return $resultData;
    }
    // Remove profile image
    public function removeClinicProfileImage($clinicId, $fileName)
    {
        try {
            DB::beginTransaction();
            DB::table('dm_clinic')
                ->where('clinic_id', $clinicId)
                ->update(['clinic_profile_image' => null]);

            if (file_exists(storage_path('app/public/user_profile_pic/' . $fileName))) {
                unlink(storage_path('app/public/user_profile_pic/' . $fileName));
            }
            DB::commit();
            $resultData['result'] = "success";
        } catch (Exception $ex) {
            DB::rollback();
        }

        return $resultData;
    }

    // update first name
    public function updateClinicFirstName($clinicId, $firstName, $fullName)
    {

        try {
            DB::beginTransaction();
            DB::table('dm_clinic')
                ->where('clinic_id', $clinicId)
                ->update(['clinic_first_name' => ucfirst($firstName), 'clinic_full_name' => $fullName]);

            DB::commit();
            $resultData['result'] = "success";
        } catch (Exception $ex) {
            DB::rollback();
        }

        return $resultData;
    }
    //update last name
    public function updateClinicLastName($clinicId, $lastName, $fullName)
    {

        try {
            DB::beginTransaction();
            DB::table('dm_clinic')
                ->where('clinic_id', $clinicId)
                ->update(['clinic_last_name' => ucfirst($lastName), 'clinic_full_name' => $fullName]);

            DB::commit();
            $resultData['result'] = "success";
        } catch (Exception $ex) {
            DB::rollback();
        }

        return $resultData;
    }

    // update mobile number
    public function updateClinicMobileNumber($clinicId, $userId, $mobileNumber)
    {

        $getQuery = DB::table('dm_user')->
            where('user_mobile', $mobileNumber)
            ->where('user_id', '!=', $userId)
            ->get();
        if ($getQuery->count() == 0) {
            try {

                DB::beginTransaction();
                DB::table('dm_user')
                    ->where('user_id', $userId)

                    ->update(['user_mobile' => $mobileNumber]);
                DB::table('dm_clinic')
                    ->where('clinic_id', $clinicId)

                    ->update(['clinic_mobile_number' => $mobileNumber]);

                DB::commit();
                $resultData['result'] = "success";
            } catch (Exception $ex) {
                DB::rollback();
            }
        } else {
            $resultData['result'] = "exists";
        }
        return $resultData;
    }

    //save inclinic booking by clinic
    public function saveInClinicBookingByClinic($familyId, $patientFirstName, $patientLastName,
        $patientMobileNumber, $isExistingPatient, $inClinicSlotId, $inClinicSlotDateId,
        $slotNameId, $clinicId, $doctorId, $bookingMadeByRoleId, $bookingMadeByUserId,
        $isBookingDoneForSelf, $bookingSlotPosition,
        $bookingDate, $inClinicPrice, $paymentMethodId,
        $rewardId, $rewardTransactionId, $offerId, $paidAmount, $offerPrice, $inClinicServiceFee,
        $inClinicCancellationDays
    ) {
        try {

            DB::beginTransaction();
            $getClinicQuery = DB::table('dm_clinic')->where('clinic_is_active', 1)
                ->where('clinic_id', $clinicId)
                ->get();
            $getClinicQueryResult = $getClinicQuery->toArray();

            $getDoctorQuery = DB::table('dm_doctor')->where('doctor_is_active', 1)
                ->where('doctor_id', $doctorId)
                ->get();
            $getDoctorQueryResult = $getDoctorQuery->toArray();
            if ($isExistingPatient == "1") {

                $getUserQuery = DB::table('dm_family_member')->where('family_member_is_active', 1)
                    ->where('family_member_id', $familyId)
                    ->get();
                $getUserQueryResult = $getUserQuery->toArray();

                $getRoleQuery = DB::table('dm_user')
                    ->where('dm_user.user_mobile', '=', $patientMobileNumber)
                    ->get();
                $getRoleResult = $getRoleQuery->toArray();
                if ($getRoleResult[0]->role_id == "1") {

                    $bookingCodePrefix = "IA" . date("ym");
                    $bookingCode = IdGenerator::generate(['table' => 'dm_in_clinic_booking', 'field' => 'in_clinic_booking_code', 'length' => 12, 'prefix' => $bookingCodePrefix,
                        'reset_on_prefix_change' => true]);

                    $transactionCodePrefix = "IT" . date("ym");
                    $transctionCode = IdGenerator::generate(['table' => 'dm_in_clinic_booking_transaction', 'field' => 'in_clinic_transaction_code', 'length' => 12, 'prefix' => $transactionCodePrefix,
                        'reset_on_prefix_change' => true]);

                    $bookingDate = date("Y-m-d", strtotime($bookingDate));
                    $getGstQuery = DB::table('dm_gst')->where('gst_applicable_for', 1)
                        ->where('gst_is_active', 1)
                        ->whereRaw('now() between gst_valid_start_date and gst_valid_end_date')
                        ->get();
                    $getGstResult = $getGstQuery->toArray();

                    $getBookingQuery = DB::table('dm_in_clinic_booking')
                        ->where('in_clinic_slot_dates_id', $inClinicSlotDateId)
                        ->where('in_clinic_booking_slot_position', $bookingSlotPosition)
                        ->where('slot_name_id', $slotNameId)
                        ->where('in_clinic_booking_is_active', 1)
                        ->where('clinic_id', $clinicId)
                        ->where('doctor_id', $doctorId)

                        ->get();
                    if ($getBookingQuery->count() == 0) {

                        $getFamilyQuery = DB::table('dm_in_clinic_booking')
                            ->where('in_clinic_slot_dates_id', $inClinicSlotDateId)
                            ->where('in_clinic_booking_made_for_family_id', $familyId)
                            ->where('in_clinic_booking_is_active', 1)
                            ->where('clinic_id', $clinicId)
                            ->where('doctor_id', $doctorId)
                            ->get();

                        if ($getFamilyQuery->count() == 0) {
                            $insertId = DB::table('dm_in_clinic_booking')->insertGetId(
                                [
                                    'in_clinic_slot_id' => $inClinicSlotId,
                                    'in_clinic_slot_dates_id' => $inClinicSlotDateId,
                                    'slot_name_id' => $slotNameId,
                                    'clinic_id' => $clinicId,
                                    'doctor_id' => $doctorId,
                                    'in_clinic_booking_made_by_role_id' => $bookingMadeByRoleId,
                                    'in_clinic_booking_made_by_user_id' => $bookingMadeByUserId,
                                    'in_clinic_booking_made_for_family_id' => $familyId,
                                    'in_clinic_is_booking_done_for_self' => $isBookingDoneForSelf,
                                    'in_clinic_booking_slot_position' => $bookingSlotPosition,
                                    'in_clinic_booking_date' => $bookingDate,
                                    'in_clinic_price' => $inClinicPrice,
                                    'in_clinic_service_fee' => $inClinicServiceFee,
                                    'in_clinic_booking_code' => $bookingCode,
                                    'in_clinic_booking_cancellation_days' => $inClinicCancellationDays,

                                ]
                            );

                            DB::table('dm_in_clinic_booking_transaction')->insertGetId(
                                [
                                    'in_clinic_booking_id' => $insertId,
                                    'in_clinic_slot_id' => $inClinicSlotId,
                                    'in_clinic_slot_dates_id' => $inClinicSlotDateId,
                                    'slot_name_id' => $slotNameId,
                                    'clinic_id' => $clinicId,
                                    'doctor_id' => $doctorId,
                                    'payment_method_id' => $paymentMethodId,
                                    'reward_id' => $rewardId,
                                    'reward_transaction_id' => $rewardTransactionId,
                                    'offer_id' => $offerId,
                                    'in_clinic_booking_made_by_role_id' => $bookingMadeByRoleId,
                                    'in_clinic_booking_made_by_user_id' => $bookingMadeByUserId,
                                    'in_clinic_booking_made_for_family_id' => $familyId,
                                    'in_clinic_is_booking_done_for_self' => $isBookingDoneForSelf,
                                    'in_clinic_booking_slot_position' => $bookingSlotPosition,
                                    'in_clinic_booking_date' => $bookingDate,
                                    'in_clinic_price' => $inClinicPrice,
                                    'in_clinic_service_fee' => $inClinicServiceFee,
                                    'in_clinic_booking_paid_amount' => $paidAmount,
                                    'in_clinic_booking_offer_price' => $inClinicServiceFee,
                                    'in_clinic_booking_gst_price' => $paidAmount * $getGstResult[0]->gst_percentage / 100,
                                    'in_clinic_booking_cgst_price' => $paidAmount * $getGstResult[0]->gst_cgst_percentage / 100,
                                    'in_clinic_booking_sgst_price' => $paidAmount * $getGstResult[0]->gst_sgst_percentage / 100,
                                    'in_clinic_booking_igst_price' => $paidAmount * $getGstResult[0]->gst_igst_percentage / 100,
                                    'in_clinic_transaction_code' => $transctionCode,

                                ]
                            );
                            $smsBookingTextForCustomer = "Dear " . $getUserQueryResult[0]->family_member_full_name . " your booking has been confirmed for Dr.  " . $getDoctorQueryResult[0]->doctor_full_name . " dated " . $bookingDate . " with booking number " . $bookingSlotPosition . " . Please contact " . $getClinicQueryResult[0]->clinic_full_name;
                            DB::table('dm_sms_schedule_details')->insertGetId(
                                [
                                    'mobile_number' => $getUserQueryResult[0]->family_member_mobile_number,
                                    'sms_text' => $smsBookingTextForCustomer,
                                    'sms_type' => 'Appointment Booking',

                                ]
                            );
                            $smsBookingTextForClinic = "Booking has made by " . $getUserQueryResult[0]->family_member_full_name . " for Dr.  " . $getDoctorQueryResult[0]->doctor_full_name . " dated " . $bookingDate . "";
                            DB::table('dm_sms_schedule_details')->insertGetId(
                                [
                                    'mobile_number' => $getClinicQueryResult[0]->clinic_mobile_number,
                                    'sms_text' => $smsBookingTextForClinic,
                                    'sms_type' => 'Appointment Booking',

                                ]
                            );
                            DB::commit();
                            $resultData['result'] = "success";
                            $resultData['bookingCode'] = $bookingCode;

                        } else {
                            $resultData['result'] = "bookedself";
                        }

                    } else {
                        $resultData['result'] = "booked";
                    }

                } else {
                    $resultData['result'] = "onlyforpatient";
                }

            } else {
                // register with patient profile
                $password = mt_rand(100000, 999999);
                $customerId = DB::table('dm_user')->insertGetId(
                    [
                        'role_id' => 1,
                        'user_mobile' => $patientMobileNumber,
                        'password' => bcrypt($password),
                        'password_normal' => $password,

                    ]
                );

                DB::table('dm_customer_personal_details')->insertGetId(
                    [
                        'user_id' => $customerId,
                        'customer_first_name' => ucfirst($patientFirstName),
                        'customer_last_name' => ucfirst($patientLastName),
                        'customer_full_name' => ucfirst($patientFirstName) . " " . ucfirst($patientLastName),
                        'customer_mobile_number' => $patientMobileNumber,
                    ]
                );

                $familyId = DB::table('dm_family_member')->insertGetId(
                    [

                        'family_member_first_name' => ucfirst($patientFirstName),
                        'family_member_last_name' => ucfirst($patientLastName),
                        'family_member_full_name' => ucfirst($patientFirstName) . " " . ucfirst($patientLastName),
                        'family_member_mobile_number' => $patientMobileNumber,
                        'user_id' => $customerId,
                        'is_self' => 1,
                    ]
                );

                $getRewardAmountQuery = DB::table('dm_reward_amount_description')->where('reward_amount_description_id', 1)->get();
                $saveRewardQuery = DB::table('dm_reward')->insertGetId(
                    [
                        'user_id' => $customerId,
                        'reward_balance' => $getRewardAmountQuery[0]->reward_amount,

                    ]
                );

                DB::table('dm_reward_transaction')->insertGetId(
                    [
                        'reward_id' => $saveRewardQuery,
                        'user_id' => $customerId,
                        'reward_transaction_balance' => $getRewardAmountQuery[0]->reward_amount,
                        'reward_transaction_remarks' => $getRewardAmountQuery[0]->reward_amount_description,
                        'is_reward_balance_added' => 1,

                    ]
                );

                $bookingCodePrefix = "IA" . date("ym");
                $bookingCode = IdGenerator::generate(['table' => 'dm_in_clinic_booking', 'field' => 'in_clinic_booking_code', 'length' => 12, 'prefix' => $bookingCodePrefix,
                    'reset_on_prefix_change' => true]);

                $transactionCodePrefix = "IT" . date("ym");
                $transctionCode = IdGenerator::generate(['table' => 'dm_in_clinic_booking_transaction', 'field' => 'in_clinic_transaction_code', 'length' => 12, 'prefix' => $transactionCodePrefix,
                    'reset_on_prefix_change' => true]);

                $bookingDate = date("Y-m-d", strtotime($bookingDate));
                $getGstQuery = DB::table('dm_gst')->where('gst_applicable_for', 1)
                    ->where('gst_is_active', 1)
                    ->whereRaw('now() between gst_valid_start_date and gst_valid_end_date')
                    ->get();
                $getGstResult = $getGstQuery->toArray();

                $getBookingQuery = DB::table('dm_in_clinic_booking')
                    ->where('in_clinic_slot_dates_id', $inClinicSlotDateId)
                    ->where('in_clinic_booking_slot_position', $bookingSlotPosition)
                    ->where('slot_name_id', $slotNameId)
                    ->where('in_clinic_booking_is_active', 1)
                    ->where('clinic_id', $clinicId)
                    ->where('doctor_id', $doctorId)

                    ->get();
                if ($getBookingQuery->count() == 0) {

                    $getFamilyQuery = DB::table('dm_in_clinic_booking')
                        ->where('in_clinic_slot_dates_id', $inClinicSlotDateId)
                        ->where('in_clinic_booking_made_for_family_id', $familyId)
                        ->where('in_clinic_booking_is_active', 1)
                        ->where('clinic_id', $clinicId)
                        ->where('doctor_id', $doctorId)
                        ->get();

                    if ($getFamilyQuery->count() == 0) {
                        $insertId = DB::table('dm_in_clinic_booking')->insertGetId(
                            [
                                'in_clinic_slot_id' => $inClinicSlotId,
                                'in_clinic_slot_dates_id' => $inClinicSlotDateId,
                                'slot_name_id' => $slotNameId,
                                'clinic_id' => $clinicId,
                                'doctor_id' => $doctorId,
                                'in_clinic_booking_made_by_role_id' => $bookingMadeByRoleId,
                                'in_clinic_booking_made_by_user_id' => $bookingMadeByUserId,
                                'in_clinic_booking_made_for_family_id' => $familyId,
                                'in_clinic_is_booking_done_for_self' => $isBookingDoneForSelf,
                                'in_clinic_booking_slot_position' => $bookingSlotPosition,
                                'in_clinic_booking_date' => $bookingDate,
                                'in_clinic_price' => $inClinicPrice,
                                'in_clinic_service_fee' => $inClinicServiceFee,
                                'in_clinic_booking_code' => $bookingCode,
                                'in_clinic_booking_cancellation_days' => $inClinicCancellationDays,

                            ]
                        );

                        DB::table('dm_in_clinic_booking_transaction')->insertGetId(
                            [
                                'in_clinic_booking_id' => $insertId,
                                'in_clinic_slot_id' => $inClinicSlotId,
                                'in_clinic_slot_dates_id' => $inClinicSlotDateId,
                                'slot_name_id' => $slotNameId,
                                'clinic_id' => $clinicId,
                                'doctor_id' => $doctorId,
                                'payment_method_id' => $paymentMethodId,
                                'reward_id' => $rewardId,
                                'reward_transaction_id' => $rewardTransactionId,
                                'offer_id' => $offerId,
                                'in_clinic_booking_made_by_role_id' => $bookingMadeByRoleId,
                                'in_clinic_booking_made_by_user_id' => $bookingMadeByUserId,
                                'in_clinic_booking_made_for_family_id' => $familyId,
                                'in_clinic_is_booking_done_for_self' => $isBookingDoneForSelf,
                                'in_clinic_booking_slot_position' => $bookingSlotPosition,
                                'in_clinic_booking_date' => $bookingDate,
                                'in_clinic_price' => $inClinicPrice,
                                'in_clinic_service_fee' => $inClinicServiceFee,
                                'in_clinic_booking_paid_amount' => $paidAmount,
                                'in_clinic_booking_offer_price' => $inClinicPrice,
                                'in_clinic_booking_gst_price' => $paidAmount * $getGstResult[0]->gst_percentage / 100,
                                'in_clinic_booking_cgst_price' => $paidAmount * $getGstResult[0]->gst_cgst_percentage / 100,
                                'in_clinic_booking_sgst_price' => $paidAmount * $getGstResult[0]->gst_sgst_percentage / 100,
                                'in_clinic_booking_igst_price' => $paidAmount * $getGstResult[0]->gst_igst_percentage / 100,
                                'in_clinic_transaction_code' => $transctionCode,

                            ]
                        );

                        $smsBookingTextForCustomer = "Dear " . $patientFirstName . " " . $patientLastName . " your booking has been confirmed for Dr.  " . $getDoctorQueryResult[0]->doctor_full_name . " dated " . $bookingDate . " with booking number " . $bookingSlotPosition . " . Please contact " . $getClinicQueryResult[0]->clinic_full_name;
                        DB::table('dm_sms_schedule_details')->insertGetId(
                            [
                                'mobile_number' => $patientMobileNumber,
                                'sms_text' => $smsBookingTextForCustomer,
                                'sms_type' => 'Appointment Booking',

                            ]
                        );
                        $smsBookingTextForClinic = "Booking has made by " . $patientFirstName . " " . $patientLastName . " for Dr.  " . $getDoctorQueryResult[0]->doctor_full_name . " dated " . $bookingDate . "";
                        DB::table('dm_sms_schedule_details')->insertGetId(
                            [
                                'mobile_number' => $getClinicQueryResult[0]->clinic_mobile_number,
                                'sms_text' => $smsBookingTextForClinic,
                                'sms_type' => 'Appointment Booking',

                            ]
                        );

                        $registrationSMSForCustomer = "Your Login details are :" . " Login ID : " . $patientMobileNumber . " Password : " . $password . " You can login by downloading the app https://play.google.com/store/apps/details?id=com.docsmeet.docsmeet. Team DocsMeet";
                        DB::table('dm_sms_schedule_details')->insertGetId(
                            [
                                'mobile_number' => $patientMobileNumber,
                                'sms_text' => $registrationSMSForCustomer,
                                'sms_type' => 'Registration SMS',

                            ]
                        );
                        DB::commit();
                        $resultData['result'] = "success";
                        $resultData['bookingCode'] = $bookingCode;

                    } else {
                        $resultData['result'] = "bookedself";
                    }

                } else {
                    $resultData['result'] = "booked";
                }
            }

        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = $ex->getMessage();
        }

        return $resultData;
    }

    // Send login details to customer whose booking done by clinic
    public function sendLoginDetailsBookedByClinic($mobile, $password)
    {
        $text = "Your Login details are :" . " Login ID : " . $mobile . " Password : " . $password . " You can login by downloading the app https://play.google.com/store/apps/details?id=com.docsmeet.docsmeet. Team DocsMeet";
        try
        {
            $smstext = rawurlencode($text);
            $ch = curl_init("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=V6dw6TBazEGoT3a3exO8UA&senderid=ODILAS&channel=2&DCS=0&flashsms=0&number=$mobile&text=$smstext&route=1");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 2);
            $result = curl_exec($ch);
            if (curl_error($ch)) {
                $result = curl_errno($ch);
            }
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }

        return response()->json($result);
    }

    //get  in clinic booking by clinic
    public function getInClinicBookingListByClinic($bookigDoneForClinicId,
        $bookigStatus, $pageNumber, $itemToLoad) {
        $pageNumber = $pageNumber;
        $itemToLoad = $itemToLoad;
        if ($pageNumber == 1) {
            $pageNumber = 0;
        } else {
            $pageNumber = $itemToLoad * $pageNumber;
            $pageNumber = $pageNumber - $itemToLoad;
        }

        $getQuery = DB::table('dm_in_clinic_booking')
            ->leftJoin('dm_in_clinic_slot', 'dm_in_clinic_slot.in_clinic_slot_id', '=', 'dm_in_clinic_booking.in_clinic_slot_id')
            ->leftJoin('dm_in_clinic_slot_dates', 'dm_in_clinic_slot_dates.in_clinic_slot_dates_id', '=', 'dm_in_clinic_booking.in_clinic_slot_dates_id')
            ->leftJoin('dm_slot_name', 'dm_slot_name.slot_name_id', '=', 'dm_in_clinic_booking.slot_name_id')
            ->leftJoin('dm_clinic', 'dm_clinic.clinic_id', '=', 'dm_in_clinic_booking.clinic_id')
            ->leftJoin('dm_doctor', 'dm_doctor.doctor_id', '=', 'dm_in_clinic_booking.doctor_id')
            ->leftJoin('dm_specialization', 'dm_doctor.doctor_id', '=', 'dm_specialization.doctor_id')
            ->leftJoin('dm_doctor_education', 'dm_doctor.doctor_id', '=', 'dm_doctor_education.doctor_id')

            ->leftJoin('dm_family_member', 'dm_family_member.family_member_id', '=', 'dm_in_clinic_booking.in_clinic_booking_made_for_family_id')
            ->leftJoin('dm_clinic_image', 'dm_clinic_image.clinic_id', '=', 'dm_clinic.clinic_id')

            ->where('dm_in_clinic_booking.in_clinic_booking_made_by_user_id', '=', $bookigDoneForClinicId)
            ->where('dm_in_clinic_booking.in_clinic_booking_is_active', '=', $bookigStatus)
            ->where('dm_clinic_image.clinic_image_type', '=', 1)
            ->where('dm_specialization.specialization_type', '=', 1)
            ->where('dm_doctor_education.education_type', '=', 1)
            ->select([
                'dm_clinic.clinic_id',
                'dm_clinic.clinic_first_name',
                'dm_clinic.clinic_last_name',
                'dm_clinic.clinic_full_name',
                'dm_clinic.clinic_mobile_number',
                'dm_clinic.clinic_profile_image',
                'dm_clinic_image.clinic_image',
                'dm_clinic.clinic_address',

                'dm_doctor.doctor_id',
                'dm_doctor.doctor_first_name',
                'dm_doctor.doctor_last_name',
                'dm_doctor.doctor_full_name',
                'dm_doctor.doctor_mobile_number',
                'dm_doctor.doctor_profile_image',
                'dm_specialization.specialization_name',
                'dm_doctor.doctor_overall_experience',
                'dm_doctor_education.education_name',

                'dm_family_member.family_member_id',
                'dm_family_member.user_id',
                'dm_family_member.family_member_first_name',
                'dm_family_member.family_member_last_name',
                'dm_family_member.family_member_full_name',
                'dm_family_member.family_member_mobile_number',
                'dm_family_member.family_member_profile_image',
                'dm_family_member.is_self',

                'dm_in_clinic_slot.in_clinic_slot_id',

                'dm_in_clinic_slot_dates.in_clinic_slot_dates_id',

                'dm_slot_name.slot_name_id',
                'dm_slot_name.slot_name',

                'dm_in_clinic_booking.in_clinic_booking_id',
                'dm_in_clinic_booking.in_clinic_booking_code',
                'dm_in_clinic_booking.in_clinic_booking_made_by_role_id',
                'dm_in_clinic_booking.in_clinic_booking_made_by_user_id',
                'dm_in_clinic_booking.in_clinic_booking_made_for_family_id',
                'dm_in_clinic_booking.in_clinic_is_booking_done_for_self',
                'dm_in_clinic_booking.in_clinic_booking_slot_position',
                'dm_in_clinic_booking.in_clinic_price',
                'dm_in_clinic_booking.in_clinic_service_fee',
                'dm_in_clinic_booking.in_clinic_booking_cancellation_days',
                'dm_in_clinic_booking.in_clinic_booking_is_active',

                DB::raw('DATE_FORMAT(dm_in_clinic_booking.in_clinic_booking_date, "%d-%m-%Y") as in_clinic_booking_date', "%d-%m-%Y"),

                DB::raw('if(DATE_sub(DATE_FORMAT(dm_in_clinic_booking.in_clinic_booking_date,"%Y-%m-%d"),
INTERVAL dm_in_clinic_booking.in_clinic_booking_cancellation_days DAY)>=date_format(now(),"%Y-%m-%d"),"1","1") as "booking_cancel_date_check"'),

            ])
            ->limit($itemToLoad)
            ->offset($pageNumber)
            ->orderBy('dm_in_clinic_booking.in_clinic_booking_date', 'desc')
            ->get();

        $data_response = array();
        if (count($getQuery) <= 0) {
            array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
        } else {
            array_push($data_response, array('data_status' => 'ok'));
            array_push($data_response, array('data' => $getQuery->toArray()));
            echo json_encode($data_response);
        }
    }

// to get the booking slot date by clinic
    public function getInClinicBookingSlotDateByClinic($clinicId)
    {
        $currentDate = date('Y-m-d');
        $getQuery = DB::select("select `dm_doctor`.`doctor_full_name`, `dm_doctor`.`doctor_id`, `dm_doctor`.`doctor_profile_image`, `dm_clinic`.`clinic_id`,
    `dm_clinic`.`clinic_full_name`, `dm_clinic`.`clinic_address`, DATE_FORMAT(dm_in_clinic_slot_dates.in_clinic_slot_dates, '%D %M %Y')
    as in_clinic_slot_dates, `dm_in_clinic_slot_dates`.`in_clinic_slot_dates_id`, `dm_in_clinic_slot`.`in_clinic_slot_id`,
    `dm_in_clinic_slot`.`slot_name_id`, sum(distinct dm_in_clinic_slot_dates.in_clinic_max_slot_position_datewise) as in_clinic_max_slot_position_datewise, count(dm_in_clinic_booking.in_clinic_slot_dates_id) as booked_slot
     from `dm_in_clinic_slot_dates` left join `dm_in_clinic_slot`
     on `dm_in_clinic_slot`.`in_clinic_slot_id` = `dm_in_clinic_slot_dates`.`in_clinic_slot_id`
     left join `dm_doctor` on `dm_doctor`.`doctor_id` = `dm_in_clinic_slot`.`doctor_id`
     left join `dm_clinic` on `dm_clinic`.`clinic_id` = `dm_in_clinic_slot`.`clinic_id`
     left join dm_in_clinic_booking on dm_in_clinic_booking.in_clinic_slot_dates_id = dm_in_clinic_slot_dates.in_clinic_slot_dates_id
     where `dm_in_clinic_slot_dates`.`in_clinic_slot_dates_is_active` = 1
     and `dm_in_clinic_slot_dates`.`in_clinic_slot_dates` >= '$currentDate'
    and `dm_in_clinic_slot`.`clinic_id` = $clinicId
     group by `dm_in_clinic_slot_dates`.`in_clinic_slot_dates`");
        return $getQuery;

    }

    // To get the in clinic booking  list date slot clinic wise

    public function getDoctorListDateSlotClinicWise($clinicId,
        $inClinicSlotDatesId, $slotNameId, $pageNumber, $itemToLoad) {
        $pageNumber = $pageNumber;
        $itemToLoad = $itemToLoad;
        if ($pageNumber == 1) {
            $pageNumber = 0;
        } else {
            $pageNumber = $itemToLoad * $pageNumber;
            $pageNumber = $pageNumber - $itemToLoad;
        }

        $getQuery = DB::table('dm_in_clinic_booking')
            ->leftJoin('dm_doctor', 'dm_doctor.doctor_id', '=', 'dm_in_clinic_booking.doctor_id')
			  ->leftJoin('dm_in_clinic_slot_dates', 'dm_in_clinic_slot_dates.in_clinic_slot_dates_id', '=', 'dm_in_clinic_booking.in_clinic_slot_dates_id')
            ->where('dm_in_clinic_booking.clinic_id', '=', $clinicId)
            ->where('dm_in_clinic_booking.in_clinic_slot_dates_id', '=', $inClinicSlotDatesId)
            ->where('dm_in_clinic_booking.slot_name_id', '=', $slotNameId)
            ->select([
'dm_in_clinic_slot_dates.in_clinic_doctor_present',
                'dm_doctor.doctor_id',
                'dm_doctor.doctor_first_name',
                'dm_doctor.doctor_last_name',
                'dm_doctor.doctor_full_name',
                'dm_doctor.doctor_mobile_number',
                'dm_doctor.doctor_profile_image',
                'dm_in_clinic_booking.in_clinic_booking_is_active',

                DB::raw("(SELECT count(*) FROM dm_in_clinic_booking
          WHERE dm_in_clinic_booking.clinic_id =$clinicId
          and dm_in_clinic_booking.in_clinic_slot_dates_id=$inClinicSlotDatesId
          and dm_in_clinic_booking.slot_name_id=$slotNameId and in_clinic_booking_is_active=1

        ) as totalBooking"),

            ])
            ->limit($itemToLoad)
            ->offset($pageNumber)
            ->groupBy('dm_in_clinic_booking.doctor_id')
            ->get();

        $data_response = array();
        if (count($getQuery) <= 0) {
            array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
        } else {
            array_push($data_response, array('data_status' => 'ok'));
            array_push($data_response, array('data' => $getQuery->toArray()));
            echo json_encode($data_response);
        }
    }

    // To get the in clinic booking  list
    public function getInClinicBookingByClinicDoctorSlotDate($bookingStatus, $clinicId,
        $inClinicSlotDatesId, $slotNameId, $doctorId, $pageNumber, $itemToLoad) {
        $pageNumber = $pageNumber;
        $itemToLoad = $itemToLoad;
        if ($pageNumber == 1) {
            $pageNumber = 0;
        } else {
            $pageNumber = $itemToLoad * $pageNumber;
            $pageNumber = $pageNumber - $itemToLoad;
        }

        $getQuery = DB::table('dm_in_clinic_booking')
            ->leftJoin('dm_in_clinic_slot', 'dm_in_clinic_slot.in_clinic_slot_id', '=', 'dm_in_clinic_booking.in_clinic_slot_id')
            ->leftJoin('dm_in_clinic_slot_dates', 'dm_in_clinic_slot_dates.in_clinic_slot_dates_id', '=', 'dm_in_clinic_booking.in_clinic_slot_dates_id')
            ->leftJoin('dm_slot_name', 'dm_slot_name.slot_name_id', '=', 'dm_in_clinic_booking.slot_name_id')
            ->leftJoin('dm_clinic', 'dm_clinic.clinic_id', '=', 'dm_in_clinic_booking.clinic_id')
            ->leftJoin('dm_doctor', 'dm_doctor.doctor_id', '=', 'dm_in_clinic_booking.doctor_id')
            ->leftJoin('dm_specialization', 'dm_doctor.doctor_id', '=', 'dm_specialization.doctor_id')
            ->leftJoin('dm_doctor_education', 'dm_doctor.doctor_id', '=', 'dm_doctor_education.doctor_id')

            ->leftJoin('dm_family_member', 'dm_family_member.family_member_id', '=', 'dm_in_clinic_booking.in_clinic_booking_made_for_family_id')
            ->leftJoin('dm_clinic_image', 'dm_clinic_image.clinic_id', '=', 'dm_clinic.clinic_id')

            ->where('dm_in_clinic_booking.clinic_id', '=', $clinicId)
            ->where('dm_in_clinic_booking.in_clinic_slot_dates_id', '=', $inClinicSlotDatesId)
            ->where('dm_in_clinic_booking.slot_name_id', '=', $slotNameId)
            ->where('dm_in_clinic_booking.doctor_id', '=', $doctorId)
            ->where('dm_in_clinic_booking.in_clinic_booking_is_active', '=', $bookingStatus)
            ->where('dm_clinic_image.clinic_image_type', '=', 1)
            ->where('dm_specialization.specialization_type', '=', 1)
            ->where('dm_doctor_education.education_type', '=', 1)
            ->select([
                'dm_clinic.clinic_id',
                'dm_clinic.clinic_first_name',
                'dm_clinic.clinic_last_name',
                'dm_clinic.clinic_full_name',
                'dm_clinic.clinic_mobile_number',
                'dm_clinic.clinic_profile_image',
                'dm_clinic_image.clinic_image',
                'dm_clinic.clinic_address',

                'dm_doctor.doctor_id',
                'dm_doctor.doctor_first_name',
                'dm_doctor.doctor_last_name',
                'dm_doctor.doctor_full_name',
                'dm_doctor.doctor_mobile_number',
                'dm_doctor.doctor_profile_image',
                'dm_specialization.specialization_name',
                'dm_doctor.doctor_overall_experience',
                'dm_doctor_education.education_name',

                'dm_family_member.family_member_id',
                'dm_family_member.user_id',
                'dm_family_member.family_member_first_name',
                'dm_family_member.family_member_last_name',
                'dm_family_member.family_member_full_name',
                'dm_family_member.family_member_mobile_number',
                'dm_family_member.family_member_profile_image',
                'dm_family_member.is_self',

                'dm_in_clinic_slot.in_clinic_slot_id',

                'dm_in_clinic_slot_dates.in_clinic_slot_dates_id',

                'dm_slot_name.slot_name_id',
                'dm_slot_name.slot_name',

                'dm_in_clinic_booking.in_clinic_booking_id',
                'dm_in_clinic_booking.in_clinic_booking_code',
                'dm_in_clinic_booking.in_clinic_booking_made_by_role_id',
                'dm_in_clinic_booking.in_clinic_booking_made_by_user_id',
                'dm_in_clinic_booking.in_clinic_booking_made_for_family_id',
                'dm_in_clinic_booking.in_clinic_is_booking_done_for_self',
                    'dm_in_clinic_booking.in_clinic_booking_slot_position',
                'dm_in_clinic_booking.in_clinic_booking_current_slot_position',
                'dm_in_clinic_booking.in_clinic_price',
                'dm_in_clinic_booking.in_clinic_service_fee',
                'dm_in_clinic_booking.in_clinic_booking_is_active',
                'dm_in_clinic_booking.in_clinic_booking_cancellation_days',

                DB::raw('DATE_FORMAT(dm_in_clinic_booking.in_clinic_booking_date, "%d-%m-%Y") as in_clinic_booking_date', "%d-%m-%Y"),
                DB::raw('if(DATE_sub(DATE_FORMAT(dm_in_clinic_booking.in_clinic_booking_date,"%Y-%m-%d"),
                INTERVAL dm_in_clinic_booking.in_clinic_booking_cancellation_days DAY)>=date_format(now(),"%Y-%m-%d"),"1","0") as "booking_cancel_date_check"'),

            ])
            ->limit($itemToLoad)
            ->offset($pageNumber)
            ->orderBy('dm_in_clinic_booking.in_clinic_booking_date', 'desc')
            ->get();

        $data_response = array();
        if (count($getQuery) <= 0) {
            array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
        } else {
            array_push($data_response, array('data_status' => 'ok'));
            array_push($data_response, array('data' => $getQuery->toArray()));
            echo json_encode($data_response);
        }

    }

    //cancel in clinic booking
    public function completeInClinicBooking($in_clinic_booking_id, $inClinicSlotDatesId ,$inClinicSlotId)
    {
        try {

            DB::beginTransaction();

            DB::table('dm_in_clinic_booking')
                ->where('in_clinic_booking_id', $in_clinic_booking_id)
                ->update([
                    'in_clinic_booking_is_active' => 3, //completd
                    'in_clinic_booking_updated_date' => now(),

                ]);

            DB::table('dm_in_clinic_booking_transaction')
                ->where('in_clinic_booking_id', $in_clinic_booking_id)
                ->update([
                    'in_clinic_booking_transaction_is_active' => 3, //completd
                    'in_clinic_booking_transaction_update_date' => now(),

                ]);
                DB::unprepared("DROP TEMPORARY TABLE IF EXISTS slot_temp;CREATE TEMPORARY TABLE slot_temp
AS
(SELECT  @a:=@a+1 rank,
        in_clinic_booking_id
FROM    dm_in_clinic_booking,
        (SELECT @a:= 0) AS a

        where in_clinic_slot_dates_id=$inClinicSlotDatesId and in_clinic_booking_is_active=1
        order by in_clinic_booking_id asc);

UPDATE dm_in_clinic_booking a, slot_temp b
SET a.in_clinic_booking_current_slot_position = b.rank,


in_clinic_booking_appointment_time =  DATE_ADD(current_time() ,
INTERVAL ((select in_clinic_slot_interval from dm_in_clinic_slot where in_clinic_slot_id=$inClinicSlotId) * (b.rank-1))  minute) ,

in_clinic_booking_reporting_time = date_add( DATE_ADD(current_time() ,
INTERVAL ((select in_clinic_slot_interval from dm_in_clinic_slot where in_clinic_slot_id=$inClinicSlotId) * (b.rank-1))  minute), INTERVAL -15 minute)


WHERE a.in_clinic_booking_id = b.in_clinic_booking_id

");


            DB::commit();
            $resultData['result'] = "success";
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
        }

        return $resultData;
    }

    public function cancelAllInClinicBooking($clinicId,
        $inClinicSlotDatesId, $slotNameId, $doctorId) {
        try {

            DB::beginTransaction();
            $allFamily_query = DB::table('dm_in_clinic_booking')

                ->leftJoin('dm_family_member', 'dm_family_member.family_member_id', '=', 'dm_in_clinic_booking.in_clinic_booking_made_for_family_id')
                ->leftJoin('dm_clinic', 'dm_clinic.clinic_id', '=', 'dm_in_clinic_booking.clinic_id')
                ->leftJoin('dm_doctor', 'dm_doctor.doctor_id', '=', 'dm_in_clinic_booking.doctor_id')
                ->where('dm_in_clinic_booking.clinic_id', '=', $clinicId)
                ->where('dm_in_clinic_booking.in_clinic_slot_dates_id', '=', $inClinicSlotDatesId)
                ->where('dm_in_clinic_booking.slot_name_id', '=', $slotNameId)
                ->where('dm_in_clinic_booking.doctor_id', '=', $doctorId)
                ->where('dm_in_clinic_booking.in_clinic_booking_is_active', '=', 1)

                ->select([

                    'dm_clinic.clinic_full_name',
                    'dm_doctor.doctor_full_name',
                    'dm_in_clinic_booking.in_clinic_booking_slot_position',
                    'dm_in_clinic_booking.in_clinic_booking_date',
                    'dm_in_clinic_booking.in_clinic_booking_cancellation_days',

                    DB::raw(" (SELECt  group_concat(distinct(dm_family_member.family_member_mobile_number))) as mobile_numbers"),
                    DB::raw('if(DATE_sub(DATE_FORMAT(dm_in_clinic_booking.in_clinic_booking_date,"%Y-%m-%d"),
                    INTERVAL dm_in_clinic_booking.in_clinic_booking_cancellation_days DAY)>=date_format(now(),"%Y-%m-%d"),"1","0") as "booking_cancel_date_check"'),

                ])

                ->get();

            if ($allFamily_query[0]->booking_cancel_date_check == "1") {
                DB::table('dm_in_clinic_booking')
                    ->where('dm_in_clinic_booking.clinic_id', '=', $clinicId)
                    ->where('dm_in_clinic_booking.in_clinic_slot_dates_id', '=', $inClinicSlotDatesId)
                    ->where('dm_in_clinic_booking.slot_name_id', '=', $slotNameId)
                    ->where('dm_in_clinic_booking.doctor_id', '=', $doctorId)
                    ->update([
                        'in_clinic_booking_is_active' => 2, //rejected
                        'in_clinic_booking_updated_date' => now(),

                    ]);

                DB::table('dm_in_clinic_booking_transaction')
                    ->where('dm_in_clinic_booking_transaction.clinic_id', '=', $clinicId)
                    ->where('dm_in_clinic_booking_transaction.in_clinic_slot_dates_id', '=', $inClinicSlotDatesId)
                    ->where('dm_in_clinic_booking_transaction.slot_name_id', '=', $slotNameId)
                    ->where('dm_in_clinic_booking_transaction.doctor_id', '=', $doctorId)
                    ->update([
                        'in_clinic_booking_transaction_is_active' => 2, //rejected
                        'in_clinic_booking_transaction_update_date' => now(),

                    ]);
                $smsCancelBooking = "Your booking has been cancelled for Dr.  " . $allFamily_query[0]->doctor_full_name . " dated " . $allFamily_query[0]->in_clinic_booking_date . " . Please contact " . $allFamily_query[0]->clinic_full_name;
                DB::table('dm_sms_schedule_details')->insertGetId(
                    [
                        'mobile_number' => $allFamily_query[0]->mobile_numbers,
                        'sms_text' => $smsCancelBooking,
                        'sms_type' => 'Cancel Booking',

                    ]
                );

                DB::commit();
                // $this->cancelBookingSMS($allFamily_query[0]->mobile_numbers, $allFamily_query[0]->doctor_full_name, $allFamily_query[0]->clinic_full_name, $allFamily_query[0]->in_clinic_booking_date);
                $resultData['result'] = "success";
            } else {
                $resultData['result'] = "fail";
                $resultData['inClinicBookingCancelDays'] = $allFamily_query[0]->in_clinic_booking_cancellation_days;
            }
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
        }

        return $resultData;
    }

    // Cancel booking SMS
    public function cancelBookingSMS($mobile, $doctorName, $clinicName, $bookingDate)
    {
        try
        {
            $smstext = rawurlencode("Your booking has been cancelled for Dr.  " . $doctorName . " dated " . $bookingDate . " . Please contact " . $clinicName);
            $ch = curl_init("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=V6dw6TBazEGoT3a3exO8UA&senderid=ODILAS&channel=2&DCS=0&flashsms=0&number=$mobile&text=$smstext&route=1");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 2);
            $result = curl_exec($ch);
            if (curl_error($ch)) {
                $result = curl_errno($ch);
            }
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }

        return response()->json($result);
    }

    public function sendAllTypeSMS()
    {

        $getQuery = DB::table('dm_sms_schedule_details')

            ->where('sms_is_active', null)
        //->orWhere('sms_is_active', '!=', 'Expired')
            ->select([
                'mobile_number',
                'sms_text',
                'sms_schedule_id',
            ])
            ->get();
        //echo (  $getQuery->count());

        foreach ($getQuery as $key => $value) {
            $smsText = rawurlencode($value->sms_text);
            $mobileNumber = $value->mobile_number;

            $ch = curl_init("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=V6dw6TBazEGoT3a3exO8UA&senderid=ODILAS&channel=2&DCS=0&flashsms=0&number=$mobileNumber&text=$smsText&route=1");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 2);
            $result = curl_exec($ch);
            curl_close($ch);
            $decodedResult = json_decode($result, true);

            DB::table('dm_sms_schedule_details')
                ->where('sms_schedule_id', $value->sms_schedule_id)
                ->update([
                    'error_message' => $decodedResult['ErrorMessage'],
                    'message_id' => $decodedResult['MessageData'][0]['MessageId'],
                    'delivery_status' => 'Pending',
                    'job_id' => $decodedResult['JobId'],
                    'sms_is_active' => $decodedResult['ErrorMessage'],
                ]);

        }

    }

    public function getSMSStatus()
    {

        $getQuery = DB::table('dm_sms_schedule_details')
            ->where('delivery_status', '!=', 'Delivered')
            ->where('delivery_status', '!=', 'Expired')
            ->where('error_message', 'Success')
            ->select([
                'job_id',
                'sms_schedule_id',
            ])
            ->get();

        foreach ($getQuery as $key => $value) {

            $ch = curl_init("https://www.smsgatewayhub.com/api/mt/GetDelivery?APIKey=V6dw6TBazEGoT3a3exO8UA&jobid=$value->job_id");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 2);
            $result = curl_exec($ch);
            curl_close($ch);
            $jsonResult = json_decode($result, true);
            DB::table('dm_sms_schedule_details')
                ->where('sms_schedule_id', $value->sms_schedule_id)
                ->where('job_id', $value->job_id)
                ->update([
                    'delivery_status' => $jsonResult['DeliveryReports'][0]['DeliveryStatus'],

                ]);

        }
    }

    // To notify customer about doctor date slot
    public function notifyCustomerAboutDoctorDateSlot($clinicId,
        $doctorId, $userId) {
        try {
            DB::beginTransaction();
            DB::table('dm_notify_customer_about_doctor_date_slot')
                ->updateOrInsert(
                    ['user_id' => $userId,
                        'doctor_id' => $doctorId,
                        'clinic_id' => $clinicId],
                    ['notify_customer_about_doctor_date_slot_created_at' => now()]
                );

            DB::commit();
            $resultData['result'] = "success";
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
        }

        return $resultData;
    }

    // search doctor clinic speciality
    public function searchDoctor($searchText, $pageNumber,
        $itemToLoad
    ) {
        $pageNumber = $pageNumber;
        $itemToLoad = $itemToLoad;
        if ($pageNumber == 1) {
            $pageNumber = 0;
        } else {
            $pageNumber = $itemToLoad * $pageNumber;
            $pageNumber = $pageNumber - $itemToLoad;
        }

        $getQuery = DB::select("SELECT dm_clinic.clinic_id , dm_clinic.clinic_full_name ,
         dm_doctor.doctor_id,dm_doctor.doctor_full_name,dm_doctor.doctor_first_name,dm_doctor.doctor_last_name,
         dm_doctor.doctor_profile_image,
         dm_specialization.specialization_name,
         dm_doctor_clinic_wise.in_clinic_appointment_fee,dm_doctor_clinic_wise.in_clinic_appointment_fee_is_visible,
         dm_doctor_clinic_wise.in_clinic_book_before_days,dm_doctor_clinic_wise.in_clinic_cancellation_days,
         dm_doctor_clinic_wise.in_clinic_consultation_is_avialable,dm_doctor_clinic_wise.in_clinic_service_fee,
         dm_doctor_clinic_wise.video_book_before_days,dm_doctor_clinic_wise.video_cancellation_days,dm_doctor_clinic_wise.video_consultation_fee,
         dm_doctor_clinic_wise.video_consultation_fee_is_visible,dm_doctor_clinic_wise.video_consultation_is_avialable,
         dm_doctor_clinic_wise.video_consultation_service_fee
                  FROM dm_doctor left join dm_doctor_clinic_wise on dm_doctor.doctor_id=dm_doctor_clinic_wise.doctor_id

                  left join dm_specialization on dm_doctor.doctor_id=dm_specialization.doctor_id

                  left join dm_doctor_education on dm_doctor.doctor_id=dm_doctor_education.doctor_id


                     left join dm_clinic on dm_clinic.clinic_id=dm_doctor_clinic_wise.clinic_id
                       WHERE dm_doctor.doctor_full_name LIKE '%" .
            $searchText . "%'
                  and dm_doctor.doctor_is_active=1 and dm_clinic.clinic_is_active=1
                   and dm_specialization.specialization_type and dm_doctor_education.education_type=1
        limit  $itemToLoad offset $pageNumber ");

        $data_response = array();
        if (count($getQuery) <= 0) {
            array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
        } else {
            array_push($data_response, array('data_status' => 'ok'));
            array_push($data_response, array('data' => $getQuery));
            echo json_encode($data_response);
        }
    }

    // Auto cancel in clinic booking
    public function autoCancelInClinicBooking()
    {
        try {
            $currentDate = date('Y-m-d');
            DB::beginTransaction();

            $getQuery = DB::table('dm_in_clinic_booking')
                ->where('in_clinic_booking_date', '<', $currentDate)
                ->where('in_clinic_booking_is_active', 1)
                ->get();

            if ($getQuery->count() > 0) {
                $getResult = $getQuery->toArray();
                for ($x = 0; $x < count($getQuery); $x++) {

                    DB::table('dm_in_clinic_booking')
                        ->where('in_clinic_booking_id', '>', $getResult[$x]->in_clinic_booking_id)
                        ->update([
                            'in_clinic_booking_is_active' => 2, //rejected
                            'in_clinic_booking_updated_date' => now(),
                        ]);

                    DB::table('dm_in_clinic_booking_transaction')
                        ->where('in_clinic_booking_id', $getResult[$x]->in_clinic_booking_id)
                        ->update([
                            'in_clinic_booking_transaction_is_active' => 2, //rejected
                            'in_clinic_booking_transaction_update_date' => now(),

                        ]);

                }

            }

            DB::commit();

            $resultData['result'] = "success";

        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
        }

        return $resultData;
    }

    // To apollo doctor
    public function getApolloDoctor($clinicId)
    {
        $currentDate = date('Y-m-d');
        $getQuery = DB::table('dm_in_clinic_slot')
            ->leftJoin('dm_doctor_clinic_wise', 'dm_doctor_clinic_wise.doctor_id', '=', 'dm_in_clinic_slot.doctor_id')
            ->leftJoin('dm_doctor', 'dm_doctor.doctor_id', '=', 'dm_in_clinic_slot.doctor_id')
            ->leftJoin('dm_clinic', 'dm_clinic.clinic_id', '=', 'dm_in_clinic_slot.clinic_id')
            ->leftJoin('dm_in_clinic_slot_dates', 'dm_in_clinic_slot.in_clinic_slot_id', '=', 'dm_in_clinic_slot_dates.in_clinic_slot_id')
            ->leftJoin('dm_specialization', 'dm_doctor.doctor_id', '=', 'dm_specialization.doctor_id')
            ->leftJoin('dm_doctor_education', 'dm_doctor.doctor_id', '=', 'dm_doctor_education.doctor_id')
            ->leftJoin('dm_slot_name', 'dm_slot_name.slot_name_id', '=', 'dm_in_clinic_slot.slot_name_id')

            ->where('dm_in_clinic_slot.in_clinic_slot_is_active', '=', 1)
            ->where('dm_specialization.specialization_type', '=', 1)
            ->where('dm_in_clinic_slot.clinic_id', '=', $clinicId)
            ->where('dm_doctor_education.education_type', '=', 1)
            ->where('dm_in_clinic_slot_dates.in_clinic_slot_dates', '>=', $currentDate)
            ->select([

                'dm_doctor.doctor_first_name',
                'dm_doctor.doctor_last_name',
                'dm_doctor.doctor_full_name',
                'dm_doctor.doctor_mobile_number',
                'dm_doctor.doctor_profile_image',

                'dm_specialization.specialization_name',
                'dm_doctor.doctor_city',
                'dm_doctor.doctor_id',
                'dm_doctor.doctor_overall_experience',
                'dm_doctor_education.education_name',
                'dm_doctor_clinic_wise.in_clinic_appointment_fee_is_visible',
                'dm_doctor_clinic_wise.video_consultation_fee_is_visible',
                'dm_doctor_clinic_wise.video_consultation_is_avialable',
                'dm_doctor_clinic_wise.in_clinic_appointment_fee',
                'dm_doctor_clinic_wise.in_clinic_service_fee',
                'dm_doctor_clinic_wise.video_consultation_service_fee',
                'dm_doctor_clinic_wise.video_consultation_fee',

                'dm_doctor_clinic_wise.in_clinic_consultation_is_avialable',
                'dm_doctor_clinic_wise.in_clinic_cancellation_days',
                'dm_doctor_clinic_wise.video_cancellation_days',
                'dm_doctor_clinic_wise.in_clinic_book_before_days',
                'dm_doctor_clinic_wise.video_book_before_days',
                DB::raw('DATE_FORMAT(dm_in_clinic_slot_dates.in_clinic_slot_dates,"%D %M %Y") as in_clinic_slot_dates', "%D %M %Y"),
                DB::raw('DATE_FORMAT(dm_in_clinic_slot_dates.in_clinic_slot_dates, "%Y-%m-%d") as in_clinic_slot_dates_another_date_format'),
                DB::raw('DATE_FORMAT(now(), "%Y-%m-%d") as server_current_date'),
                'dm_in_clinic_slot.in_clinic_slot_id',
                'dm_in_clinic_slot.slot_name_id',
                'dm_in_clinic_slot_dates.in_clinic_max_slot_position_datewise',

                'dm_clinic.clinic_full_name',
                'dm_slot_name.slot_name',
                'dm_in_clinic_slot_dates.in_clinic_slot_start_time',
                'dm_in_clinic_slot_dates.in_clinic_slot_end_time',
                'dm_in_clinic_slot_dates.in_clinic_slot_dates_id',

            ])

            ->orderBy('dm_in_clinic_slot_dates.in_clinic_slot_dates')
            ->get();

        $getResult = $getQuery->toArray();
        return $getResult;

    }
	    public function markDoctorIn($inClinicSlotDatesId, $inClinicSlotId)
    {
        try {
            DB::beginTransaction();

            DB::table('dm_in_clinic_slot_dates')
                ->where('in_clinic_slot_dates_id', $inClinicSlotDatesId)
                ->update(['in_clinic_doctor_present' => 1]);
           DB::unprepared("DROP TEMPORARY TABLE IF EXISTS slot_temp;CREATE TEMPORARY TABLE slot_temp
AS
(SELECT  @a:=@a+1 rank,
        in_clinic_booking_id
FROM    dm_in_clinic_booking,
        (SELECT @a:= 0) AS a

        where in_clinic_slot_dates_id=$inClinicSlotDatesId and in_clinic_booking_is_active=1
        order by in_clinic_booking_id asc);

UPDATE dm_in_clinic_booking a, slot_temp b
SET a.in_clinic_booking_current_slot_position = b.rank,


in_clinic_booking_appointment_time =  DATE_ADD(current_time() ,
INTERVAL ((select in_clinic_slot_interval from dm_in_clinic_slot where in_clinic_slot_id=$inClinicSlotId) * (b.rank-1))  minute) ,

in_clinic_booking_reporting_time = date_add( DATE_ADD(current_time() ,
INTERVAL ((select in_clinic_slot_interval from dm_in_clinic_slot where in_clinic_slot_id=$inClinicSlotId) * (b.rank-1))  minute), INTERVAL -15 minute)


WHERE a.in_clinic_booking_id = b.in_clinic_booking_id

");
    

            DB::commit();

            $resultData['result'] = "success";

        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
        }

        return $resultData;
    }

    public function updateInClinicBookingSlotPosition($inClinicSlotDatesId, $inClinicSlotId)
    {
         DB::unprepared("DROP TEMPORARY TABLE IF EXISTS slot_temp;CREATE TEMPORARY TABLE slot_temp
AS
(SELECT  @a:=@a+1 rank,
        in_clinic_booking_id
FROM    dm_in_clinic_booking,
        (SELECT @a:= 0) AS a

        where in_clinic_slot_dates_id=$inClinicSlotDatesId and in_clinic_booking_is_active=1
        order by in_clinic_booking_id asc);

UPDATE dm_in_clinic_booking a, slot_temp b
SET a.in_clinic_booking_current_slot_position = b.rank,


in_clinic_booking_appointment_time =  DATE_ADD(current_time() ,
INTERVAL ((select in_clinic_slot_interval from dm_in_clinic_slot where in_clinic_slot_id=$inClinicSlotId) * (b.rank-1))  minute) ,

in_clinic_booking_reporting_time = date_add( DATE_ADD(current_time() ,
INTERVAL ((select in_clinic_slot_interval from dm_in_clinic_slot where in_clinic_slot_id=$inClinicSlotId) * (b.rank-1))  minute), INTERVAL -15 minute)


WHERE a.in_clinic_booking_id = b.in_clinic_booking_id

");
    }

}
