
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rewards</title>
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
            <h1 class="m-0">Rewards </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li><form action="{{ route('reward.twod.submit') }}" method="POST">
                    @csrf
                    @method('POST')
                <button type="submit" class="btn btn-sm btn-success">Reward All Users</button>
</li>
            </li>
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
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-9">
                    <h3 class="card-title">Rewards {{ $start }} - {{ $end }}</h3>
                    </div>
                    <div class="col-lg-3">
                    
                    </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap" id="myTable">
                  <thead>
                    <tr>
                      <th>UserId</th>
                      <th>Bet Total Amount</th>
                      <th>Reward Amount</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach($rewards as $reward)
                    <tr>
                      <td>{{ $reward['user']['phone-number'] }}</td>
                      <td>{{ $reward['amount'] }}</td>
                      <td>{{ $reward['rewardAmount'] }}</td>
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
                <div class="row">
                    <div class="col-lg-9">
                    <h3 class="card-title">Referrals {{ $start }} - {{ $end }}</h3>
                    </div>
                    <div class="col-lg-3">
                    
                    </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap" id="myTable">
                  <thead>
                    <tr>
                      <th>Referral UserId</th>
                      <th>Bet Total Amount</th>
                      <th>Referral Amount</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach($referrals as $referral)
                    <tr>
                      <td>{{ $referral['user']['phone-number'] }}</td>
                      <td>{{ $referral['amount'] }}</td>
                      <td>{{ $referral['rewardAmount'] }}</td>
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
