<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\ApiController;
use App\Enums\UserStatusEnum;
use App\Enums\EmployeeTypeEnum;
use App\Helpers\Enum;
use Illuminate\Http\Request;

class StatusController extends ApiController
{
    /**
     * APIs for retrive status record [support multiple status type]
     *
     * @urlParam type string. Example: user,business_type,employee,item,general,purchase
     */
    public function index(Request $request)
    {
        $requestStatus = explode(',', $request->get('type'));

        $allowableStatus = [
            'user' => (new Enum(UserStatusEnum::class))->values(),
            'user_type' => (new Enum(EmployeeTypeEnum::class))->values()
        ];

        $statusTypes = collect($allowableStatus)->filter(function ($value, $index) use ($requestStatus) {
            return in_array($index, $requestStatus);
        });

        return $this->successResponse($statusTypes,'Status type list are successfully retrived');
    }
}