<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>
            Jobbeurs 
        </title>
        
        <style>
            body {
                font-family: Helvetica, Arial, sans-serif;
                font-size: 15px;
                line-height: 1.42857143;
                color: #5a5a5a;
            }
            a {
                color: #f4b653;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
            Beste
            <?php
                if(isset($db_first_name, $db_last_name)
                        ){
                    echo $db_first_name . " " . $db_last_name;
                }
            ?>
        </p>
        <p>
            Bedankt voor je inschrijving op de jobbeurs.<br>
            <?php
                if(isset($db_contact) && $db_contact != ''){
                    switch ($db_contact) {
                        case 'tdd':
                            
?>
    Je hebt interesse getoond in onze Talent Detection Day
        <?php
            if(isset($db_tdd) && $db_tdd != ''){        
                if( strpos($db_tdd,'andere') !== false ){
                    echo 'op een andere datum.';
                }
                else{
                    if(strpos($db_tdd, "_") !== false)
                    {
                        echo "van ";
                        $tdd_arr = explode("_",$db_tdd);
                        //var_dump($tdd_arr);
                        
                        $tdd1 = str_replace('_', '', $tdd_arr[0]);
                        $tdd1_obj = DateTime::createFromFormat('Y-m-d', $tdd1);

                        
                        echo $tdd1_obj->format('d/m/Y');

                        
                        if( isset($tdd_arr[1]) && $tdd_arr[1] != '')
                        {
                            echo ' en ';
                            $tdd2 = str_replace('_', '', $tdd_arr[1]);
                            $tdd2_obj = DateTime::createFromFormat('Y-m-d', $tdd2);
                            echo $tdd2_obj->format('d/m/Y');
                        }
                        
                        echo ".";
                    }
                    else{
                        echo '. Er is een error opgetreden.';

                    }
                }
            }
            else
            {
                echo '. Er is een error opgetreden.';
            }
?>
    <br>
    We bellen je hieromtrent zo spoedig mogelijk op.
<?php
                            break;
                        case 'skype':
?>
    Je hebt interesse getoond in een vrijblijvend skype gesprek. 
    <br>
    Wanneer lukt dit voor jou?
<?php
                            break;
                        case 'andere':
                        default:
?>
    We bellen je zo spoedig mogelijk op om je te kunnen helpen bij je specifieke vraag.
<?php
                            break;
                    } 
                    
                }
                else{
                    echo "Errors";
                }
                    
            
            ?>
        </p>
        <p>
            Tot binnenkort
        </p>
        <p>
           Tatyana & Natasha<br>
           Planet Talent

        </p>
        <p>
           <a href="http://www.facebook.com/TalentPlanet" target="_blank">
               <img src="http://www.planet-talent.com/wp-content/themes/Frame/img/icons/facebook-yellow.png"> 
               Volg ons op Facebook.
           </a>
            <br>
           <a href="https://www.linkedin.com/company/25446?trk=prof-0-ovw-curr_pos" target="_blank">
               <img src="http://www.planet-talent.com/wp-content/themes/Frame/img/icons/linkedin-yellow.png"> 
               Volg ons op LinkedIn.
           </a>
        </p>

    </body>
</html>
