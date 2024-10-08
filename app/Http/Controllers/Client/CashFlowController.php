<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ProductIncoming;
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
}
