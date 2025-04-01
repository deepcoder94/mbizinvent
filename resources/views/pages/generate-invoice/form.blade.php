<x-layout>
    <div class="app-content mt-3">
        <section class="content">
            <div class="container-fluid">
              <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Generate Invoice</h3>
                    </div>
                    <div class="card-body">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Customer Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="customer_id">Select Customer</label>
                                            <select name="customer_id" id="customer_id" class="form-control">
                                                @forelse ($customers as $c)
                                                    <option value="{{ $c->id }}">{{ $c->customer_name }}</option>
                                                @empty
                                                    <option value=""></option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="invoice_number">Invoice Number</label>
                                            <input type="text" name="invoice_number" id="invoice_number" class="form-control" value="MM-{{ $invoiceCount }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="invoice_date">Invoice Date</label>
                                            <input type="text" name="invoice_date" id="invoice_date" class="form-control datepicker">
                                        </div>
                                    </div>                            
                                </div>
        
                            </div>
                        </div>
                        <div class="card card-success mt-3">
                            <div class="card-header">
                                <h3 class="card-title">Product Information</h3>
                            </div>
                            <div class="card-body">
                                <button class="btn btn-primary" onclick="addProduct()">Add Product</button>
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Rate</th>
                                            <th>Gross Total</th>
                                            <td>Discount</td>
                                            <td>Taxable Value</td>
                                            <th>Tax Rate <br/> (%)</th>
                                            <th>Total</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody id="invoice_product_tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card card-dark mt-3">
                            <div class="card-header">
                                <h3 class="card-title">Total Information</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th>Quantity</th>
                                            <th>Rate</th>
                                            <th>Gross Total</th>
                                            <td>Discount</td>
                                            <td>Taxable Value</td>
                                            <th>CGST <br/>%</th>
                                            <th>SGST</th>
                                            <th>Round Off</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    @include('pages.generate-invoice.total-invoice')


                                </table>                                

                            </div>
                        </div>

                        <button class="btn btn-primary mt-3" onclick="generateInvoice()">Generate Invoice</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </section>
    </div>
    @include('pages.generate-invoice.scripts')
</x-layout>