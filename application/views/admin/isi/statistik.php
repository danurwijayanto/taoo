<?php 
  function url($data){
    //GETTING DOMAIN USING PREG MATCH
    // get host name from URL
    preg_match('@^(?:http://)?([^/]+)@i', $data, $matches); $host = $matches[1];

    // get last two segments of host name
    preg_match('/[^.]+\.[^.]+$/', $host, $matches); 
    return $domain = $matches[0];

  }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Log 
        <small>Statistik</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Squid Proxy</a></li>
        <li class="active">Statistik</li>
      </ol>
    </section>
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-12">
          <div class="box-body">
            <!-- Konten -->
            <form class="form-horizontal" role="form" method="post" action="<?php echo base_url();?>index.php/welcome/cari_statistik";>
              <div class="form-group">
                <label class="control-label col-sm-3" for="if">Interface :</label>
                <div class="col-sm-5">
                  <select class="form-control" name="if" id="if">
                    <option value="0">-- Pilih --</option>
                    <?php 
                      foreach ($interface as $if) { ?>
                        <option value=<?php echo $if['interface_index']?>><?php echo $if['nama_interface']?></option>
                    <?php
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3" for="tanggal_awal">Tanggal Awal :</label>
                <div class="col-sm-5"> 
                    <input type="date" class="form-control" name="tanggal_awal" id="tanggal_awal">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3" for="tanggal_akhir">Tanggal Akhir :</label>
                <div class="col-sm-5"> 
                  <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3" for="berdasar">Berdasarkan :</label>
                <div class="col-sm-5"> 
                  <select class="form-control" name="berdasar" id="berdasar">
                    <option value="0">-- Pilih --</option>
                    <option value="0">Hari</option>
                    <option value="0">Bulan</option>
                    <option value="0">Tahun</option>
                  </select>
                </div>
              </div>
              <div class="form-group"> 
                <div class="col-sm-offset-3 col-sm-10">
                  <button type="submit" class="btn btn-default cari_statistik">Cari</button>
                </div>
              </div>
            </form>
            <br>
            <?php 
            if (!isset($history)){
            }  else {
                $domain = array();
                foreach ($history as $his) { 
                  array_push($domain,url($his['domain_tujuan']));
                  echo url($his['domain_tujuan'])."<br>";
                } 
            } ?>
            <br>
            <?php echo print_r(array_count_values($domain))?>
            <!-- End Konten -->
        </div>
      </div>
    </section>
</div><!-- /.content-wrapper -->

