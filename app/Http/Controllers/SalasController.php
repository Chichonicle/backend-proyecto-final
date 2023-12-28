<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SalasController extends Controller
{
    public function joinSala(Request $request, $series_id)
    {
        try {
            $user = auth::user();
            if (!$user) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Authentication required"
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            $existingMember = Sala::where('user_id', $user->id)->where('series_id', $series_id)->first();
            if ($existingMember) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "User is already a member of that sala"
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $salaMember = Sala::create([
                'user_id' => $user->id,
                'series_id' => $series_id,
            ]);

            return response()->json(
                [
                    "success" => true,
                    "message" => "User joined to sala successfully",
                    "data" => $salaMember
                ],
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error joining the sala",
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    
}
