<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/sign-in",
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
        // Log::info($request->all());
        try {
            $credentials = $request->validate([
                'user' => ['required'],
                'password' => ['required'],
            ], [
                'required' => 'El campo :attribute es requerido.'
            ]);

            if (!Auth::attempt($credentials)) {
                if (!$request->has('user') || $request->input('user') == '') {
                    throw new \Exception("Campo de usuario vacio");
                }
                if (!$request->has('password') || $request->input('password') == '') {
                    throw new \Exception("Campo contraseña vacio");
                }
            }

            $user = User::where('email', $request['user'])
                ->orwhere('nickname', $request['user'])
                ->orwhere('phone', $request['user'])
                ->firstOrFail();

            // Validate password
            if(!Hash::check($request->input('password'), $user->password)) {
                throw new \Exception('Contraseña incorrecta');
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => 60 * 24 * 7
            ]);
        } catch (ModelNotFoundException $ex) {
            Log::error($ex);
            return response()->json([
                'error' => 'Hubo un error, verifica tu usuario y/o contraseña'
            ], 400);
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
}
