<x-layout>
    <div class="app-content mt-3">
        <section class="content">
            <div class="container-fluid">
              <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Inventory List</h3>
      
                      <div class="card-tools d-flex">
                        <input type="text" name="" id="" class="form-control" placeholder="Search Product">
                        <button class="btn btn-primary w-100" style="margin-left:11px" onclick="showAddInventoryModal()">Add Inventory</button>
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>HSN Code</th>
                            <th>Product Description</th>
                            <th>Available Stock</th>
                            <th>Buying Price</th>
                            <th>Updated Date</th>
                          </tr>
                        </thead>
                        <tbody>
                            @include('pages.inventory.single',['inventory'=>$inventory])
                        </tbody>
                      </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
      
                  <!-- /.card -->
                </div>

              <!-- /.row -->
            </div><!-- /.container-fluid -->
          </section>        
    </div>
    <script>
        function showAddInventoryModal(){
            let url = '{{ route('inventory.create') }}';
            let storeurl = '{{ route('inventory.store') }}'

            $.ajax({
                url: url, // The URL defined in your routes
                type: "GET",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ), // CSRF Token
                },
                success: function (response) {
                    $("#addEditModalBody").html(response)
                    $("#modalTitle").html('Add Inventory');
                    $("#addEditModal").modal('show');

                    validateAndSubmitFormFields(false,storeurl);
                    
                },
                error: function(err){

                }
            });
        }      
         
        function validateAndSubmitFormFields(isEdit,url){
            $("#addEditForm").on("submit", function(ev){
                ev.preventDefault();
                
                let values = $("#addEditForm").serializeArray();  
                let isFormValid = true;
                let errors = [];
                values.some((v)=>{
                    
                    if(v.value.length == 0){
                        errors.push({
                            key: v.name,
                            error: `${v.name} is required`
                        });
                        isFormValid = false
                    }                    
                });

                if(errors.length > 0){
                    
                    errors.some((er)=>{
                        let field = $(`#${er.key}`);
                        let errorField = $(`#${er.key}-error`);                        

                        field.addClass('is-invalid')
                        errorField.removeClass('d-none')
                        errorField.html(`${er.key} is required`);
                        
                    });
                }
                else{

                    $.ajax({
                        url:url,
                        type: isEdit ? 'PUT':'POST',
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ), // CSRF Token
                        },                        
                        data:values,
                        success: function(response){
                            if(response.success){
                                alert(response.message);
                                location.reload()
                            }
                        },
                        error: function(ev){
                            console.log(ev);
                            
                        }
                    });
                
                }                
                
                // console.log('submmited',values);
                        
                        
            });

        }        

        function revalidateForm(id){
            let elem = $("#"+id);
            let errorDiv = $(`#${id}-error`);
            if(elem.val().length > 0){
                elem.removeClass('is-invalid');
                errorDiv.addClass('d-none');
            }
            else{
                elem.addClass('is-invalid');
                errorDiv.removeClass('d-none');
                errorDiv.html(`${id} is required`)
            }
        }        
    </script>
</x-layout>