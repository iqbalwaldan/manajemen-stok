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
                ->editColumn('product_type_name', function ($product) {
                    return $product->productType->name;
                })
                ->editColumn('price', function ($product) {
                    return 'Rp ' . number_format($product->price, 0, ',', '.');
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
