<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductQuantity;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Department;
use App\Models\ProductType;
use App\Models\ProductTag;
use App\Models\ProductTypeDepartment;
use App\Models\Size;
use App\Models\SizeScale;
use App\Models\Tax;
use App\Models\Tag;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Barryvdh\DomPDF\Facade\Pdf;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('brand','department','productType')->latest()->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $latestProduct = Product::orderBy('article_code', 'desc')->first();

        $latestNewCode = $latestProduct ? (int)$latestProduct->article_code : 300000;
        $brands = Brand::where('status', 'Active')->whereNull('deleted_at')->latest()->get();
        $departments = Department::where('status', 'Active')->whereNull('deleted_at')->latest()->get();
        $taxes = Tax::where('status', 'Active')->latest()->get();
        $tags  = Tag::where('status', 'Active')->latest()->get();
        $sizeScales = SizeScale::select('id', 'size_scale')->where('status', 'Active')->latest()->with('sizes')->get();

        return view('products.create', compact('latestNewCode', 'brands', 'departments', 'taxes', 'tags', 'sizeScales'));
    }

    public function saveStep1(Request $request){
        $request->validate([
            'article_code' => [ 
                'required', 
                Rule::unique('products')->whereNull('deleted_at'), 
            ],
            'manufacture_code' => [
                'required',
                    Rule::unique('products')->whereNull('deleted_at'),
                ],
            'brand_id'          => 'required',
            'department_id'     => 'required',
            'product_type_id'   => 'required',
            'size_scale_id'     => 'required',
            'supplier_price'    => 'required',
            'mrp'               => 'required',
            'short_description' => 'required',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $productData = $request->all();
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $request->article_code . '.' . $image->getClientOriginalExtension();
            $path = 'uploads/products/';
            $image->move(public_path($path), $imageName);
        
            // Store only the file path in the data array
            $productData['image_path'] = $path . $imageName;
            unset($productData['image']);
        }
        
        Session::put('savingProduct', $productData);
        return redirect()->route('products.create.step-2');
    }

    public function updateStep1(Request $request, $productId){
        $request->validate([
            'manufacture_code' => [
                'required',
                Rule::unique('products')->ignore($productId)->whereNull('deleted_at'),
            ],
            'brand_id'          => 'required',
            'department_id'     => 'required',
            'product_type_id'   => 'required',
            'size_scale_id'     => 'required',
            'supplier_price'    => 'required',
            'mrp'               => 'required',
            'short_description' => 'required',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);


        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $request->article_code . '.' . $image->getClientOriginalExtension();
            $path = 'uploads/products/';
            $image->move(public_path($path), $imageName);
        
            // Store only the file path in the data array
            $imagePath = $path . $imageName;
        }

        
        $product = Product::find($productId);

        if(!$imagePath){
            $imagePath = $product->image;
        }

        if ($product) {
            $product->update([
                'manufacture_code' => $request->manufacture_code,
                'department_id' => $request->department_id,
                'brand_id' => $request->brand_id,
                'product_type_id' => $request->product_type_id,
                'short_description' => $request->short_description,
                'mrp' => $request->mrp,
                'supplier_price' => $request->supplier_price,
                'season' => $request->season,
                'supplier_ref' => $request->supplier_ref,
                'tax_id' => $request->tax_id,
                'in_date' => $request->in_date,
                'last_date' => $request->last_date,
                'size_scale_id' => $request->size_scale_id,
                'image' => $imagePath,
                'status' => $request->status,
            ]);
        }
        if(isset($request->tag_id)){
            foreach($request->tag_id as $tags){
                ProductTag::updateOrCreate(
                    [
                        'product_id' => $productId, 
                        'tag_id' => $tags            
                    ],
                    [
                        'product_id' => $productId, 
                        'tag_id' => $tags             
                    ]
                );
            }
        }

        return redirect()->route('products.edit.step-2', $productId);
    }

    public function editStep2(Product $product){
        $sizes = $product->sizes;

        $savedColorIds = $product->colors->pluck('color_id')->toArray();
        $reversedColorIds = array_reverse($savedColorIds);
        $savedColors = Color::whereIn('id', $reversedColorIds)->get();
        $savedColorsMapped = $savedColors->keyBy('id')->toArray();

        $savedColors = array_map(function ($colorId) use ($savedColorsMapped) {
            return $savedColorsMapped[$colorId] ?? null;
        }, $reversedColorIds);

        $colors = Color::where('status','Active')->get();

        return view('products.steps.edit-step-2', compact('product', 'sizes', 'savedColors', 'colors'));
    }

    public function saveStep2(Request $request){
        $product = Session::get('savingProduct');
        $product['size_range_min'] = $request->size_range_min;
        $product['size_range_max'] = $request->size_range_max;

        $product['supplier_color_codes'] = $request->supplier_color_code;
        $product['colors'] = $request->colors;
        Session::put('savingProduct', $product);

        $request->validate([
            'colors' => 'required|array',
            'colors.*' => 'required|distinct|exists:colors,id',
            'supplier_color_code' => 'required|array',
            'supplier_color_code.*' => 'required|distinct|string|min:3|max:10', 
            'size_range_min' => 'required|exists:sizes,id',
            'size_range_max' => 'required|exists:sizes,id|gte:size_range_min',
        ]);
        return redirect()->route('products.create.step-3');
    }

    public function addVariant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_color_code' => 'required|string|max:255',
            'color_select' => 'required|exists:colors,id'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
        } else {
            $errors = new MessageBag(); 
        }

        $savingProduct = Session::get('savingProduct', []);

        if(empty($savingProduct)){
            $savingProduct['supplier_color_codes'] = [];
            $savingProduct['colors'] = [];
        }

        if(isset($request->product_id)){
            $savedProduct = Product::with('colors')->find($request->product_id);
            if($savedProduct){
                $supplierColorCodes = $savedProduct->colors->pluck('supplier_color_code')->toArray();
                $savedColorCodes = $savedProduct->colors->pluck('color_id')->toArray();
                
                $savingProduct['supplier_color_codes'] = $supplierColorCodes;
                $savingProduct['colors'] = $savedColorCodes;
            } 
        }

        if ($savingProduct) {
            if (is_array($savingProduct['supplier_color_codes']) && in_array($request->supplier_color_code, $savingProduct['supplier_color_codes'])) {
                $errors->add('supplier_color_code', 'Supplier Code already exists');
            }
            if (is_array($savingProduct['colors']) && in_array($request->color_select, $savingProduct['colors'])) {
                $errors->add('color_select', 'Color already exists');
            }
        }

        if ($errors->isNotEmpty()) {
            return response()->json([
                'errors' => $errors
            ], 422);
        }

        if($request->product_id){
            ProductColor::updateOrCreate(
                [
                    'product_id' => $request->product_id,
                    'color_id' => $request->color_select,
                ],
                [
                    'supplier_color_code' => $request->supplier_color_code,
                ]
            );            
        }

        $color = Color::where('id',$request->color_select)->first();
        array_push($savingProduct['supplier_color_codes'], $request->supplier_color_code);
        array_push($savingProduct['colors'], $request->color_select);
        $savingProduct = Session::put('savingProduct',$savingProduct);

        return response()->json([
            'success' => true,
            'data' => [
                'supplier_color_code' => $request->supplier_color_code,
                'color_id' => $request->color_select,
                'color_name' => $color->color_name,
                'color_code' => $color->color_code,
                'ui_color_code' => $color->ui_color_code,
            ],
            'message' => 'Variant added successfully!'
        ]);
    }

    public function removeVariant(Request $request, $colorId){
        // Retrieve the product session data
        $savingProduct = Session::get('savingProduct');
        
        if (!$savingProduct && !$request->productId) {
            return response()->json(['error' => 'No product session found.'], 404);
        }

        if($request->productId){
            $product = Product::find($request->productId);
            if($product){
                $product->colors()->where('color_id', $colorId)->delete();
            }
        }

        // Check if colorId exists in the 'colors' array
        $key = array_search($colorId, $savingProduct['colors']);

        if ($key === false) {
            return redirect()->back()->with('error', 'Color doesn\'t exist');
        }

        // Remove the colorId from the 'colors' array
        unset($savingProduct['colors'][$key]);

        // Remove the corresponding supplier color code from the 'supplier_color_codes' array
        unset($savingProduct['supplier_color_codes'][$key]);

        // Reindex the arrays to maintain numeric indexes
        $savingProduct['colors'] = array_values($savingProduct['colors']);
        $savingProduct['supplier_color_codes'] = array_values($savingProduct['supplier_color_codes']);

        // Update the session with the modified product data
        Session::put('savingProduct', $savingProduct);

        return redirect()->back();
    }

    public function store(Request $request)
    {
        $productData = Session::get('savingProduct');
        $productData['variantData'] = $request->all();
        Session::put('savingProduct', $productData);

        $product = Product::create([
            'manufacture_code' => $productData['manufacture_code'] ?? NULL,
            'department_id' => $productData['department_id'] ?? NULL,
            'brand_id' => $productData['brand_id'] ?? NULL,
            'product_type_id' => $productData['product_type_id'] ?? NULL,
            'short_description' => $productData['short_description'] ?? NULL ,
            'mrp' => $productData['mrp'] ?? NULL,
            'supplier_price' => $productData['supplier_price'] ?? NULL,
            'season' => $productData['season'] ?? NULL,
            'supplier_ref' => $productData['supplier_ref'] ?? NULL,
            'tax_id' => $productData['tax_id'] ?? NULL,
            'in_date' => $productData['in_date'] ?? NULL,
            'last_date' => $productData['last_date'] ?? NULL,
            'size_scale_id' => $productData['size_scale_id'] ?? NULL,
            'image' => $productData['image_path'] ?? NULL,
            'min_size_id' => $productData['size_range_min'],
            'max_size_id' => $productData['size_range_max'],
            'status' => $productData['status'],
        ]);

        if(isset($productData['tag_id'])){
            foreach($productData['tag_id'] as $tags){
                ProductTag::create([
                    "product_id" => $product->id,
                    "tag_id" => $tags
                ]);
            }
        }
        foreach ($productData['variantData']['mrp'] as $sizeId => $mrp) {
            ProductSize::create([
                'product_id' => $product->id,
                'size_id' => $sizeId,
                'mrp' => $mrp
            ]);
        }
    
        foreach ($productData['supplier_color_codes'] as $index => $supplierColorCode) {
            $productColor = ProductColor::create([
                'product_id' => $product->id,
                'color_id' => $productData['colors'][$index],
                'supplier_color_code' => $supplierColorCode,
            ]);

            $color_id = $productData['colors'][$index];
            foreach ($productData['variantData']['quantity'][$color_id] as $sizeId => $quantity) {
                $productSize = ProductSize::where('size_id',  $sizeId)->first();

                ProductQuantity::create([
                    'product_id' => $product->id,
                    'product_color_id' => $productColor->id,
                    'product_size_id' => $productSize->id,
                    'quantity' => $quantity,
                    'total_quantity' => $quantity,
                ]);
            }
        }
    
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $brands = Brand::where('status', 'Active')->whereNull('deleted_at')->latest()->get();
        $departments = Department::where('status', 'Active')->whereNull('deleted_at')->latest()->get();
        $productTypes = ProductType::where('status', 'Active')->whereNull('deleted_at')->latest()->get();
        $taxes = Tax::where('status', 'Active')->latest()->get();
        $tags  = Tag::where('status', 'Active')->latest()->get();
        $sizeScales = SizeScale::where('status', 'Active')->latest()->get();
        $sizes = Size::where('status', 'Active')->latest()->get();
        $productTags = ProductTag::where('product_id', $product->id)->pluck('tag_id'); 

        return view('products.edit', compact('brands', 'productTypes', 'departments', 'product', 'taxes', 'tags', 'sizes', 'sizeScales','productTags'));
    }

    public function update(Request $request, Product $product)
    {
        foreach($request->mrp as $product_size_id => $mrp){
            ProductSize::find($product_size_id)->update([
                'mrp' => $mrp
            ]);
        }

        foreach($request->quantity as $colorId => $tempQuantity){
            $productColor = ProductColor::where('product_id', $product->id)->where('color_id', $colorId)->first();
            if($productColor){
                $productColorId = $productColor->id;

                foreach($tempQuantity as $productSizeId => $newQuantity){
                    $quantityRecord = ProductQuantity::firstOrCreate(
                        [
                            'product_id' => $product->id,
                            'product_color_id' => $productColorId,
                            'product_size_id' => $productSizeId,
                        ],
                        [
                            'quantity' => 0,
                            'total_quantity' => 0,
                        ]
                    );

                    if($quantityRecord){
                        $quantityRecord->quantity += $newQuantity;
                        $quantityRecord->total_quantity += $newQuantity;
                        $quantityRecord->save();
                    }
                }
            }
        }
        
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.'
        ]);
    }

    public function getProducts(Request $request)
    {
        $query = Product::with(['brand', 'department', 'quantities', 'productType', 'colors.colorDetail', 'sizes.sizeDetail']);
    
        // Apply search filter if there's any search value
        if ($request->has('search') && !empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function($q) use ($search) {
                $q->where('article_code', 'like', "%{$search}%")
                ->orWhere('manufacture_code', 'like', "%{$search}%")
                ->orWhereHas('brand', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('department', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('productType', function($q) use ($search) {
                    $q->where('product_type_name', 'like', "%{$search}%");
                });
            });
        }
        
        // Order by id in descending order by default
        $products = $query->orderBy('id', 'desc') // Changed to 'desc' for descending order
                        ->paginate($request->input('length', 10));

        $data = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $products->total(),
            'recordsFiltered' => $products->total(),
            'data' => $products->items(),
        ];

        return response()->json($data);
    }
    
    
    public function productStatus(Request $request)
    {
        $product = Product::find($request->id);
        if ($product) {
            $product->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        }

        return response()->json(['error' => 'Product not found.'], 404);
    }

    public function getDepartment($departmentId)
    {
        $productTypes = ProductTypeDepartment::with('productTypes')->where('department_id',$departmentId)->get();

        return response()->json($productTypes);
    }

    public function productStep1()
    {
        $latestProduct = Product::orderBy('article_code', 'desc')->first();

        $latestNewCode = $latestProduct ? (int)$latestProduct->article_code : 300000;
        $brands = Brand::where('status', 'Active')->whereNull('deleted_at')->latest()->get();
        $departments = Department::where('status', 'Active')->whereNull('deleted_at')->latest()->get();
        $taxes = Tax::where('status', 'Active')->latest()->get();
        $tags  = Tag::where('status', 'Active')->latest()->get();
        $sizeScales = SizeScale::select('id', 'size_scale')->where('status', 'Active')->latest()->with('sizes')->get();

        $product = (object)Session::get('savingProduct');

        return view('products.create', compact('latestNewCode', 'product', 'brands', 'departments', 'taxes', 'tags', 'sizeScales'));
    }

    public function productStep2()
    {
        $savingProduct = (object)Session::get('savingProduct');
        if (empty($savingProduct->size_scale_id)) {
            return redirect()->route('products.create.step-1');
        }
        $brand = Brand::where('id',$savingProduct->brand_id)->first();
        $sizeScale = SizeScale::where('id',$savingProduct->size_scale_id)->first();
        $colors = Color::where('status','Active')->get();
        $sizes = Size::where('status', 'Active')
                ->where('size_scale_id', $savingProduct->size_scale_id)
                ->orderBy('id', 'asc')
                ->get();  

        return view('products.steps.step-2', compact('savingProduct','brand','sizeScale','colors','sizes'));
    }

    public function productStep3(Request $request)
    {
        $savingProduct = (object)Session::get('savingProduct');
        if (empty($savingProduct->size_scale_id)) {
            return redirect()->route('products.create.step-1');
        }

        $sizes = Size::whereBetween('id', [$savingProduct->size_range_min, $savingProduct->size_range_max])->get();

        $reversedColors = array_reverse($savingProduct->colors);
        $savedColors = Color::whereIn('id', $reversedColors)->get();
        $savedColorsMapped = $savedColors->keyBy('id')->toArray();

        $savedColors = array_map(function ($colorId) use ($savedColorsMapped) {
            return $savedColorsMapped[$colorId] ?? null;
        }, $reversedColors);

        $colors = Color::where('status','Active')->get();

        return view('products.steps.step-3', compact('savingProduct', 'sizes', 'savedColors', 'colors'));
    }

    public function downloadBarcodes()
    {
        $barcodesQty = (object)Session::get('barcodesToBePrinted');
        $barcodes = [];

        $generator = new BarcodeGeneratorPNG();

        foreach($barcodesQty->barcodesToBePrinted as $data){
            
            foreach($data['product'] as $quantityDetail){
                $products = ProductQuantity::with('product.department', 'product.brand', 'sizes.sizeDetail', 'colors.colorDetail')->where('id',$quantityDetail['id'])->get();

                foreach($products as $productDetail){
                    $article_code = $productDetail->product->article_code;
                    $color_code = $productDetail->colors->colorDetail->color_code;
                    $new_code = $productDetail->sizes->sizeDetail->new_code;
                    $article_code = $article_code.$color_code.$new_code;
                   
                    $checkCode = $this->generateCheckDigit($article_code);
                    for ($i=0; $i < $quantityDetail['printQty']; $i++) { 
                        $barcode = base64_encode($generator->getBarcode($article_code, $generator::TYPE_EAN_13, 1, 20, [0, 0, 0]));
        
                        $barcodes[] = [
                            'barcode' => $barcode,
                            'product_code' => $article_code.$checkCode,
                            'department' => $productDetail->product->department->name,
                            'manufacture_code' => $productDetail->product->manufacture_code,
                            'size' => $productDetail->sizes->sizeDetail->size,
                            'mrp' => $productDetail->sizes->mrp,
                            'article_code' => $productDetail->product->article_code,
                            'short_description' => $productDetail->product->short_description,
                            'color' => $productDetail->colors->colorDetail->color_name,
                            'brand_short_name' => $productDetail->product->brand->short_name ?? $productDetail->product->brand->name,
                        ];
                    }
                }
            }
        }

       $pdf = PDF::loadView('products.pdf.barcodes', ['barcodes' => $barcodes]);

       return view('products.pdf.barcodes', ['barcodes' => $barcodes]);
      // return $pdf->stream('product-barcodes.pdf');
      // return $pdf->download('product_barcodes.pdf');
    }

    public function generateCheckDigit($code) {
        
        if (strlen($code) !== 12) {
            throw new InvalidArgumentException('Code must be 12 digits.');
        }
    
        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $digit = (int) $code[$i];
            $sum += ($i % 2 === 0) ? $digit : $digit * 3;
        }
    
        $remainder = $sum % 10;
        return $remainder === 0 ? 0 : 10 - $remainder;
    }

    public function setBarcodeSession(Request $request){
        Session::put('barcodesToBePrinted', $request->all());
        return response()->json([
            "success" => true,
            "message" => "Session stored successfully"
        ]);

    }
    public function saveBarcodes(){

        $getPrinted = (object)Session::get('barcodesToBePrinted');
        foreach($getPrinted->barcodesToBePrinted as $data){
            foreach($data['product'] as $quantityDetail){
                $products = ProductQuantity::where('id',$quantityDetail['id'])->where('product_id',$data['productId'])->first();
                $products->original_printed_barcodes = $products->original_printed_barcodes + $quantityDetail['orignalQty'];
                $products->total_printed_barcodes = $products->total_printed_barcodes + $quantityDetail['printQty'];
                $products->save();
            }
        } 
        Session::forget('barcodesToBePrinted');
        return redirect()->route('products.index')->with('success','Barcodes Printed Successfully');
    }

    
}
