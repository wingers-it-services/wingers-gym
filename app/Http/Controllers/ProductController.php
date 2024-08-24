<?php

namespace App\Http\Controllers;

use App\Enums\ProductCategoryEnum;
use App\Models\Accessory;
use App\Models\Cloth;
use App\Models\Equipment;
use App\Models\Suppliment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    protected $suppliment;
    protected $equipment;
    protected $accessory;
    protected $cloth;

    public function __construct(
        Suppliment $suppliment,
        Equipment $equipment,
        Accessory $accessory,
        Cloth $cloth,
    ) {
        $this->suppliment = $suppliment;
        $this->equipment = $equipment;
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
            return redirect()->back()->with('status', 'error')->with('message', 'Validation Error' . json_encode($e->errors()));
        } catch (\Throwable $e) {
            Log::error('[ProductController][addCloth] Error adding cloth: ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Internal Server Error' . $e->getMessage());
        }
    }

    public function addAccessory(Request $request)
    {
        // dd($request->all());
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

            $cloth = $this->accessory->addAccessoryDetails($accessoryDetails, $images);

            return redirect()->back()->with('status', 'success')->with('message', 'Accessory added successfully');
        } catch (ValidationException $e) {
            Log::error('[ProductController][addAccessory] Error accessory : ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Validation Error' . json_encode($e->errors()));
        } catch (\Throwable $e) {
            Log::error('[ProductController][addAccessory] Error accessory : ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Internal Server Error' . $e->getMessage());
        }
    }

    public function addSuppliment(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'name'             => 'required|string',
                'brand_name'       => 'required|string',
                'price'            => 'required|numeric',
                'comission'        => 'required|numeric',
                'discount'         => 'required|numeric',
                'gst'              => 'required|numeric',
                'company_name'     => 'required|string',
                'company_contact'  => 'required|string',
                'company_address'  => 'required|string',
                'suppliment_company_website'  => 'required',
                'description'      => 'nullable|string',
                'supliment_warrenty'  => 'nullable|string',
                'supliment_warrenty_details' => 'nullable|string',
                'item_form'        => 'nullable|string',
                'manufacturer'     => 'nullable|string',
                'flavour'          => 'nullable|string',
                'age_range'        => 'nullable|string',
                'supliment_size'             => 'nullable|string',
                'quantity'         => 'nullable|numeric',
                'diet_type'        => 'nullable|string',
                'product_benefits' => 'nullable|string',
                'item_dimensions'  => 'nullable|string',
                'special_ingredients' => 'nullable|string',
                'category'         => 'required|string',
                'images'           => 'required|array',
                'images.*'         => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Example for image validation
            ]);

            // Extract the details from the request
            $supplimentDetail = $request->all();   
            $images = $request->file('images');
    
            // Call the model function to add the supplement
            $suppliment = $this->suppliment->addSupplimentDetails($supplimentDetail, $images);

            // Redirect back with success message
            return redirect()->back()->with('status', 'success')->with('message', 'Supplement added successfully');
        } catch (ValidationException $e) {
            Log::error('[ProductController][addSuppliment] Validation error: ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Validation Error: ' . json_encode($e->errors()));
        } catch (\Throwable $e) {
            Log::error('[ProductController][addSuppliment] Error: ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Internal Server Error: ' . $e->getMessage());
        }
    }

    public function addEquipment(Request $request)
    {
        try {
            // Validate the incoming request data
            $request->validate([
                'name'                   => 'required|string|max:255',
                'brand_name'             => 'required|string|max:255',
                'price'                  => 'required|numeric',
                'equipment_comission'    => 'nullable|numeric',
                'equipment_discount'               => 'nullable|numeric',
                'equipment_gst'                    => 'nullable|numeric',
                'amount'                 => 'nullable|numeric',
                'equipment_company_name'           => 'required|string|max:255',
                'equipment_company_contact'        => 'required|string|max:255',
                'equipment_company_address'        => 'required|string|max:255',
                'equipment_company_website' => 'nullable',
                'description'            => 'nullable|string',
                'equipment_warrenty'     => 'nullable|string',
                'equipment_warrenty_details' => 'nullable|string',
                'item_weight'            => 'nullable|string|max:255',
                'colour'                 => 'nullable|string|max:255',
                'tension_level'          => 'nullable|string|max:255',
                'special_feautre'        => 'nullable|string|max:255',
                'supliment_size'         => 'nullable|string|max:255',
                'category'               => 'required|string|max:255',
                'equipment_material'=>'required|string|max:255',
                'images'                 => 'nullable|array',
                'images.*'               => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Get the validated data
            $equipmentDetail = $request->all();

            // Get images from the request if any
            $images = $request->file('images') ?? [];

            // Call the addEquipmentsDetails method
            $equipment = $this->equipment->addEquipmentsDetails($equipmentDetail, $images);

            // Return a successful response
            return redirect()->back()->with('status', 'success')->with('message', 'Equipment added successfully!');
        } catch (\Throwable $e) {
            // Log the error
            Log::error('[EquipmentController][addEquipment] Error adding equipment: ' . $e->getMessage());

            // Return an error response
            return redirect()->back()->with('status', 'error')->with('message', 'Error adding equipment: ' . $e->getMessage());
        }
    }

    public function addProduct(Request $request)
    {
        // dd($request->category);
        try {
            $request->validate([
                'category'      => 'required|string'
            ]);
            $category = $request->input('category');

            if ($category == ProductCategoryEnum::CLOTHS) {
                return $this->addCloth($request);
            } elseif ($category == ProductCategoryEnum::ACCESSORIES) {
                return $this->addAccessory($request);
            }  elseif ($category == ProductCategoryEnum::SUPPLIMENTS) {
                return $this->addSuppliment($request);
            } elseif ($category == ProductCategoryEnum::EQUIPMENTS) {
                return $this->addEquipment($request);
            }  else {
                return redirect()->back()->with('status', 'error')->with('message', 'Invalid category selected');
            }
        } catch (ValidationException $e) {
            Log::error('[ProductController][addProduct] Validation error: ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Validation Error ' .json_encode($e->errors()));
        } catch (\Throwable $e) {
            Log::error('[ProductController][addProduct] Error: ' . $e->getMessage());
            return redirect()->back()->with('status', 'error')->with('message', 'Internal Server Error ' . $e->getMessage());
        }
    }
}
