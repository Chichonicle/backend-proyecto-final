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
public function getSalaById(Request $request, $id)
    {
        try {
            $sala = Sala::query()->find($id);

            if (!$sala) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Sala doesn't exist",
                    ],
                    Response::HTTP_OK
                );
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Sala obtained succesfully",
                    "data" => $sala
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining sala"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

        


  
