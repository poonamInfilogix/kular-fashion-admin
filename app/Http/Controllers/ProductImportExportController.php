<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Department;
use App\Models\ProductType;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductQuantity;

class ProductImportExportController extends Controller
{
    // Export products to CSV
    public function exportProductsToCSV()
    {
        $products = Product::with(['brand', 'department', 'productType', 'colors', 'sizes', 'quantities'])->get();
        $fileName = 'products.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'Article Code', 'Manufacture Code', 'Brand', 'Department', 'Product Type', 'Short Description',
                'MRP', 'Supplier Price', 'Image', 'Season', 'Supplier Ref', 'Tax ID', 'In Date', 'Last Date',
                'Size Scale ID', 'Min Size ID', 'Max Size ID', 'Status', 'Are Barcodes Printed', 'Barcodes Printed For All',
                'Colors', 'Sizes', 'Quantities'
            ]);

            // Add product data
            foreach ($products as $product) {
                $colors = $product->colors->pluck('color_id')->implode(', ');
                $sizes = $product->sizes->pluck('size_id')->implode(', ');
                $quantities = $product->quantities->pluck('quantity')->implode(', ');

                fputcsv($file, [
                    $product->article_code,
                    $product->manufacture_code,
                    $product->brand->name ?? '',
                    $product->department->name ?? '',
                    $product->productType->product_type_name ?? '',
                    $product->short_description,
                    $product->mrp,
                    $product->supplier_price,
                    $product->image,
                    $product->season,
                    $product->supplier_ref,
                    $product->tax_id,
                    $product->in_date,
                    $product->last_date,
                    $product->size_scale_id,
                    $product->min_size_id,
                    $product->max_size_id,
                    $product->status,
                    $product->are_barcodes_printed,
                    $product->barcodes_printed_for_all,
                    $colors,
                    $sizes,
                    $quantities,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Import products from CSV
    public function importProductsFromCSV(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);
    
        $file = $request->file('file');
        if (!$file->isReadable()) {
            return redirect()->back()->with('error', 'File cannot be read.');
        }
    
        $handle = fopen($file->getPathname(), 'r');
    
        // Skip the header row and store column names
        $headers = fgetcsv($handle);
        
        $errorRows = []; // Store failed rows for logging
        $successCount = 0;
    
        while (($data = fgetcsv($handle)) !== false) {
            $data = array_map('trim', $data);
            $errors = [];
    
            // Validate required fields
            if (empty($data[0])) $errors[] = "Article Code is missing";
            if (empty($data[1])) $errors[] = "Manufacture Code is missing";
            if (empty($data[2])) $errors[] = "Brand is missing";
            if (empty($data[3])) $errors[] = "Department is missing";
            if (empty($data[4])) $errors[] = "Product Type is missing";
            if (!is_numeric($data[6])) $errors[] = "MRP must be numeric";
            if (!is_numeric($data[7])) $errors[] = "Supplier Price must be numeric";
    
            // Convert empty date values to NULL
            $inDate = !empty($data[12]) ? date('Y-m-d', strtotime($data[12])) : null;
            $lastDate = !empty($data[13]) ? date('Y-m-d', strtotime($data[13])) : null;
    
            if (!empty($data[12]) && !$inDate) $errors[] = "Invalid format for In Date";
            if (!empty($data[13]) && !$lastDate) $errors[] = "Invalid format for Last Date";
    
            if (!empty($errors)) {
                // Add row to error file with reason
                $data[] = implode(', ', $errors);
                $errorRows[] = $data;
                continue;
            }
    
            // Create or fetch related records
            $brand = Brand::firstOrCreate(['name' => $data[2]]);
            $department = Department::firstOrCreate(['name' => $data[3]]);
            $productType = ProductType::firstOrCreate(['product_type_name' => $data[4]]);
    
            // Create the product
            Product::create([
                'article_code' => $data[0],
                'manufacture_code' => $data[1],
                'brand_id' => $brand->id,
                'department_id' => $department->id,
                'product_type_id' => $productType->id,
                'short_description' => $data[5],
                'mrp' => (float) $data[6],
                'supplier_price' => (float) $data[7],
                'image' => $data[8] ?? null,
                'season' => $data[9] ?? null,
                'supplier_ref' => $data[10] ?? null,
                'tax_id' => is_numeric($data[11]) ? (int) $data[11] : null,
                'in_date' => $inDate,
                'last_date' => $lastDate,
                'size_scale_id' => is_numeric($data[14]) ? (int) $data[14] : null,
                'min_size_id' => is_numeric($data[15]) ? (int) $data[15] : null,
                'max_size_id' => is_numeric($data[16]) ? (int) $data[16] : null,
                'status' => $data[17] ?? 'Active',
                'are_barcodes_printed' => (int) $data[18] ?? 0,
                'barcodes_printed_for_all' => (int) $data[19] ?? 0,
            ]);
    
            $successCount++;
        }
    
        fclose($handle);
    
        // If there are errors, generate a log file
        if (!empty($errorRows)) {
            $errorFileName = 'failed_imports_' . time() . '.csv';
            $errorFilePath = storage_path("app/public/{$errorFileName}");
            
            // Ensure directory exists
            if (!file_exists(storage_path('app/public'))) {
                mkdir(storage_path('app/public'), 0777, true);
            }
    
            $errorFile = fopen($errorFilePath, 'w');
    
            // Add headers with extra "Error Reason" column
            fputcsv($errorFile, array_merge($headers, ['Error Reason']));
    
            // Add failed rows
            foreach ($errorRows as $row) {
                fputcsv($errorFile, $row);
            }
    
            fclose($errorFile);
    
            return redirect()->back()->with([
                'success' => "$successCount products imported successfully.",
                'error' => "Some records failed. <a href='" . asset("storage/{$errorFileName}") . "' target='_blank'>Download Error Report</a>"
            ]);
        }
    
        return redirect()->back()->with('success', "$successCount products imported successfully!");
    }
    
    
    
}