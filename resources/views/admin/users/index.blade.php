
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

          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $todayusers }}</h3>

                <p>Today Register</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $todaysilver }}</h3>

                <p>Today Subscriber</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-6">
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
                <table class="table table-hover text-nowrap">
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
                          <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-success" role="button">Edit</a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="event.preventDefault();document.getElementById('delete-user-form-{{ $user->id }}').submit()">
                            Delete
                        </button>
                            <form id="delete-user-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id ) }}" method="POST" style="display:none">
                                @csrf
                                @method("DELETE")
                            </form>
                    </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                {{ $users->links() }}

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
</body>
</html>
