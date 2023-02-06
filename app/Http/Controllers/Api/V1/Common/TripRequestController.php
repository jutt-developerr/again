<?php

namespace App\Http\Controllers\Api\V1\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\SosRequest;
use Carbon\Carbon;
use App\Models\Admin\TripRequest;
//use Illuminate\Http\Request;
use App\Models\Request\Request;

class TripRequestController extends Controller
{
    protected $trip_request;

    public function __construct(TripRequest $trip_request)
    {
        $this->trip_request = $trip_request;
    }

    /**
     * List Sos
     * @urlParam lat required double  latitude provided by user
     * @urlParam lng required double  longitude provided by user
     * @responseFile responses/common/sos.json
     */
    public function index()
    {
        $result = $this->trip_request
            ->select('id', 'name', 'number', 'user_type', 'created_by')
            ->where('created_by', auth()->user()->id)
            ->orWhere('user_type', 'admin')
            ->orderBy('created_at', 'Desc')
            ->companyKey()->get();

        return $this->respondSuccess($result, 'trip_request_list');
    }

    /**
     * Store TripRequest
     * @bodyParam name string required name of the user
     * @bodyParam number string required number of the user
     * @response {
    "success": true,
    "message": "trip_request_created"
    }
     */
    public function store(Request $request)
    {
        //get the current created request from the request table
        $created_request=Request::where('created_at',Carbon::now()->toDateTimeString())->get();
        if($created_request) {
            $trip_request = new TripRequest();
            $trip_request->name = auth()->user()->name;
            $trip_request->number = auth()->user()->number;
            $trip_request->created_by = (int)auth()->user()->id;
            $trip_request->user_type = 'mobile-users';
            $trip_request->company_key = auth()->user()->company_key;
            $trip_request->active = true;

            $trip_request->save();
        }
        return $this->respondSuccess(null, 'trip_request_created');
    }

    /**
     * Delete Sos
     * @urlParam id required uuid  id of sos
     * @response {
    "success": true,
    "message": "trip_request_deleted"
    }
     */
    public function delete(TripRequest  $trip_request)
    {
        if ($trip_request->created_by != auth()->user()->id) {
            $this->throwAuthorizationException();
        }

        $trip_request->delete();

        return $this->respondSuccess(null, 'trip_request_deleted');
    }
}
