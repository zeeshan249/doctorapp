<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ClinicSlotController extends Controller
{
    public function getSlotName(Request $request)
    {

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn =$request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;


        $getQuery = DB::table("dm_slot_name")


            ->select('dm_slot_name.slot_name_id','slot_name'

            )

            ->where(function ($q) use ($filterBy) {
                $q->where('dm_slot_name.slot_is_active', 1);

            })
            ->paginate($itemsPerPage);


        return response()->json([ 'success' => 'true','resultData' => $getQuery], 200);
    }

    public function saveInClinicSlot(Request  $request){
        $saveQuery = DB::table('dm_in_clinic_slot')->insertGetId(
            [
                'slot_name_id' => trim($request->slot_name_id),
                'clinic_id'=>$request->clinic_id,
                'doctor_id' =>$request->doctor_id,
                'in_clinic_doctor_max_booking_days'=>$request->in_clinic_doctor_max_booking_days,
                'in_clinic_slot_is_active'=>$request->in_clinic_slot_is_active,
                'in_clinic_doctor_is_available_date_wise'=>$request->in_clinic_doctor_is_available_date_wise,
                'in_clinic_max_slot_position'=>$request->in_clinic_max_slot_position,
                'in_clinic_slot_start_time'=>$request->in_clinic_slot_start_time,
                'in_clinic_slot_end_time'=>$request->in_clinic_slot_end_time,
                'in_clinic_slot_interval'=>$request->in_clinic_slot_interval,
                'in_clinic_doctor_booking_week_days'=>$request->in_clinic_doctor_booking_week_days

            ]
        );
        if ($saveQuery > 0) {
            return response()->json(['message' => 'In Clinic Slot saved successfully','success'=>'true'], 200);
        }
    }

    public function saveDoctorClinicWise(Request  $request){
        $saveQuery = DB::table('dm_doctor_clinic_wise')->insertGetId(
            [
                'doctor_id' => trim($request->doctor_id),
                'clinic_id'=>$request->clinic_id,

                'in_clinic_appointment_fee_is_visible'=>$request->in_clinic_appointment_fee_is_visible,
                'video_consultation_fee_is_visible'=>$request->video_consultation_fee_is_visible,
                'video_consultation_is_avialable'=>$request->video_consultation_is_avialable,
                'in_clinic_appointment_fee'=>$request->in_clinic_appointment_fee,
                'video_consultation_fee'=>$request->video_consultation_fee,
                'in_clinic_service_fee'=>$request->in_clinic_service_fee,
                'video_consultation_service_fee'=>$request->video_consultation_service_fee,
                'doctor_clinic_wise_is_active'=>$request->doctor_clinic_wise_is_active,
                'doctor_clinic_wise_created_at'=>Carbon::now(),
//                'doctor_clinic_wise_created_by'=>$request->doctor_clinic_wise_created_by,
                'doctor_clinic_wise_updated_at'=>Carbon::now(),
//                'doctor_clinic_wise_updated_by'=>$request->doctor_clinic_wise_updated_by,
                'in_clinic_consultation_is_avialable'=>$request->in_clinic_consultation_is_avialable,
                'in_clinic_cancellation_days'=>$request->in_clinic_cancellation_days,
                'video_cancellation_days'=>$request->video_cancellation_days,
                'in_clinic_book_before_days'=>$request->in_clinic_book_before_days,
                'video_book_before_days'=>$request->video_book_before_days
            ]
        );
        if ($saveQuery > 0) {
            return response()->json(['message' => 'Doctor Clinic Slot saved successfully','success'=>'true'], 200);
        }
    }


}
