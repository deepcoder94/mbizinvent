<script>
    var productCount = 0;
    var invProducts = new Set();

    function addProduct(){
        invProducts.add(++productCount)   
                             
        
        let url = '{{ route('addSingleProduct') }}';
        $.ajax({
            url: url, // The URL defined in your routes
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ), // CSRF Token
            },
            data:{
                productCount:invProducts.size
            },
            success: function (response) {
                $("#invoice_product_tbody").append(response)
                
                // $("#addEditModalBody").html(response)
                // $("#modalTitle").html('Add Inventory');
                // $("#addEditModal").modal('show');

                // validateAndSubmitFormFields(false,storeurl);
                
            },
            error: function(err){

            }
        });            
    }

    function populateValues(id,event){
        
        let url = '{{ route('getProductInfo') }}';
        $.ajax({
            url: url, // The URL defined in your routes
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ), // CSRF Token
            },
            data:{
                id:event.target.value,
            },
            success: function (response) {
                if(response.success){
                    $(`#product_rate_${id}`).val(response.data.rate)
                    $(`#max_qty_${id}`).html('Max Qty: '+response.data.stock.available_stock)
                }                    
            },
            error: function(err){

            }
        });                    
    }

    function deleteProduct(id){
        $("#product_"+id).remove();
        invProducts.delete(id)
    }

    function calculateTotal(index){

        
        let product_qty = $(`#product_qty_${index}`).val();
        let product_rate = $(`#product_rate_${index}`).val();
        let product_gross_total = $(`#product_gross_total_${index}`).val();
        let product_discount = $(`#product_discount_${index}`).val();
        let product_taxable_value = $(`#product_taxable_value_${index}`).val();
        let product_tax_rate = $(`#product_tax_rate_${index}`).val();



        product_qty = product_qty.length > 0 ? parseFloat(product_qty) : 0.00
        product_rate = product_rate.length > 0 ? parseFloat(product_rate) : 0.00
        product_gross_total = product_gross_total.length > 0 ? parseFloat(product_gross_total) : 0.00
        product_discount = product_discount.length > 0 ? parseFloat(product_discount) : 0.00
        product_taxable_value = product_taxable_value.length > 0 ? parseFloat(product_taxable_value) : 0.00
        product_tax_rate = product_tax_rate.length > 0 ? parseFloat(product_tax_rate) : 0.00



        let grosstotal = (product_qty*product_rate)
        
        let taxableValue = (grosstotal-product_discount)
        let grandTotal = taxableValue + ((product_tax_rate / 100) * taxableValue) 
        
        $(`#product_gross_total_${index}`).val(grosstotal.toFixed(2));
        $(`#product_taxable_value_${index}`).val(taxableValue.toFixed(2))
        $(`#product_total_amt_${index}`).val(grandTotal.toFixed(2));
        
        calcGroupTotal()
    }

    function calcGroupTotal() {
        let qtys = document.querySelectorAll('.product_qty');
        $("#total_quantity").html(calcSingle(qtys).toFixed(2))
        let rates = document.querySelectorAll('.product_rate');
        $("#total_rate").html(calcSingle(rates).toFixed(2))
        let product_gross_total = document.querySelectorAll('.product_gross_total');
        $("#total_gross_sum").html(calcSingle(product_gross_total).toFixed(2))
        let discounts = document.querySelectorAll('.product_discount');
        $("#total_discount").html(calcSingle(discounts).toFixed(2))            
        let taxable_values = document.querySelectorAll('.product_taxable_value');
        $("#total_taxable_value").html(calcSingle(taxable_values).toFixed(2))            
        let tax_rates = document.querySelectorAll('.product_tax_rate');
        $("#total_cgst").html((calcSingle(tax_rates)/2).toFixed(2));
        $("#total_sgst").html((calcSingle(tax_rates)/2).toFixed(2));            
        let product_total_amts = document.querySelectorAll('.product_total_amt');


        let total_amts = calcSingle(product_total_amts);

        let total_round_off = $("#total_round_off").val();
        let round_off = 0;
        round_off = total_round_off.length > 0 ? parseFloat(total_round_off) : 0.00

        total_amts += round_off


        $("#total_grand").html(total_amts.toFixed(2))            
        


    }

    function calcSingle(entity) {
        let total = 0;
        entity.forEach((v)=>{
            total += v.value.length > 0 ? parseFloat(v.value) : 0.00  
        })
        return total
    }

    function generateInvoice() {
        let url = '{{ route('generateInvoice') }}';
        $.ajax({
            url: url, // The URL defined in your routes
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ), // CSRF Token
            },
            data:{
            },
            success: function (response) {
                window.location.href = response.zipUrl;                
            },
            error: function(err){

            }
        });                            
    }
</script>
