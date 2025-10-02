<?php

namespace App\Http\Controllers\E_commerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\User;
use App\Models\OrderItem;

class ProfileController extends Controller
{

    public function show()
{
    $user = auth()->user();
    
    $groupedItems = $user=User::with('orders')->where('id', auth()->user()->id)->firstOrFail()->orders()
        ->with('items')
        ->get()
        ->flatMap->items
        ->groupBy('product_name')
        ->map(function ($items) {
            return [
                'total_quantity' => $items->sum('quantity'),
                'product_name' => $items->first()->product_name
            ];
        });

    return view('profile', compact('groupedItems'));
}

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.auth()->id(),
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $user = User::find(auth()->id());
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->hasFile('profile_photo')) {
                // حذف الصورة القديمة من Cloudinary إذا كانت موجودة
                if ($user->profile_photo) {
                    $publicId = pathinfo($user->profile_photo, PATHINFO_FILENAME);
                    Cloudinary::destroy($publicId);
                }
                
                // رفع الصورة الجديدة إلى Cloudinary
                $uploadedFileUrl = Cloudinary::upload($request->file('profile_photo')->getRealPath(), [
                    'folder' => 'profile_photos',
                    'transformation' => [
                        'width' => 200,
                        'height' => 200,
                        'crop' => 'fill',
                        'gravity' => 'face'
                    ]
                ])->getSecurePath();
                
                $user->profile_photo = $uploadedFileUrl;
            }

            $user->save();

            return redirect()->route('profile')
                ->with('success', 'تم تحديث البروفايل بنجاح');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء تحديث البروفايل: '.$e->getMessage());
        }
    }
}