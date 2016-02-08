



<div class="panel-body">
    <div id="info" class="form-group">
    <?php 
        echo validation_errors(); 

    ?>
    </div>

<div class="col-sm-12">
        <h1>Database  pagina

        </h1>
<?php
        
        
        echo form_open('admin/homeForm');
        
        
        
        $ip_in = array(
        "type" => "text",
        "name" => "ip",
        "id" => "ip",
        "placeholder" => "Ip adress",
        "class" => "form-control input-lg",
        
        );

            $ip_in['value'] = set_value('ip');


        echo "<p>Ip adress :<br> ".form_input($ip_in)."</p>";

?>
        
    <p>
    <input type="submit" class="btn btn-lg btn-warning btn-block" value="Submit">
    </p>
<?php 
    echo form_close(); 
?>  
    <p>
        <a href="<?php echo base_url('index.php/admin/admin_page');?>"
          class="btn btn-lg btn-warning btn-block">
            Klik hier om de <b>local</b> te werken</a>
    </p>
</div>
    
</div>
