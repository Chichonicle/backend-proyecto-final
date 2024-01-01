<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Sala;
use App\Models\Series;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class adminController extends Controller
{
    public function createSerie(Request $request)
    {
        try {

            $user = auth()->user();
            if ($user->role != "admin") {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "You are not an admin"
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3|max:100',
                'genre' => 'required|min:3|max:50',
                'year' => 'required|min:4|max:4',
                'url' => 'required|min:3|max:200',
                'picture' => 'required|min:3|max:200',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Error creating serie",
                        "error" => $validator->errors()
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $newSerie = Series::create(
                [
                    "name" => $request->input('name'),
                    "genre" => $request->input('genre'),
                    "year" => $request->input('year'),
                    "url" => $request->input('url'),
                    "picture" => $request->input('picture'),
                    "user_id" => $user->id
                ]
            );

            return response()->json(
                [
                    "success" => true,
                    "message" => "Serie created successfully",
                    "data" => $newSerie
                ],
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error creating serie"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function deleteSerie(Request $request, $id)
    {
        try {

            $user = auth()->user();

            if ($user->role != "admin") {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "You are not admin"
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            $serie = Series::query()->find($id);

            if ($serie) {

                Series::destroy($id);

                return response()->json(
                    [
                        "success" => true,
                        "message" => "Serie deleted successfully"
                    ],
                    Response::HTTP_OK
                );
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Serie not exist"
                ],
                Response::HTTP_OK
            );

        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error deleting serie"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getAllSalas(Request $request)
    {
        try {
            $user = auth()->user();

            if ($user->role != "admin") {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "You are not admin"
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            $salas = Sala::query()->get();

            if($salas->isEmpty()){
                return response()->json(
                    [
                        "success" => true,
                        "message" => "There are not any salas", 
                    ],
                    Response::HTTP_OK
                ); 
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Salas obtained succesfully",
                    "data" => $salas
                ],
                Response::HTTP_OK
            );

        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining salas",
                    "data" => $salas
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getAllUsers(Request $request)
    {
        try {
            $user = auth()->user();

            if ($user->role != "admin") {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "You are not admin"
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            $users = User::query()->get();

            if($users->isEmpty()){
                return response()->json(
                    [
                        "success" => true,
                        "message" => "There are not any user", 
                    ],
                    Response::HTTP_OK
                ); 
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Users obtained succesfully",
                    "data" => $users
                ],
                Response::HTTP_OK
            );

        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining users",
                    "data" => $users
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function deleteUserById(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "User not found"
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }

            $user->delete();

            return response()->json(
                [
                    "success" => true,
                    "message" => "User deleted"
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error deleting User"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function deleteMessageByAdmin($id)
{
    try {
        $user = auth()->user();

        $sala_user = Mensaje::query()->where('id', $id)->first();
        if (!$sala_user) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "This message does not exist"
                ],
                Response::HTTP_OK
            );
        }

        if ($sala_user->user_id != $user->id && $user->role != 'admin') {
            return response()->json(
                [
                    "success" => false,
                    "message" => "You do not have permission to delete this message"
                ],
                Response::HTTP_FORBIDDEN
            );
        }

        Mensaje::destroy($sala_user->id);

        return response()->json(
            [
                "success" => true,
                "message" => "Message deleted succesfully"
            ],
            Response::HTTP_OK
        );
    } catch (\Throwable $th) {
        Log::error($th->getMessage());

        return response()->json(
            [
                "success" => false,
                "message" => "Error deleting the message"
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
}
