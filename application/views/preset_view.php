
<?php
    if(isset($ip) && $ip != ''){
        $url_getDiploma = base_url('index.php/admin/getDiplomas/'.$ip.'?q=');
    }
    else{
        $url_getDiploma = base_url('index.php/admin/getDiplomas?q=');
    }  

    if(isset($ip) && $ip != ''){
        $url_getSchool = base_url('index.php/admin/getSchools/'.$ip.'?q=');
    }
    else{
        $url_getSchool = base_url('index.php/admin/getSchools?q=');
    }
?>

        
<script>
    

function showDiploma(str) {  
  
    if (str == "") {
        document.getElementById("diploma_list").innerHTML = "";

//        document.getElementById("diploma").placeholder = 
//                "Kies uw diploma hier.";

        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                
            
            document.getElementById("diploma_list").innerHTML = xmlhttp.responseText;
            }
        };

        xmlhttp.open("GET","<?php echo $url_getDiploma; ?>"+ str,true);
        //xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xmlhttp.send();

//        document.getElementById("diploma").placeholder = "Kies uw diploma hier.";
        return;
    }
}


function showSchool(str) {

    if (str == "") {
        document.getElementById("school_list").innerHTML = "";

//        document.getElementById("school").placeholder = 
//                "Kies school hier.";

        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                
            
            document.getElementById("school_list").innerHTML = xmlhttp.responseText;
            }
        };

        xmlhttp.open("GET","<?php echo $url_getSchool; ?>"+ str,true);
        //xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xmlhttp.send();

//        document.getElementById("school").placeholder = "Kies school hier.";
        return;
    }
}

</script>


<div class="panel-body">
    <div id="info" class="form-group">
    <?php 
        echo validation_errors(); 

    ?>
    </div>

<div class="col-sm-12">
        <h1>Preset pagina
<?php
        if(isset($ip) && $ip != ''){
            echo 'voor IP = ' . $ip;
        }
?>
        </h1>
        <?php


        //
        // Preset Diploma Niveau van database
        //
        
        if(isset($db_preset['diplomaLV'])){
            $diplomaLV = urlencode($db_preset['diplomaLV']);
        }
        else{
            $diplomaLV = false;
        }
        //
        // Preset Diploma type van database
        //        
        if(isset($db_preset['diploma'])){
            $diploma = $db_preset['diploma'];
        }
        else{
            $diploma = false;
        }
        //
        // Preset Diploma Sub type van database
        //
        if(isset($db_preset['diplomaSub'])){
            $diplomaSub = $db_preset['diplomaSub'];
        }
        else{
            $diplomaSub = false;
        }
        
        
        
        if(isset($db_preset['provincie'])){
            $region = urlencode($db_preset['provincie']);
        }
        else{
            $region = false;
        }
        //
        // Preset Diploma type van database
        //        
        if(isset($db_preset['school'])){
            $school = $db_preset['school'];
        }
        else{
            $school = false;
        }
       
        
        $hidden = array();
        if(isset($db_preset['id'])){
            $hidden['id'] = $db_preset['id'];
        }
       
        
        if(isset($ip) && $ip != ''){
           $url_form = 'admin/presetForm/'.$ip;
        }
        else{
            $url_form = 'admin/presetForm';
        }        

        
        
        echo form_open($url_form, '', $hidden);
        
        
        
        $beurs = array(
        "type" => "text",
        "name" => "beurs",
        "id" => "beurs",
        "placeholder" => "Beurs",
        "class" => "form-control input-lg",
        
        );
        
        if(isset($db_preset['beurs']) && $db_preset['beurs'] != ''){
            $beurs["value"] = $db_preset['beurs'];
        }
        else{
            $beurs['value'] = set_value('beurs');
        }

        echo "<p>Beurs :<br> ".form_input($beurs)."</p>";


?>
        <p> Provincie: <br>
<select id="provincie" name="provincie" 
        class="btn btn-secondary btn-lg btn-block dropdown-toggle" 
        onchange="showSchool(this.value);">
    <option id="provincie" name="provincie" value="" 
            
            <?php if($region === false) echo "selected"; ?>
            >Provincie
    </option>
  <?php      
    foreach ($db_region as $val) {
        echo "<option id=\"provincie\" name=\"provincie\""
         . " value=\"";
        echo urlencode($val->crm_name);
        echo "\"";

        if($region !== false && $region == urlencode($val->crm_name)){
            echo " selected";
        }


        echo ">";
        echo form_prep($val->name);

        echo "</option>\n";
    }
