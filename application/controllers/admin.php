<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin extends CI_Controller {
   
    public function index(){
        $this->home();
    }

    public function home(){
        $this->load->view('header');
        $this->load->view('DB_selector');
        $this->load->view('footer');
    }
    public function homeForm() {
        
        
        
        $this->load->library("form_validation");
        $this->form_validation->set_message('ipv4_test', 'IP moet van de vorm "XXX.XXX.XXX.XXX" zijn.');

        $this->form_validation->set_rules("ip", "Ip adress", "callback_ipv4_test|min_length[7]|max_length[15]");

        
        if ($this->form_validation->run() == false){
        
            $this->load->view('header');
            $this->load->view('DB_selector');
            $this->load->view('footer');
        }
        else{
            
            $IP = $this->input->post('ip');
            
            $db = $this->testDB($IP);
            if($db !== false){
                $this->admin_page($IP);
            }
            else{
                $data['ip'] = $IP;
                $this->load->view('header');
                $this->load->view('database_error',$data);
                $this->load->view('footer');
            }
                
            
        }
            
    }
    
    
    public function admin_page( $IP = NULL )
    {
        $data = array();
        if(isset($IP)){
            $db = $this->testDB($IP);
            if( $db !== FALSE ){
                $data['ip'] = $IP;
            }
            else{
                $data['ip'] = $IP;                
                $this->load->view('header');                
                $this->load->view('database_error',$data);
                $this->load->view('footer');
                return;
            }
        }
            
        $this->load->view('header');
        $this->load->view('admin_page', $data);
        $this->load->view('footer');
        
    }


    public function sendMail( $IP = NULL ) {
        $this->load->library('email');
        $this->load->model('admin_model');

        if(isset($IP)){
            $db = $this->testDB($IP);
            if( $db !== FALSE ){
                $db_preset = $this->admin_model->getPreset($db);
                $db_data = $this->admin_model->getEmailInfo($db);
            }
            else{
                $data['ip'] = $IP;
                $this->load->view('header');
                $this->load->view('database_error',$data);
                $this->load->view('footer');
                return;
            }
        }
        else{
            $db_preset = $this->admin_model->getPreset();
            $db_data = $this->admin_model->getEmailInfo();            
        }
        
        
        if(isset($db_preset['beurs']) && $db_preset['beurs'] != ''){
            $beurs = $db_preset['beurs'];
        }
        else{
            $beurs = 'Jobbeurs'; 
        }

        

        echo "Beurs = ". $beurs. "<br>";


        $data = array();

        foreach($db_data->result_array() as $val){
            $this->email->clear(TRUE);

            $data = array();
            $data['db_first_name'] = $val['first_name'];
            $data['db_last_name'] = $val['last_name'];
            $data['db_contact'] = $val['contact'];
            $data['db_tdd'] = $val['tdd'];
            
            $data['personal_logo'] = $val['personal_logo'];
            $data['personal_logo'] = str_replace('[removed]','data:image/png;base64,', $data['personal_logo']);
            
            $personal_logo_file = 'personal_logo.png';
            
            $ifp = fopen($personal_logo_file, "w+"); 
            $logodata = explode(',', $data['personal_logo']);
            fwrite($ifp, base64_decode($logodata[1])); 
            fclose($ifp);
            
            $this->email->from('Recruitment2016@planet-talent.com', 'Recruitment 2016');
            $this->email->reply_to('talent@planet-talent.com', 'Talent');
            $this->email->subject('Bedankt voor je inschrijving');

            $this->email->to($val['private_email'], $val['first_name'] ." ".$val['last_name']);
            
            $this->email->message($this->load->view('html_email', $data, true));
            $this->email->attach($personal_logo_file);
            echo "Send Mail to ".$val['private_email']."->". $val['first_name'] ." ".$val['last_name']."<br>"."<p><img src='C:/wamp/www/admin_ci/assets/images/icon/pt-logo-signed-1.png'/></p>";
           
            
            if($this->email->send() ){
                echo "Succes!<br>";  
            }
            else{
                echo "Error!<br>";
                echo $this->email->print_debugger();
            }
            
        }

    }
    
    public function tdd( $IP = NULL ){
        $this->load->model('admin_model');
        //$this->load->helper('form');
        $data = array();
        
        if(isset($IP)){
            $db = $this->testDB($IP);
                if( $db !== FALSE ){
                    $data['ip'] = $IP;
                      
                    $db_tdd = $this->admin_model->getTdds( $db );

                }
                else{
                    $data['ip'] = $IP;
                    $this->load->view('header');
                    $this->load->view('database_error',$data);
                    $this->load->view('footer');
                    return;
                }
        }
        else{
            $db_tdd = $this->admin_model->getTdds( );
            
        }       
        
        $data['db_tdd'] = $db_tdd;
        
        $this->load->view('header');
        $this->load->view('tdd_view', $data);
        $this->load->view('footer');
    }
    public function tddForm( $IP = NULL ){
        
              $this->load->model('admin_model');
        //$this->load->helper('form');
        $data = array();
        
        if(isset($IP)){
            $db = $this->testDB($IP);
                if( $db !== FALSE ){
                    $data['ip'] = $IP;
                      
                    $db_tdd = $this->admin_model->getTdds( $db );

                }
                else{
                    $data['ip'] = $IP;
                    $this->load->view('header');
                    $this->load->view('database_error',$data);
                    $this->load->view('footer');
                }
        }
        else{
            $db_tdd = $this->admin_model->getTdds( );
            
        }       
        
        $data['db_tdd'] = $db_tdd;
        
//        $data['test_post'] = $this->input->post();

        
        
        $this->load->library("form_validation");

        $this->form_validation->set_rules("tdd_id1", "tdd_id 1", "numeric|min_length[1]|max_length[10]");
        $this->form_validation->set_rules("tdd_id2", "tdd_id 2", "numeric|min_length[1]|max_length[10]");
        $this->form_validation->set_rules("tdd1", "datum 1", "min_length[10]|max_length[10]");
        $this->form_validation->set_rules("tdd2", "datum 2", "min_length[10]|max_length[10]");


        if ($this->form_validation->run() == false){

            $this->load->view('header');
            $this->load->view('tdd_view', $data);
            $this->load->view('footer');
        }
        else{
            
            $post = $this->input->post();
            if(isset($IP) && $db !== FALSE){

                if(isset($post['tdd1']) && $post['tdd1'] != ''){
                    if(isset($post['tdd_id1']) && $post['tdd_id1'] != ''){
                        //update preset
                        $this->admin_model->updateTdd($post['tdd1'], $post['tdd_id1'], $db);
                    }
                    else{
                        //insert preset
                        $this->admin_model->insertTdd($post['tdd1'], $db);
                    }
                }
                if(isset($post['tdd2']) && $post['tdd2'] != ''){
                    if(isset($post['tdd_id2']) && $post['tdd_id2'] != ''){
                        //update preset
                        $this->admin_model->updateTdd($post['tdd2'], $post['tdd_id2'], $db);
                    }
                    else{
                        //insert preset
                        $this->admin_model->insertTdd($post['tdd2'], $db);
                    }
                }
                $db_tdd = $this->admin_model->getTdds($db);     

            }
            else{
                if(isset($post['tdd1']) && $post['tdd1'] != ''){
                    if( isset($post['tdd_id1']) && $post['tdd_id1'] != ''){
                        //update preset
                        $this->admin_model->updateTdd($post['tdd1'], $post['tdd_id1']);
                    }
                    else{
                        //insert preset
                        $this->admin_model->insertTdd($post['tdd1']);
                    }
                }
                
                
                if(isset($post['tdd2']) && $post['tdd2'] != ''){
                    if(isset($post['tdd_id2']) && $post['tdd_id2'] != ''){
                        //update preset
                        $this->admin_model->updateTdd($post['tdd2'], $post['tdd_id2']);
                    }
                    else{
                        //insert preset
                        $this->admin_model->insertTdd($post['tdd2']);
                    }
                }
                $db_tdd = $this->admin_model->getTdds();    
    
            }
            
            $data['db_tdd'] = $db_tdd;
            
            
            $this->load->view('header');
            
            //echo "Succes!";
            $this->load->view('tdd_view', $data);
            $this->load->view('succes_page', $data);
            $this->load->view('footer');
            
        }
        

    }

    public function preset( $IP = NULL ){
        $this->load->model('admin_model');
        //$this->load->helper('form');
        $data = array();
        if(isset($IP)){
            $db = $this->testDB($IP);
                if( $db !== FALSE ){
                    $data['ip'] = $IP;
                    
                    
                    $db_preset = $this->admin_model->getPreset( $db );
                    $db_diplomaLV = $this->admin_model->getDiplomaLVs( $db);
                    $db_diploma = $this->admin_model->getDiplomas( NULL, $db);
                    $db_region = $this->admin_model->getRegions($db);
                    $db_school = $this->admin_model->getSchools(NULL, $db);
                }
                else{
                    $data['ip'] = $IP;
                    $this->load->view('header');
                    $this->load->view('database_error',$data);
                    $this->load->view('footer');
                    return;
                }
        }
        else{
            $db_preset = $this->admin_model->getPreset();
            $db_diplomaLV = $this->admin_model->getDiplomaLVs();
            $db_diploma = $this->admin_model->getDiplomas();
            $db_region = $this->admin_model->getRegions();
            $db_school = $this->admin_model->getSchools();
            
        }

        $data['db_preset'] = $db_preset;
        $data['db_diplomaLV'] = $db_diplomaLV;
        $data['db_diploma'] = $db_diploma;
        $data['db_region'] = $db_region;
        $data['db_school'] = $db_school;

        $this->load->view('header');
        $this->load->view('preset_view', $data);
        $this->load->view('footer');
    
    
        
    }
    public function presetForm( $IP = NULL ){

        $this->load->model('admin_model');
        //$this->load->helper('form');
        $data = array();
        if(isset($IP)){
            $db = $this->testDB($IP);
                if( $db !== FALSE ){
                    $data['ip'] = $IP;

                    $db_preset = $this->admin_model->getPreset( $db );
                    $db_diplomaLV = $this->admin_model->getDiplomaLVs( $db);
                    $db_diploma = $this->admin_model->getDiplomas( NULL, $db);
                    $db_region = $this->admin_model->getRegions($db);
                    $db_school = $this->admin_model->getSchools(NULL, $db);
                }
                else{
                    $data['ip'] = $IP;
                    
                    $this->load->view('header');
                    $this->load->view('database_error',$data);
                    $this->load->view('footer');
                    return;
                }
        }
        else{
            $db_preset = $this->admin_model->getPreset();
            $db_diplomaLV = $this->admin_model->getDiplomaLVs();
            $db_diploma = $this->admin_model->getDiplomas();
            $db_region = $this->admin_model->getRegions();
            $db_school = $this->admin_model->getSchools();
            
        }
        
        $data['db_preset'] = $db_preset;
        $data['db_diplomaLV'] = $db_diplomaLV;
        $data['db_diploma'] = $db_diploma;
        $data['db_region'] = $db_region;
        $data['db_school'] = $db_school;
        
        $this->load->library("form_validation");

        $this->form_validation->set_rules("id", "id", "numeric|min_length[1]|max_length[10]");
        $this->form_validation->set_rules("beurs", "Beurs", "required|min_length[3]|max_length[20]");
        $this->form_validation->set_rules("provincie", "Provincie", "min_length[3]|max_length[20]");
        $this->form_validation->set_rules("school", "School", "min_length[1]|max_length[60]");
        $this->form_validation->set_rules("diplomaLV", "diploma level", "min_length[3]|max_length[20]");
        $this->form_validation->set_rules("diploma", "diploma", "min_length[3]|max_length[60]");

        if ($this->form_validation->run() == false){
            $this->load->view('header');
            $this->load->view('preset_view', $data);
            $this->load->view('footer');
        }
        else{
            
            $post = $this->input->post();
                       
            $diploma = '';
            $diplomaSub = '';
            
            if(isset($post['diploma']) && $post['diploma'] != '')
            {            
                if( strpos($post['diploma'], "_") !== false)
                {
                    $diplomaArr = explode("_",$post['diploma'], 2);
                    $diploma = $diplomaArr[0];
                    if( isset($diplomaArr[1]) )
                    {
                        $diplomaSub = $diplomaArr[1];
                    }
                    else
                    {
                        $diplomaSub = '';
                    }
                }
                else
                {
                    $diploma = $post['diploma'];
                    $diplomaSub = '';
                }
            }
            
            $input_data = array(
                'beurs' => $post['beurs'],
                'andere_school' => FALSE,
                'provincie' => urldecode($post['provincie']),
                'school' => $post['school'],
                'diplomaLV' => urldecode($post['diplomaLV']),
                'diploma' => $diploma,
                'diplomaSub' => $diplomaSub,
                'grad_jaar' => $post['grad_jaar']
            );

            if(isset($IP) && $db !== FALSE){

                if(isset($post['id']) && $post['id'] != ''){
                    //update preset
                    $this->admin_model->updatePreset($input_data, $post['id'], $db);
                }
                else{
                    //insert preset
                    $this->admin_model->insertPreset($input_data, $db);
                }
                $db_preset = $this->admin_model->getPreset($db);     

            }
            else{
                if(isset($post['id']) && $post['id'] != ''){
                    //update preset
                    $this->admin_model->updatePreset($input_data, $post['id']);
                }
                else{
                    //insert preset
                    $this->admin_model->insertPreset($input_data);
                }               
                $db_preset = $this->admin_model->getPreset();
    
            }
                    
            $data['db_preset'] = $db_preset;           
            
            
            $this->load->view('header');
            //echo 'Succes!';
            $this->load->view('preset_view', $data);
            $this->load->view('succes_page', $data);

            $this->load->view('footer');
        }
 
    }

    public function getDiplomas( $IP = NULL )
    {        
        if ($this->input->get('q') != NULL )
        {
            
            $this->load->model('admin_model');
            $diplomaLV = $this->input->get('q');
            
            if(isset($IP)){
                $db = $this->testDB($IP);
                if( $db !== FALSE ){
                    $data['diplomas'] = $this->admin_model->getDiplomas($diplomaLV, $db);
                }
                else{
                    echo 'DB connection error with '.$IP.'<br>';
                    return;
                }
            }
            else{

                $data['diplomas'] = $this->admin_model->getDiplomas($diplomaLV);
            }

            $this->load->view('templates/diplomas',$data);

        }
        
    }
    public function getSchools( $IP = NULL )
    {

        if ($this->input->get('q') != NULL )
        {
            
            $this->load->model('admin_model');
            $provincie = $this->input->get('q');
            
            if(isset($IP)){
                $db = $this->testDB($IP);
                if( $db !== FALSE ){
                    $data['schools'] = $this->admin_model->getSchools($provincie, $db);
                }
                else{
                    echo 'DB connection error with '.$IP.'<br>';
                    return;
                }


            }
            else{

                $data['schools'] = $this->admin_model->getSchools($provincie);
            }

            $this->load->view('templates/schools',$data);

        }
    }


    public function clearDB( $IP = NULL ) {
        $this->load->model('admin_model');
        
        $data = array();

        if(isset($IP)){
            $db = $this->testDB($IP);
            if( $db !== FALSE ){
                $data['ip'] = $IP;
                       
                
                $db_crm = $this->admin_model->getDBdata($db);
                $db_preset = $this->admin_model->getPreset($db);
                $db_tdd = $this->admin_model->getTdds($db);


                //$this->admin_model->clearDB($db);
            }
            else{
                $data['ip'] = $IP;
                $this->load->view('header');
                $this->load->view('database_error',$data);
                $this->load->view('footer');
                return;
            }
        }
        else{

            $db_crm = $this->admin_model->getDBdata();
            $db_preset = $this->admin_model->getPreset();
            $db_tdd = $this->admin_model->getTdds();
               
            //$this->admin_model->clearDB();
        }

        
        $data['db_crm'] = $db_crm->result_array();
        $data['db_preset'] = $db_preset;
        $data['db_tdd'] = $db_tdd;
        
        
                        
            $this->load->view('header');
            $this->load->view('clear_view',$data);
            $this->load->view('footer');
        
//        echo "Cleared DB<br> ";
    }

    public function clearDBForm( $IP = NULL ) {
        $this->load->model('admin_model');
        

        $this->load->library("form_validation");

        $this->form_validation->set_rules("answer", "Antwoord", "min_length[2]|max_length[2]");
        
        $data = array();      
        
        
        if(isset($IP)){
            $db = $this->testDB($IP);
            if( $db !== FALSE ){
                $data['ip'] = $IP;
                       
                
                $db_crm = $this->admin_model->getDBdata($db);
                $db_preset = $this->admin_model->getPreset($db);
                $db_tdd = $this->admin_model->getTdds($db);


                //$this->admin_model->clearDB($db);
            }
            else{
                $data['ip'] = $IP;
                $this->load->view('header');
                $this->load->view('database_error',$data);
                $this->load->view('footer');
                return;
            }
        }
        else{

            $db_crm = $this->admin_model->getDBdata();
            $db_preset = $this->admin_model->getPreset();
            $db_tdd = $this->admin_model->getTdds();
               
            //$this->admin_model->clearDB();
        }

        
        $data['db_crm'] = $db_crm->result_array();
        $data['db_preset'] = $db_preset;
        $data['db_tdd'] = $db_tdd;
        
        if ($this->form_validation->run() == false){
            $this->load->view('header');
            $this->load->view('clear_view',$data);
            $this->load->view('footer');

        }
        else{
            $answer = $this->input->post('answer');
            
            if(strcasecmp($answer, 'ja') == 0){
                
                if(isset($IP) && $db !== false){
                    $this->admin_model->clearDB($db);

                }
                else{
                    $this->admin_model->clearDB();

                }
                    
                $this->load->view('header');
                $this->load->view('succes_page',$data);
                $this->load->view('footer');                
            }
            else{
                $this->load->view('header');
                $this->load->view('admin_page',$data);
                $this->load->view('footer');   
            }

        }

        
//        echo "Cleared DB<br> ";
    }


    public function sendMailDB( $IP = NULL){

        $this->load->model('admin_model');
        
        if(isset($IP)){
            $db = $this->testDB($IP);
            if( $db !== FALSE ){
                $db_data = $this->admin_model->getDBdata($db);
                $db_extra = $this->admin_model->getDBextra($db);
                $db_preset = $this->admin_model->getPreset($db);     

                
                $filename = "PT_CRM(".$IP.")=".date('d-m-Y ( H\ui\ms\s )') ;

            }
            else{
                $data['ip'] = $IP;
                $this->load->view('header');
                $this->load->view('database_error',$data);
                $this->load->view('footer');
                return;
            }
        }
        else{
            
            $db_data = $this->admin_model->getDBdata();
            $db_extra = $this->admin_model->getDBextra();
            $db_preset = $this->admin_model->getPreset();     

            $filename = "PT_CRM=".date('d-m-Y ( H\ui\ms\s )') ;

        }
        

        if(isset($db_preset['beurs']) && $db_preset['beurs'] != ''){
            $beurs = $db_preset['beurs'];
        }
        else{
            $beurs = 'Jobbeurs'; 
        }
//        $mail_to = 'vandendriessche.janmarco@gmail.com';       
//        $mail_to = 'tatyana.skoraya@planet-talent.com';
        
       $mail_to = 'talent@planet-talent.com';

        
        $subject = "DB ". $beurs . " (" . date('d-m-Y'). ")";
        //echo $filename;
        $filelocal_xlsx = 'temp/'.$filename . '.xlsx';
        $filelocal_csv = 'temp/'.$filename . '.csv';




        $this->make_excel($filelocal_xlsx, $db_data, $db_extra);
        echo "Made excel!<br>";


        $this->make_csv($filelocal_csv, $db_data);
        echo "Made csv!<br>";


        $this->load->library('email');

        $this->email->from('Recruitment2016@planet-talent.com', 'Planet Talent');
        $this->email->reply_to('talent@planet-talent.com', 'Planet Talent');
        
        $this->email->to($mail_to);
        

        $this->email->subject($subject);
        $this->email->message('Sending DB info');

        $this->email->attach($filelocal_xlsx);  
        $this->email->attach($filelocal_csv);  

        echo "Send DB Mail to ". $mail_to ."<br>";
            if($this->email->send() ){
                echo "Succes!<BR>";
            }
            else{
                echo "Error!<br>";
                echo $this->email->print_debugger();
            }


    }
     public function saveDB( $IP = NULL ){

        $this->load->model('admin_model');
        $data = array();
        
        if(isset($IP)){
            $db = $this->testDB($IP);
            if( $db !== FALSE ){
                $data['ip'] = $IP;
                $db_data = $this->admin_model->getDBdata($db);
                $db_extra = $this->admin_model->getDBextra($db);
                $db_preset = $this->admin_model->getPreset($db);     

                
                $filename = "PT_CRM(".$IP.")=".date('d-m-Y ( H\ui\ms\s )') ;

            }
            else{
                $data['ip'] = $IP;
                $this->load->view('header');
                $this->load->view('database_error',$data);
                $this->load->view('footer');
                return;
            }
        }
        else{
            
            $db_data = $this->admin_model->getDBdata();
            $db_extra = $this->admin_model->getDBextra();
            $db_preset = $this->admin_model->getPreset();     

            $filename = "PT_CRM=".date('d-m-Y ( H\ui\ms\s )') ;

        }
        

        if(isset($db_preset['beurs']) && $db_preset['beurs'] != ''){
            $beurs = $db_preset['beurs'];
        }
        else{
            $beurs = 'Jobbeurs'; 
        }

        //echo $filename;
        $filelocal_xlsx = 'temp/'.$filename . '.xlsx';
        $filelocal_csv = 'temp/'.$filename . '.csv';




        $this->make_excel($filelocal_xlsx, $db_data, $db_extra);
//        echo "Made excel in ". $filelocal_xlsx ."!<br>";


        $this->make_csv($filelocal_csv, $db_data);
//        echo "Made csv in ". $filelocal_csv ."!<br>";       
        

        $this->load->view('header');
        echo '<div class="panel-body">';
        echo "<p>Excel bestand is te vinden in \"/www/admin_ci/". $filelocal_xlsx ."\".</p>";
        echo "<p>Csv bestand is te vinden in \"/www/admin_ci/". $filelocal_csv ."\".</p>"; 
        echo '</div>';
        $this->load->view('succes_page',$data);

        $this->load->view('footer');
        
    }
    public function download_DB_excel( $IP = NULL ){

        $this->load->model('admin_model');
        
        if(isset($IP)){
            $db = $this->testDB($IP);
            if( $db !== FALSE ){
                $db_data = $this->admin_model->getDBdata($db);
                $db_extra = $this->admin_model->getDBextra($db);
                $db_preset = $this->admin_model->getPreset($db);     

                
                $filename = "PT_CRM(".$IP.")=".date('d-m-Y ( H\ui\ms\s )') ;

            }
            else{
                $data['ip'] = $IP;
                $this->load->view('header');
                $this->load->view('database_error',$data);
                $this->load->view('footer');
                return;
            }
        }
        else{
            
            $db_data = $this->admin_model->getDBdata();
            $db_extra = $this->admin_model->getDBextra();
            $db_preset = $this->admin_model->getPreset();     

            $filename = "PT_CRM=".date('d-m-Y ( H\ui\ms\s )') ;

        }
        

        if(isset($db_preset['beurs']) && $db_preset['beurs'] != ''){
            $beurs = $db_preset['beurs'];
        }
        else{
            $beurs = 'Jobbeurs'; 
        }

        
// We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');

        //echo $filename;
       

// It will be called file.xls
        header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
        

         $filelocal_xlsx = 'php://output';



        $this->make_excel($filelocal_xlsx, $db_data, $db_extra);


    }
    public function download_DB_csv( $IP = NULL ){

        $this->load->model('admin_model');
        
        if(isset($IP)){
            $db = $this->testDB($IP);
            if( $db !== FALSE ){
                $db_data = $this->admin_model->getDBdata($db);
                $db_extra = $this->admin_model->getDBextra($db);
                $db_preset = $this->admin_model->getPreset($db);     

                
                $filename = "PT_CRM(".$IP.")=".date('d-m-Y ( H\ui\ms\s )') ;

            }
            else{
                $data['ip'] = $IP;
                $this->load->view('header');
                $this->load->view('database_error',$data);
                $this->load->view('footer');
                return;
            }
        }
        else{
            
            $db_data = $this->admin_model->getDBdata();
            $db_extra = $this->admin_model->getDBextra();
            $db_preset = $this->admin_model->getPreset();     

            $filename = "PT_CRM=".date('d-m-Y ( H\ui\ms\s )') ;

        }
        

        if(isset($db_preset['beurs']) && $db_preset['beurs'] != ''){
            $beurs = $db_preset['beurs'];
        }
        else{
            $beurs = 'Jobbeurs'; 
        }

        
        // We'll be outputting an excel file
        header('Content-type: text/csv');
       

        // It will be called file.xls
        header('Content-Disposition: attachment; filename="'.$filename.  '.csv"');
        

         $filelocal_csv = 'php://output';



        $this->make_csv($filelocal_csv, $db_data);



    }
    
    
    
    function make_csv($filelocal, $crm_array){

        //load our new PHPExcel library
        $this->load->library('excel');
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('crm');

        $this->db_to_excelsheet($this->excel, $crm_array, true);




        //setAutoSize
        foreach ($this->excel->getWorksheetIterator() as $worksheet) {

            $this->excel
                    ->setActiveSheetIndex($this->excel->getIndex($worksheet));

            $sheet = $this->excel->getActiveSheet();
            $cellIterator = $sheet->getRowIterator()
                    ->current()->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            /** @var PHPExcel_Cell $cell */
            foreach ($cellIterator as $cell) {
                $sheet->getColumnDimension($cell->getColumn())
                        ->setAutoSize(true);
            }
        }


        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'CSV');  
        $objWriter->save($filelocal);
    }


    function make_excel( $filelocal, $crm_array, $extra_array = NULL ){

        //load our new PHPExcel library
        $this->load->library('excel');
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('crm');

        $this->db_to_excelsheet($this->excel, $crm_array, true);

        $this->excel->createSheet(1);
        $this->excel->setActiveSheetIndex(1);
        $this->excel->getActiveSheet()->setTitle('extra');


        if( isset($extra_array)  )
        {
          $this->db_to_excelsheet($this->excel, $extra_array);
        }



        //setAutoSize
        foreach ($this->excel->getWorksheetIterator() as $worksheet) {

            $this->excel
                    ->setActiveSheetIndex($this->excel->getIndex($worksheet));

            $sheet = $this->excel->getActiveSheet();
            $cellIterator = $sheet->getRowIterator()
                    ->current()->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            /** @var PHPExcel_Cell $cell */
            foreach ($cellIterator as $cell) {
                $sheet->getColumnDimension($cell->getColumn())
                        ->setAutoSize(true);
            }
        }

        $this->excel->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
        $objWriter->save($filelocal);

    }

    function db_to_excelsheet($excelobj, $array, $isCRM = FALSE){

        $contact_xml = array(
            "first_name"        =>  "First Name",
            "contact_type"      =>  "Contact Type",
            "account"           =>  "Account",
            "last_name"         =>  "Last Name",
            "owner"             =>  "Owner",
            "source"            =>"Source",
            "diploma_level"     =>"Diploma Level",
            "diploma_type"      =>"Diploma Type",
            "diploma_sub_type"  =>    "Diploma Sub Type",
            "school"            =>    "School",
            "graduation_month"  =>    "Graduation Month",
            "graduation_year"   =>    "Graduation Year",
            "home_phone"        =>    "Home Phone",
            "mobile_phone"      =>    "Mobile Phone",
            "private_email"     =>    "Private E-mail",
            "gender"            =>    "Gender",
            "language"          =>    "Language",
            "description"       =>    "Description",
            "nationality"       =>    "Nationality",
            "birthday"          =>    "Birthday",
            "address_street"    =>    "Address: Street",
            "address_country"   =>    "Address: Country",
            "address_city_belgium"=>    "Address: City (Belgium)",
            "address_postal_code"=>    "Address: ZIP/Postal Code",
            "address_city"      =>    "Address: City",

        );


        $h = array();
        foreach($array->result_array() as $row){
            foreach($row as $key=>$val){
                $temp = $key;
                if($isCRM){
                    //echo $key ."-" .$contact_xml[$key]."<br>";
                    $temp = $contact_xml[$key];
                }
                else{
                    $temp = $key;
                }


                if(!in_array($temp, $h)){
                 $h[] = $temp;   
                }


            }
        }
        //echo the entire table headers
        $row_count = 1;
        $col_count = 'A';
        foreach($h as $key) {


            $excelobj->getActiveSheet()
                    ->setCellValue($col_count . $row_count, $key);


            $excelobj->getActiveSheet()
                    ->getStyle($col_count . $row_count)
                    ->getFont()
                    ->setBold(true);
            $excelobj->getActiveSheet()
                    ->getStyle($col_count . $row_count)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            //$row_count++;
            $col_count++;
        }

        $row_count = 2;
        $col_count = 'A';
        foreach($array->result_array() as $row){

            foreach($row as $key=>$val){

                if($key == 'graduation_month'){
                    $temp = "";
                    $temp .= sprintf("%02d", $val);
                    //echo $temp. "<br>";
//                        $excelobj->getActiveSheet()
//                            ->setCellValue($col_count . $row_count, $temp);
                    $excelobj->getActiveSheet()
                        ->setCellValueExplicit($col_count . $row_count, $temp,PHPExcel_Cell_DataType::TYPE_STRING);
                }
                else{
                    $excelobj->getActiveSheet()
                        ->setCellValueExplicit($col_count . $row_count, $val,PHPExcel_Cell_DataType::TYPE_STRING);

                }
                $col_count++;
            }
            $col_count = 'A';
            $row_count++;

        }
    }
    
    public function testDB($IP = NULL)
    {
//            $this->load->model('admin_model');
//            echo $IP . "<br>";
        $test = $this->ipv4_test($IP);

        if( isset($IP) 
            && $test
                ){

            $config['hostname'] = $IP;
//            $config['hostname'] = '192.168.50.28';
            $config['username'] = 'pt_admin';
            $config['password'] = 'T4l3nt$';
            $config['database'] = 'ptmdbpt';
            $config['dbdriver'] = 'mysqli';
//            $config['pconnect'] = TRUE;
            $config['db_debug'] = FALSE;
            $config['cache_on'] = FALSE;
            $config['char_set'] = 'utf8';
            $config['dbcollat'] = 'utf8_general_ci';
            $config['autoinit'] = FALSE;



            $tempDB = $this->load->database($config, TRUE);
            $connected = $tempDB->initialize();


            if( $connected ){
//                    $db_data = $this->admin_model->getDBdata($tempDB);
//                    var_dump($db_data->result());
                return $tempDB;
            }
            else{
//                    echo 'cant connect to db<br>';
                return false;

            }

//                $tempDB->close();

        }
        else {
//                echo 'Something went wrong<br>Expected format xxx.xxx.xxx.xxx<br>';
            return false;

        }

    }

        
    function ipv4_test($str)
    {     
        $regex = "/^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/"; 
        return ( ! preg_match($regex, $str)) ? FALSE : TRUE;
    } 
        
}