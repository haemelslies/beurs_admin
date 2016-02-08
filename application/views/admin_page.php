<?php       
if(isset($ip) && $ip != ''){
    $preset_url = base_url('index.php/admin/preset/' . $ip);
    $tdd_url = base_url('index.php/admin/tdd/' . $ip);
    $saveDB_url = base_url('index.php/admin/saveDB/'.$ip);
    $dl_excel_url = base_url('index.php/admin/download_DB_excel/'.$ip);
    $dl_csv_url = base_url('index.php/admin/download_DB_csv/'.$ip);
    
    $emailDB_url = base_url('index.php/admin/sendMailDB/'.$ip);
    $email_url = base_url('index.php/admin/sendMail/'.$ip);
    
    $clearDB_url = base_url('index.php/admin/clearDB/'.$ip);
}
else{
    $preset_url = base_url('index.php/admin/preset');
    $tdd_url = base_url('index.php/admin/tdd');
    $saveDB_url = base_url('index.php/admin/saveDB');
    $dl_excel_url = base_url('index.php/admin/download_DB_excel');
    $dl_csv_url = base_url('index.php/admin/download_DB_csv');
    
    $emailDB_url = base_url('index.php/admin/sendMailDB');
    $email_url = base_url('index.php/admin/sendMail');
    
    $clearDB_url = base_url('index.php/admin/clearDB');
}
?>
<div class="col-sm-12">
    <h1>Admin Hoofdpagina
    <?php
        if(isset($ip) && $ip != ''){
            echo 'voor IP = ' . $ip;
        }
    ?>
    </h1>    
    
    <h2>Settings </h2>
    <div>
        
    <p>
        <a href="<?php echo $preset_url;?>"
          class="btn btn-lg btn-warning btn-block">
            Klik hier om de <b>Preset</b> pagina te openen</a>
    </p>
    
    <p>
        <a href="<?php echo $tdd_url;?>"
        class="btn btn-lg btn-warning btn-block">
            Klik hier om de <b>Talent Detection Day</b> pagina te openen
        </a>
    </p>
    </div>
    
    
    <h2>Database Backup</h2>
    <p>
        <a href="<?php echo $saveDB_url;?>"
          class="btn btn-lg btn-warning btn-block">
            Klik hier om de database <b>backup</b> te maken in de "/www/temp/" map. 
            
        </a>
    </p>
    
    <p>
        <a href="<?php echo $emailDB_url;?>"
           class="btn btn-lg btn-warning btn-block">
            Klik hier om de database <b>backup</b> te maken en versturen naar 
            <b>talent@planet-talent.com</b>
        </a>
    </p>
    
    <br>
    <p>
        <a href="<?php echo $dl_excel_url;?>"
           class="btn btn-lg btn-warning btn-block">
            Klik hier om de database te downloaden in <b>excel</b> formaat.
        </a>
    </p>
    
    <p>
        <a href="<?php echo $dl_csv_url;?>"
           class="btn btn-lg btn-warning btn-block">
            Klik hier om de database te downloaden in <b>csv</b> formaat.
        </a>
    </p>


        <h2>Emails naar studenten</h2>
    <p>
        <a href="<?php echo $email_url;?>"
           class="btn btn-lg btn-warning btn-block">
            Klik hier om <b>e-mails</b> te sturen naar de studenten in de database.
        </a>
    </p>
    
    <br>

    <h2>Database Leeg maken</h2>
     <p>
        <a href="<?php echo $clearDB_url;?>"
           class="btn btn-lg btn-danger btn-block">
            Klik hier om de database <b>Leeg</b> te maken!
        </a>
    </p>   
    
    
    <br>
    <br>
    
    <p>
        <a href="<?php echo base_url('index.php/admin/home');?>"
           class="btn btn-lg btn-primary btn-block">
            Klik hier voor terug naar de <b>Home</b> pagina te gaan.
        </a>
    </p>
    
</div>