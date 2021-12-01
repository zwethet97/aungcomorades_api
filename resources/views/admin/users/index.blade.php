
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
            <h1 class="m-0">Users</h1>
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

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $totalAmount }} Ks</h3>

                <p>Total User Amount</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $todayusers }}</h3>

                <p>Today Register</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $todaysilver }}</h3>

                <p>Today Subscriber</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $total }}</h3>

                <p>Total Users</p>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
      

        <div class="row">
          <div class="col-12">
              
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap" id="myTable">
                  <thead>
                    <tr>
                      <th>Phone Number</th>
                      <th>Username</th>
                      <th>Referral Code</th>
                      <th>User Level</th>
                      <th>Credits</th>
                      <th><b>Actions</b></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($users as $user)
                    <tr>
                      <td>{{ $user['phone-number'] }}</td>
                      <td>{{ $user['username'] }}</td>
                      <td>{{ $user['referral-code'] }}</td>
                      <td>{{ $user['user-level'] }}</td>
                      <td>{{ $user['credits'] }}</td>
                      <td>
                          <a href="{{ route('users.betslip', $user->id) }}" class="btn btn-sm btn-success" role="button">Betslips</a>
                          <a href="{{ route('users.transaction', $user->id) }}" class="btn btn-sm btn-success" role="button">Transaction</a>
                          <a href="{{ route('users.referral', $user['referral-code']) }}" class="btn btn-sm btn-success" role="button">Referrals</a>

                          <button type="button" class="btn btn-primary btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal{{ $user->id }}" data-whatever="@mdo">Deposit</button>

                          <div class="modal fade" id="exampleModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Deposit {{ $user['phone-number'] }}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form action="{{ route('users.deposit.update', $user->id) }}" method="POST">
                                  @csrf
                                  @method('POST')
                                <div class="modal-body">
                                    <div class="form-group">
                                      <label for="password" class="col-form-label">Admin Password</label>
                                      <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="form-group">
                                      <label for="amount" class="col-form-label">Deposit Amount</label>
                                      <div class="input-group">
                                        <input type="text" class="form-control" id="amount" name="amount" required>
                                        <div class="input-group-append">
                                          <span class="input-group-text"><i class="fas fa-plus"></i></span>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Deposit Now</button>
                                </div>
                                </form>
                              </div>
                            </div>
                          </div>

                          <button type="button" class="btn btn-primary btn-sm btn-warning" data-toggle="modal" data-target="#exampleModalwi{{ $user->id }}" data-whatever="@mdo">Withdraw</button>

                          <div class="modal fade" id="exampleModalwi{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Withdraw {{ $user['phone-number'] }}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form action="{{ route('users.withdraw.update', $user->id) }}" method="POST">
                                  @csrf
                                  @method('POST')
                                <div class="modal-body">
                                    <div class="form-group">
                                      <label for="password" class="col-form-label">Admin Password</label>
                                      <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="form-group">
                                      <label for="amount" class="col-form-label">Withdraw Amount</label>
                                      <div class="input-group">
                                        <input type="text" class="form-control" id="amount" name="amount" required>
                                        <div class="input-group-append">
                                          <span class="input-group-text"><i class="fas fa-minus"></i></span>
                                        </div>
                                      </div>
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



                        <!--    <button type="button" class="btn btn-sm btn-danger" onclick="event.preventDefault();document.getElementById('delete-user-form-{{ $user->id }}').submit()">-->
                        <!--    <i class="fas fa-trash-alt"></i>-->
                        <!--</button>-->
                            <form id="delete-user-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id ) }}" method="POST" style="display:none">
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
