<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *      path="/me",
     *      operationId="profile",
     *      security={{"bearer":{}}},
     *      tags={"User"},
     *      summary="Get user's profile",
     *      description="Obtains the current user's profile using the JWT token delivered by login and/or register.",
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(response=401, description="Access denied"),
     *     )
     */
    public function me() {
        $user = Auth::user();

        $user->profile;

        return response()->json($user, $this->successStatus);
    }
}
