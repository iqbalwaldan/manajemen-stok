<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductOutgoing;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductOutgoingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $productOutgoing = ProductOutgoing::with('product')->latest();
            return DataTables::of($productOutgoing)
                ->addIndexColumn()
                ->editColumn('datetime_transaction', function ($outgoing) {
                    return $outgoing->datetime_transaction->format('Y-m-d');
                })
                ->editColumn('product_id', function ($outgoing) {
                    return $outgoing->product->name;
                })
                ->editColumn('purchase_price', function ($outgoing) {
                    return 'Rp ' . number_format($outgoing->purchase_price, 0, ',', '.');
                })
                ->editColumn('selling_price', function ($outgoing) {
                    return 'Rp ' . number_format($outgoing->selling_price, 0, ',', '.');
                })
                ->editColumn('total_price', function ($outgoing) {
                    return 'Rp ' . number_format($outgoing->total_price, 0, ',', '.');
                })
                ->editColumn('profit', function ($outgoing) {
                    return 'Rp ' . number_format($outgoing->profit, 0, ',', '.');
                })
                ->addColumn('action', 'admin.outgoing.action')
                ->toJson();
        };

        return view('admin.outgoing.index', [
            'products' => Product::all(),
            'title' => 'Outgoing',
            'active' => 'outgoing',
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'datetime_transaction' => 'required',
                'buyer_name' => 'required',
                'product_id' => 'required',
                'stock_out' => 'required',
                'purchase_price' => 'required',
                'selling_price' => 'required',
                'total_price' => 'required',
                'profit' => 'required',
            ]);

            $request->merge([
                'datetime_transaction' => $request->datetime_transaction . ' ' . now()->format('H:i:s'),
            ]);

            $product = Product::find($request->product_id);
            $product->stock -= $request->stock_out;
            if ($product->stock < 0) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Stock tidak boleh kurang dari 0',
                ], 400);
            } else {
                ProductOutgoing::create($request->all());
                $product->save();
            }

            return response()->json([
                'title' => 'Success!',
                'message' => 'Data outgoing berhasil ditambahkan',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'title' => 'Opss...',
                'message' => 'Data outgoing gagal ditambahkan',
            ], 400);
        }
    }

    public function update(Request $request, ProductOutgoing $outgoing)
    {
        try {
            $request->validate([
                'datetime_transaction' => 'required',
                'buyer_name' => 'required',
                'product_id' => 'required',
                'stock_out' => 'required',
                'purchase_price' => 'required',
                'selling_price' => 'required',
                'total_price' => 'required',
                'profit' => 'required',
            ]);

            $outgoing->update($request->all());
            if ($outgoing) {
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'Data outgoing berhasil diubah',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'title' => 'Opss...',
                'message' => 'Data outgoing gagal diubah',
            ], 400);
        }
    }

    public function destroy(ProductOutgoing $outgoing)
    {
        try {
            $outgoing->delete();
            return response()->json([
                'title' => 'Success!',
                'message' => 'Data outgoing berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'title' => 'Opss...',
                'message' => 'Data outgoing gagal dihapus',
            ], 400);
        }
    }
}
