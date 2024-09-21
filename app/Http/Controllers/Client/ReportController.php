<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ProductOutgoing;
use App\Models\ProductSalesReport;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan dan tahun saat ini jika tidak ada input filter
        $currentMonth = $request->month ?? date('m'); // Default bulan saat ini
        $currentYear = $request->year ?? date('Y');   // Default tahun saat ini

        // Query awal
        $query = ProductSalesReport::query();

        // Filter berdasarkan bulan
        if ($currentMonth) {
            $query->whereMonth('datetime_report', $currentMonth);
        }

        // Filter berdasarkan tahun
        if ($currentYear) {
            $query->whereYear('datetime_report', $currentYear);
        }

        // Ambil data setelah filter
        $reports = $query->get();

        // Jika permintaan dari AJAX (DataTables)
        if ($request->ajax()) {
            return DataTables::of($reports)
                ->addIndexColumn()
                ->editColumn('datetime_report', function ($reports) {
                    return $reports->datetime_report->format('Y-m-d');
                })
                ->editColumn('profit', function ($reports) {
                    return 'Rp ' . number_format($reports->profit, 0, ',', '.');
                })
                ->editColumn('ads', function ($reports) {
                    return 'Rp ' . number_format($reports->ads, 0, ',', '.');
                })
                ->editColumn('total_profit', function ($reports) {
                    return 'Rp ' . number_format($reports->total_profit, 0, ',', '.');
                })
                ->toJson();
        }

        return view('admin.report.index', [
            'title' => 'Report',
            'active' => 'report',
        ]);
    }

    public function getStockOut(Request $request)
    {
        // Ambil tanggal dari request
        $date = $request->get('date');

        // Query untuk menghitung total barang keluar (stock_out) berdasarkan tanggal
        $totalStockOut = ProductOutgoing::whereDate('datetime_transaction', $date)->sum('stock_out'); // Sesuaikan field yang digunakan
        $profit = ProductOutgoing::whereDate('datetime_transaction', $date)->sum('profit'); // Sesuaikan field yang digunakan

        // Return data ke client dalam bentuk JSON
        return response()->json([
            'total_stock_out' => $totalStockOut,
            'profit' => $profit,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'datetime_report' => 'required',
                'total_stock_out' => 'required',
                'profit' => 'required',
                'ads' => 'required',
                'total_profit' => 'required',
            ]);

            $request->merge([
                'datetime_report' => $request->datetime_report . ' ' . now()->format('H:i:s'),
            ]);

            // Mencari apakah data dengan datetime_report yang sama sudah ada
            $existingReport = ProductSalesReport::whereDate('datetime_report', date('Y-m-d', strtotime($request->datetime_report)))->first();

            if ($existingReport) {
                // Jika sudah ada, update data
                $existingReport->update($request->all());
                // return response()->json([
                //     'title' => 'Success!',
                //     'message' => 'Data berhasil diperbarui',
                // ], 200);
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'Data berhasil diperbarui',
                ], 200);
            } else {
                // Jika tidak ada, buat data baru
                ProductSalesReport::create($request->all());
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'Data berhasil disimpan',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'title' => 'Opss...',
                'message' => 'Data report gagal disimpan',
            ], 400);
        }
    }
}
