<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
class ClinicController extends Controller
{
    public function Get(Request $request)
    {

        $status= $request->clinic_is_active;
        if ($status != null) {
            $status = $request->clinic_is_active;
        } else {
            $status = 1;
        }

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn ='dm_clinic.'.$request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;


        $getQuery = DB::table("dm_clinic")
            ->join('dm_city', 'dm_city.city_id', '=', 'dm_clinic.city_id')
            ->join('dm_area', 'dm_area.area_id', '=', 'dm_clinic.area_id')

            ->select('dm_clinic.clinic_id','dm_clinic.area_id', 'dm_clinic.city_id', 'dm_area.area_name','dm_city.city_name', 'dm_clinic.clinic_mobile_number', 'dm_clinic.clinic_full_name'
                ,'dm_clinic.clinic_profile_image','dm_clinic.clinic_address','dm_clinic.clinic_owner_name','dm_clinic.clinic_setup_date'
                ,'dm_clinic.clinic_email_id','dm_clinic.clinic_address','dm_clinic.clinic_whatsapp','dm_clinic.clinic_facebook'

            )

            ->where(function ($q) use ($filterBy) {
                $q->where('dm_clinic.clinic_full_name', 'like', "%$filterBy%");
//                    ->orWhere('dm_doctor.doctor_full_name', 'like', "%$filterBy%")
//                    ->orWhere('dm_family_member.family_member_full_name', 'like', "%$filterBy%");
            })

            ->where('dm_clinic.clinic_is_active',$status)
            ->paginate($itemsPerPage);


        return response()->json([ 'success' => 'true','resultData' => $getQuery], 200);
    }

    public function clinicWiseBooking(Request $request){
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;

        $clinic_id=$request->clinic_id;
//        $filterBy = $request->searchText;
        $status= $request->in_clinic_booking_is_active;
        if ($status != null) {
            $status = $request->in_clinic_booking_is_active;
        } else {
            $status = 1;
        }
    $getQuery=   DB::table("dm_in_clinic_booking")


            ->join('dm_clinic','dm_clinic.clinic_id','dm_in_clinic_booking.clinic_id')
            ->join('dm_doctor','dm_doctor.doctor_id','dm_in_clinic_booking.doctor_id')

            ->select(DB::raw('DATE_FORMAT(dm_in_clinic_booking.in_clinic_booking_date, "%d-%m-%Y") as in_clinic_booking_date'),'dm_clinic.clinic_full_name','dm_clinic.clinic_id','dm_in_clinic_booking.doctor_id','dm_doctor.doctor_full_name',
                DB::raw("count(dm_in_clinic_booking.in_clinic_booking_is_active) as total_booking",

            )
                )

              ->groupBy('dm_in_clinic_booking.clinic_id')
             ->groupBy('dm_doctor.doctor_id')
            ->where('dm_in_clinic_booking.in_clinic_booking_date','=',$request->in_clinic_booking_date)
            ->where(function ($query) use ($clinic_id) {
            if($clinic_id != null)
            {
                $query
                    ->where('dm_in_clinic_booking.clinic_id',$clinic_id);           //passing clinic_id
            }
                  })
        ->where('dm_in_clinic_booking.in_clinic_booking_is_active',$status)
            ->orderBy($sortColumn, $sortOrder)
              ->get();
//            ->paginate($itemsPerPage);
        return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
    }

    public function upcomingBookingDetails(Request $request){

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;

        $clinic_id=$request->clinic_id;
//        $filterBy = $request->searchText;
        $status= $request->in_clinic_booking_is_active;
        if ($status != null) {
            $status = $request->in_clinic_booking_is_active;
        } else {
            $status = 1;
        }
        $getQuery=   DB::table("dm_in_clinic_booking")


            ->join('dm_clinic','dm_clinic.clinic_id','dm_in_clinic_booking.clinic_id')
            ->join('dm_doctor','dm_doctor.doctor_id','dm_in_clinic_booking.doctor_id')

            ->select(DB::raw('DATE_FORMAT(dm_in_clinic_booking.in_clinic_booking_date, "%d-%m-%Y") as in_clinic_booking_date'),'dm_clinic.clinic_full_name','dm_clinic.clinic_id','dm_in_clinic_booking.doctor_id','dm_doctor.doctor_full_name',
                DB::raw("count(dm_in_clinic_booking.in_clinic_booking_is_active) as total_booking",

                )
            )

            ->groupBy('dm_in_clinic_booking.clinic_id')
            ->groupBy('dm_doctor.doctor_id')
            ->where('dm_in_clinic_booking.in_clinic_booking_date','>=',now())
            ->where(function ($query) use ($clinic_id) {
                if($clinic_id != null)
                {
                    $query
                        ->where('dm_in_clinic_booking.clinic_id',$clinic_id);           //passing clinic_id
                }
            })
            ->where('dm_in_clinic_booking.in_clinic_booking_is_active',$status)
            ->orderBy($sortColumn, $sortOrder)
            ->get();
//            ->paginate($itemsPerPage);
        return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
    }

    public function getDoctorDetailsWithoutPagination(Request $request){
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn =$request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;
        $status= $request->doctor_is_active;
        if ($status != null) {
            $status = $request->doctor_is_active;
        } else
        {
            $status = 1;
        }

        $getQuery = DB::table("dm_doctor")
            ->join('dm_specialization','dm_specialization.doctor_id','dm_doctor.doctor_id')
            ->select('dm_doctor.doctor_id','dm_doctor.doctor_full_name','doctor_mobile_number','doctor_overall_experience'
                ,'doctor_city','doctor_address','dm_specialization.specialization_name'
            )

            ->where(function ($q) use ($filterBy) {
                $q->where('dm_doctor.doctor_full_name', 'like', "%$filterBy%");
//                    ->orWhere('dm_doctor.doctor_full_name', 'like', "%$filterBy%")
//                    ->orWhere('dm_family_member.family_member_full_name', 'like', "%$filterBy%");
            })
            ->where('dm_doctor.doctor_is_active',$status)
            ->get();


        return response()->json([ 'success' => 'true','resultData' => $getQuery], 200);
    }

    public function getDoctorDetails(Request $request){
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn =$request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;
        $status= $request->doctor_is_active;
        if ($status != null) {
            $status = $request->doctor_is_active;
        } else
        {
            $status = 1;
        }

        $getQuery = DB::table("dm_doctor")
            ->join('dm_specialization','dm_specialization.doctor_id','dm_doctor.doctor_id')
            ->select('dm_doctor.doctor_id','dm_doctor.doctor_full_name','doctor_mobile_number','doctor_overall_experience'
                ,'doctor_city','doctor_address','dm_specialization.specialization_name'
            )

            ->where(function ($q) use ($filterBy) {
                $q->where('dm_doctor.doctor_full_name', 'like', "%$filterBy%");
//                    ->orWhere('dm_doctor.doctor_full_name', 'like', "%$filterBy%")
//                    ->orWhere('dm_family_member.family_member_full_name', 'like', "%$filterBy%");
            })
            ->where('dm_doctor.doctor_is_active',$status)
            ->paginate($itemsPerPage);


        return response()->json([ 'success' => 'true','resultData' => $getQuery], 200);
    }
}
