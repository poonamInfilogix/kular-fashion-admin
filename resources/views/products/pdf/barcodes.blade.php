@extends('layouts.app')

@section('content')

    <div class="page-content">
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
                margin-right: 50px;
            }
    
            .ch-4 span {
                margin-right: 2px;
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
                    cursor: pointer;
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
        <div style="text-align: right; margin-top: 20px;">
            <button onclick="window.print()" class="btn btn-primary">Print</button>
        </div>
        <div class="container-fluid" id="main-barcode-container">
            <table id="table-content">
                <tbody>
                    <!-- Barcode rows -->
                    @foreach ($barcodes as $index => $item)
                        @if ($index % 4 == 0)
                            <tr>
                        @endif
                        <td @class(['barcode-box','bg-white' => $index == 0]) data-index="{{$index}}">
                            <div class="main-ct">
                                <h3><strong>{{ strtoupper($item['brand_short_name']) }}</strong></h3>
                                <div class="product-header" style="width: 100%; font-size: 8px;">
                                    <span style="float: left">{{ Str::words(strtoupper($item['short_description']), 25) }}</span>
                                    <span>{{ $item['manufacture_code'] }}</span>
                                </div>
                                <div class="ch-2">
                                    <span >{{ strtoupper($item['color']) }}</span>
                                    <span class="product-name" style="text-transform: uppercase;">{{ $item['department'] }}</span>
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
                                    <span>£<span class="txt-adj">{{ $item['mrp'] }}</span></span>
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
    <script>
    $(document).on('click', 'td.barcode-box', function() {
        $('td.barcode-box').removeClass('bg-white');
        $(this).addClass('bg-white');

        var clickedIndex = $(this).data('index');
        removeTdBeforeClick(clickedIndex);
    });

    function removeTdBeforeClick(index) {
        var tableHtml = $('.page-content').html();
        var $table = $('<table>').html(tableHtml);
        
        $table.find('td').slice(0, index).remove();

        tableHtml = $table[0].outerHTML;

        var printWindow = window.open('', '', 'height=1200,width=1000');

        if (printWindow) {
            printWindow.document.write('<html><head><title>Print Barcode</title></head><body>');
            printWindow.document.write('<div>' + tableHtml + '</div>');
            printWindow.document.write('</body></html>');
            
            printWindow.document.close();

            printWindow.onload = function() {
                printWindow.focus();
                printWindow.print();
                printWindow.close(); 
            };
                        // Debugging after print
            window.onafterprint = function() {
                console.log('After print: Custom logic after printing');
                alert('Print operation finished or canceled.');
                // Custom cleanup logic can be placed here
                // Example: Restore elements, reset the layout, etc.
            };
        } else {
            console.error("Failed to open print window.");
        }
    }
    window.onafterprint = function() {
        alert('The print dialog was closed.');
        // You can add other actions here that you want to execute after printing
    };

    </script>
@endsection