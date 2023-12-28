<?php

namespace App\Http\Controllers;

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
}
