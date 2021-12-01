
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aung Pwal | Dashboard</title>
  @include('layouts.header')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">


  @include('layouts.nav')

  <!-- /.navbar -->

  
  @include('layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="min-height: 1604.8px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Contacts</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body pb-0">
          <div class="row">
            <div class="col-12 col-sm-6 col-md-6 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                <span class="badge bg-secondary">{{ $date }}</span>
                <span class="badge bg-secondary bg-success">12:01</span>

                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-12">
                      <br>
                      <h2 class="lead" style="text-align:right"><b>Win No. {{ $winNumberNoon }}</b></h2>
                      <br>
                      <div class="row">
                        <div class="col-lg-6">
                        Commission
                        </div>
                        <div class="col-lg-6">
                         <h6 style="text-align:right"> {{ $NoonSlipAmount * 0.15 }} </h6>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                        Total Sale
                        </div>
                        <div class="col-lg-6">
                         <h6 style="text-align:right"> {{ $NoonSlipAmount }} </h6>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          Win Amount
                        </div>
                        <div class="col-lg-6">
                         <p style="text-align:right"> {{ $winAmount }}</p>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                        Payout
                        </div>
                        <div class="col-lg-6">
                         <h6 style="text-align:right"> {{ $payout }} </h6>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-lg-6">
                        Total Profit
                        </div>
                        <div class="col-lg-6">
                         <h6 style="text-align:right"> {{ $NetProfit }} </h6>
                        </div>
                      </div>
                    </div>
                    
                    
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <form action="{{ route('bet.view') }}" method="POST">
                      @csrf
                      @method('POST')
                    <input type="text" name="date" value="{{ $date }}" style="display:none"/>
                    <input type="text" name="time" value="12:01 PM" style="display:none"/>
                    <button type="submit" class="btn btn-sm btn-primary">
                      <i class="fas fa-user"></i> View Details
                    </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-6 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                <span class="badge bg-secondary">{{ $date }}</span>
                <span class="badge bg-secondary bg-success">4:31</span>

                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-12">
                      <br>
                      <h2 class="lead" style="text-align:right"><b>Win No. {{ $winNumberEven }}</b></h2>
                      <br>
                      
                      <div class="row">
                        <div class="col-lg-6">
                        Commission
                        </div>
                        <div class="col-lg-6">
                         <h6 style="text-align:right"> {{ $EvenSlipAmount * 0.15 }} </h6>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                        Total Sale
                        </div>
                        <div class="col-lg-6">
                         <h6 style="text-align:right"> {{ $EvenSlipAmount }} </h6>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          Win Amount
                        </div>
                        <div class="col-lg-6">
                         <p style="text-align:right"> {{ $winEvenAmount }}</p>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                        Payout
                        </div>
                        <div class="col-lg-6">
                         <h6 style="text-align:right"> {{ $evenPayout }} </h6>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-lg-6">
                        Total Profit
                        </div>
                        <div class="col-lg-6">
                         <h6 style="text-align:right"> {{ $EvenNetProfit }} </h6>
                        </div>
                      </div>
                    </div>
                    
                    
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                  <form action="{{ route('bet.view') }}" method="POST">
                      @csrf
                      @method('POST')
                    <input type="text" id="date" name="date" value="{{ $date }}" style="display:none"/>
                    <input type="text" id="time" name="time" value="4:30 PM" style="display:none"/>
                    <button type="submit" class="btn btn-sm btn-primary">
                      <i class="fas fa-user"></i> View Details
                    </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-6 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                <span class="badge bg-secondary">{{ $tdate }}</span>
                <span class="badge bg-secondary bg-success">12:01</span>

                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-12">
                      <br>
                      <div class="row">
                        <div class="col-lg-6">
                        Total Sale
                        </div>
                        <div class="col-lg-6">
                         <h6 style="text-align:right"> {{ $tmrNoonSlipAmount }} </h6>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                        Commission
                        </div>
                        <div class="col-lg-6">
                         <h6 style="text-align:right"> {{ $tmrNoonSlipAmount * 0.15 }} </h6>
                        </div>
                      </div>
                      
                      <hr>
                      <div class="row">
                        <div class="col-lg-6">
                        Total Profit
                        </div>
                        <div class="col-lg-6">
                         <h6 style="text-align:right"> {{ $tmrNoonSlipAmount * 0.15 }} </h6>
                        </div>
                      </div>
                    </div>
                    
                    
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                  <form action="{{ route('bet.view') }}" method="POST">
                      @csrf
                      @method('POST')
                    <input type="text" name="date" value="{{ $tdate }}" style="display:none"/>
                    <input type="text" name="time" value="12:01 PM" style="display:none"/>
                    <button type="submit" class="btn btn-sm btn-primary">
                      <i class="fas fa-user"></i> View Details
                    </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-12 col-sm-6 col-md-6 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                <span class="badge bg-secondary">{{ $tdate }}</span>
                <span class="badge bg-secondary bg-success">4:30</span>

                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-12">
                      <br>
                      <div class="row">
                        <div class="col-lg-6">
                        Total Sale
                        </div>
                        <div class="col-lg-6">
                         <h6 style="text-align:right"> {{ $tmrEvenSlipAmount }} </h6>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                        Commission
                        </div>
                        <div class="col-lg-6">
                         <h6 style="text-align:right"> {{ $tmrEvenSlipAmount * 0.15 }} </h6>
                        </div>
                      </div>
                      
                      <hr>
                      <div class="row">
                        <div class="col-lg-6">
                        Total Profit
                        </div>
                        <div class="col-lg-6">
                         <h6 style="text-align:right"> {{ $tmrEvenSlipAmount * 0.85 }} </h6>
                        </div>
                      </div>
                    </div>
                    
                    
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                  <form action="{{ route('bet.view') }}" method="POST">
                      @csrf
                      @method('POST')
                    <input type="text" name="date" value="{{ $tdate }}" style="display:none"/>
                    <input type="text" name="time" value="4:30 PM" style="display:none"/>
                    <button type="submit" class="btn btn-sm btn-primary">
                      <i class="fas fa-user"></i> View Details
                    </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

    </section>
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
