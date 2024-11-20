<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Barcodes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td {
            padding: 6px;
            text-align: center;
            border: 1px solid #ddd;
            vertical-align: top;
            width: 23%;  /* Reduced width for smaller cells */
            height: 130px;  /* Adjusted for smaller cells */
        }

        .barcode-box img {
            max-width: 70%;  /* Reduced image size further to 70% */
            height: auto;
        }

        .barcode-box .product-code {
            font-size: 8px;  /* Smaller product code font size */
            color: #666;
        }

        .size-label {
            font-size: 8px;  /* Smaller size label font */
        }

        .barcode-container {
            display: block;
            margin-top: 5px;
        }

        .barcode {
            margin-bottom: 5px;
        }

        h3 {
            text-align: left;
            margin-top: 5px;
            font-size: 12px;  /* Reduced font size for h3 */
        }

  

        .ch-3 span {
            font-size: 10px;
        }

        span.txt-adj {
            font-weight: 600;
        }

        /* Print-specific styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
            }

            table {
                width: 100%;
                page-break-before: always;
            }

            tr {
                page-break-inside: avoid;  /* Prevent row break */
            }

            td {
                width: 23%;  /* Reduced cell width for print */
                height: 130px;  /* Reduced cell height */
                padding: 4px;  /* Reduced padding */
            }

            .barcode-box {
                padding: 4px;  /* Reduced padding */
                margin: 0 !important;
            }

            .barcode-container {
                display: block;
                margin-top: 5px;
            }

            .size-label,
            .product-code {
                font-size: 8px;  /* Smaller size for print */
            }

            h3 {
                font-size: 12px;  /* Smaller size for h3 */
                text-align: left;
            }


            /* Ensure barcode images fit the space */
            .barcode-box img {
                max-width: 70%;  /* Reduced image size for print */
                height: auto;
            }
        }
    </style>
</head>

<body>
    <table>
        <tbody>
            <!-- Barcode rows -->
            @foreach ($barcodes as $index => $item)
                @if ($index % 4 == 0)
                    <tr> <!-- Start new row for every 4 items -->
                @endif
                <td class="barcode-box">
                    <div class="main-ct">
                        <h3>ARMOR LUX</h3>
                        <div style="width: 100%; font-size: 10px;">
                            <span style="float: left">STRIPE NEW JACK</span>
                            <span style="float: right">84112449</span>
                        </div>
                        <div class="ch-2">
                            <span >BLUE</span>
                            <span>MEN</span>
                        </div>
                        <div class="ch-3">
                            <img src="data:image/png;base64,{{ $item['barcode'] }}" alt="Barcode">
                            <span class="product-size">Size <span class="txt-adj">{{ $item['size'] }}</span></span>
                        </div>
                        <div class="ch-4">
                            <span>{{ $item['product_code'] }}</span>
                            <span>£<span class="txt-adj">50</span></span>
                        </div>
                    </div>
                </td>
                @if (($index + 1) % 4 == 0 || $loop->last)
                    </tr> <!-- Close row after 4 items or last item -->
                @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>
