<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SeriesController extends Controller
{
    public function getAllSeries(Request $request)
    {
        try { 
            $series = Series::query()->where('is_active', true)->get();
            if ($series->isEmpty()) { 
            return response()->json( 
                [
                        'success' => false,
                        'message' => 'No series found'
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Series found',
                    'data' => $series
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error founding series'
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
