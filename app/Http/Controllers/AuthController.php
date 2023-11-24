<?php

namespace App\Http\Controllers;

use App\Constants\FleetManagementConstants;
use App\Http\Responses\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;

/**
 * @group Authentication
 *
 * APIs for managing user authentication.
 */
class AuthController extends Controller
{
    /**
     * Login user and generate access token.
     *
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="Login user and generate access token.",
     *     tags={"Auth"},
     *     @OA\Parameter(
     *          name="Locale",
     *          description="Locale",
     *          required=false,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="email", type="string", example="Alaahabib364@gmail.com"),
     *                 @OA\Property(property="password", type="string", example="password"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful",
     *     @OA\JsonContent(
     *              type="object",
     *               @OA\Property(property="is_successful", type="boolean", example=true),
     *               @OA\Property(property="message", type="string", description="string"),
     *              @OA\Property(property="data", type="object",
     *                       @OA\Property(property="token", type="string", example="access_token"),
     *                       @OA\Property(property="name", type="string", example="Alaa Habib"),
     *              ),
     *               @OA\Property(property="errors", type="object"),
     *               @OA\Property(property="response_code", type="string", description="Response code"),
     *      ),
     *     @OA\Property(property="is_successful", type="boolean", example=true),
     *     @OA\Property(type="string",description="message",property="message" , example="Login Successfully."),
     *     @OA\Property(type="object",description="errors",property="errors" , example=""),
     *     @OA\Property(type="string",description="response_code",property="response_code" , example="AUTH_4001"),
     *    ),
     *    @OA\Response(
     *     response="401",
     *     description="Unauthorized",
     *     @OA\JsonContent(
     *         @OA\Property(property="is_successful", type="boolean", example=false),
     *         @OA\Property(property="message", type="string", example="Unauthorized"),
     *         @OA\Property(property="data", type="object"),
     *         @OA\Property(property="errors", type="object"),
     *         @OA\Property(property="response_code", type="string",example="AUTH_4002"),
     *     ),
     * ),
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;
            return Response::create()
                ->setData($success)
                ->setStatusCode(ResponseStatus::HTTP_OK)
                ->setMessage(__(FleetManagementConstants::RESPONSE_CODES_MESSAGES[FleetManagementConstants::AUTH_4001]))
                ->setResponseCode(FleetManagementConstants::AUTH_4001)

                ->success();
        } else
            return Response::create()
                ->setStatusCode(ResponseStatus::HTTP_UNAUTHORIZED)
                ->setMessage(__(FleetManagementConstants::RESPONSE_CODES_MESSAGES[FleetManagementConstants::AUTH_4002]))
                ->setResponseCode(FleetManagementConstants::AUTH_4002)
                ->failure();
    }
    /**
     * Logout user and revoke the access token.
     *
     * @OA\Get(
     *     path="/api/v1/logout",
     *     summary="Logout user and revoke the access token.",
     *     tags={"Auth"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *          name="Locale",
     *          description="Locale",
     *          required=false,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful",
     *     @OA\JsonContent(
     *              type="object",
     *               @OA\Property(property="is_successful", type="boolean", example=true),
     *               @OA\Property(property="message", type="string", description="string"),
     *               @OA\Property(property="errors", type="object"),
     *               @OA\Property(property="response_code", type="string", description="Response code"),
     *      ),
     *     @OA\Property(property="is_successful", type="boolean", example=true),
     *     @OA\Property(type="string",description="message",property="message" , example="Logout Successfully."),
     *     @OA\Property(type="object",description="errors",property="errors" , example=""),
     *     @OA\Property(type="string",description="response_code",property="response_code" , example="AUTH_4003"),
     *    ),
     *    @OA\Response(
     *     response="401",
     *     description="Unauthorized",
     *     @OA\JsonContent(
     *         @OA\Property(property="is_successful", type="boolean", example=false),
     *         @OA\Property(property="message", type="string", example="Unauthorized"),
     *         @OA\Property(property="data", type="object"),
     *         @OA\Property(property="errors", type="object"),
     *         @OA\Property(property="response_code", type="string",example="AUTH_4002"),
     *     ),
     * ),
     * )
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();

        return Response::create()
            ->setStatusCode(ResponseStatus::HTTP_OK)
            ->setMessage(__(FleetManagementConstants::RESPONSE_CODES_MESSAGES[FleetManagementConstants::AUTH_4003]))
            ->setResponseCode(FleetManagementConstants::AUTH_4003)
            ->success();
    }
}
