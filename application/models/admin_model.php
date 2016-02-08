<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_Model extends CI_Model {
    
    
    
    public function getDBdata( $db = NULL ) {
        $sql = 'SELECT '
                . '`first_name`, '
                . '`contact_type`, '
                . '`account`, '
                . '`last_name`, '
                . '`owner`, '
                . '`source`, '
                . '`diploma_level`, '
                . '`diploma_type`, '
                . '`diploma_sub_type`, '
                . '`school`, '
                . '`graduation_month`, '
                . '`graduation_year`, '
                . '`home_phone`, '
                . '`mobile_phone`, '
                . '`private_email`, '
                . '`gender`, '
                . '`language`, '
                . '`description`, '
                . '`nationality`, '
                . '`birthday`, '
                . '`address_street`, '
                . '`address_country`, '
                . '`address_city_belgium`, '
                . '`address_postal_code`, '
                . '`address_city` '
                . 'FROM pt_crm';
        
        if( isset($db) ){
            $query = $db->query($sql);
        }
        else{
            $query = $this->db->query($sql);
        }
        //return $query->result();
        return $query;
    }
    
    function getDBextra( $db = NULL ){
        $sql =  "SELECT "
                . "id, "
                . "first_name, "
                . "last_name, "
                . "jobs, "
                . "contact, "
                . "tdd "
                . "FROM "
                . "pt_extra e "
                . "JOIN "
                . "pt_crm c ON "
                . "e.id = c.index";
        
        if( isset($db) ){
            $query = $db->query($sql);
        }
        else{
            $query = $this->db->query($sql);
        }
        return $query;
    }
    function getPreset( $db = NULL ){
        $sql = "SELECT "
                . "id, "
                . "beurs, "
                . "andere_school, "
                . "provincie, "
                . "school, "
                . "diplomaLV, "
                . "diploma, "
                . "diplomaSub, "
                . "grad_jaar "
                . "FROM "
                . "pt_presets "
                . "ORDER BY id DESC "
                . "LIMIT 0,1";
        
        if( isset($db) ){
            $query = $db->query($sql);
        }
        else{
            $query = $this->db->query($sql);
        }    
        

        return $query->row_array();
            
    }
    function getTdds( $db = NULL ){
        $sql = "SELECT "
                . "id, "
                . "datum "
                . "FROM "
                . "pt_tdd "
                . "WHERE datum > CURDATE()"
                . "ORDER BY datum "
                . "LIMIT 2";
        
        if( isset($db) ){
            $query = $db->query($sql);
        }
        else{
            $query = $this->db->query($sql);
        }    
        

        return $query->result_array();
            
    }
    public function getEmailInfo( $db = NULL ){
        $sql = "SELECT "
                . "id, "
                . "first_name, "
                . "last_name, "
                . "private_email, "
                . "contact, "
                . "tdd, "
                . "personal_logo "
                . "FROM "
                . "pt_extra e "
                . "JOIN "
                . "pt_crm c ON "
                . "e.id = c.index";
        if( isset($db) ){
            $query = $db->query($sql);
        }
        else{
            $query = $this->db->query($sql);
        }
        return $query;
    }
    
    public function getDiplomaLVs( $db = NULL ){
        $sql = 'SELECT id, name, crm_name
                    FROM pt_diploma_level';
        if( isset($db) ){
            $query = $db->query($sql);
        }
        else{
            $query = $this->db->query($sql);
        }
            return $query->result();
    }
        
    public function getDiplomas( $diplomaLV = NULL, $db = NULL ){
        if( isset( $diplomaLV ) ){
            $sql = "SELECT type, sub, crm_type, crm_sub
                    FROM pt_diploma_view 
                    WHERE crm_level = ?" ;

            if( isset($db) ){
                $query = $db->query($sql, $diplomaLV);
            }
            else{
                $query = $this->db->query($sql, $diplomaLV);
            }
        }
        else{
            $sql = "SELECT type, sub, crm_type, crm_sub
                    FROM pt_diploma_view" ;

            if( isset($db) ){
                $query = $db->query($sql);
            }
            else{
                $query = $this->db->query($sql);
            }
        }

        return $query->result();

    }
    
    public function getRegions( $db = NULL ){
            $sql =  'SELECT id, name, crm_name 
                     FROM pt_school_region';
            if( isset($db) ){
                    $query = $db->query($sql);
                }
                else{
                    $query = $this->db->query($sql);
                }
            
            return $query->result();
            
    }
    
    public function getSchools( $provincie = NULL, $db = NULL ){
            
            if( isset( $provincie ) ){
                $sql = "SELECT school, crm_school 
                        FROM pt_school_view 
                        WHERE crm_region = ?" ;
                if( isset($db) ){
                    $query = $db->query($sql, $provincie);
                }
                else{
                    $query = $this->db->query($sql, $provincie);
                }

            }
            else{
                $sql = "SELECT school, crm_school 
                        FROM pt_school_view" ;
                if( isset($db) ){
                    $query = $db->query($sql);
                }
                else{
                    $query = $this->db->query($sql);
                }

            }

            return $query->result();
            
    }
    
    
    function clearDB( $db = NULL ){
        
        
        if( isset($db) ){
            $db->query("TRUNCATE pt_crm");
            $db->query("TRUNCATE pt_extra");
            $db->query("TRUNCATE pt_presets");
            $db->query("TRUNCATE pt_tdd");
        }
        else{
            $this->db->query("TRUNCATE pt_crm");
            $this->db->query("TRUNCATE pt_extra");
            $this->db->query("TRUNCATE pt_presets");
            $this->db->query("TRUNCATE pt_tdd");
        }        
    }

    public function updatePreset($data, $id, $db = NULL){
        $update_data = array(
            'beurs' => $data['beurs'],
            'andere_school' => FALSE,
            'provincie' => $data['provincie'],
            'school' => $data['school'],
            'diplomaLV' => $data['diplomaLV'],
            'diploma' => $data['diploma'],
            'diplomaSub' => $data['diplomaSub'],
            'grad_jaar' => $data['grad_jaar']

        );
        
        $where = "id = " . $id;
        
        if( isset($db) ){
            $query = $db->update_string('pt_presets', $update_data, $where); 
            $db->query( $query );
        }
        else{
            $query = $this->db->update_string('pt_presets', $update_data, $where); 
            $this->db->query( $query );
        }
        
        
    }
    public function insertPreset($data, $db = NULL) {
        $insert_data = array(
            'beurs' => $data['beurs'],
            'andere_school' => FALSE,
            'provincie' => $data['provincie'],
            'school' => $data['school'],
            'diplomaLV' => $data['diplomaLV'],
            'diploma' => $data['diploma'],
            'diplomaSub' => $data['diplomaSub'],
            'grad_jaar' => $data['grad_jaar']
        );
        if( isset($db) ){
            $query = $db->insert_string('pt_presets', $insert_data); 
            $db->query( $query );
        }
        else{
            $query = $this->db->insert_string('pt_presets', $insert_data); 
            $this->db->query( $query );
        }

    }
    
    public function updateTdd($datum, $id, $db = NULL){
        $update_data = array(
            'datum' => $datum
        );
        
        $where = "id = " . $id;
        
        if( isset($db) ){
            $query = $db->update_string('pt_tdd', $update_data, $where); 
            $db->query( $query );
        }
        else{
            $query = $this->db->update_string('pt_tdd', $update_data, $where); 
            $this->db->query( $query );
        }
        
        
    }
    public function insertTdd($datum, $db = NULL){
        $insert_data = array(
            'datum' => $datum
        );
                
        if( isset($db) ){
            $query = $db->insert_string('pt_tdd', $insert_data); 
            $db->query( $query );
        }
        else{
            $query = $this->db->insert_string('pt_tdd', $insert_data); 
            $this->db->query( $query );
        }
        
        
    }


    
    
}