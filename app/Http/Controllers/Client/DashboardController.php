<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ProductOutgoing;
use App\Models\ProductSalesReport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $report = ProductSalesReport::selectRaw('DATE_FORMAT(datetime_report, "%Y-%m") as month, DATE_FORMAT(datetime_report, "%Y-%m-%d") as date, total_stock_out, profit, ads, total_profit')
            ->groupBy('month', 'date', 'total_stock_out', 'profit', 'ads', 'total_profit')
            ->orderByDesc('month')
            ->orderBy('date', 'asc')
            ->get();

        $stock_out = $report->sum('total_stock_out');
        $total_profit = $report->sum('total_profit');

        return view('admin.dashboard.index', [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'stock_out' => $stock_out,
            'total_profit' => $total_profit,
            'report' => $report,
        ]);
    }

    public function exportPDF()
    {
        $report = ProductSalesReport::selectRaw('DATE_FORMAT(datetime_report, "%Y-%m") as month, DATE_FORMAT(datetime_report, "%Y-%m-%d") as date, total_stock_out, profit, ads, total_profit')
            ->groupBy('month', 'date', 'total_stock_out', 'profit', 'ads', 'total_profit')
            ->orderByDesc('month')
            ->orderBy('date', 'asc')
            ->get();

        $stock_out = $report->sum('total_stock_out');
        $total_profit = $report->sum('total_profit');

        $pdf = Pdf::loadView('admin.dashboard.export-pdf',[
            'stock_out' => $stock_out,
            'total_profit' => $total_profit,
            'report' => $report,
        ]);
        return $pdf->download('invoice.pdf');
    }
}
