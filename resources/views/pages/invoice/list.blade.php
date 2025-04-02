<x-layout>
    <div class="app-content mt-3">
        <section class="content">
            <div class="container-fluid">
              <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Invoice List</h3>
      
                      <div class="card-tools d-flex">
                        <input type="text" name="" id="" class="form-control" placeholder="Search Product">
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Invoice No.</th>
                            <th>Customer Name</th>
                            <th>Invoice Total</th>
                            <th>Created Date</th>
                          </tr>
                        </thead>
                        <tbody>
                            @include('pages.invoice.single',['invoices'=>$invoices])
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
</x-layout>