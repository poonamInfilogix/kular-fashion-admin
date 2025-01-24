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
                margin-top: 4px;
                margin-bottom: 4px;
                font-size: 12px;
            }

            .product-header {
                display: flex;
                font-size: 11px;
                justify-content: space-between;
                margin-right: 8px;
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
                margin-right: 8px;
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
                margin-right: 8px;
            }

            .ch-4 span {
                margin-right: 2px;
                font-weight: 700;
            }

            .size-label-container .mrp {
                font-size: 18px
            }

            @media print {
                body {
                    margin: 0;
                    padding: 0;
                    font-family: Arial, sans-serif;
                    visibility: visible;
                }

                .page-content>div:not(.container-fluid) {
                    display: none !important;
                }

                .container-fluid {
                    display: block;
                    visibility: visible;
                    width: 100%;
                    margin-top: 30px;
                    /* Margin for spacing between header and content on subsequent pages */
                }

                .container-fluid:first-of-type {
                    margin-top: 0;
                    /* No margin on the first page */
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
                    height: 115px;
                    /* Adjusted to fit 9 rows per page */
                    padding: 6px;
                    text-align: center;
                    border: 1px solid #ddd;
                    vertical-align: top;
                    border-radius: 21px;
                    box-sizing: border-box;
                    width: 25%;
                    /* Ensures four columns per row */
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

                .size-label-container .mrp {
                    font-size: 18px
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
                    size: A4;
                    margin-top: 4mm;
                    margin-left: 2mm;
                    /* Optional: Add left margin */
                    margin-right: 2mm;
                    /* Optional: Add right margin */
                    margin-bottom: 0mm;
                }

                /* Add page-break styles for controlling spacing between pages */
                .page-break {
                    page-break-before: always;
                }

                td {
                    width: 25%;
                    page-break-inside: avoid;
                    /* Prevent breaking rows between pages */
                }

                /* Control page breaks between barcode rows */
                table {
                    width: 100%;
                    border-collapse: separate;
                    margin: 0;
                    page-break-before: always;
                }

                tr {
                    page-break-inside: avoid;
                    /* Prevent splitting rows */
                }
            }

            .barcode_number {
                font-size: 13px;
                margin-bottom: 4px;
            }

            .brand_name {
                font-size: 17px;
                margin-top: 4px;
            }
        </style>

        <div class="container px-5">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Print Barcodes Preview</h4>

                        <div class="page-title-right">
                            <button id="print-btn" class="btn btn-primary me-2">
                                <i class="bx bx-printer"></i>
                                Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <table id="table-content">
                <tbody>
                    <!-- Barcode rows -->
                    @foreach ($barcodes as $index => $item)
                        @if ($index % 4 == 0)
                            <tr>
                        @endif
                        <td @class(['barcode-box', 'bg-success-subtle' => $index == 0]) data-index="{{ $index }}">
                            <div class="main-ct">
                                <h3 class="brand_name"><strong>{{ strtoupper($item['brand_short_name']) }}</strong></h3>
                                <div class="product-header">
                                    <span>{{ Str::words(strtoupper($item['short_description']), 22) }}</span>
                                    <span>{{ $item['random_digits'] }}</span>
                                </div>
                                <div class="ch-2">
                                    <span>{{ strtoupper($item['color']) }}</span>
                                    <span>{{ strtoupper($item['size']) }}</span>
                                    <span class="product-name" style="text-transform: uppercase;">{{ $item['type'] }}</span>
                                </div>

                                <div class="ch-3">
                                    <div class="barcode-container">
                                        <img src="data:image/png;base64,{{ $item['barcode'] }}" alt="Barcode"
                                            class="barcode-image">

                                        <div class="size-label-container">
                                            <div class="size-label-container-bottom">
                                                <span class="mrp">£{{ $item['mrp'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="ch-4">
                                    <span class="barcode_number">{{ $item['product_code'] }}</span>
                                </div>
                            </div>
                        </td>
                        @if (count($barcodes) % 4 !== 0 && $index === count($barcodes) - 1)
                            @php
                                $emptyCells = 4 - (count($barcodes) % 4);
                            @endphp
                            @for ($i = 0; $i < $emptyCells; $i++)
                                <td></td>
                            @endfor
                            </tr>
                        @endif

                        @if (($index + 1) % 4 == 0 || $loop->last)
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var selectedIndex = null;

            // Make the first barcode selected by default
            var firstBarcode = $('td.barcode-box').first();
            firstBarcode.addClass('bg-success-subtle');
            selectedIndex = firstBarcode.data('index');

            $(document).on('click', 'td.barcode-box', function() {
                $('td.barcode-box').removeClass('bg-success-subtle');
                $(this).addClass('bg-success-subtle');

                selectedIndex = $(this).data('index');
            });

            // When clicking the "Print" button
            $('#print-btn').on('click', function() {
                if (selectedIndex === null) {
                    alert('Please select a barcode first.');
                    return;
                }

                // Call the function to open the print dialog with the content starting from the selected barcode
                openPrintWindowFromIndex(selectedIndex);
            });

            function openPrintWindowFromIndex(index) {
                var tableHtml = $('#table-content').html();
                var $table = $('<table>').html(tableHtml);

                var allTdElements = $table.find('td').toArray();

                var tdElementsFirstPart = allTdElements.slice(index);
                var tdElementsSecondPart = allTdElements.slice(0, index);

                function createTableHtml(tdElements) {
                    var newRowsHtml = '';
                    for (var i = 0; i < tdElements.length; i += 4) {
                        var rowHtml = tdElements.slice(i, i + 4).map(function(td) {
                            return td.outerHTML;
                        }).join('');

                        while (rowHtml.split('<td').length - 1 < 4) {
                            rowHtml += '<td style="width: 25%;"></td>';
                        }

                        newRowsHtml += `<tr>${rowHtml}</tr>`;
                    }
                    return `<table id="table-content">${newRowsHtml}</table>`;
                }

                var newTableHtmlFirstPart = createTableHtml(tdElementsFirstPart);
                var newTableHtmlSecondPart = createTableHtml(tdElementsSecondPart);

                var combinedHtml = `
                    ${newTableHtmlFirstPart}
                    ${selectedIndex ? newTableHtmlSecondPart : ''}
                `;

                var styles = $('style').map(function() {
                    return $(this).prop('outerHTML');
                }).get().join('');

                var printWindowContent = `
                <html>
                <head>
                    <title>Print Barcode</title>
                    <style>${styles}</style>
                </head>
                <body>
                    <div>${combinedHtml}</div>
                </body>
                </html>
            `;

                var iframe = document.createElement('iframe');
                iframe.style.position = 'absolute';
                iframe.style.width = '0px';
                iframe.style.height = '0px';
                iframe.style.border = 'none';

                document.body.appendChild(iframe);

                var iframeDoc = iframe.contentWindow.document;
                iframeDoc.open();
                iframeDoc.write(printWindowContent);
                iframeDoc.close();

                iframe.onload = function() {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                };

                iframe.contentWindow.onafterprint = function() {
                    document.body.removeChild(iframe);
                    window.location.href = `{{ route('save.barcodes') }}`;
                };
            }
        });
    </script>
@endsection
