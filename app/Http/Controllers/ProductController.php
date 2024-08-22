<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Cloth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    protected $accessory;
    protected $cloth;

    public function __construct(
        Accessory $accessory,
        Cloth $cloth
    ) {
        $this->accessory = $accessory;
        $this->cloth = $cloth;
    }

    public function addCloth(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'name'        => 'required|string',
                'category'    => 'required|string',
                'size'        => 'required|string',
                'brand_name'  => 'required|string',
                'quantity'    => 'required|integer',
                'price'       => 'required|numeric',
                'material'    => 'required|string',
                'description' => 'nullable|string',
                'images'      => 'required|array',
                'images.*'    => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Example for image validation
            ]);

            // $clothDetail = $request->only(['name', 'category', 'size', 'brand_name', 'quantity', 'price', 'material', 'description']);
            $clothDetail = $request->all();
            $images = $request->file('images');

            $cloth = $this->cloth->addClothsDetails($clothDetail, $images);

            return redirect()->back()->with('status', 'success')->with('message', 'Cloth added successfully');
        } catch (ValidationException $e) {
            Log::error('[ProductController][addCloth] Error adding cloth: ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Validation Error' . $e->errors());
        } catch (\Throwable $e) {
            Log::error('[ProductController][addCloth] Error adding cloth: ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Internal Server Error' . $e->getMessage());
        }
    }

    public function addAccessory(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'name'          => 'required|string',
                'category'      => 'required|string',
                'brand_name'    => 'required|string',
                'model_number'  => 'required|string',
                'quantity'      => 'required|integer',
                'price'         => 'required|numeric',
                'description'   => 'nullable|string',
                'condition'     => 'nullable|string',
                'images'        => 'required|array',
                'images.*'      => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Example for image validation
            ]);

            // $clothDetail = $request->only(['name', 'category', 'size', 'brand_name', 'quantity', 'price', 'material', 'description']);
            $accessoryDetails = $request->all();
            $images = $request->file('images');

            $cloth = $this->cloth->addClothsDetails($accessoryDetails, $images);

            return redirect()->back()->with('status', 'success')->with('message', 'Accessory added successfully');
        } catch (ValidationException $e) {
            Log::error('[ProductController][addAccessory] Error accessory cloth: ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Validation Error' . $e->errors());
        } catch (\Throwable $e) {
            Log::error('[ProductController][addAccessory] Error accessory cloth: ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Internal Server Error' . $e->getMessage());
        }
    }

    public function addProduct(Request $request)
    {
        try {
            $category = $request->input('category');

            if ($category === 'cloth') {
                return $this->addCloth($request);
            } elseif ($category === 'accessory') {
                return $this->addAccessory($request);
            } else {
                return redirect()->back()->with('status', 'error')->with('message', 'Invalid category selected');
            }
        } catch (ValidationException $e) {
            Log::error('[ProductController][addProduct] Validation error: ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Validation Error ' . $e->errors());
        } catch (\Throwable $e) {
            Log::error('[ProductController][addProduct] Error: ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Internal Server Error ' . $e->getMessage());
        }
    }
}
