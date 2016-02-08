<?php
    if( isset($diplomas) )
    {
        foreach ($diplomas as $val) {
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
?>


