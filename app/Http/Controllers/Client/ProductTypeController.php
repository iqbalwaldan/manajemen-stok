<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use function PHPSTORM_META\type;

class ProductTypeController extends Controller
{
    public function index(Request $request)
    {
        $type = ProductType::latest();
        if ($request->ajax()) {
            return DataTables::of($type)
                ->addIndexColumn()
                ->addColumn('action', 'admin.type.action')
                ->toJson();
        };
        return view('admin.type.index', [
            'title' => 'Produk Tipe',
            'active' => 'type',
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $add = ProductType::create($request->all());
            if ($add) {
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'Data tipe produk berhasil ditambahkan',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'title' => 'Opss...',
                'message' => 'Data tipe produk gagal ditambahkan',
            ], 400);
        }
    }

    public function update(Request $request, ProductType $productType)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $productType->update($request->all());
            if ($productType) {
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'Data tipe produk berhasil diubah',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'title' => 'Opss...',
                'message' => 'Data tipe produk gagal diubah',
            ], 400);
        }
    }

    public function destroy(ProductType $productType)
    {
        try {
            if (Product::where('product_type_id', $productType->id)->exists()) {
                return response()->json([
                    'title' => 'Opss...',
                    'message' => 'Tidak bisa menghapus tipe produk yang memiliki data produk',
                ], 400);
            } else {
                $productType->delete();
                return response()->json([
                    'title' => 'Success!',
                    'message' => 'Data tipe produk berhasil dihapus',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'title' => 'Opss...',
                'message' => 'Data tipe produk gagal dihapus',
            ], 400);
        }
    }
}
