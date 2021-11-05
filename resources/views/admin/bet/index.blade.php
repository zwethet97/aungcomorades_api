
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bets</title>
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
            <h1 class="m-0">Bets <span class="badge bg-secondary">{{ $date }}</span> <span class="badge bg-secondary bg-success">{{ $time }}</span> </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
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
      
      
        <h3><span class="badge bg-secondary">D2D Bets</span></h3>
        <div class="row">
          
          <div class="col-4">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Bet Integer</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($lows as $low)
                    <tr>
                      <td>{{ $low['integer'] }}</td>
                      <td>{{ $low['amount'] }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-4">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Bet Integer</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($mids as $mid)
                    <tr>
                      <td>{{ $mid['integer'] }}</td>
                      <td>{{ $mid['amount'] }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-4">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Bet Integer</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($highs as $high)
                    <tr>
                      <td>{{ $high['integer'] }}</td>
                      <td>{{ $high['amount'] }}</td>
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
        <hr>
        <h3><span class="badge bg-secondary">D3D Bets</span></h3>
        <div class="row">
          
          <div class="col-4">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Bet Integer</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($low3s as $low3)
                    <tr>
                      <td>{{ $low3['integer'] }}</td>
                      <td>{{ $low3['amount'] }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-4">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Bet Integer</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($mid3s as $mid3)
                    <tr>
                      <td>{{ $mid3['integer'] }}</td>
                      <td>{{ $mid3['amount'] }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-4">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Bet Integer</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($high3s as $high3)
                    <tr>
                      <td>{{ $high3['integer'] }}</td>
                      <td>{{ $high3['amount'] }}</td>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css">
<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
<script>
	$(document).ready(function(){
		var date_input=$('input[name="date"]'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			format: 'dd.mm.yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
		})
	})
</script>
</body>
</html>

