<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payslip;

class PayslipController extends Controller
{
    public function confirmPayslip(Request $request)
    {
        $request->validate([
            'payslip_id' => 'required|exists:payslips,id',
        ]);

        $payslip = Payslip::find($request->payslip_id);
        $payslip->status = 'confirmed'; // Assuming you have a 'status' column
        $payslip->save();

        return response()->json([
            'success' => true,
            'message' => 'Payslip confirmed successfully.'
        ]);
    }

    public function appealPayslip(Request $request)
    {
        $request->validate([
            'payslip_id' => 'required|exists:payslips,id',
        ]);

        $payslip = Payslip::find($request->payslip_id);
        $payslip->status = 'under_review'; // Assuming you have a 'status' column
        $payslip->save();

        return response()->json([
            'success' => true,
            'message' => 'Payslip appeal submitted successfully.'
        ]);
    }
}
