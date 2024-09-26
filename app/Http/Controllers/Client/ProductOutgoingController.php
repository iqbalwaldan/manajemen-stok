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
        $productOutgoing = ProductOutgoing::with('product')
            ->orderByRaw('DATE(datetime_transaction) DESC')
            ->orderBy('product_id', 'DESC')
            ->get();

        if ($request->ajax()) {
            return DataTables::of($productOutgoing)
                ->addIndexColumn()
                ->editColumn('datetime_transaction', function ($outgoing) {
                    return $outgoing->datetime_transaction->format('d-m-Y');
                })
                ->editColumn('product_id', function ($outgoing) {
                    return $outgoing->product->name . $outgoing->product->id;
                })
                ->editColumn('stock_out', function ($outgoing) {
                    return (string)$outgoing->stock_out;
                })
                ->editColumn('purchase_price', function ($outgoing) {
                    return (string)$outgoing->purchase_price;
                })
                ->editColumn('selling_price', function ($outgoing) {
                    return (string)$outgoing->selling_price;
                })
                ->editColumn('total_price', function ($outgoing) {
                    return (string)$outgoing->total_price;
                })
                ->editColumn('profit', function ($outgoing) {
                    return (string)$outgoing->profit;
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

            if ($request->stock_out < 1) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Stock tidak boleh kurang dari 1',
                ], 400);
            }
            if ($request->purchase_price < 0) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Harga beli tidak boleh kurang dari 1',
                ], 400);
            }
            if ($request->selling_price < 0) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Harga jual tidak boleh kurang dari 1',
                ], 400);
            }

            $product = Product::find($request->product_id);
            if ($product->stock < $request->stock_out) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Stok barang tidak mencukupi',
                ], 400);
            } else {
                $product->stock -= $request->stock_out;
            }

            $product->save();
            ProductOutgoing::create($request->all());

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

            if ($request->stock_out < 1) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Stock tidak boleh kurang dari 1',
                ], 400);
            }
            if ($request->purchase_price < 0) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Harga beli tidak boleh kurang dari 1',
                ], 400);
            }
            if ($request->selling_price < 0) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Harga jual tidak boleh kurang dari 1',
                ], 400);
            }

            $preProduct = Product::find($outgoing->product_id);
            $preProduct->stock += $outgoing->stock_out;

            if ($preProduct->id != $request->product_id) {
                $product = Product::find($request->product_id);
            } else {
                $product = $preProduct;
            }

            if ($product->stock < $request->stock_out) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Stok barang tidak mencukupi',
                ], 400);
            } else {
                $product->stock -= $request->stock_out;
            }

            $preProduct->save();
            $product->save();
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
