
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Users</title>
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
            <h1 class="m-0">BetSlips</h1>
          </div>
          <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
          <li><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1" data-whatever="@mdo">Change Noon Slips</button></li>
          <li><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2" data-whatever="@mdo">Change Even Slips</button></li>
</ol>
</div>
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Change Noon Slips</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('compensate.noon') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
</div>
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel2">Change Even Slips</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('compensate.even') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
</div>
          
          <!-- /.col -->
          <!-- /.col -->
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
      <div class="row">

          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $nooncount }} </h3>

                <p>Today Noon Ongoing Slips</p>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $evencount }}</h3>

                <p>Today Evening Ongoing Slips</p>
              </div>
            </div>
          </div>

          
          <!-- ./col -->
        </div>
      
      

        <div class="row">
          <div class="col-12">
              
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-hover text-nowrap" id="myTable">
                  <thead>
                    <tr>
                      <th>UserId</th>
                      <th>Type</th>
                      <th>for Date/Time</th>
                      <th>Bet Numbers</th>
                      <th>Total Selected Numbers</th>
                      <th>Total Amount</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($betslips as $betslip)
                    <tr>
                      <td>{{ $betslip['userId'] }}</td>
                      <td>{{ $betslip['type'] }}</td>
                      <td>{{ $betslip['forDate'] }} {{ $betslip['forTime'] }}</td>
                      <td>{{ $betslip['bet-numbers'] }}</td>
                      <td>{{ $betslip['selected-total-number'] }}</td>
                      <td>{{ $betslip['total-bet-amount'] }}</td>
                      <td>{{ $betslip['status'] }}</td>
                      <td>
                          <a href="{{ route('betslips.show', $betslip->id) }}" class="btn btn-sm btn-success" role="button">View Detail</a>
                            <!-- <button type="button" class="btn btn-sm btn-danger" onclick="event.preventDefault();document.getElementById('delete-user-form-{{ $betslip->id }}').submit()">
                            Delete
                        </button>
                            <form id="delete-user-form-{{ $betslip->id }}" action="{{ route('betslips.destroy', $betslip->id ) }}" method="POST" style="display:none">
                                @csrf
                                @method("DELETE")
                            </form> -->
                    </td>
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
