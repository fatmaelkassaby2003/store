<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Http\Requests\StoreProductRequest;

class ProductController extends BaseController
{
    
    public function getproducts()
    {
        $productss = Product::paginate(9);
        return view('dashboard.products', compact('productss'));
    }

    public function productshow($id)
    {
        $product = Product::findOrFail($id);
        $sold = DB::table('order_items')
            ->where('product_id', $id)
            ->sum('quantity');

        return view('dashboard.productshow', compact('product', 'sold'));
    }
    public function product(Request $request)
    {
        $search = $request->input('search');

        $products = Product::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%");
        })->get();

        $productss = Product::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%");
        })->paginate(9);

        return view('dashboard.products', compact('products', 'productss'));
    }
    public function ProductQuantity(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        $product = Product::where('code', $request->product_code)->first();
        $product->quantity += $request->quantity;
        $product->save();

        return redirect()->route('products.view', ['id' => $product->id]);
    }

    public function addproduct(StoreProductRequest $request)
    {
        
        $code = fake()->numerify(str_repeat('#', 13));
        $quantity   = 50;
        $company_id = 1;

        $uploadedFileUrl = Cloudinary::upload(
            $request->file('image')->getRealPath()
        )->getSecurePath();

        Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'image'       => $uploadedFileUrl,
            'category'    => $request->category,
            'code'        => $code,
            'size'        => $request->size . ' جرام',
            'quantity'    => $quantity,
            'company_id'  => $request->company_id ?? null,
        ]);

        return redirect()
            ->route('dashboard.products')
            ->with('success', 'تم اضافة المنتج بنجاح');
    }
    public function deleteproduct($id)
    {
        $product = Product::where('id', $id)->first();
        $product->delete();
        return redirect(route('dashboard.products'))->with('success', 'تم حذف المنتج بنجاح');
    }
    public function adddiscount($id, Request $request)
    {
        $product = Product::where('id', $id)->first();
        $product->old_price = $request->old_price;
        $product->price = $request->new_price;
        $product->save();
        return redirect()->route('products.view', ['id' => $product->id]);
    }
}
