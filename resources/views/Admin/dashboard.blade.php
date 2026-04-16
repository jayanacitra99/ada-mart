@extends('Admin.layout')
@section('title')
    Dashboard
@endsection
@section('styles')
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{$orders}}</h3>

                  <p>Total Orders</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="{{url('admin/orders')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>{{$categories}}</h3>

                  <p>Category</p>
                </div>
                <div class="icon">
                  <i class="fas fa-tags"></i>
                </div>
                <a href="{{url('admin/categories')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{$promos}}</h3>

                  <p>Promo</p>
                </div>
                <div class="icon">
                  <i class="fas fa-percentage"></i>
                </div>
                <a href="{{url('admin/promos')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>{{$products}}</h3>

                  <p>Products</p>
                </div>
                <div class="icon">
                  <i class="fas fa-gifts"></i>
                </div>
                <a href="{{url('admin/products')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title">Monthly Recap Report</h5>
  
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <p class="text-center">
                      </p>
  
                      <div class="chart">
                        <!-- Sales Chart Canvas -->
                        <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                      </div>
                      <!-- /.chart-responsive -->
                    </div>
                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
    <!-- jQuery Mapael -->
    <script src="{{asset('')}}adminlte/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="{{asset('')}}adminlte/plugins/raphael/raphael.min.js"></script>
    <script src="{{asset('')}}adminlte/plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="{{asset('')}}adminlte/plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="{{asset('')}}adminlte/plugins/chart.js/Chart.min.js"></script>
    <script>
      $(function () {
        $.ajax({
          url: "{{ route('admin.orders.monthly') }}",
          type: "GET",
          dataType: "json",
          success: function (data) {
            var salesChartCanvas = $('#salesChart').get(0).getContext('2d');

            var salesChartData = {
              labels: data.months.map(function(month) {
                return moment(month, "YYYY-MM").format("MMM YY");
              }),
              datasets: [{
                label: 'Total Orders',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: 5, // Size of point marker
                pointBackgroundColor: 'rgba(60,141,188,0.8)', // Color of point marker
                pointBorderColor: 'rgba(60,141,188,1)', // Border color of point marker
                pointHoverRadius: 7, // Size of point marker on hover
                pointHoverBackgroundColor: 'rgba(60,141,188,1)', // Color of point marker on hover
                pointHoverBorderColor: 'rgba(60,141,188,1)', // Border color of point marker on hover
                data: data.orders,
                datasetTotals: data.totals,
              }]
            };

            var salesChartOptions = {
              maintainAspectRatio: false,
              responsive: true,
              legend: {
                display: false
              },
              scales: {
                xAxes: [{
                  gridLines: {
                    display: false
                  },
                  ticks: {
                    callback: function(value, index, values) {
                      return value; // this is where we get the 'M y' format
                    }
                  }
                }],
                yAxes: [{
                  gridLines: {
                    display: false
                  }
                }]
              },
              tooltips: {
                callbacks: {
                  label: function(tooltipItem, data) {
                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ': ' + tooltipItem.yLabel;
                  },
                  afterLabel: function(tooltipItem, data) {
                    return data.datasets[0].datasetTotals[tooltipItem.index];
                  }
                }
              }
            };

            var salesChart = new Chart(salesChartCanvas, {
              type: 'line',
              data: salesChartData,
              options: salesChartOptions
            });
          }
        });
      });
    </script>
@endsection
@section('end_scripts')
@endsection