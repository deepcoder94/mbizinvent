
<tr id="product_{{ $index }}">
    <td>
        <div class="form-group">
            <select name="product_id[]" id="product_id_{{ $index }}" class="form-control" onchange="populateValues('{{$index}}',event)">
                <option value="">Select</option>
                @forelse ($products as $p)
                    <option value="{{ $p->id }}">{{ $p->product_description }}</option>
                @empty
                    <option value=""></option>
                @endforelse
            </select>            
        </div>
    </td>
    <td>
        <div class="form-group">
            <input type="text" name="product_qty[]" id="product_qty_{{ $index }}" class="form-control product_qty" onkeyup="calculateTotal('{{$index}}')" value="1">
            <span style="font-size: 13px;color: red;font-weight: 400;" id="max_qty_{{ $index }}">Max Qty: </span>
        </div>
    </td>
    <td>
        <div class="form-group">
            <input type="text" name="product_rate[]"  id="product_rate_{{ $index }}" class="form-control product_rate" onkeyup="calculateTotal('{{$index}}')" value="0">
        </div>
    </td>    
    <td>
        <div class="form-group">
            <input type="text" name="product_gross_total[]" id="product_gross_total_{{ $index }}" class="form-control product_gross_total" onkeyup="calculateTotal('{{$index}}')" value="0">
        </div>
    </td>        
    <td>
        <div class="form-group">
            <input type="text" name="product_discount[]" id="product_discount_{{ $index }}" class="form-control product_discount" onkeyup="calculateTotal('{{$index}}')" value="0">
        </div>
    </td>            
    <td>
        <div class="form-group">
            <input type="text" name="product_taxable_value[]" id="product_taxable_value_{{ $index }}" class="form-control product_taxable_value" onkeyup="calculateTotal('{{$index}}')" value="0">
        </div>
    </td>                
    <td>
        <div class="form-group">
            <input type="text" name="product_tax_rate[]" id="product_tax_rate_{{ $index }}" class="form-control product_tax_rate" onkeyup="calculateTotal('{{$index}}')" value="0">
        </div>
    </td>                    
    <td>
        <div class="form-group">
            <input type="text" name="product_total_amt[]" id="product_total_amt_{{ $index }}" class="form-control product_total_amt" onkeyup="calculateTotal('{{$index}}')" value="0">
        </div>
    </td>     
    <td>
        <button class="btn btn-danger" type="button" onclick="deleteProduct('{{ $index }}')">
            <i class="nav-icon bi bi-trash"></i>
        </button>
    </td>                   
</tr>