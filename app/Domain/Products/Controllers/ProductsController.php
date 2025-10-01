<?php

namespace App\Domain\Products\Controllers;

use App\Domain\Api\Model\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductsController extends Controller
{

    /**
     * Check username game.
     */
    public function checkUsername(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|string|max:255',
            'zone_id'   => 'required|string|max:255',

        ]);

        $api = Api::select('apigames_secret', 'apigames_merchant_id')->first();
        if (!$api) return response()->json(['success' => false, 'message' => 'API data tidak ditemukan'], 404);


        $merchant   = $api['apigames_merchant_id'];
        $secret     = $api['apigames_secret'];
        $gameCode   = $request->game_code;
        $sig = md5($merchant . $secret);
        $userIdFormatted = $request->user_id . '(' . $request->zone_id . ')';

        $url = "https://v1.apigames.id/merchant/M250706VICX9741YY/cek-username/mobilelegend?user_id={$userIdFormatted}&signature=69612f60828c50c4e1827d4b8e6fec64";

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                return response()->json([
                    'success'  => true,
                    'message'  => 'Username valid.',
                    'response' => $response->json(),
                    'url'      => $url
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memverifikasi username.',
                    'error'   => $response->json(),
                    'url' => $url
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saat request ke API.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
