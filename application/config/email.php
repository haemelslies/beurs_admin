<?php
//$config['mailpath'] = 'D:\xampp\sendmail\sendmail.exe';

$config['protocol'] = 'smtp';
    
$config['smtp_crypto'] = 'tls';
$config['smtp_host'] = 'smtp.office365.com';
$config['smtp_port'] = '587';
$config['smtp_user'] = 'Recruitment2016@planet-talent.com';
$config['smtp_pass'] = 'Xaja7099'; //add password
$config['charset']='utf-8'; // Default should be utf-8 (this should be a text field) 
$config['newline']="\r\n"; //"\r\n" or "\n" or "\r". DEFAULT should be "\r\n" 
$config['crlf'] = "\r\n"; //"\r\n" or "\n" or "\r" DEFAULT should be "\r\n" 
$config['mailtype'] = 'html';

//$config = Array(
//    'protocol' => 'smtp',
//    'smtp_host' => 'ssl://smtp.googlemail.com',
//    'smtp_port' => 465,
//    'smtp_user' => '*****@gmail.com',
//    'smtp_pass' => '****',
//    'mailtype'  => 'html', 
//    'charset'   => 'utf-8',
//    
//);
//
//$config['newline']    = "\r\n";