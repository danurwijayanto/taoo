<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Konten 1-->
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Log 
        <small>Situs Terpopuler</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Squid Proxy</a></li>
        <li class="active">Popular Site</li>
      </ol>
    </section>
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-12">
          <div class="box-body">
            <!-- KONTEN -->  
            <table id="pop_site" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>No</th>
                <th>Situs</th>
                <th>Hit</th>
              </tr>
            </thead>
            <tbody>
            <?php $i=1;foreach ($pop_site as $pop) {  
            ?>
              
              <tr>
                  <th><?php echo $i; ?></th>
                  <th><?php echo $pop['domain_tujuan']; ?></th>
                  <th><?php echo $pop['cnt']; ?></th>
              </tr>
            
            <?php $i++; } ?>
            </tbody>
            </table>
            <!-- END KONTEN -->
        </div>
      </div>
    </section>

    <!-- Konten 2-->
    <!-- Content Header (Page header) -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-12">
          <div class="box-body">
            <!-- KONTEN -->  
            <table id="pop_site_2" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>No</th>
                <th>Interface</th>
                <th>Situs</th>
                <th>Hit</th>
              </tr>
            </thead>
            <tbody>
            <?php $i=1;foreach ($stats as $stats) {  
            ?>
              
              <tr>
                  <th><?php echo $i; ?></th>
                  <th><?php echo $stats[1]; ?></th>
                  <th><?php echo $stats[0]; ?></th>
                  <th><?php echo $stats[2]; ?></th>
              </tr>
            
            <?php $i++; } ?>
            </tbody>
            </table>
            <!-- END KONTEN -->
        </div>
      </div>
    </section>
</div><!-- /.content-wrapper -->

