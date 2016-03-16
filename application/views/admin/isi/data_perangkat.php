<?php
function ping($host){
    exec("ping -c 2 " . $host, $output, $result);
    if ($result == 0)
      return "Up";
    else
      return "Down";
  }
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Perangkat 
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Perangkat</a></li>
        <li class="active">Data Perangkat</li>
      </ol>
    </section>
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-12">
          <div class="box-body">
            <table id="dat_per" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Perangkat</th>
                  <th>Alamat IP</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=1;foreach ($data_perangkat as $a) { 
                  ?>
                  <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $a['nama_perangkat'];?></td>
                    <td><?php echo $a['ip_address'];?></td>
                    <td><?php echo ping($a['ip_address']); ?></td>
                    <td>
                      <a href="<?php #echo base_url();?>admin/edit_user?id=<?php #echo $daftar_user['id']; ?>" class="btn btn-primary">Edit</a>
                      <a href="<?php #echo base_url();?>operation/del_user_byid?id=<?php #echo $daftar_user['id']; ?>" class="btn btn-success">Detail</a>
                      <a href="<?php #echo base_url();?>operation/del_user_byid?id=<?php #echo $daftar_user['id']; ?>" class="btn btn-danger">Hapus</a>
                    </td>
                  </tr>
                <?php $i++ ;} ?>
              </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#tambah_device">Tambah Perangkat</button>
      </div>
    </section>
</div><!-- /.content-wrapper -->

<!-- Modal Tambah Device -->
<div class="modal fade" id="tambah_device" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Perangkat</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form">
          <div class="form-group">
            <label class="control-label col-sm-2" for="nama_perangkat">Nama Perangkat:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nama_perangkat" placeholder="Nama Perangkat">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="ip">Alamat IP:</label>
            <div class="col-sm-10"> 
              <input type="text" class="form-control" id="ip" placeholder="Alamat IP Perangkat">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="ver">Versi SNMP:</label>
            <div class="col-sm-10"> 
              <input type="text" class="form-control" id="ver" value="v1" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="community">Community:</label>
            <div class="col-sm-10"> 
              <input type="text" class="form-control" id="community" placeholder="Nama Community SNMP">
            </div>
          </div>
          <div class="form-group"> 
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Submit</button>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


