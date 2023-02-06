<?php

namespace App\Http\Controllers\Web\Master;

use App\Base\Filters\Master\CommonMasterFilter;
use App\Base\Libraries\QueryFilter\QueryFilterContract;
use App\Http\Controllers\Web\BaseController;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Base\Services\ImageUploader\ImageUploaderContract;


class CountryController extends BaseController
{
    protected $country;

    /**
     * CarMakeController constructor.
     *
     * @param \App\Models\Admin\Country $country
     */
    public function __construct(Country $country)
    {
        $this->country = $country;
    }

    public function index()
    {

      
        $page = trans('pages_names.view_country');

        $main_menu = 'master';
        $sub_menu = 'country';

        return view('admin.master.country.index', compact('page', 'main_menu', 'sub_menu'));
    }

    public function fetch(QueryFilterContract $queryFilter)
    {
        $query = $this->country->query();//->active()
        $results = $queryFilter->builder($query)->customFilter(new CommonMasterFilter)->paginate();

        return view('admin.master.country._country', compact('results'));
    }

    public function create()
    {
        $page = trans('pages_names.add_country');

        $main_menu = 'master';
        $sub_menu = 'country';

        return view('admin.master.country.create', compact('page', 'main_menu', 'sub_menu'));
    }

    public function store(Request $request)
    {
        if (env('APP_FOR')=='demo') {
            $message = trans('succes_messages.you_are_not_authorised');

            return redirect('country')->with('warning', $message);
        }

        Validator::country($request->all(), [
            'name' => 'required|unique:country,name'
        ])->validate();

        $created_params = $request->only(['name']);
        $created_params['active'] = 1;

        // $created_params['company_key'] = auth()->user()->company_key;

        $this->country->create($created_params);

        $message = trans('succes_messages.country_added_succesfully');

        return redirect('country')->with('success', $message);
    }

    public function getById(Country $country)
    {

        // dd($country);
        $page = trans('pages_names.edit_country');

        $main_menu = 'master';
        $sub_menu = 'country';
        $item = $country;

        return view('admin.master.country.update', compact('item', 'page', 'main_menu', 'sub_menu'));
    }

    public function update(Request $request, Country $country)
    {
        if (env('APP_FOR')=='demo') {
            $message = trans('succes_messages.you_are_not_authorised');

            return redirect('country')->with('warning', $message);
        }
        

        Validator::make($request->all(), [
            'name' => 'required|unique:countries,name',
            'currency_code' => 'required',
            'currency_symbol' => 'required',

        ])->validate();

        if ($uploadedFile = $this->getValidatedUpload('flag', $request)) {
            $created_params['flag'] = $this->imageUploader->file($uploadedFile)
                ->saveVehicleTypeImage();
        }

        $updated_params = $request->all();
        $country->update($updated_params);
        $message = trans('succes_messages.country_updated_succesfully');
        return redirect('country')->with('success', $message);
    }

    public function toggleStatus(Country $country)
    {
        $status = $country->isActive() ? false: true;
        $country->update(['active' => $status]);

        $message = trans('succes_messages.country_status_changed_succesfully');
        return redirect('country')->with('success', $message);
    }

    public function delete(Country $country)
    {
        if (env('APP_FOR')=='demo') {
            $message = trans('succes_messages.you_are_not_authorised');

            return redirect('country')->with('warning', $message);
        }
        $country->delete();

        $message = trans('succes_messages.country_deleted_succesfully');
        return redirect('country')->with('success', $message);
    }
}
