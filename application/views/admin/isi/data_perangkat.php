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
                    <td>
                      <a href="<?php #echo base_url();?>admin/edit_user?id=<?php #echo $daftar_user['id']; ?>" class="btn btn-success">Edit</a>
                      <a href="<?php #echo base_url();?>operation/del_user_byid?id=<?php #echo $daftar_user['id']; ?>" class="btn btn-danger">Detail</a>
                    </td>
                  </tr>
                <?php $i++ ;} ?>
              </tbody>
            </table>
        </div>
      </div>
    </section>
</div><!-- /.content-wrapper -->

