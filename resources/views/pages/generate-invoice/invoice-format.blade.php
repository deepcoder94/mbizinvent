<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Invoice</title>
    <style>
        /* General body styles */
        body { 
            font-family: Arial, sans-serif; 
            font-size: 10px; /* Reduced font size */
            margin: 0; /* Remove margins */
            padding: 0; /* Remove padding */
            height: 100%; /* Ensure full height of the page is used */
        }

        /* Remove margins from the page when printing */
        @media print {
            html, body {
                margin: 0; /* Remove all margins */
                padding: 0; /* Remove all padding */
                height: 100%; /* Ensure full height is used */
            }
            /* Ensure tables stretch to full width */
            table { 
                width: 100%; 
                border-collapse: collapse;
            }

            /* Adjust for printing: reduced padding and font size */
            th, td { 
                border: 1px solid black; 
                padding: 3px 5px; /* Reduced padding for smaller rows */
                text-align: left; 
                font-size: 10px; /* Reduced font size */
                line-height: 1.2; /* Tightened line height for compact rows */
            }
            
            /* Adjust header and section styling for print */
            .header { 
                text-align: center; 
                font-size: 15px; /* Smaller header font size */
                font-weight: bold; 
                margin-bottom: 10px;
            }

            /* Specific styles for invoice info tables */
            .invoice-info { 
                margin-bottom: 10px; 
            }
            .invoice-info td { 
                padding: 3px; /* Reduced padding */
            }
            .invoice-info th { 
                text-align: left; 
                padding-left: 10px; 
                font-size: 10px;
            }

            /* Section specific styles */
            .section { 
                margin-bottom: 8px; /* Adjust spacing between sections */
            }
            .section th, .section td { 
                padding: 4px 6px; /* Reduced padding inside table cells */
                font-size: 10px; /* Smaller font size */
            }
        }

        /* Ensure tables stretch to full width */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 8px; /* Adjust space between tables */
        }
        
        th, td { 
            border: 1px solid black; 
            padding: 3px 5px; /* Reduced padding for smaller rows */
            text-align: left; 
            font-size: 10px; /* Reduced font size */
            line-height: 1.2; /* Tighten line height for compact rows */
        }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        .header { 
            text-align: center; 
            font-size: 13px; /* Smaller header font size */
            font-weight: bold; 
            margin-bottom: 10px;
        }

        .invoice-info { 
            margin-bottom: 10px; 
        }

        .invoice-info td { 
            padding: 3px; /* Reduced padding */
        }
        
        .invoice-info th { 
            text-align: left; 
            padding-left: 10px; 
            font-size: 10px;
        }

        .section { 
            margin-bottom: 8px; /* Adjust spacing between sections */
        }

        .section th, .section td { 
            padding: 4px 6px; /* Reduced padding inside table cells */
            font-size: 10px; /* Smaller font size */
        }
    </style>
</head>
<body>

    <div class="header">Tax Invoice</div>

    <p><strong>Invoice Number:</strong> {{ $invoice['invoice_number'] }}</p>
    <p><strong>Invoice Date:</strong> {{ $invoice['invoice_date'] }}</p>

    <div class="section">
        <table>
            <tr>
                <td><strong>Buyer Details:</strong><br>
                    {!! $custhtml !!}
                </td>
                <td><strong>Seller Details:</strong><br>
                    Name: {{ $settings->dist_name }}<br>
                    Address: {{ $settings->address }}<br>
                    State: {{ $settings->state }}<br>
                    State Code: {{ $settings->state_code }}<br>
                    GSTIN: {{ $settings->gstin_number }}<br>
                    Mobile: {{ $settings->phone }}<br>
                    PAN: {{$settings->pan_number}}
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <table>
            <tr>
                <th>#</th>
                <th>Product Description</th>
                <th>Qty</th>
                <th>HSN Code</th>
                <th>Rate</th>
                <th>Gross Total</th>
                <th>Discount</th>
                <th>Taxable Value</th>
                <th colspan="2">CGST</th>
                <th colspan="2">SGST</th>
                <th>Total</th>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>%</td>
                <td>Amount</td>
                <td>%</td>
                <td>Amount</td>
                <td></td>
            </tr>
            @foreach ($invoice['products'] as $i => $p)
            <tr>
                <td>{{++$i}}</td>
                <td>{{ $p['product_description'] }}</td>
                <td>{{$p['quantity']}}</td>
                <td>{{$p['hsn_code']}}</td>
                <td>{{ $p['rate'] }}</td>
                <td>{{ $p['gross_total'] }}</td>
                <td>{{ $p['discount'] }}</td>
                <td>{{ $p['taxable_value'] }}</td>
                <td>{{ $p['cgst_perc'] }}</td>
                <td>{{ $p['cgst'] }}</td>
                <td>{{ $p['sgst_perc']}}</td>
                <td>{{ $p['sgst'] }}</td>
                <td>{{$p['total_amount']}}</td>
            </tr>
            @endforeach
        </table>
    </div>

    <div class="section">
        <table>
            <tr>
                <th>Total Qty</th>
                <th>Gross Total</th>
                <th>Discount</th>
                <th>Taxable Amount</th>
                <th>CGST Amt</th>
                <th>SGST Amt</th>
                <th>Round Off</th>
                <th>Grand Total</th>
            </tr>
            <tr>
                <td>{{ $invoice['total_quantity'] }}</td>
                <td>{{ $invoice['total_gross_sum'] }}</td>
                <td>{{ $invoice['total_discount'] }}</td>
                <td>{{ $invoice['total_taxable_value'] }}</td>
                <td>{{ $invoice['total_cgst'] }}</td>
                <td>{{ $invoice['total_sgst'] }}</td>
                <td>{{ $invoice['total_round_off'] }}</td>
                <td>{{ $invoice['total_grand'] }}</td>
            </tr>
        </table>
    </div>

</body>
</html>