<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminShopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminProductController extends Controller
{
    private $product;

    public function __construct(
        AdminShopProduct $product
    ) {
        $this->product = $product;
    }
    public function viewAddProduct()
    {
        return view('admin.admin-add-product');
    }

    public function listProduct()
    {
        $products = $this->product->all();

        return view('admin.admin-product-list', compact('products'));
    }

    public function addProductByAdmin(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'image' => 'required',
                'product_name' => 'required',
                'product_code' => 'required',
                'product_brand' => 'nullable',
                'address' => 'required',
                'availability' => 'nullable',
                'description' => 'required',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $userImage = $request->file('image');
                $filename = time() . '_' . $userImage->getClientOriginalName();
                $imagePath = 'admin_product_images/' . $filename;
                $userImage->move(public_path('admin_product_images/'), $filename);
            }

            // Assuming you have a method addCoupon in your GymCoupon model
            $this->product->addAdminProduct($validatedData, $imagePath);

            return redirect()->route('listProduct')->with('success', 'Product added successfully.');
        } catch (\Throwable $th) {
            Log::error("[AdminProductController][addProductByAdmin] error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

}
