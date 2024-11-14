<?php

namespace App\Imports;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

class BrandImport implements ToModel, WithHeadingRow
{
    protected $errors = [];
    protected $rowIndex = 0;

    /**
     * Handle the import of a single row.
     *
     * @param array $row
     * @return Brand|null
     */
    public function model(array $row)
    {
        $this->rowIndex++;
        $validator = Validator::make($row, [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $field => $messages) {
                foreach ($messages as $message) {
                    $this->errors[] = [
                        'message' => $message . " in row " . $this->rowIndex,
                        'row' => $row,
                    ];
                }
            }
            return null;
        }

        $brand = Brand::where('name', $row['name'])->first();

        if (!$brand) {
            // Brand doesn't exist, create a new one
            $imagePath = $this->handleImage($row);
        
            Brand::create([
                'name' => $row['name'],
                'image'      => $imagePath,
            ]);
        } else {
            if (isset($row['image']) && $row['image']) {
                $imagePath = $this->handleImage($row);
                
                if ($imagePath) {
                    $brand->update([
                        'image' => $imagePath,
                    ]);
                }
            } else {
                $this->errors[] = [
                    'message' => "Brand name '{$row['name']}' already exists in row {$this->rowIndex}",
                    'row' => $row,
                ];
            }
        }

        return null;
    }

    /**
     * Handle image upload (URL or file).
     *
     * @param array $row
     * @return string|null
     */
    private function handleImage(array $row)
    {
        $imagePath = null;
        $path = 'uploads/brands/'; // Define your directory path here
        $publicPath = public_path($path); // Get the full public path

        // Ensure the directory exists
        if (!File::exists($publicPath)) {
            File::makeDirectory($publicPath, 0755, true); // Create directory if it doesn't exist
        }

        if (isset($row['image']) && $row['image']) {
            $imageUrl = $row['image'];  // The image URL from the import file

            if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                try {
                    // Attempt to download the image content
                    $imageContent = Http::get($imageUrl)->body();

                    if ($imageContent) {
                        // Extract a clean file name from the URL (without query parameters)
                        $imageName = basename(parse_url($imageUrl, PHP_URL_PATH));

                        // Construct the full image path
                        $imagePath = $path . $imageName;

                        // Save the image content to the public directory
                        file_put_contents($publicPath . $imageName, $imageContent);
                    }
                } catch (\Exception $e) {
                    // Handle any exceptions that occur during the download
                    $this->errors[] = [
                        'message' => "Error downloading image from URL: " . $imageUrl,
                        'row' => $row,
                    ];
                    return null;
                }
            } else {
                // Handle local file paths (if any)
                if (file_exists($imageUrl)) {
                    $imageName = basename($imageUrl);  // Extract the file name from local path
                    $imagePath = $path . $imageName;   // Construct the full path

                    // Move the file to the public directory
                    copy($imageUrl, $publicPath . $imageName);
                }
            }
        }

        return $imagePath;
    }


    /**
     * Get validation errors during the import.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
