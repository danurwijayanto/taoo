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
            Uptime : <span id="uptime" ><?php #echo $uptime; ?></span><br>
            Used Memmory : <span id="usedmem" ><?php #echo $uptime; ?></span>
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

    //$('#links').load('test.php',function () {
    //     $(this).unwrap();
    //});
}

  loadlink(); // This will run on page load
  setInterval(function(){
      loadlink() // this will run after every 5 seconds
  }, 3000);

</script>
