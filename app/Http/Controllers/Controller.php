<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     description="Hackathon Endpoints",
 *     version="1.0.0",
 *     title="Hackathon Endpoints",
 *     termsOfService="http://pf4.io/terms/",
 *     @OA\Contact(
 *         email="developers@pf4.io"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\Server(url="http://localhost:8000")
 * @OA\Server(url="http://ec2-52-73-186-169.compute-1.amazonaws.com/v1")
 */

/**
 * @OA\SecurityScheme(
 *   securityScheme="authentication",
 *   type="http",
 *   scheme="bearer"
 * )
 **/
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
