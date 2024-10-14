<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductIncoming;
use App\Models\ProductInstallment;
use App\Models\ProductSalesReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CashFlowController extends Controller
{
    public function index(Request $request)
    {
        $totalDp = ProductIncoming::where('payment_type', 'installment')->sum('dp');
        $totalPaidOff = ProductIncoming::where('payment_type', 'installment')->sum('paid_off');
        $totalOutcomeInstallments = ProductIncoming::where('payment_type', 'installment')->sum('total_price');
        $totalOutcome = ProductIncoming::sum('total_price');

        $installments = ProductInstallment::with('productIncoming.product')
            ->select('product_installments.datetime_payment', 'product_installments.product_incoming_id', 'product_installments.installment', 'products.name as product_name')
            ->join('product_incomings', 'product_incomings.id', '=', 'product_installments.product_incoming_id')
            ->join('products', 'products.id', '=', 'product_incomings.product_id')
            ->orderBy('datetime_payment', 'DESC')
            ->get();

        if ($request->ajax()) {
            return DataTables::of($installments)
                ->addIndexColumn()
                ->editColumn('datetime_payment', function ($installments) {
                    return Carbon::parse($installments->datetime_payment)->format('d-m-Y');
                })
                ->editColumn('product_incoming_id', function ($installments) {
                    return (string)$installments->product_incoming_id;
                })
                ->editColumn('product_name', function ($installments) {
                    return (string)$installments->product_name;
                })
                ->editColumn('installment', function ($installments) {
                    return (string)$installments->installment;
                })
                ->toJson();
        };

        return view('admin.cash-flow.index', [
            'title' => 'Keuangan',
            'active' => 'cash-flow',
            'totalDp' => $totalDp,
            'totalPaidOff' => $totalPaidOff,
            'totalOutcomeInstallments' => $totalOutcomeInstallments,
            'totalOutcome' => $totalOutcome,
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