?>
</select>
        </p>
        
<datalist id="school_list">
<?php
    if( isset($db_school) )
    {
        foreach ($db_school as $val) {
            echo "<option value=\"";
            echo form_prep($val->crm_school);
           
            echo "\">";
            echo form_prep($val->school);
          
            echo "</option>\n";                     
        }
        
    }
    else{
        echo "<option value=''></option>\n";
    }

?>    
</datalist>  
        
  <p> School: <br>
    <input list="school_list" name="school" id="school"
           class="form-control input-lg" 
           placeholder="Kies uw school hier."
           
<?php 
    if(isset($school)
            && $school != ''        
    ){
        echo 'value="'.form_prep($school). '">';
    }
    else{
        echo 'value="'.set_value('school').'">';
    }
    ?>
  </p>
        
        
        
        <p> Diploma niveau:<br>
<select id="diplomaLV" name="diplomaLV" 
        class="btn btn-secondary btn-lg btn-block dropdown-toggle" 
        onchange="showDiploma(this.value);">
    <option id="diplomaLV" name="diplomaLV" value="" 
            
            <?php if($diplomaLV === false) echo "selected"; ?>
            >Diploma niveau
    </option>
  <?php      
    foreach ($db_diplomaLV as $val) {
        echo "<option id=\"diplomaLV\" name=\"diplomaLV\""
         . " value=\"";
        echo urlencode($val->crm_name);
        echo "\"";

        if($diplomaLV !== false && $diplomaLV == urlencode($val->crm_name)){
            echo " selected";
        }


        echo ">";
        echo form_prep($val->name);

        echo "</option>\n";
    }
?>
</select>
        </p>
        
<datalist id="diploma_list">
<?php
    if( isset($db_diploma) )
    {
        foreach ($db_diploma as $val) {
            echo "<option value=\"";
            echo form_prep($val->crm_type);
            if( isset($val->sub) && $val->sub != ''){
               echo "_";
               echo form_prep($val->crm_sub);               
            }            
            echo "\">";
            echo form_prep($val->type);
            if( isset($val->sub) && $val->sub != ''){
               echo " (";
                echo form_prep($val->sub);
               echo ")";
            }           
            echo "</option>\n";                     
        }
        
    }
    else{
        echo "<option value=''></option>\n";
    }

?>    
</datalist>  
        
  <p> Diploma type en sub type: <br>
    <input list="diploma_list" name="diploma" id="diploma"
           class="form-control input-lg" 
           placeholder="Kies uw diploma hier."
           
<?php 
    if(isset($diploma)
            && $diploma != ''        
    ){
        if( isset($diplomaSub) && 
            $diplomaSub != ''){

            echo 'value="'.form_prep($diploma)."_". form_prep($diplomaSub). '">';
        }
        else{
            echo 'value="'.form_prep($diploma). '">';
        }   
    }
    else{
        $set_diplomaSub = set_value('diplomaSub');
        
        if(isset($set_diplomaSub) && $set_diplomaSub != ''){
            echo 'value="'.  set_value('diploma'). "_". $set_diplomaSub.'">';
        }
        else{
            echo 'value="'.  set_value('diploma').'">';
           
        }
    }
    ?>
  </p>
  <p> Graduatie Jaar:<br>
<?php
    $this->load->helper('date');

    $jaar = date('Y'); 

    $years = array('' => 'Jaar');
    for ($i = $jaar-4; $i <= $jaar+5; $i++)
    {
        $years[$i] = $i; 
    }
    $selected_year = set_value('grad_jaar');
    if( isset($db_preset['grad_jaar'])
               && $db_preset['grad_jaar'] != '') {
            $selected_year = $db_preset['grad_jaar'];
    }
    echo form_dropdown('grad_jaar', $years, $selected_year, 
            'class="btn btn-secondary btn-lg btn-block dropdown-toggle"'); 

?>
  </p>
<BR>

    <input type="submit" class="btn btn-lg btn-warning btn-block" value="Submit">

<?php 
    echo form_close(); 
?>       
</div>
</div>
