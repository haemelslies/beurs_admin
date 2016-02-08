<?php
if(isset($ip) && $ip != ''){
    $admin_url = base_url('index.php/admin/admin_page/'.$ip);
}
else{
    $admin_url = base_url('index.php/admin/admin_page');

}
?>
<div class="panel-body">
<div class="col-sm-12">
    <h1>Succes!</h1>    
    <p>
        <a href="<?php echo $admin_url; ?>"
          class="btn btn-lg btn-warning btn-block">
            Terug naar hoofdpagina</a>
    </p>
    
</div>
</div>