<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Models\User;
use App\Models\Notification;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use App\Traits\NotificationTrait;

class CompanyController extends ApiController
{
    use NotificationTrait;
    public function __construct()
    {
        $this->resource = CompanyResource::class;
        $this->model = app(Company::class);
        $this->repositry = new Repository($this->model);
    }

    public function save(Request $request)
    {

        $company = $this->repositry->save($request->all());

        $user = User::find($company->user_id);

        $token = $user->device_token;

        $this->send('تم إضافة عنوانك التجاري بنجاح','مرحبا ',$token);


        $note = new Notification();
        // $note->title = 'مرحبا';
        $note->content = 'تم اضافة عنوانك التجاري بنجاح';
        $note->user_id = $company->user_id;
        $note->save();

        return $this->returnSuccessMessage(__('The notification has been sent successfully!'));

    }

    public function edit($id, Request $request)
    {

        return $this->update($id, $request->all());

    }

    public function lookfor(Request $request)
    {

        return $this->search('name', $request->value);

    }


}
