<?php

namespace App\Http\Controllers\E_commerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProductController extends Controller
{
    //
    public function show($id)
{
    $product =Product::findOrFail($id);
    return view('shop-single', compact('product'));
}


public function index()
{
    $products = Product::all(); 
    $users = User::orderBy('bill_count', 'DESC')
    ->take(6)
    ->get();
    $lastProducts = Product::latest()->take(6)->get()->reverse();
    return view('index', compact('products', 'lastProducts', 'users')); 
}

public function shop()
{
    $products = Product::paginate(9); 
    return view('shop', compact('products'));
}

public function shopsingle($id)
{
    $product = Product::with('company')->findOrFail($id);
    return view('shop-single', compact('product'));
}

public function getProductsByCategory($category)
{
    $products = Product::where('category', $category)
        ->take(6)
        ->get();

    return response()->json($products);
}


public function search(Request $request)
{
    $query = $request->input('query');
    $products = Product::where('name', 'LIKE', '%' . $query . '%')->limit(10)->get();

    $results = [];
    foreach ($products as $product) {
        $results[] = [
            'id'   => $product->id,
            'name' => $product->name,
        ];
    }
    return response()->json($results);
}



// 2) إرجاع تفاصيل منتج محدد في Blade جزئي (Partial)
public function getProductDetails($id)
{
    $product = Product::findOrFail($id);
    return view('partials.product', compact('product'));
}

    public function upload(Request $request, $productId)
    {
        if (!$request->hasFile('image')) {
            return back()->withErrors(['image' => 'لم يتم رفع أي صورة']);
        }

        $uploadedFile = $request->file('image');
        if (!$uploadedFile->isValid()) {
            return back()->withErrors(['image' => 'الصورة غير صالحة']);
        }

        $uploadedFileUrl = Cloudinary::upload($uploadedFile->getRealPath())->getSecurePath();
        if (!$uploadedFileUrl) {
            return back()->withErrors(['image' => 'حدث خطأ أثناء رفع الصورة إلى Cloudinary']);
        }

        $product = Product::findOrFail($productId);
        $product->image = $uploadedFileUrl;
        $product->save();

        return back()->with('success', 'تم رفع الصورة بنجاح!')->with('image_url', $uploadedFileUrl);
    }


}