
        <form action="" id="addEditForm" method="post">
            <div class="form-group">
                <label for="customer_name">Customer Name</label>
                <input type="text" class="form-control" name="customer_name" id="customer_name" value="{{ $customer->customer_name ?? ''  }}" onkeyup="revalidateForm('customer_name')" />
                <span id="customer_name-error" class="error invalid-feedback d-none" ></span>
              </div>
              <div class="form-group mt-2">
                <label for="address">Address</label>
                <input type="text" class="form-control" name="address" id="address" value="{{ $customer->address ?? ''  }}" value="" />
                <span id="address-error" class="error invalid-feedback d-none" ></span>
              </div>
              <div class="form-group mt-2">
                  <label for="state">State</label>
                  <input type="text" class="form-control" name="state" id="state" value="{{ $customer->state ?? ''  }}" value="" />
                <span id="state-error" class="error invalid-feedback d-none" ></span>
              </div>
              <div class="form-group mt-2">
                  <label for="state_code">State Code</label>
                  <input type="text" class="form-control" name="state_code" id="state_code" value="{{ $customer->state_code ?? '' }}" value="" />
                <span id="state_code-error" class="error invalid-feedback d-none" ></span>
              </div>                            
              <div class="form-group mt-2">
                <label for="city">City</label>
                <input type="text" class="form-control" name="city" id="city" value="{{ $customer->city ?? '' }}" value="" />
                <span id="city-error" class="error invalid-feedback d-none" ></span>
              </div>                          
              <div class="form-group mt-2">
                <label for="phone">Phone</label>
                <input type="text" class="form-control"  name="phone" id="phone" value="{{ $customer->phone ?? ''  }}" value="" />
                <span id="phone-error" class="error invalid-feedback d-none" ></span>
              </div>                                                                  
              <div class="form-group mt-2">
                <label for="gstin_number">GSTIN Number</label>
                <input type="text" class="form-control" name="gstin_number" id="gstin_number" value="{{ $customer->gstin_number ?? ''  }}" value=""/>
                <span id="gstin_number-error" class="error invalid-feedback d-none" ></span>

              </div>                                
              <div class="form-group mt-2">
                <label for="pan_number">PAN Number</label>
                <input type="text" class="form-control" name="pan_number" id="pan_number" value="{{ $customer->pan_number  ?? '' }}" value="" />
                <span id="pan_number-error" class="error invalid-feedback d-none" ></span>

              </div>               
            </form>