<?php

namespace App\Http\Controllers\Api\V1\Common;

use App\Models\Master\CarMake;
use App\Models\Master\CarModel;
use App\Http\Controllers\Api\V1\BaseController;
use Carbon\Carbon;
use Sk\Geohash\Geohash;
use Illuminate\Http\Request;

/**
 * @group Vehicle Management
 *
 * APIs for vehilce management apis. i.e types,car makes,models apis
 */
class CarMakeAndModelController extends BaseController
{
    protected $car_make;
    protected $car_model;

    public function __construct(CarMake $car_make, CarModel $car_model)
    {
        $this->car_make = $car_make;
        $this->car_model = $car_model;
    }

    /**
    * Get All Car makes
    *
    */
    public function getCarMakes()
    { 
        if(request()->has('vehicle_type')){

        return $this->respondSuccess($this->car_make->active()->orderBy('name')->where('vehicle_make_for',request()->vehicle_type)->get());

        }else{
            return $this->respondSuccess($this->car_make->active()->orderBy('name')->get());
        }
    }

   

    /**
    * Get Car models by make id
    * @urlParam make_id  required integer, make_id provided by user
    */
    public function getCarModels($make_id)
    {
        return $this->respondSuccess($this->car_model->where('make_id', $make_id)->active()->orderBy('name')->get());
    }


    /**
     * Test Api
     * 
     * */
    public function testApi(){

        $this->throwCustomValidationException('Provided email has already been taken','email');

        dd("emv vfvrf");
    }


    /**
     * Test Distance Matrix Api
     * @bodyParam pick_lat double required pikup lat of the user
     * @bodyParam pick_lng double required pikup lng of the user
     * @bodyParam drop_lat double required drop lat of the user
     * @bodyParam drop_lng double required drop lng of the user
     * 
     * */
    public function testDistanceMatrixApi(Request $request){

        $request->validate([
        'pick_lat' => 'required',
        'pick_lng' => 'required',
        'drop_lat' => 'required',
        'drop_lng' => 'required',
        'map_key' => 'sometimes|required'
        ]);

        // Test the Distance Matrix by provided lat & long

        if($request->has('map_key') && $request->map_key){

            $distance_matrix_result = get_distance_matrix_of_clients($request->pick_lat, $request->pick_lng, $request->drop_lat, $request->drop_lng,$request->map_key);    
        }else{

            $distance_matrix_result = get_distance_matrix($request->pick_lat, $request->pick_lng, $request->drop_lat, $request->drop_lng,true,$request->map_key);
        }
        

        if($distance_matrix_result->status=='OK'){
            return $this->respondSuccess($distance_matrix_result);

        }else{

            return response()->json(['success'=>false,'message'=>'there is an error with your map key','error'=>$distance_matrix_result]);
        }

    }
}
