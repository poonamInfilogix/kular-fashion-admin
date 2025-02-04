@extends('layouts.app')

@section('content')
    @push('styles')
        <style>
            @page {
                size: A4;
                margin-top: 15mm;
                margin-bottom: 15mm;
                margin-left: 4.8mm;
                margin-right: 4.8mm;
            }

            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                flex-wrap: wrap;
                justify-content: center;
            }

            .pages {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .page {
                display: grid;
                grid-template-columns: repeat(4, 48.6mm);
                grid-template-rows: repeat(9, 29.6mm);
                column-gap: 2mm;
                padding: 0;
                box-sizing: border-box;
                page-break-after: always;
            }

            .ticket-container {
                border: 1px solid #ddd;
                border-radius: 2mm;
                display: block;
                font-size: 12px;
                overflow: hidden;
                padding: 4px;
                color: #000
            }

            .page-content .page-header {
                margin: 0 34mm;
            }

            .brand-name {
                font-size: 16px;
                margin: 0;
                font-weight: bold;
            }

            .description-container {
                display: flex;
                justify-content: space-between
            }

            .description-container p {
                font-size: 12px;
                margin: 0;
            }

            .variant-info {
                display: flex;
                justify-content: space-between;
            }

            .variant-info p {
                margin: 0;
            }

            .barcode-container {
                width: 100%;
                display: flex;
                gap: 4px;
            }
            .barcode-container img{
                width: 112px
            }

            .barcode-right-section{
                font-size: 16px;
            }

            .department-name{
                text-align: center;
                font-weight: bold;
            }
        </style>
    @endpush

    <div class="page-content">
        <div class="row page-header">
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

        <div class="pages">
            @foreach (array_chunk($barcodes, 36) as $pageIndex => $barcode)
                <div class="page">
                    @foreach ($barcode as $index => $item)
                        <div @class([
                            'ticket-container',
                            'bg-success-subtle' => $pageIndex == 0 && $index == 0,
                        ])>
                            <h6 class="brand-name">{{ Str::limit($item['brand_name'], 14) }}</h6>
                            <div class="description-container">
                                <p>{{ Str::words(strtoupper($item['short_description']), 22) }}</p>
                                <p>{{ $item['random_digits'] }}</p>
                            </div>
                            <div class="variant-info">
                                <p>{{ strtoupper($item['color']) }}</p>
                                <p>{{ strtoupper($item['size']) }}</p>
                                <p>{{ strtoupper($item['product_type_short_name']) }}</p>
                            </div>
                            <div class="barcode-container">
                                <div class="barcode-left-section">
                                    <img src="data:image/png;base64,{{ $item['barcode'] }}" alt="Barcode">
                                    <p>{{ $item['product_code'] }}</p>
                                </div>
                                <div class="barcode-right-section">
                                    <div class="department-name">{{ substr($item['department'], 0, 1) }}</div>
                                    <div>£{{ $item['mrp'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

        </div>

    </div>

    @push('scripts')
        <script>
            $(function() {
                $('#print-btn').click(function() {
                    window.print();
                })
            })
        </script>
    @endpush
@endsection
