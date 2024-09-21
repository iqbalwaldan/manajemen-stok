<?php

namespace App\Exports;

use App\Models\ProductSalesReport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductSalesReportExport implements FromView, WithStyles
{
    public function view(): View
    {
        $report = ProductSalesReport::selectRaw('DATE_FORMAT(datetime_report, "%Y-%m") as month, DATE_FORMAT(datetime_report, "%Y-%m-%d") as date, total_stock_out, profit, ads, total_profit')
            ->groupBy('month', 'date', 'total_stock_out', 'profit', 'ads', 'total_profit')
            ->orderByDesc('month')
            ->orderBy('date', 'asc')
            ->get();

        $stock_out = $report->sum('total_stock_out');
        $total_profit = $report->sum('total_profit');

        return view('admin.dashboard.export-exel', [
            'stock_out' => $stock_out,
            'total_profit' => $total_profit,
            'report' => $report,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Set style for headers
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal('center');

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);

        // Set borders all
        $sheet->getStyle('A1:E' . $sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle('thin');

        // Set currency format
        $sheet->getStyle('B2:C' . $sheet->getHighestRow())->getNumberFormat()->setFormatCode('"Rp"#,##0,00');
        $sheet->getStyle('E2:E' . $sheet->getHighestRow())->getNumberFormat()->setFormatCode('"Rp"#,##0,00');
    }
}
