
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tablero Principal
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Principal</a></li>
        <li class="active">Tablero Principal</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <?php if($is_admin == true): ?>

        <div class="row">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?php echo $total_lotes ?></h3>

                <p>Lotes</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo base_url('lotes/') ?>" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3><?php echo $total_salidas ?></h3>

                <p>Pedidos Facturados</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('salidas/') ?>" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3><?php echo $total_users; ?></h3>

                <p>Panel de Usuarios</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-people"></i>
              </div>
              <a href="<?php echo base_url('users/') ?>" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3><?php echo $total_almacenes ?></h3>

                <p>Almacenes</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-home"></i>
              </div>
              <a href="<?php echo base_url('almacenes/') ?>" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      <?php endif; ?>
    </section>

    <section>
      <canvas id="myChart" width="auto" height="auto"></canvas>
    </section>

      <script>
          // var ctx = document.getElementById("myChart").getContext('2d');
          // var f_month = moment().format('M');
          // var months = moment()._locale.months();

          // // for (var i = 0, len = months.length; i<len; i++)
          // //     console.log(months.slice(i,i-1).concat(months.slice(0, Math.max(i+1-len, 0)).join(",")));
          // //
          // // console.log(months);
          // // console.log(f_month);
          // var myChart = new Chart(ctx, {
          //     type: 'bar',
          //     data: {
          //         labels: months,
          //         datasets: [{
          //             label: '# de Salida',
          //             data: [12, 19, 3, 5, 2, 3],
          //             backgroundColor: [
          //                 'rgba(255, 99, 132, 0.2)',
          //                 'rgba(54, 162, 235, 0.2)',
          //                 'rgba(255, 206, 86, 0.2)',
          //                 'rgba(75, 192, 192, 0.2)',
          //                 'rgba(153, 102, 255, 0.2)',
          //                 'rgba(255, 159, 64, 0.2)'
          //             ],
          //             borderColor: [
          //                 'rgba(255,99,132,1)',
          //                 'rgba(54, 162, 235, 1)',
          //                 'rgba(255, 206, 86, 1)',
          //                 'rgba(75, 192, 192, 1)',
          //                 'rgba(153, 102, 255, 1)',
          //                 'rgba(255, 159, 64, 1)'
          //             ],
          //             borderWidth: 1
          //         }]
          //     },
          //     options: {
          //         scales: {
          //             yAxes: [{
          //                 ticks: {
          //                     beginAtZero:true
          //                 }
          //             }]
          //         }
          //     }
          // });
      </script>
        <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    $(document).ready(function() {
      $("#dashboardMainMenu").addClass('active');
    }); 
  </script>
