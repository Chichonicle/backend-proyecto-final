<?php

namespace App\Http\Controllers;

use App\Models\Member;
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
}
