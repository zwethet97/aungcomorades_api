
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tips</title>
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
            <h1 class="m-0">Schedule Tips</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
          <li><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">+ Create</button></li>
</ol>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Tip Schedule</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('tips.daily.create') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
      <div class="modal-body">
          <div class="form-group">
            <label for="date" class="col-form-label">Date</label>
            <input type="text" class="form-control" id="tipuser_id" name="tipuser_id" value="{{ $tipuser_id }}" style="display:none">
            <input type="text" class="form-control" id="date" name="date">
          </div>
          <div class="form-group">
            <label for="bannerOne" class="col-form-label">Banner Image One</label>
            <input type="file" class="form-control" id="bannerOne" name="bannerOne">
          </div>
          <div class="form-group">
            <label for="descriptionOne" class="col-form-label">Description One</label>
            <textarea class="form-control" name="descriptionOne" rows="4"></textarea>
          </div>
          <div class="form-group">
            <label for="bannerTwo" class="col-form-label">Banner Image Two</label>
            <input type="file" class="form-control" id="bannerTwo" name="bannerTwo">
          </div>
          <div class="form-group">
            <label for="descriptionTwo" class="col-form-label">Description Two</label>
            <textarea class="form-control" name="descriptionTwo" rows="4"></textarea>
          </div>
          <div class="form-group">
            <label for="bannerThree" class="col-form-label">Banner Image Three</label>
            <input type="file" class="form-control" id="bannerThree" name="bannerThree">
          </div>
          <div class="form-group">
            <label for="descriptionThree" class="col-form-label">Description Three</label>
            <textarea class="form-control" name="descriptionThree" rows="4"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
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
                      <th>Date</th>
                      <th>Banner</th>
                      <th>Description One</th>
                      <th>Banner Two</th>
                      <th>Description Two</th>
                      <th>Banner Three</th>
                      <th>Description Three</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($tips as $tip)
                    <tr>
                      <td>{{ $tip['date'] }}</td>
                      <td><a href="" data-toggle="modal" data-target="#one{{ $tip->id }}">Banner Image</a>
                    
                    <div class="modal fade" id="one{{ $tip->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="one{{ $tip->id }}">Banner Image One</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <img src="{{ url('/tipBanner/'.$tip['bannerImageOne']) }}" width="100%"/>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>
                    </td>
                      <td style="max-width: 200px;
    overflow: auto;">{{ $tip['imageOneDescription'] }}</td>
                    <td><a href="" data-toggle="modal" data-target="#two{{ $tip->id }}">Banner Image Two</a>
                    
                    <div class="modal fade" id="two{{ $tip->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="two{{ $tip->id }}">Banner Image Two</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <img src="{{ url('/tips/'.$tip['bannerImageTwo']) }}" width="100%"/>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>
                    </td>
                      <td style="max-width: 200px;
    overflow: auto;">{{ $tip['imageTwoDescription'] }}</td>
                    <td><a href="" data-toggle="modal" data-target="#three{{ $tip->id }}">Banner Image Three</a>
                    
                    <div class="modal fade" id="three{{ $tip->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="three{{ $tip->id }}">Banner Image Three</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <img src="{{ url('/tipBanner/'.$tip['bannerImageThree']) }}" width="100%"/>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>
                    </td>
                      <td style="max-width: 200px;
    overflow: auto;">{{ $tip['imageThreeDescription'] }}</td>
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
