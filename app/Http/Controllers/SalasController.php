<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Symfony\Component\HttpFoundation\Response;

class SalasController extends Controller
{
    public function createSala(Request $request)
{
    try {
        $validator = FacadesValidator::make($request->all(), [
        'name' => 'required|min:3|max:100',
        'series_id' => 'required|exists:series,id'
    ]);

    if ($validator->fails()) {
        return response()->json(
            [
                "success" => true,
                "message" => "Error creating sala",
                "error" => $validator->errors()
            ],
            Response::HTTP_BAD_REQUEST
        );
    } 

    $newSala = Sala::create(
        [
            "name" => $request->input('name'),
            "series_id" => $request->input('series_id')
        ]
    );
        $user = auth::user();
        $newSala->Sala_userManyToMany()->attach($user->id);


        return response()->json(
            [
                "success" => true,
                "message" => "Sala created successfully",
                "data" => $newSala
            ],
            Response::HTTP_CREATED
        );
    } catch (\Throwable $th) {
        Log::error($th->getMessage());

        return response()->json(
            [
                "success" => false,
                "message" => "Error creating sala"
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}

        

        


    public function leaveSala(Request $request, $series_id)
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

            $salasMember = Sala::where('user_id', $user->id)->where('series_id', $series_id)->first();

            if ($salasMember) {
                $salasMember->delete();

                return response()->json(
                    [
                        "success" => true,
                        "message" => "User left the sala successfully"
                    ],
                    Response::HTTP_OK
                );
            } else {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "User is not a member of the sala"
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error leaving the sala",
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function isUserMemberOfSala($user_id, $series_id)
{
    $existingMember = Sala::where('user_id', $user_id)->where('series_id', $series_id)->first();

    if ($existingMember) {
        return response()->json(
            [
                "success" => true,
                "message" => "User is a member of the sala",
                "data" => $existingMember
            ],
            Response::HTTP_OK
        );
    } else {
        return response()->json(
            [
                "success" => false,
                "message" => "User is not a member of the sala",
            ],
            Response::HTTP_OK
        );
    }
}
}
