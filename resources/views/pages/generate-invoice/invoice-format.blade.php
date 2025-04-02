<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid black; padding: 5px; text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .header { text-align: center; font-size: 18px; font-weight: bold; }
        .invoice-info { margin-bottom: 20px; }
        .invoice-info td { padding: 5px; }
        .invoice-info th { text-align: left; padding-left: 15px; }
    </style>
</head>
<body>

    <div class="header">Tax Invoice</div>

    <p><strong>Invoice Number:</strong> {{ $invoice['invoice_number'] }}</p>
    <p><strong>Invoice Date:</strong> {{ $invoice['invoice_date'] }}</p>

    <table>
        <tr>
            <td><strong>Buyer Details:</strong><br>
                Name: {{ $customer->customer_name }}<br>
                Address: {{ $customer->address }}<br>
                State: {{ $customer->state }}<br>
                State Code: {{ $customer->state_code }}<br>
                GSTIN Number: {{ $customer->gstin_number }}<br>
                Mobile: {{ $customer->phone }}<br>
                PAN Number: {{$customer->pan_number}}
            </td>
            <td><strong>Seller Details:</strong><br>
                Name: {{ $settings->dist_name }}<br>
                Address: {{ $settings->address }}<br>
                State: {{ $settings->state }}<br>
                State Code: {{ $settings->state_code }}<br>
                GSTIN Number: {{ $settings->gstin_number }}<br>
                Mobile: {{ $settings->phone }}<br>
                PAN Number: {{$settings->pan_number}}
            </td>
        </tr>
    </table>

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

</body>
</html>
