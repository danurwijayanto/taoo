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
            Uptime : <span id="uptime"></span>
            <br><br>
            

                <input type="text" id="knob" class="knob" value="30" data-width="90" data-height="90" data-max=<?php echo $snmp['totmem'];?> data-fgColor="#3c8dbc" data-readonly="true"/>
                      <div class="knob-label">Memmory Usage</div>
               
              
            <br><br>
            Max Memmory : <span id="totmem" ></span><br>
            Used Memmory : <span id="usedmem" ></span>
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
$(document).ready(function(){
    $(function () {
        /* jQueryKnob */

        $(".knob").knob({
          /*change : function (value) {
           //console.log("change : " + value);
           },
           release : function (value) {
           console.log("release : " + value);
           },
           cancel : function () {
           console.log("cancel : " + this.value);
           },*/

        });
        /* END JQUERY KNOB */

      });

  function loadlink(){
    $.ajax({
        url:"../welcome/uptime",              
        dataType : "json",
        type: "POST",

        success: function(data){
          //document.getElementById("uptime").value = data[0];
          $('#uptime').html(data['uptime']);
          //document.getElementById("knob").setAttribute("value", data['usedmem'].replace(/[INTEGER: ]/gi, ''));
          //document.getElementById("knob").setAttribute("data-max", data['totmem'].replace(/[INTEGER: ]/gi, ''));
          //$('#usedmem').html(data['usedmem'].replace(/[INTEGER: ]/gi, ''));
          //$('#totmem').html(data['totmem'].replace(/[INTEGER: ]/gi, ''));
          //Fungsi mngganti value knob 
          $('.knob')
            .val(data['usedmem'].replace(/[INTEGER: ]/gi, ''))
            .trigger('change');
          }
    }); 
  }

  loadlink(); // This will run on page load
  setInterval(function(){
      loadlink() // this will run after every 5 seconds
  }, 3000);
  });
</script>
