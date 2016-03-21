<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Perangkat 
        <small>Detail Perangkat</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Perangkat</a></li>
        <li class="">Data Perangkat</li>
        <li class="active">Detail Perangkat</li>
      </ol>
    </section>
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-12">
          <div class="box-body">
            <?php 
             
              foreach ($detail as $detail) { ?>
                Nama Perangkat : <?php echo $detail['nama_perangkat'];?><br>
            <?php    
             }
            ?>
            Uptime : <span id="uptime" ><?php #echo $uptime; ?></span><br>
            Used Memmory : <span id="usedmem" ><?php #echo $uptime; ?></span>
            <br><br>

            <table id="detail_if" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Interface</th>
                  <th>Status</th>
                  <th>IP Address</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=1;foreach ($data_id as $data) { 
                    //GETTING DOMAIN USING PREG MATCH
                    // get host name from URL
                    #preg_match('@^(?:http://)?([^/]+)@i', $log['domain_tujuan'], $matches); $host = $matches[1];

                    // get last two segments of host name
                    #preg_match('/[^.]+\.[^.]+$/', $host, $matches); 
                    #$domain = $matches[0];

                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $data['nama_interface']; ?></td>
                    <td><?php echo $data['status'];?></td>
                    <td><?php echo $data['ip_address'];?></td>
                  </tr>
                <?php $i++ ;} ?>
              </tbody>
            </table>
        </div>
      </div>
    </section>
</div><!-- /.content-wrapper -->

<script>
  function loadlink(){
    $.ajax({
        url:"../welcome/uptime",              
        dataType : "json",
        type: "POST",

        success: function(data){
          //document.getElementById("uptime").value = data[0];
          $('#uptime').html(data['uptime']);
          $('#usedmem').html(data['usedmem']);
        }
    }); 
  }

  loadlink(); // This will run on page load
  setInterval(function(){
      loadlink() // this will run after every 5 seconds
  }, 3000);

</script>
