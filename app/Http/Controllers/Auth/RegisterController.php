<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
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
     *                      enum={"Negocio", "Emprendedor", "Cuentahabiente"},
     *                      default="Cuentahabiente"
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
        $validation = $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);
        // Build username
        preg_match('/([^@]+)/', $validation['email'], $output_array);
        Log::info( $output_array);
        $username = $output_array[0].'#'.mt_rand();

        $user = User::create([
            'username' => $username, //'username_'.$validation['email'][],
            'email' => $validation['email'],
            'password' => Hash::make($validation['password'])
        ]);

        $data = $request->only( 'last_name', 'birthdate', 'sex', 'bio', 'phone');
        // $data['users_id'] = $user->id;
        $filePath = $this->uploadUserPhoto($request, $user->username, 'photo');
        $data = array_merge($data, ['first_name' => $request->input('name'), 'users_id' => $user->id, 'image_profile' => $filePath]);
        // Log::info($data);
        UserProfile::create($data);

        $user->assignRole('Administrator');

        // $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Usuario creado',
        ]);
    }

}
