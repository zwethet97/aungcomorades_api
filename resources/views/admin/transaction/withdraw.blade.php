
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Withdraw Request</title>
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
            <h1 class="m-0">Withdraw Requests</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>
            </ol>
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
        <div class="row">
            
          <div class="col-12">
              
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap" id="myTable">
                  <thead>
                    <tr>
                      <th>User ID</th>
                      <th>Name</th>
                      <th>Current Amount</th>
                      <th>Platform</th>
                      <th>Account Number</th>
                      <th>Withdraw Amount</th>
                      <th><b>Actions</b></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($withdraws as $withdraw)
                    <tr>
                      <td>{{ $withdraw['user']['phone-number'] }}</td>
                      <td>{{ $withdraw['user']['username'] }}</td>
                      <td>{{ $withdraw['user']['credits'] }}</td>
                      <td>{{ $withdraw['withdrawl']['platform'] }}</td>
                      <td>{{ $withdraw['withdrawl']['accountnumber'] }}</td>
                      <td>{{ $withdraw['withdrawl']['amount'] }}</td>
                        <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{ $withdraw['withdrawl']['id'] }}" data-whatever="@mdo">Withdraw</button>

                          <div class="modal fade" id="exampleModal{{ $withdraw['withdrawl']['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel{{ $withdraw['withdrawl']['id'] }}">Withdraw {{ $withdraw['user']['phone-number'] }}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form action="{{ route('transaction.withdraw.update', $withdraw['withdrawl']['id']) }}" method="POST">
                                  @csrf
                                  @method('POST')
                                <div class="modal-body">
                                    <div class="form-group">
                                      <label for="phonenumber" class="col-form-label">User Phone Number</label>
                                      <input type="text" class="form-control" id="phonenumber" name="phonenumber" value="{{ $withdraw['user']['phone-number'] }}" disabled>
                                    </div>
                                    <div class="form-group">
                                      <label for="depositamount" class="col-form-label">Withdraw Amount</label>
                                      <input type="text" class="form-control" id="depositamount" name="amount" value="@isset($withdraw['withdrawl']) {{ $withdraw['withdrawl']['amount'] }} @endisset" >
                                    </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Withdraw Now</button>
                                </div>
                                </form>
                              </div>
                            </div>
                          </div>
                          
                           <button type="button" class="btn btn-sm btn-danger" onclick="event.preventDefault();document.getElementById('delete-user-form-{{ $withdraw['withdrawl']['id'] }}').submit()">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                            <form id="delete-user-form-{{ $withdraw['withdrawl']['id'] }}" action="{{ route('transaction.record.delete', $withdraw['withdrawl']['id'] ) }}" method="POST" style="display:none">
                                @csrf
                                @method("DELETE")
                            </form>

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
