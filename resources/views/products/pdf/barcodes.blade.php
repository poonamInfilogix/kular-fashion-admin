@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: separate;
        }

        td {
            padding: 6px;
            text-align: center;
            border: 1px solid #ddd;
            vertical-align: top;
            width: 23%;
            height: 120px;
            border-radius: 21px;
        }

        .barcode-box img {
            max-width: 60%;
            height: auto;
        }

        .barcode-box .product-code {
            font-size: 8px;
            color: #666;
        }

        .main-ct {
            padding-left: 8px;
        }

        .size-label {
            font-size: 8px;
        }

        .barcode {
            margin-bottom: 5px;
        }

        h3 {
            text-align: left;
            margin-top: 5px;
            font-size: 12px;
        }

        .ch-2 {
            margin-top: 3px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
        }

        .ch-4 {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
        }

        .size-label-container .product-size {
            font-size: 9px;
            font-weight: bold;
            color: #333;
        }

        .barcode-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%; 
            height: 100%;
        }

        .size-label-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: left;
            margin-left: 10px;
            margin-right: 55px;
        }

        .size-label-container-top {
            font-size: 9px;
            font-weight: bold;
            color: #333;
            margin-bottom: 3px;
        }

        .size-label-container-bottom {
            font-size: 9px;
            font-weight: bold;
            color: #333;
        }

        .barcode-image {
            width: 80%;
            max-width: 80%;
            height: auto;
        }

        span.product-name {
            margin-right: 103px;
        }

        .ch-4 span {
            margin-right: 28px;
            font-weight: 700;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
                visibility: visible;
            }

            .page-content > div:not(.container-fluid) {
                display: none !important;
            }

            .container-fluid {
                display: block;
                visibility: visible;
                width: 100%;
                margin-top: 30px; /* Margin for spacing between header and content on subsequent pages */
            }

            .container-fluid:first-of-type {
                margin-top: 0; /* No margin on the first page */
            }

            table {
                width: 100%;
                border-collapse: separate;
                page-break-before: always;
                page-break-inside: avoid;
                margin: 0;
            }

            tr {
                page-break-inside: avoid;
            }

            td {
                height: 120px;
                padding: 6px;
                text-align: center;
                border: 1px solid #ddd;
                vertical-align: top;
                border-radius: 21px;
                box-sizing: border-box;
            }

            .barcode-box {
                padding: 4px;
                margin: 0 !important;
            }

            .barcode-box img {
                max-width: 60%;
                height: auto;
            }

            .size-label,
            .product-code {
                font-size: 8px;
            }

            h3 {
                font-size: 12px;
                text-align: left;
            }

            .barcode-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
            }

            .size-label-container {
                display: flex;
                flex-direction: column;
                justify-content: center;
                text-align: left;
                margin-left: 10px;
                margin-right: 10px;
            }

            .size-label-container-top,
            .size-label-container-bottom {
                font-size: 9px;
                font-weight: bold;
                color: #333;
            }

            .size-label-container-top {
                margin-bottom: 3px;
            }

            .barcode-box img {
                max-width: 70%;
                height: auto;
            }

            @page {
                size: auto;
                margin: 0;
            }

            /* Add page-break styles for controlling spacing between pages */
            .page-break {
                page-break-before: always;
            }
        }
    </style>
    <div class="page-content">
        <div style="text-align: right; margin-top: 20px;">
            <button onclick="window.print()" class="btn btn-primary">Print</button>
        </div>
        <div class="container-fluid">
            <table>
                <tbody>
                    <!-- Barcode rows -->
                    @foreach ($barcodes as $index => $item)
                        @if ($index % 4 == 0)
                            <tr>
                        @endif
                        <td class="barcode-box">
                            <div class="main-ct">
                                <h3><strong>ARMOR LUX</strong></h3>
                                <div class="product-header" style="width: 100%; font-size: 8px;">
                                    <span style="float: left">STRIPE NEW JACK</span>
                                    <span>84112449</span>
                                </div>
                                <div class="ch-2">
                                    <span >BLUE</span>
                                    <span class="product-name">MEN</span>
                                </div>

                                <div class="ch-3">
                                    <div class="barcode-container">
                                        <img src="data:image/png;base64,{{ $item['barcode'] }}" alt="Barcode" class="barcode-image">
                                
                                        <div class="size-label-container">
                                            <span class="size-label-container-top">Size</span>
                                            <div class="size-label-container-bottom">
                                                <span class="product-size"><span class="txt-adj">{{ $item['size'] }}</span></span>
                                            </div>
                                        </div>
                                    </div>
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
        </div> 
    </div>
@endsection