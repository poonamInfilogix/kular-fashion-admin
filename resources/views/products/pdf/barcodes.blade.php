<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Barcodes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse; /* Removes spacing between table cells */
            margin-bottom: 20px;
        }
        td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            vertical-align: middle;
        }
        .barcode img {
            max-width: 80%; /* Ensures barcode images fit inside their containers */
            height: auto;
        }
        .barcode p {
            margin: 5px 0;
        }
        .barcode .product-code {
            font-size: 1em;
            color: #666;
        }

        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            td {
                padding: 10px; /* Reduced padding for smaller screens */
            }
            table {
                font-size: 14px; /* Smaller font size on mobile */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Product Barcodes</h1>
        <table>
            <tbody>
                <!-- Barcode rows -->
                @foreach($barcodes as $index => $item)
                    @if($index % 6 == 0)
                        <tr> <!-- Start new row for every 6 items -->
                    @endif
                        <td class="barcode">
                            <img src="data:image/png;base64,{{ $item['barcode'] }}" alt="Barcode">
                            <p class="product-code">{{ $item['product']->article_code }}</p> <!-- Display 1, 2, 3, 4, 5, 6, etc. -->
                        </td>
                    @if(($index + 1) % 6 == 0 || $loop->last)
                        </tr> <!-- Close row after 6 items or last item -->
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
