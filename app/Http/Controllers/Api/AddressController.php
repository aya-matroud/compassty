<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Models\Code;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AddressController extends ApiController
{

    public function __construct()
    {
        $this->resource = AddressResource::class;
        $this->model = app(Address::class);
        $this->repositry = new Repository($this->model);
    }

    public function save(Request $request)
    {


        $country_code = substr($request->country,0, 2);
        $city_code =substr($request->city,0, 2);

        // echo $city_code;
        // return;
        $country_city = strtoupper( $country_code . $city_code );
        $random_number = random_int(1000, 9999);
        $rn = (string) $random_number;

        if ($this->checkUniqueNumber($rn)) {

            // print_r($rn . '</br>');
            // echo 'true';

            $code = new Code();
            $code->code = 'UNIQUE' . $rn;
            //$code->name = 'Unique - ' . $rn;
            $code->save();

            return $this->save($request);

        }else {


            $code_rn = str($country_city)->append($rn);
            $code = new Code();
            $code->id = $request->id;
            $code->code = $code_rn;
            //$code->name = $request->name;
            $code->save();

            $request['code_id'] = $code->id;

            $address = $this->repositry->save($request->all());

            return $this->returnData('data', new $this->resource($address), __('Get  succesfully'));

            // return $this->store($request->all());
        }
    }

    public function edit($id, Request $request)
    {

        return $this->update($id, $request->all());

    }

    public function view($code)
    {

        $data = Code::where('code', $code)->first();
        if (!$data->address) {
            return $this->returnError('Address not found !!!');
        }

        // echo $data->name; // getNameAttribute()
        // return;
        return $this->returnData('data', new $this->resource($data->address), __('Get  succesfully'));
    }

    public function myAddresses(Request $request)
    {

        $user = Auth::user();

        return $this->returnData('data', MyAddressResource::collection($user->addresses), __('Get  succesfully'));
    }

    public function checkUniqueNumber($rn)
    {

        if (($rn[1] == $rn[0] + 1 ||
            $rn[2] == $rn[1] + 1 ||
            $rn[3] == $rn[2] + 1) || ($rn[1] == $rn[0] - 1 ||
            $rn[2] == $rn[1] - 1 ||
            $rn[3] == $rn[2] - 1) || ($rn[0] == $rn[1] ||
            $rn[1] == $rn[2] ||
            $rn[2] == $rn[3])) {
            return true;
        }

        return false;

    }



}
