<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use App\Models\Sala_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Sala_userController extends Controller
{
    public function getSalaUser(Request $request)
    {
        try {
            $user = auth()->user();
            $sala_user = Sala_user::query()->where('user_id', $user->id)->get();

            if ($sala_user->isEmpty()) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "This user does not have any sala."
                    ],
                    Response::HTTP_OK
                );
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Salas obtained succesfully",
                    "data" => $sala_user
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining salas"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function createSalaUser(Request $request)
{
    try {
        $user_id = $request->input('user_id');
        $salas_id = $request->input('salas_id');

        $user = auth()->user();

        $sala_user = Sala_user::firstOrCreate(
            ['salas_id' => $salas_id, 'user_id' => $user_id]
        );

        if ($sala_user->wasRecentlyCreated) {
            return response()->json(
                [
                    "success" => true,
                    "message" => "Sala created successfully",
                    "data" => $sala_user
                ],
                Response::HTTP_OK
            );
        }

        if ($sala_user->user_id != $user->id) {
            return response()->json(
                [
                    "success" => true,
                    "message" => "You aren't an owner of this sala"
                ],
                Response::HTTP_OK
            );
        }

        $newMember = Sala_user::create(
            [
                "user_id" => $user_id,
                "salas_id" => $salas_id
            ]
        );

        return response()->json(
            [
                "success" => true,
                "message" => "User member added succesfully",
                "data" => $newMember
            ],
            Response::HTTP_OK
        );
    } catch (\Throwable $th) {
        Log::error($th->getMessage());

        return response()->json(
            [
                "success" => false,
                "message" => "Error can't adding a new member to sala "
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
}
