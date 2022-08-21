<h1>Welcome to <?php echo $_settings->info('name') ?></h1>
<hr>
<section class="content">
<div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total registered vehicles</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM vehicle_registration")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
</section>