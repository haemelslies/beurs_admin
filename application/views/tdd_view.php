


<div class="panel-body">
    <div id="info" class="form-group">
    <?php 
        echo validation_errors(); 
//        var_dump($db_tdd);
//        if(isset($test_post))
//            var_dump($test_post);
    ?>
    </div>

<div class="col-sm-12">
        <h1>Talent Detection Day Pagina
<?php
        if(isset($ip) && $ip != ''){
            echo 'voor IP = ' . $ip;
        }
?>
        </h1>
        <?php
        if(isset($ip) && $ip != ''){
           $url_form = 'admin/tddForm/'.$ip;
        }
        else{
            $url_form = 'admin/tddForm';
        }       

        $hidden = array();
        $i = 1;
        $tdd = array( 
            1 => '',
            2 => '',
            
        );
        foreach($db_tdd as $val){
            $hidden['tdd_id'.$i] = $val['id'];
            if(isset($val['datum']) && $val['datum'] != ''){
                $tdd[$i] = $val['datum'];
            }
            $i++;
        }

        
        echo form_open($url_form, '', $hidden);
        
        
        ?>
    <p> Talent Detection Day 1
    <div class="bfh-datepicker"
        data-name="tdd1"
        data-format="y-m-d" 
        data-min="today"
        data-date ="<?php echo $tdd[1]; ?>"
     >

    </div>
    </p>
    <p> Talent Detection Day 2
<div class="bfh-datepicker"
     data-name ="tdd2"
     data-format="y-m-d"
     data-min="today"
     data-date="<?php echo $tdd[2]; ?>">

</div>
</p>

    
    
    <input type="submit" class="btn btn-lg btn-warning btn-block" value="Submit">

<?php 
    echo form_close(); 
?>       
</div>
</div>
