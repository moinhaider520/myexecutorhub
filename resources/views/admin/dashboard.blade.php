@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <!-- Total Customers Card -->
          <div class="col-xl-6 col-sm-6">
            <div class="card">
              <div class="card-body student">
                <div class="d-flex gap-2 align-items-end">
                  <div class="flex-grow-1">
                    <h2>{{ number_format($totalCustomers) }}</h2>
                    <p class="mb-0 text-truncate">Total Customers</p>
                    <div class="d-flex student-arrow text-truncate">
                      <p class="mb-0 up-arrow bg-light-danger">
                        <i class="icon-arrow-down font-danger"></i>
                      </p>
                      <span class="f-w-500 font-danger">- 17.06%</span> than last 6 months
                    </div>
                  </div>
                  <div class="flex-shrink-0">
                    <img src="../assets/images/dashboard-4/icon/student.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Active Customers Card -->
          <div class="col-xl-6 col-sm-6">
            <div class="card">
              <div class="card-body student-2">
                <div class="d-flex gap-2 align-items-end">
                  <div class="flex-grow-1">
                    <h2>{{ number_format($ActiveCustomer) }}</h2>
                    <p class="mb-0 text-truncate">Active Customers</p>
                    <div class="d-flex student-arrow text-truncate">
                      <p class="mb-0 up-arrow bg-light-success">
                        <i class="icon-arrow-up font-success"></i>
                      </p>
                      <span class="f-w-500 font-success">+27.02%</span> than last 4 months
                    </div>
                  </div>
                  <div class="flex-shrink-0">
                    <img src="../assets/images/dashboard-4/icon/teacher.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Inactive Customers Card -->
          <div class="col-xl-6 col-sm-6">
            <div class="card">
              <div class="card-body student-3">
                <div class="d-flex gap-2 align-items-end">
                  <div class="flex-grow-1">
                    <h2>{{ number_format($nonActiveCustomer) }}</h2>
                    <p class="mb-0 text-truncate">Inactive Customers</p>
                    <div class="d-flex student-arrow text-truncate">
                      <p class="mb-0 up-arrow bg-light-success">
                        <i class="icon-arrow-up font-success"></i>
                      </p>
                      <span class="f-w-500 font-success">+12.01%</span> than last 8 months
                    </div>
                  </div>
                  <div class="flex-shrink-0">
                    <img src="../assets/images/dashboard-4/icon/calendar.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-sm-6">
            <div class="card">
              <div class="card-body student-4">
                <div class="d-flex gap-2 align-items-end">
                  <div class="flex-grow-1">
                    <h2>1,984</h2>
                    <p class="mb-0 text-truncate"> Revenue</p>
                    <div class="d-flex student-arrow text-truncate">
                      <p class="mb-0 up-arrow bg-light-danger"><i class="icon-arrow-down font-danger"></i></p><span class="f-w-500 font-danger">- 15.02%</span>than last 5 Month
                    </div>
                  </div>
                  <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/invoice.png" alt=""></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Customers List</h4>
                <span>List of all the Registered Customers.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Full Name</th>
                          <th>Email</th>
                          <th>Address</th>
                          <th>Contact Number</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($customers as $index => $customer)
                        <tr role="row" class="odd">
                          <td>{{ $index + 1 }}</td>
                          <td>{{ $customer->name }}</td>
                          <td>{{ $customer->email }}</td>
                          <td>{{ $customer->address ?? 'N/A'  }}</td>
                          <td>{{ $customer->contact_number ?? 'N/A' }}</td>
                          <td>{{ $customer->status == 'A' ? 'Active' : 'Inactive' }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid Ends-->
</div>
@endsection