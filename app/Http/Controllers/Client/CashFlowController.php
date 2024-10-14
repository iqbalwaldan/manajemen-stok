<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ProductIncoming;
use App\Models\ProductInstallment;
use App\Models\ProductSalesReport;
use Illuminate\Http\Request;

class CashFlowController extends Controller
{
    public function index()
    {
        $income = ProductSalesReport::sum('total_profit');
        $outcome = ProductIncoming::sum('total_price');

        return view('admin.cash-flow.index', [
            'title' => 'Keuangan',
            'active' => 'cash-flow',
            'income' => $income,
            'outcome' => $outcome,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'datetime_payment' => 'required',
            'installment' => 'required',
            'product_incoming_id' => 'required',
        ]);

        $request->merge([
            'datetime_payment' => $request->datetime_payment . ' ' . now()->format('H:i:s'),
        ]);

        $income = ProductIncoming::find($request->product_incoming_id);
        $income->paid_off -= $request->installment;
        $income->total_installment -= 1;
        if ($income->total_installment == 0) {
            $income->payment_status = 'lunas';
        }
        ProductInstallment::create($request->all());
        $income->save();

        return response()->json([
            'title' => 'Success!',
            'message' => 'Data cicilan berhasil ditambahkan',
        ], 200);
    }
}
