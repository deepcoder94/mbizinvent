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
    </style>
</head>
<body>

    <div class="header">Tax Invoice</div>

    <table>
        <tr>
            <td><strong>Seller:</strong><br>
                Amit Kumar Sen<br>
                Burdwan Road (Near SBI) Chaul Patty<br>
                Tarakeshwar, 712410<br>
                GSTIN: 19AAVFS6967R1ZJ<br>
                PAN: AAVFS6967R
            </td>
            <td><strong>Buyer:</strong><br>
                M.M. Enterprise (Mankundu)<br>
                299, Sarkarpukur Lane, Palpara, Mankundu<br>
                West Bengal, 712139<br>
                GSTIN: 19APEP2145M1ZM
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <th>#</th>
            <th>Item</th>
            <th>HSN</th>
            <th>Batch</th>
            <th>Expiry</th>
            <th>Qty</th>
            <th>Rate</th>
            <th>Gross</th>
            <th>Discount</th>
            <th>Taxable</th>
            <th>CGST</th>
            <th>SGST</th>
            <th>Total</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Suthol Active Neem 100ml</td>
            <td>30049011</td>
            <td>M919</td>
            <td>Mar 2028</td>
            <td>360</td>
            <td>35.67</td>
            <td>12841.20</td>
            <td>(4%) 513.65</td>
            <td>12327.55</td>
            <td>739.65</td>
            <td>739.65</td>
            <td>13806.85</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Suthol Active Neem 200ml</td>
            <td>30049011</td>
            <td>NM585</td>
            <td>Feb 2028</td>
            <td>66</td>
            <td>64.21</td>
            <td>3852.60</td>
            <td>(4%) 154.10</td>
            <td>3698.50</td>
            <td>221.95</td>
            <td>221.95</td>
            <td>4142.32</td>
        </tr>
        <tr>
            <td colspan="9" class="text-right"><strong>Total</strong></td>
            <td>23883.73</td>
            <td>1430.02</td>
            <td>1430.02</td>
            <td>26693.77</td>
        </tr>
    </table>

    <p><strong>Invoice Value (In Words):</strong> Rupees Twenty Six Thousand Six Hundred Ninety Four Only</p>

</body>
</html>
