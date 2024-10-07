<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductIncoming;
use App\Models\ProductOutgoing;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BalanceStockController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('productType')->get();
        $data = [];

        foreach ($products as $product) {
            $productType = $product->productType->name;
            $productName = $product->name;
            // sum stock in
            $productIncoming = ProductIncoming::where('product_id', $product->id)->get();
            $stockIn = $productIncoming->sum('stock_in');
            // sum stock out
            $productOutgoing = ProductOutgoing::where('product_id', $product->id)->get();
            $stockOut = $productOutgoing->sum('stock_out');
            // stock final
            $stockFinal = $product->stock;
            $stock = $stockFinal - $stockIn + $stockOut;
            $data[] = [
                'type' => $productType,
                'name' => $productName,
                'stock' => $stock,
                'stock_in' => $stockIn,
                'stock_out' => $stockOut,
                'stock_final' => $stockFinal,
            ];
        }
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->toJson();
        };
        return view('admin.stock.index', [
            'title' => 'Stock',
            'active' => 'stock',
        ]);
    }
}
