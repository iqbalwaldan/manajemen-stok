<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductIncoming;
use App\Models\ProductInstallment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductIncomingController extends Controller
{
    public function index(Request $request)
    {
        $productIncoming = ProductIncoming::with(['product', 'productInstallments'])
        ->orderByRaw('DATE(datetime_incoming) DESC')
        ->orderBy('product_id', 'DESC')
        ->get();

        if ($request->ajax()) {
            return DataTables::of($productIncoming)
                ->addIndexColumn()
                ->editColumn('datetime_incoming', function ($incoming) {
                    return Carbon::parse($incoming->datetime_incoming)->format('d-m-Y');
                })
                ->editColumn('product_id', function ($incoming) {
                    return $incoming->product->name . $incoming->product->id;
                })
                ->editColumn('stock_in', function ($incoming) {
                    return (string)$incoming->stock_in;
                })
                ->editColumn('price', function ($incoming) {
                    return (string)$incoming->price;
                })
                ->editColumn('total_price', function ($incoming) {
                    return (string)$incoming->total_price;
                })
                ->editColumn('dp', function ($incoming) {
                    return (string)$incoming->dp;
                })
                ->editcolumn('payment_status', function ($incoming) {
                    return $incoming->payment_status == 'lunas' ? 'Lunas' : 'Belum Lunas';
                })
                ->editColumn('payment_type', function ($incoming) {
                    return $incoming->payment_type == 'cash' ? 'Tunai' : 'Cicil';
                })
                ->editColumn('total_installment', function ($incoming) {
                    return (string)$incoming->total_installment;
                })
                ->editColumn('paid_off', function ($incoming) {
                    return (string)$incoming->paid_off;
                })
                ->editColumn('installments', function ($incoming) {
                    return $incoming->productInstallments;
                })
                ->editColumn('total_detail_installments', function ($incoming) {
                    return $incoming->productInstallments->count();
                })
                ->addColumn('action', 'admin.incoming.action')
                ->toJson();
        };

        return view('admin.incoming.index', [
            'title' => 'Produk Masuk',
            'active' => 'incoming',
            'products' => Product::all(),
            'productInstallments' => ProductInstallment::all(),
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'stock_in' => 'required|numeric',
                'price' => 'required|numeric',
                'total_price' => 'required|numeric',
                'payment_type' => 'required',
                'total_installment' => 'required|numeric|min:0',
                'dp' => 'required|numeric',
                'paid_off' => 'required|numeric',
                'payment_status' => 'required',
                'datetime_incoming' => 'required|date',
                'product_id' => 'required|exists:products,id',
            ]);

            $request->merge([
                'datetime_incoming' => $request->datetime_incoming . ' ' . now()->format('H:i:s'),
            ]);

            if ($request->stock_in < 0) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Stock in tidak boleh kurang dari 0',
                ], 400);
            }
            if ($request->price < 0) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Harga in tidak boleh kurang dari 0',
                ], 400);
            }
            if ($request->dp < 0) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'DP in tidak boleh kurang dari 0',
                ], 400);
            }
            if ($request->paid_off < 0) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'DP melebihi total harus dibayar',
                ], 400);
            }
            if ($request->payment_type == 2 && $request->total_installment < 2) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Total cicilan tidak boleh kurang dari 2',
                ], 400);
            }

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
                'payment_type' => 'required',
                'total_installment' => 'required|numeric|min:0',
                'dp' => 'required|numeric',
                'paid_off' => 'required|numeric',
                'payment_status' => 'required',
                'datetime_incoming' => 'required|date',
                'product_id' => 'required|exists:products,id',
            ]);

            $request->merge([
                'datetime_incoming' => $request->datetime_incoming . ' ' . now()->format('H:i:s'),
            ]);

            if ($request->stock_in < 0) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Stock in tidak boleh kurang dari 0',
                ], 400);
            }
            if ($request->price < 0) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Harga in tidak boleh kurang dari 0',
                ], 400);
            }
            if ($request->dp < 0) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'DP in tidak boleh kurang dari 0',
                ], 400);
            }
            if ($request->paid_off < 0) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'DP melebihi total harus dibayar',
                ], 400);
            }

            if ($request->payment_type == 2 && $request->total_installment < 2 && $incoming->payment_type == 2) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Total cicilan tidak boleh kurang dari 2',
                ], 400);
            }

            $preProduct = Product::find($incoming->product_id);
            $preProduct->stock -= $incoming->stock_in;


            if ($preProduct->id != $request->product_id) {
                $product = Product::find($request->product_id);
            } else {
                $product = $preProduct;
            }
            $product->stock += $request->stock_in;

            if ($preProduct->stock < 0) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Stok barang tidak mencukupi',
                ], 400);
            } else {
                $preProduct->save();
                $product->save();
                $incoming->update($request->all());
            }

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
            $product = Product::find($incoming->product_id);
            $product->stock -= $incoming->stock_in;
            $product->save();
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
