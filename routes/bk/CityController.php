<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function Get(Request $request)
    {
        try {

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $searchText = $request->searchText;


        $getQuery = DB::table("dm_city")
            ->select('city_id','city_name','city_is_active')
            ->where('city_name', 'like', '%' . $searchText . '%')->orderBy($sortColumn, $sortOrder)

            ->paginate($itemsPerPage);

        }
        catch (Exception $ex) {

            return response()->json(['success'=>'false','result' => "exception", 'message' => 'Something went wrong']);
        }


        return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
    }

    public function Save(Request  $request){
        $city_name = trim($request->city_name);

        $city= DB::table('dm_city')->where('city_name',$city_name)->count();
        if ( $city>0) {
            return response()->json(['success'=>'true','message' => 'City name already present please enter a new City Name'], 200);
        }
        else {
            $saveQuery = DB::table('dm_city')->insertGetId(
                [
                    'city_name' => $city_name,
                    'city_is_active' => 1,

                ]
            );
            if ($saveQuery > 0) {
                return response()->json(['success'=>'true','message' => 'City saved successfully'], 200);
            }
        }
    }

    public function Update(Request  $request){
        $city_name = trim($request->city_name);
        $Id = $request->Id;


        $db = DB::table('dm_city')->where('city_name', $city_name)->where('city_id', '!=', $Id )->count();

        if ($db > 0) {
            return response()->json(['success'=>'true','message' => 'City name name already present please enter a new City name'], 200);
        }
        else {
            $updateQuery = DB::table('dm_city')
                ->where('city_id', $Id)
                ->update([
                    'city_name' => $city_name,


                ]);
            if ($updateQuery) {

                return response()->json(['success'=>'true','message' =>  'City updated successfully'], 200);
            }
        }
    }

    public function Status(Request  $request){
        $city_status = $request->city_status;
        $Id = $request->Id;
        try {
            $updateQuery = DB::table('dm_city')
                ->where('city_id', $Id)
                ->update([
                    'city_is_active' => $city_status,


                ]);
            if ($updateQuery > 0) {

                return response()->json(['success'=>'true','message' => 'City Status Changed successfully'], 200);
            }
        }
        catch (Exception $ex) {

            return response()->json(['success'=>'false','result' => "exception", 'message' => 'Something went wrong']);
        }
    }
}
