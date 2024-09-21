<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductIncoming;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductIncomingController extends Controller
{
    public function index(Request $request)
    {
        $productIncoming = ProductIncoming::with('product')->latest();

        if ($request->ajax()) {
            return DataTables::of($productIncoming)
                ->addIndexColumn()
                ->editColumn('datetime_incoming', function ($incoming) {
                    return $incoming->datetime_incoming->format('Y-m-d');
                })
                ->editColumn('product_id', function ($incoming) {
                    return $incoming->product->name;
                })
                ->editColumn('price', function ($incoming) {
                    return 'Rp ' . number_format($incoming->price, 0, ',', '.');
                })
                ->editColumn('total_price', function ($incoming) {
                    return 'Rp ' . number_format($incoming->total_price, 0, ',', '.');
                })
                ->editColumn('dp', function ($incoming) {
                    return 'Rp ' . number_format($incoming->dp, 0, ',', '.');
                })
                ->editColumn('paid_off', function ($incoming) {
                    return 'Rp ' . number_format($incoming->paid_off, 0, ',', '.');
                })
                ->editColumn('payment_status', function ($incoming) {
                    return $incoming->payment_status ? 'Lunas' : 'Belum Lunas';
                })
                ->addColumn('action', 'admin.incoming.action')
                ->toJson();
        };

        return view('admin.incoming.index', [
            'title' => 'Incoming',
            'active' => 'incoming',
            'products' => Product::all(),
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'stock_in' => 'required|numeric',
                'price' => 'required|numeric',
                'total_price' => 'required|numeric',
                'dp' => 'required|numeric',
                'paid_off' => 'required|numeric',
                'payment_status' => 'required|boolean',
                'datetime_incoming' => 'required|date',
                'product_id' => 'required|exists:products,id',
            ]);

            $request->merge([
                'datetime_incoming' => $request->datetime_incoming . ' ' . now()->format('H:i:s'),
            ]);

            ProductIncoming::create($request->all());

            $product = Product::find($request->product_id);
            $product->stock += $request->stock_in;
            $product->save();

            return response()->json([
                'title' => 'Success!',
                'message' => 'Data incoming berhasil ditambahkan',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'title' => 'Opss...',
                'message' => 'Data incoming gagal ditambahkan',
            ], 400);
        }
    }

    public function update(Request $request, ProductIncoming $incoming)
    {

        try {
            $request->validate([
                'stock_in' => 'required|numeric',
                'price' => 'required|numeric',
                'total_price' => 'required|numeric',
                'dp' => 'required|numeric',
                'paid_off' => 'required|numeric',
                'payment_status' => 'required|boolean',
                'datetime_incoming' => 'required|date',
                'product_id' => 'required|exists:products,id',
            ]);

            $request->merge([
                'datetime_incoming' => $request->datetime_incoming . ' ' . now()->format('H:i:s'),
            ]);

            $incoming->update($request->all());

            return response()->json([
                'title' => 'Success!',
                'message' => 'Data incoming berhasil diubah',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'title' => 'Opss...',
                'message' => 'Data incoming gagal diubah',
            ], 400);
        }
    }

    public function destroy(ProductIncoming $incoming)
    {
        try {
            $incoming->delete();
            return response()->json([
                'title' => 'Success!',
                'message' => 'Data incoming berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'title' => 'Opss...',
                'message' => 'Data incoming gagal dihapus',
            ], 400);
        }
    }
}
