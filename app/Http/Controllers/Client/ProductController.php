<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductIncoming;
use App\Models\ProductOutgoing;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $productTypes = ProductType::all();

        $product = Product::with('productType')->get();

        if ($request->ajax()) {
            return DataTables::of($product)
                ->addIndexColumn()
                ->editColumn('id', function ($product) {
                    return (string)$product->id;
                })
                ->editColumn('product_type_name', function ($product) {
                    return $product->productType->name;
                })
                ->editColumn('price', function ($product) {
                    return (string)$product->price;
                })
                ->editColumn('stock', function ($product) {
                    return (string)$product->stock;
                })
                ->addColumn('productOutgoing', function ($product) {
                    return $product->productOutgoing()->exists(); // Misalkan Anda memiliki relasi ini
                })
                ->addColumn('productIncoming', function ($product) {
                    return $product->productIncoming()->exists(); // Misalkan Anda memiliki relasi ini
                })
                ->addColumn('action', 'admin.product.action')
                ->toJson();
        };

        return view('admin.product.index', [
            'title' => 'Facebook Account',
            'active' => 'facebook-account',
            'productTypes' => $productTypes,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'product_type_id' => 'required',
                'price' => 'required',
                'stock' => 'required',
            ]);

            if (Product::where('name', $request->name)->where('product_type_id', $request->product_type_id)->exists()) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Data produk sudah ada',
                ], 400);
            }

            if ($request->stock < 0) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Stok tidak boleh kurang dari 0',
                ], 400);
            }

            if ($request->price < 0) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Harga tidak boleh kurang dari 0',
                ], 400);
            }

            Product::create($request->all());

            return response()->json([
                'title' => 'Success!',
                'message' => 'Data produk berhasil ditambahkan',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'title' => 'Opss...',
                'message' => 'Data produk gagal ditambahkan',
            ], 400);
        }
    }

    public function update(Request $request, Product $product)
    {
        try {
            $request->validate([
                'name' => 'required',
                'product_type_id' => 'required',
                'price' => 'required',
                'stock' => 'required',
            ]);

            if (Product::where('name', $request->name)
                ->where('product_type_id', $request->product_type_id)
                ->where('id', '!=', $product->id) // Mengecualikan produk yang sedang di-update
                ->exists()
            ) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Data produk sudah ada',
                ], 400);
            }

            if ($request->stock < 0) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Stok tidak boleh kurang dari 0',
                ], 400);
            }

            if ($request->price < 0) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Harga tidak boleh kurang dari 0',
                ], 400);
            }

            $product->update($request->all());

            return response()->json([
                'title' => 'Success!',
                'message' => 'Data produk berhasil diubah',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'title' => 'Opss...',
                'message' => 'Data produk gagal diubah',
            ], 400);
        }
    }

    public function destroy(Product $product)
    {
        try {
            if (ProductIncoming::where('product_id', $product->id)->exists() || ProductOutgoing::where('product_id', $product->id)->exists()) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Produk tidak bisa dihapus karena sudah ada transaksi',
                ], 400);
            } else {
                $product->delete();
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'Data produk berhasil dihapus',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'title' => 'Opss...',
                'message' => 'Data produk gagal dihapus',
            ], 400);
        }
    }

    public function data(Request $request)
    {
        $product = Product::where('id', $request->get('id'))->first();
        $price = $product->price;

        return response()->json([
            'price' => $price,
        ]);
    }
}
