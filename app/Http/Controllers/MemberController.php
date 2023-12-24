<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Sala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class MemberController extends Controller
{
    public function addUserSalas(Request $request)
    {
        try {
            $userId = auth()->id();
            $salas_id = $request->input('salas_id');
            $newMember = Member::create([
                "user_id" => $userId,
                "salas_id" => $salas_id
            ]);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Member created",
                    "data" => $newMember
                ],
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            dd($th);
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error creating member"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function addMember(Request $request)
    {
        try {
            $userId = auth()->id();
            $userCreateSalas = Sala::where("user_id", $userId);

            if(!$userCreateSalas){
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Don't have auth"
                    ],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            $user_id = $request->input('user_id');
            $salas_id = $request->input('salas_id');

            $addMember = Member::create([
                "user_id" => $user_id,
                "salas_id" => $salas_id
            ]);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Member created",
                    "data" => $addMember
                ],
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error creating member"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function exitSalaById($id)
    {
        try {
            $memberId = Member::query()->find($id);

            if (!$memberId) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Member not found"
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }

            $userId = auth()->id();
            if ($memberId->user_id != $userId) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "You are not authorized to delete this member"
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }
            $memberDeleted = $memberId->delete();

            if ($memberDeleted) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Member deleted successfully"
                    ],
                    Response::HTTP_OK
                );
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error deleting member"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
