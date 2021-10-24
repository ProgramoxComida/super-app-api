<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\UploadTrait;
use App\Models\{User, UserProfile};
use Illuminate\Http\Request;
use Laravel\Passport\Client as OClient;
use Validator;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    use UploadTrait;
    /**
     * @OA\Post(
     *     path="/api/v1/sign-up",
     *     operationId="register",
     *     tags={"Auth"},
     *     summary="Auth",
     *     description="Este endpoint recibe los datos de un nuevo registro de cuenta.",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="email",
     *                      description="Email",
     *                      type="string",
     *                      format="email"
     *                  ),
     *                  @OA\Property(
     *                      property="username",
     *                      description="Username",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      description="Contraseña",
     *                      type="string",
     *                      format="password"
     *                  ),
     *                  @OA\Property(
     *                      property="phone",
     *                      description="Telefono",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="first_name",
     *                      description="Nombre o Nombres",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="first_last_name",
     *                      description="Primer Apellido",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="second_last_name",
     *                      description="Segundo Apellido",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="birthdate",
     *                      description="Cumpleaños",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="sex",
     *                      description="Genero",
     *                      type="string",
     *                      enum={"Masculino", "Femenino", "Otros", "Prefiere no especificar"},
     *                      default="Prefiere no especificar"
     *                  ),
     *                  @OA\Property(
     *                      property="type",
     *                      description="Indica el tipo de cuenta a crear",
     *                      type="string",
     *                      enum={"Invitado", "Libreton", "MiPyme"},
     *                      default="Invitado"
     *                  ),
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
    public function register(Request $request) {
        // Log::info($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users',
                'username' => 'unique:users',
                'password' => 'required',
                'phone' => 'required|same:password',
                'first_name' => 'required',
                'first_last_name' => 'required',
                'second_last_name' => 'required',
                'birthdate' => 'required',
                'sex' => 'required',
                'type' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 400);
            }
            $type = $request->input('type', 'Cuentahabiente');
            // creando usuario
            $password = $request->password;
            $iuser = $request->only('email', 'phone', 'password', 'username');
            $iuser['password'] = bcrypt($iuser['password']);
            $user = User::create($iuser);

            // creando perfil
            $data = $request->only( 'first_name', 'first_last_name', 'second_last_name', 'birthdate', 'sex');
            $filePath = $this->uploadUserPhoto($request, $user->username, 'photo');
            $data = array_merge($data, ['users_id' => $user->id, 'photo' => $filePath]);
            // Log::info($data);
            UserProfile::create($data);
            switch($type) {
                case 'Libreton':
                    $user->assignRole('Libreton');
                    break;
                case 'MiPyme':
                    $user->assignRole('MiPyme');
                    break;
                default:
                    $user->assignRole('Invitado');
                    break;
            }

            // oauth
            $oClient = OClient::where('password_client', 1)->first();
            return $this->getTokenAndRefreshToken($oClient, $user->email, $password);
        } catch(Exception $ex) {
            Log::error($ex);
            return response()->json([
                'error' => 'Ocurrio un error, por favor vuelva a intentar o intente mas tarde.'
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
