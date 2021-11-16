
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Limit/ Today Win Number</title>
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
            <h1 class="m-0">Today Win Number</h1>
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

        <div class="row">
          <div class="col-12">
              
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap" >
                  <thead>
                    <tr>
                      <th>Type</th>
                      <th>Limit Amount</th>
                      <th><b>Actions</b></th>
                    </tr>
                  </thead>
                  <tbody>

                @if ( $limits )
                @foreach ($limits as $limit)
                    <tr>
                      <td>{{ $limit['type'] }}</td>
                      <td>{{ $limit['limit'] }}</td>  
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLimit" data-whatever="@mdo">Edit</button>

                          <div class="modal fade" id="exampleModalLimit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabelLimit">Update Limit Amount</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form action="{{ route('compensate.limit.update', $limit['id']) }}" method="POST">
                                  @csrf
                                  @method('POST')
                                <div class="modal-body">
                                    <div class="form-group">
                                      <label for="password" class="col-form-label">Password</label>
                                      <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                    <div class="form-group">
                                      <label for="limit" class="col-form-label">Limit Amount</label>
                                      <input type="text" class="form-control" id="limit" name="limit" value="@isset($limit){{ $limit['limit'] }}@endisset">
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Change Now</button>
                                </div>
                                </form>
                              </div>
                            </div>
                          </div>

                        </td>
                    </tr>
                @endforeach
                @endif
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
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap" >
                  <thead>
                    <tr>
                      <th>D3D</th>
                      <th>SET</th>
                      <th>VALUE</th>
                      <th>date</th>
                      <th>time</th>
                      <th><b>Actions</b></th>
                    </tr>
                  </thead>
                  <tbody>

                @if ( $noons )
                @foreach ($noons as $noon)
                    <tr>
                      <td>{{ $noon['3D'] }}</td>
                      <td>{{ $noon['set'] }}</td>
                      <td>{{ $noon['value'] }}</td>
                      <td>{{ $noon['date'] }}</td>
                      <td>{{ $noon['time'] }}</td>
                      
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{ $noon['id'] }}" data-whatever="@mdo">Edit</button>

                          <div class="modal fade" id="exampleModal{{ $noon['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel{{ $noon['id'] }}">Update Number</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form action="{{ route('compensate.number.update', $noon['id']) }}" method="POST">
                                  @csrf
                                  @method('POST')
                                <div class="modal-body">
                                    <div class="form-group">
                                      <label for="password" class="col-form-label">Password</label>
                                      <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                    <div class="form-group">
                                      <label for="d3d" class="col-form-label">Win Number</label>
                                      <input type="text" class="form-control" id="d3d" name="d3d" value="@isset($noon) {{ $noon['3D'] }} @endisset">
                                    </div>
                                    <div class="form-group">
                                      <label for="set" class="col-form-label">SET</label>
                                      <input type="text" class="form-control" id="set" name="set" value="@isset($noon) {{ $noon['set'] }} @endisset">
                                    </div>
                                    <div class="form-group">
                                      <label for="value" class="col-form-label">VALUE</label>
                                      <input type="text" class="form-control" id="value" name="value" value="@isset($noon) {{ $noon['value'] }} @endisset">
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Confirm Now</button>
                                </div>
                                </form>
                              </div>
                            </div>
                          </div>

                        </td>
                    </tr>
                @endforeach
                @endif
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
