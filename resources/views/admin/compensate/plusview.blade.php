
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Compensation</title>
  @include('layouts.header')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">


  @include('layouts.nav')

  <!-- /.navbar -->

  
  @include('layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">2D Plus Compensation</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
          <li><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Compensate</button></li>
</ol>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Compensate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('compensate.twodplus') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
      <div class="modal-body">
          <div class="form-group">
            <label for="password" class="col-form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Confrim</button>
      </div>
      </form>
    </div>
  </div>
</div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

      <div class="row">
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $winNumberNoon }}</h3>

                <p>Morning Win Number</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $winNumberEven }}</h3>

                <p>Evening Win Number</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          
        </div>

      <div class="row">
            <div class="col-lg-12">
            @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
        @if($errors->any())
        <div class="alert alert-danger" role="alert">
            {{$errors->first()}}
        </div>
        @endif
</div>
        </div>

        <div class="row">
          <div class="col-12">
          
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">12:01 PM Compensation</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap" id="myTable">
                  <thead>
                    <tr>
                      <th>UserId</th>
                      <th>BetSlip ID</th>
                      <th>Win Number</th>
                      <th>Amount</th>
                      <th>Compensation Amount</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach($winslips as $winslip)
                    <tr>
                      <td>{{ $winslip['user']['phone-number'] }}</td>
                      <td>{{ $winslip['betslip']['id'] }}</td>
                      <td>{{ $winslip['betinteger']['integer'] }}</td>
                      <td>{{ $winslip['betinteger']['amount'] }}</td>
                      <td>{{ $winslip['betinteger']['amount'] * 85 }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <div class="row">
          <div class="col-12">
              
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">4:31 PM Compensation</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap" id="myTable">
                  <thead>
                    <tr>
                      <th>UserId</th>
                      <th>BetSlip ID</th>
                      <th>Win Number</th>
                      <th>Amount</th>
                      <th>Compensation Amount</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach($winslipsEven as $winslipEven)
                    <tr>
                      <td>{{ $winslipEven['user']['phone-number'] }}</td>
                      <td>{{ $winslipEven['betslip']['id'] }}</td>
                      <td>{{ $winslipEven['betinteger']['integer'] }}</td>
                      <td>{{ $winslipEven['betinteger']['amount'] }}</td>
                      <td>{{ $winslipEven['betinteger']['amount'] * 85 }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  @include('layouts.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('js/app.js') }}" ></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js">
    </script>
<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
</body>
</html>
