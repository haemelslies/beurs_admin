
<div class="panel-body">
    <div id="info" class="form-group">
    <?php 
        echo validation_errors(); 


    ?>
    </div>

<div class="col-sm-12">
        <h1>Database opruimen pagina
<?php
        if(isset($ip) && $ip != ''){
            echo 'voor IP = ' . $ip;
        }
?>
        </h1>
    <h2>Bent u zeker dat u volgende gegevens uit de database wilt smijten</h2>
    
    
    <table class='table table-striped table-bordered'>
        <thead>
        <tr><th>CRM tabel</th></tr>
        </thead>
        <tbody>
            
<?php

    if(isset($db_crm) && count($db_crm) != 0){
        echo "<tr><td>"
        . "<table class='table table-striped table-bordered'>"
        . "<thead>"
        . "<tr>"
        . "<th> Voornaam </th>"
        . "<th> Naam </th>"
        . "<th> Email </th>"            
        . "<th> Stad </th>"            
        . "</tr>"    
        . "</thead>";
        foreach ($db_crm as  $val) {

                echo "<tr>";

                echo "<td>";
                echo $val['first_name'];
                echo "</td>"; 

                echo "<td>";
                echo $val['last_name'];
                echo "</td>"; 

                echo "<td>";
                echo $val['private_email'];
                echo "</td>"; 

                echo "<td>";
                echo $val['address_postal_code'];
                echo "-";
                echo $val['address_city'];
                echo "</td>"; 

                echo "</tr>";
            
        }
        
        echo "</table>"
        . "</td></tr>";
    }
    else{
        echo "<td>CRM database is leeg!</td> ";
    }
?>                       

        </tbody>
    </table>
    
    <table class='table table-striped table-bordered'>
        <thead>
        <tr><th>Preset tabel</th></tr>

        </thead>
        <tbody>
<?php

    if( isset($db_preset) ){
        echo "<tr><td>"
        . "<table class='table table-striped table-bordered'>";
        foreach ($db_preset as $key => $val) {
            
            if( isset($val) && $val != ''
                && $key != 'id'
                && $key != 'andere_school'
                    
                    ){
                echo "<tr>";


                echo "<th>";
                echo $key;
                echo "</th>"; 

                echo "<td>";
                echo $val;
                echo "</td>"; 

                echo "</tr>";
            }
        }
        
        echo "</table>"
        . "</td></tr>";
        
    }
    else{
        echo "<tr><td>Preset database is leeg!</td></tr>";
    }
?>          
        </tbody>
    </table>
    
    
    
    <table class='table table-striped table-bordered'>
        <thead>
        <tr><th>Tdd tabel</th></tr>

        </thead>
        <tbody>
           
  <?php

    if( isset($db_tdd) && count($db_tdd) != 0){
        foreach ($db_tdd as $val) {
           echo "<tr>";
           echo "<td>";
           echo DateTime::createFromFormat('Y-m-d', $val['datum'])->format('d/m/Y');
           echo "</td>"; 
           
           echo "</tr>"; 
        }
    }
    else{
        echo "<tr><td>Tdd database is leeg!</td></tr>";
    }
?>                      
        
        </tbody>
    </table>
    
        
    
    
        
    
    
    
    
    
<?php
        if(isset($ip) && $ip != ''){
            $form_url = 'admin/clearDBForm/'.$ip;
            
        }
        else{
            $form_url = 'admin/clearDBForm';
        }
        
        echo form_open($form_url);
        
        
        
        $answer = array(
        "type" => "text",
        "name" => "answer",
        "id" => "answer",
        "placeholder" => "Database leegmaken? tip 'ja' om verder te gaan.",
        "class" => "form-control input-lg",
        
        );

            $answer['value'] = set_value('answer');


        echo "<p> ".form_input($answer)."</p>";

?>
        
    <p>
    <input type="submit" class="btn btn-lg btn-warning btn-block" value="Submit">
    </p>
<?php 
    echo form_close(); 
?>  
    <p>
<?php
    if(isset($ip) && $ip != ''){
        $admin_url = base_url('index.php/admin/admin_page/'.$ip);

    }
    else{
        $admin_url = base_url('index.php/admin/admin_page');
    }  
?>
        <a href="<?php echo $admin_url; ?>"
          class="btn btn-lg btn-warning btn-block">
            Klik hier om <b>terug</b> te gaan</a>
    </p>
</div>
    
</div>
