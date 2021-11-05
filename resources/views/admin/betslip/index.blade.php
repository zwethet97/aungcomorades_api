
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
          </div><!-- /.col -->
          <!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      
      

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
