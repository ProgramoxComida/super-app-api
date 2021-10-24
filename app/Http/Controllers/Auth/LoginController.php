<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Validator};
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Client as OClient;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/sign-in",
     *     operationId="login",
     *     tags={"Auth"},
     *     summary="Auth",
     *     description="Este endpoint login del usuario.",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="user",
     *                      description="Email / Telefono / Usuario",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      description="Contraseña",
     *                      type="string",
     *                      format="password"
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Token")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid credentials",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Couldn't Create Token",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function login(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'user' => ['required'],
                'password' => ['required'],
            ], [
                'required' => 'El campo :attribute es requerido.'
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator->errors());
            }

            $user = User::where('email', $request['user'])
                ->orwhere('username', $request['user'])
                ->orwhere('phone', $request['user'])
                ->firstOrFail();

            // Validate password
            if(!Hash::check($request->input('password'), $user->password)) {
                throw new \Exception('Contraseña incorrecta');
            }

            $oClient = OClient::where('password_client', 1)->first();
            return $this->getTokenAndRefreshToken($oClient, request('email'), request('password'), true);

        } catch (ModelNotFoundException $ex) {
            Log::error($ex);
            return response()->json([
                'error' => 'Hubo un error, verifica tu usuario y/o contraseña'
            ], 401);
        } catch (ValidationException $ex) {
            return response()->json([
                'status' => false,
                'error' => $ex->errors()
            ], 400);
        } catch (\Exception $ex) {
            Log::error($ex);
            return response()->json([
                'status' => false,
                'error' => $ex->getMessage()
            ], 400);
        }
    }

    private function getTokenAndRefreshToken(OClient $oClient, $email, $password, $isLogin = false) {
        $oClient = OClient::where('password_client', 1)->first();
        $http = new Client;
        $userRole = null;

        if($isLogin) {
            $user = Auth::user();
            $userRole = $user->role()->first();
        }

        $response = $http->request('POST', env('OAUTH_APP_URL'), [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $oClient->id,
                'client_secret' => $oClient->secret,
                'username' => $email,
                'password' => $password,
                'scope' => (null !== $userRole) ? $userRole->role : 'Invitado',
            ],
        ]);

        $result = json_decode((string) $response->getBody(), true);
        return response()->json($result, $this->successStatus);
    }
}
