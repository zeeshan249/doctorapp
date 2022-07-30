<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function Get(Request $request)
    {

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $doctor_id=$request->doctor_id;
        $clinic_id=$request->clinic_id;
        $filterBy = $request->searchText;
        $status= $request->in_clinic_booking_is_active;
        if ($status != null) {
            $status = $request->in_clinic_booking_is_active;
        } else {
            $status = 1;
        }
        $getQuery = DB::table("dm_in_clinic_booking")

            ->join('dm_doctor','dm_in_clinic_booking.doctor_id','dm_doctor.doctor_id')
            ->join('dm_clinic','dm_clinic.clinic_id','dm_in_clinic_booking.clinic_id')
            ->join('dm_specialization','dm_specialization.doctor_id','dm_in_clinic_booking.doctor_id')
            ->join('dm_family_member','dm_family_member.family_member_id','dm_in_clinic_booking.in_clinic_booking_made_for_family_id')
            ->select('dm_in_clinic_booking.in_clinic_booking_slot_position','dm_doctor.doctor_full_name','dm_clinic.clinic_full_name','dm_in_clinic_booking.disease_name'
            ,'dm_specialization.specialization_name','dm_in_clinic_booking.in_clinic_booking_current_slot_position',DB::raw('DATE_FORMAT(dm_in_clinic_booking.in_clinic_booking_date, "%d-%m-%Y") as in_clinic_booking_date'),
                'dm_family_member.family_member_full_name','dm_family_member.family_member_mobile_number',

                \DB::raw('(CASE

                        WHEN dm_in_clinic_booking.in_clinic_booking_is_active = "1" THEN "Active"

                        WHEN dm_in_clinic_booking.in_clinic_booking_is_active = "3" THEN "Completed"

                      WHEN dm_in_clinic_booking.in_clinic_booking_is_active = "2" THEN "Cancel"

                     WHEN dm_in_clinic_booking.in_clinic_booking_is_active = "4" THEN "Absent"
                        END) AS status'),

            )


            ->where('dm_in_clinic_booking.in_clinic_booking_date','>=',$request->in_clinic_booking_from_date)
            ->where('dm_in_clinic_booking.in_clinic_booking_date','<=',$request->in_clinic_booking_to_date)

           ->where(function ($q) use ($filterBy) {
               $q->where('dm_clinic.clinic_full_name', 'like', "%$filterBy%")
                   ->orWhere('dm_doctor.doctor_full_name', 'like', "%$filterBy%")
               ->orWhere('dm_family_member.family_member_full_name', 'like', "%$filterBy%");
           })
            ->where(function ($query) use ($doctor_id, $clinic_id) {
               if($clinic_id != null)
               {
                   $query ->where('dm_in_clinic_booking.doctor_id', $doctor_id)
                       ->where('dm_in_clinic_booking.clinic_id',$clinic_id);
               }
            })


            ->where('dm_in_clinic_booking.in_clinic_booking_is_active',$status)
           ->orderBy($sortColumn, $sortOrder)

            ->paginate($itemsPerPage);



        return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
    }

    public function doctorActiveDetails(Request  $request){
        $getQuery = DB::table("dm_doctor")
            ->join('dm_doctor_clinic_wise','dm_doctor_clinic_wise.doctor_id','dm_doctor.doctor_id')
            ->select('dm_doctor.doctor_id','dm_doctor_clinic_wise.clinic_id','dm_doctor.doctor_full_name')
            ->where('dm_doctor_clinic_wise.clinic_id',$request->clinic_id)
            ->where('dm_doctor.doctor_is_active',1)->get();
        return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
    }

    public function  clinicActiveDetails(){
        $getQuery = DB::table("dm_clinic")->where('dm_clinic.clinic_is_active',1)
            ->select('dm_clinic.clinic_id','dm_clinic.clinic_full_name')->get();
        return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
    }
}
