<?php

namespace App\Http\Controllers;

use App\Models\Series;
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
}
