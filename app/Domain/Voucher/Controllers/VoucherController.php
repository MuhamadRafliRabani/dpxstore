<?php

namespace App\Domain\Voucher\Controllers;

use App\Domain\Voucher\Models\Voucher;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VoucherController extends Controller
{

    public function check(Request $request)
    {
        // Logic to check the voucher
        $request->validate([
            'voucher_code' => 'required|string|max:255',
        ]);

        // check vocher on database
        $voucherCode = Voucher::where('voucher', $request->input('voucher_code'))->first();

        if (!$voucherCode) {
            return response()->json(['error' => 'Voucher not found'], 404);
        }

        // This is a placeholder for the actual implementation
        return response()->json(['message' => 'Voucher checked successfully', 'voucher' => $voucherCode], 200);
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
