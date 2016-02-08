<?php
    if( isset($schools) )
    {
        foreach ($schools as $val) {
            echo "<option value=\"";

            echo form_prep($val->crm_school);

            
            echo "\">";
            echo form_prep($val->school);

           
            echo "</option>\n";
            
            
        }
    }
?>


