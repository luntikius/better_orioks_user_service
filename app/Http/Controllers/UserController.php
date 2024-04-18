<?php

namespace App\Http\Controllers;

use App\Models\OrioksScore;
use App\Models\OrioksUser;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * @OA\Info(
 *     title="Better Orioks User Service API",
 *     version="1",
 *     @OA\Contact(
 *         email="luntikius@gmail.com",
 *         name="Ivan"
 *     )
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/users",
     *     tags={"Users"},
     *     summary="Add a user",
     *     @OA\RequestBody(
     *          required=true,
     *          description="User data",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="string", example="123"),
     *              @OA\Property(property="auth_string", type="string", example="abcd1234"),
     *              @OA\Property(property="is_receiving_news_notifications", type="boolean", example=true),
     *              @OA\Property(property="is_receiving_performance_notifications", type="boolean", example=true)
     *          )
     *      ),
     *     @OA\Response(response="200", description="registers a user in database")
     * )
     */
    public function registerAUser (Request $request): View
    {
        $userData = $request -> validate([
            'id' => 'required',
            'auth_string' => 'required',
            'is_receiving_performance_notifications' => 'required',
            'is_receiving_news_notifications' => 'required',
            ]);
        $userData['last_news_id'] = -1;
        
        OrioksUser::create($userData);
        return view("welcome");
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users",
     *     tags={"Users"},
     *     summary="users",
     *     @OA\Response(response="200", description="List Of Users")
     * )
     */
    public function getUsers(): false|string
    {
        return json_encode(OrioksUser::all());
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/users",
     *     tags={"Users"},
     *     summary="users",
     *     @OA\RequestBody(
     *           required=true,
     *           description="User data",
     *           @OA\JsonContent(
     *               @OA\Property(property="id", type="string", example="123"),
     *           )
     *       ),
     *     @OA\Response(response="200", description="Delete A User By ID")
     * )
     */
    public function deleteUser(Request $request):void
    {
        $id = $request -> validate(['id' => 'required']);
        OrioksUser::where('id', $id) -> delete();
    }

    /**
     * @OA\Get(
     *     path="/api/v1/performances",
     *     tags={"performances"},
     *     summary="performances",
     *     @OA\Response(response="200", description="List Of Performances")
     * )
     */
    public function getPerformance(): false|string
    {
        return json_encode(OrioksScore::all());
    }

}
