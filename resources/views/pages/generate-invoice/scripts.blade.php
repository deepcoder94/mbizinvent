<script>
    var productCount = 0;
    var invProducts = new Set();
    var isValidForm = true;
    var setting_profit = 0;

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
                $('.sel2input').select2();
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
                    // $(`#product_rate_${id}`).val(response.data.rate)
                    $(`#max_qty_${id}`).html('Max Qty: '+response.data.stock.available_stock);
                    $(`#max_qty_f_${id}`).val(response.data.stock.available_stock);
                    $(`#gst_percentage_${id}`).val(response.data.gst_percentage);

                    setting_profit = response.profit
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

        
        let product_qty = parseFloat($(`#product_qty_${index}`).val());
        let product_mrp = parseFloat($(`#product_mrp_${index}`).val());
        let product_profit = parseFloat($(`#product_profit_${index}`).val());
        let product_discount = parseFloat($(`#product_discount_${index}`).val());
        let product_discount_amt = parseFloat($(`#product_discount_amt_${index}`).val());
        let gst_percentage = parseFloat($(`#gst_percentage_${index}`).val());


        let prod_amt = product_mrp / setting_profit // 1.16

        prod_amt = prod_amt / product_profit; // 1.06

        $(`#product_rate_${index}`).val(prod_amt.toFixed(3));



        prod_amt *= product_qty

        $(`#product_gross_total_${index}`).val(prod_amt.toFixed(3));

        let finalAmt = prod_amt
        let disc = (100+product_discount) / 100
        finalAmt /= disc

        finalAmt -= product_discount_amt


        let taxable_value = finalAmt.toFixed(3);
        $(`#product_taxable_value_${index}`).val(taxable_value);

        gst_perc = (100 + gst_percentage) / 100
        let withgst = (gst_percentage / 100) * finalAmt
        $(`#product_total_gst_${index}`).val(withgst);

        // finalAmt = finalAmt / gst_perc

        

        
        $(`#product_tax_rate_${index}`).val(gst_percentage);

        $("#product_cgst_perc_"+index).val(gst_percentage/2);
        $("#product_sgst_perc_"+index).val(gst_percentage/2);
        $("#product_cgst_"+index).val((withgst/2).toFixed(3));
        $("#product_sgst_"+index).val((withgst/2).toFixed(3));
        $("#product_sgst_"+index).val((withgst/2).toFixed(3));

        $(`#product_total_amt_${index}`).val(finalAmt.toFixed(3));


        // console.log(setting_profit);
        


        // let product_rate = $(`#product_rate_${index}`).val();
        // let product_gross_total = $(`#product_gross_total_${index}`).val();
        // let product_discount = $(`#product_discount_${index}`).val();
        // let product_taxable_value = $(`#product_taxable_value_${index}`).val();
        // let product_tax_rate = $(`#product_tax_rate_${index}`).val();
        // let max_qty = $(`#max_qty_f_${index}`).val();


        // product_qty = product_qty.length > 0 ? parseFloat(product_qty) : 0.00
        

        // product_rate = product_rate.length > 0 ? parseFloat(product_rate) : 0.00
        // product_gross_total = product_gross_total.length > 0 ? parseFloat(product_gross_total) : 0.00
        // product_discount = product_discount.length > 0 ? parseFloat(product_discount) : 0.00
        // product_taxable_value = product_taxable_value.length > 0 ? parseFloat(product_taxable_value) : 0.00
        // product_tax_rate = product_tax_rate.length > 0 ? parseFloat(product_tax_rate) : 0.00
        // max_qty = max_qty.length > 0 ? parseFloat(max_qty) : 0.00

        // if(product_qty < max_qty){
            
        //     isValidForm = true
        // }
        // else{
        //     isValidForm = false
        // }


        // let grosstotal = (product_qty*product_rate)
        
        // let taxableValue = (grosstotal-product_discount)

        // let addTax = (product_tax_rate / 100) * taxableValue;
        // $("#product_cgst_perc_"+index).val(product_tax_rate/2)
        // $("#product_sgst_perc_"+index).val(product_tax_rate/2)
        // $("#product_cgst_"+index).val((addTax/2).toFixed(3))
        // $("#product_sgst_"+index).val((addTax/2).toFixed(3))

        // let grandTotal = taxableValue + ((product_tax_rate / 100) * taxableValue) 
        
        // $(`#product_gross_total_${index}`).val(grosstotal.toFixed(3));
        // $(`#product_taxable_value_${index}`).val(taxableValue.toFixed(3))
        // $(`#product_total_amt_${index}`).val(grandTotal.toFixed(3));
        
        calcGroupTotal()
    }

    function calcGroupTotal() {
        let qtys = document.querySelectorAll('.product_qty');
        $("#total_quantity").html(calcSingle(qtys).toFixed(3))
        $("#total_quantity_h").val(calcSingle(qtys).toFixed(3))

        let total_discount = parseFloat($("#total_discount").val());
        let total_discount_amt = parseFloat($("#total_discount_amt").val());

        // let discounts = document.querySelectorAll('.product_discount');
        // $("#total_discount").html(calcSingle(discounts).toFixed(3))      
        // $("#total_discount_h").val(calcSingle(discounts).toFixed(3))            

        let taxable_values = document.querySelectorAll('.product_taxable_value');
        let total_taxable_value=calcSingle(taxable_values).toFixed(3);

        $("#total_taxable_value").html(calcSingle(taxable_values).toFixed(3))  
        $("#total_taxable_value_h").val(calcSingle(taxable_values).toFixed(3))            

        let product_gross_totals = document.querySelectorAll('.product_gross_total');
        let gross_total=calcSingle(product_gross_totals).toFixed(3);
        $("#total_gross_sum_h").val(gross_total);


        let tax_rates = document.querySelectorAll('.product_tax_rate');
        $("#total_cgst_perc_h").val((calcSingle(tax_rates)/2).toFixed(3));

        $("#total_sgst_perc_h").val((calcSingle(tax_rates)/2).toFixed(3));
        
        let product_cgst = document.querySelectorAll('.product_cgst');
        $("#total_cgst_h").val(calcSingle(product_cgst).toFixed(3));

        let product_sgst = document.querySelectorAll('.product_sgst');
        $("#total_sgst_h").val(calcSingle(product_sgst).toFixed(3));

        
        let product_total_amts = document.querySelectorAll('.product_total_amt');


        let total_amts = calcSingle(product_total_amts);
        
        total_amts -= ((total_discount / 100) * total_amts);
        total_amts -= total_discount_amt


        $("#total_taxable_value").html(total_amts.toFixed(3));  
        $("#total_taxable_value_h").val(total_amts.toFixed(3));            


        let total_round_off = $("#total_round_off").val();
        let round_off = 0;
        round_off = total_round_off.length > 0 ? parseFloat(total_round_off) : 0.00

        total_amts += round_off

        let product_total_gst = document.querySelectorAll('.product_total_gst');
        let total_gst=parseFloat(calcSingle(product_total_gst).toFixed(3));

        $("#total_gst").val(calcSingle(product_total_gst).toFixed(3));

        total_amts += total_gst;

        // total_amts -= taxDisc
        

        $("#total_grand").html(total_amts.toFixed(3));            
        $("#total_grand_h").val(total_amts.toFixed(3));            

        


    }

    function calcSingle(entity) {
        let total = 0;
        entity.forEach((v)=>{
            total += v.value.length > 0 ? parseFloat(v.value) : 0.00;  
        })
        return total
    }

    function generateInvoice() {
        if(!isValidForm){
            alert('Invalid Form. Please check the inputs');
            return;
        }

            let fData = new FormData($("#invForm")[0]);
            // let values = $("#invForm").serialize();
            
        let url = '{{ route('generateInvoice') }}';
        $.ajax({
            url: url, // The URL defined in your routes
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ), // CSRF Token
            },
            processData: false,  // Important for FormData
            contentType: false,  // Important for FormData            
            data:fData,
            success: function (response) {

                $("#invForm")[0].reset();
                $("#total_quantity").html(0)
                $("#total_quantity_h").html(0)
                $("#total_rate").html(0)
                $("#total_rate_h").html(0)
                $("#total_gross_sum").html(0)
                $("#total_gross_sum_h").html(0)
                $("#total_discount").html(0)
                $("#total_discount_h").html(0)
                $("#total_taxable_value").html(0)
                $("#total_taxable_value_h").html(0)
                $("#total_cgst_perc").html(0)
                $("#total_cgst_perc_h").html(0)
                $("#total_sgst_perc").html(0)
                $("#total_sgst_perc_h").html(0)
                $("#total_cgst").html(0)
                $("#total_cgst_h").html(0)
                $("#total_sgst").html(0)
                $("#total_sgst_h").html(0)
                $("#total_grand").html(0)
                $("#total_grand_h").html(0)
                document.querySelectorAll('.invoiceProducts').forEach(el => el.remove());
                invProducts.clear();
                productCount = 0
                window.location.href = response.zipUrl;  

            },
            error: function(err){

            }
        });                            
    }
</script>
