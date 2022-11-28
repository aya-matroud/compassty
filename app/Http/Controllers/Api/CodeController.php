<?php

namespace App\Http\Controllers\Api;

use App\Models\Code;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use App\Http\Requests\CodeRequest;
use App\Http\Resources\CodeResource;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Str;

class CodeController extends ApiController
{
    public function __construct()
    {
        $this->resource = CodeResource::class;
        $this->model = app(Code::class);
        $this->repositry =  new Repository($this->model);
    }


     public function sellCode(Request $request){


        $data=Code::where('code',$request->code)->first();

        if ($data) {

            $data->update([
                'user_id'=> $request->user_id
            ]);
            return $this->returnData('data', new $this->resource( $data ), __('Updated succesfully'));
        }

        return $this->returnError(__('Sorry! Failed to get !'));


     }



}
