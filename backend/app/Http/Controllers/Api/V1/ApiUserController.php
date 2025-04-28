<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\ApiUserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiUserResource;

class ApiUserController extends Controller
{
    public function __construct(protected ApiUserService $apiUserService)
    {
        //
    }
   

    /**
     * Display a listing of the resource.
     */
    public function getProfile()
    {
        $user = $this->apiUserService->getProfile();

        return response()->json([
            'user' => new ApiUserResource($user),
        ]);
    }

  
}
