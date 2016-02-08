
<div class="panel-body">
<div class="col-sm-12">
    <h1>Er is een database error
    <?php 
        if(isset($ip) && $ip != ''){
            echo 'met '.$ip;
            
        }
        
    
    ?>
    </h1>    
    <p>
        <a href="<?php echo base_url('index.php/admin/home'); ?>"
          class="btn btn-lg btn-warning btn-block">
            Terug naar Home pagina</a>
    </p>
    
</div>
</div>