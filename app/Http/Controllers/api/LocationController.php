<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function country()
    {
        $country = DB::table('countries')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data Country',
            'data' => $country
        ], Response::HTTP_OK)->header('Accept', 'application/json');
    }

    public function states($country_id)
    {
        $states = DB::table('states')->where('country_id', $country_id)->get();
        return response()->json([
            'status' => true,
            'message' => 'Data States',
            'data' => $states
        ], Response::HTTP_OK)->header('Accept', 'application/json');
    }

    public function cities($state_id)
    {
        $cities = DB::table('cities')->where('state_id', $state_id)->get();
        return response()->json([
            'status' => true,
            'message' => 'Data Cities',
            'data' => $cities
        ], Response::HTTP_OK)->header('Accept', 'application/json');
    }
}
