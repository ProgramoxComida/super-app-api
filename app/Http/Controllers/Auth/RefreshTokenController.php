<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Exception;
use GuzzleHttp\Client;
use Laravel\Passport\Client as OClient;

class RefreshTokenController extends Controller
{
    /**
     * @OA\Post(
     *      path="/refresh_token",
     *      operationId="refreshtoken",
     *      tags={"Auth"},
     *      summary="Refresh Token",
     *      description="Refresh token with OAuth 2 for keeping the session active.",
     *
     *      @OA\Parameter(
     *          name="Refreshtoken",
     *          in="header",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *      ),
     *      @OA\Response(response=401, description="Access denied"),
     *     )
     */
    public function refreshToken(Request $request) {
        $refresh_token = $request->header('Refreshtoken');
        $oClient = OClient::where('password_client', 1)->first();
        $http = new Client;

        try {
            $response = $http->request('POST',  env('OAUTH_APP_URL'), [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refresh_token,
                    'client_id' => $oClient->id,
                    'client_secret' => $oClient->secret,
                    'scope' => '*',
                ],
            ]);
            return json_decode((string) $response->getBody(), true);
        } catch (Exception $e) {
            return response()->json("Unauthorized", 401);
        }
    }
}
