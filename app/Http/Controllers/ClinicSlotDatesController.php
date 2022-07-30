<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClinicSlotDatesController extends Controller
{
    public function getAllSlotDates(Request  $request){
//        $status= $request->clinic_is_active;
//        if ($status != null) {
//            $status = $request->clinic_is_active;
//        } else {
//            $status = 1;
//        }

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn =$request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;

        $getQuery = DB::table("dm_in_clinic_slot_dates")
            ->select(['dm_in_clinic_slot_dates.in_clinic_slot_dates_id','dm_in_clinic_slot_dates.in_clinic_slot_id','dm_in_clinic_slot_dates.is_booking_available',
                'dm_in_clinic_slot.clinic_id','dm_in_clinic_slot.doctor_id','dm_clinic.clinic_full_name',
                'dm_doctor.doctor_full_name','dm_in_clinic_slot_dates.in_clinic_slot_dates',


                DB::raw('DATE_FORMAT(dm_in_clinic_slot_dates.in_clinic_slot_start_time, "%h-%i %p") as start_time', "%d-%m-%Y"),
                DB::raw('DATE_FORMAT(dm_in_clinic_slot_dates.in_clinic_slot_end_time, "%h-%i %p") as end_time', "%d-%m-%Y")
                    ])

            ->join('dm_in_clinic_slot','dm_in_clinic_slot.in_clinic_slot_id','dm_in_clinic_slot_dates.in_clinic_slot_id')
            ->join('dm_clinic','dm_clinic.clinic_id','dm_in_clinic_slot.clinic_id')
            ->join('dm_doctor','dm_doctor.doctor_id','dm_in_clinic_slot.doctor_id')



            ->where('dm_in_clinic_slot_dates.in_clinic_slot_start_time', 'like',  '%'.$filterBy.'%' )
            ->where('dm_in_clinic_slot_dates.in_clinic_slot_dates',$filterBy)

            ->where('dm_in_clinic_slot_dates.in_clinic_slot_dates_is_active', '1')
            ->orderBy($sortColumn,$sortOrder)
            ->paginate($itemsPerPage);



        return response()->json([ 'success' => 'true','resultData' => $getQuery], 200);
    }

    public function slotstatus(Request $request)
    {



        try
        {

            $id = $request->in_clinic_slot_dates_id;

            $updateQuery = DB::table('dm_in_clinic_slot_dates')
                ->where('in_clinic_slot_dates_id', $id)
                ->update([
                    'is_booking_available' => $request->is_booking_available,

                ]);
            if ($updateQuery > 0) {

                return response()->json(['result' => "success", 'message' => 'Slot updated successfully']);

            } else {
                return response()->json(['result' => "error", 'message' => 'Something went wrong']);

            }

        } catch (Exception $ex) {

            return response()->json(['result' => "exception", 'message' => 'Something went wrong']);
        }

    }
}
