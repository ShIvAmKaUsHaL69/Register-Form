<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function insert_user($data) {
        return $this->db->insert('temp', $data);
    }

    public function check_email_exists($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('basicinfo');
        return $query->num_rows() > 0;
    }

    public function verify_login($email, $password) {
        $this->db->where('email', $email);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('temp');
        
        if ($query->num_rows() > 0) {
            $user = $query->row();
            if ($password === $user->password) {
                return $user;
            }
        }
        return false;
    }

    public function move_to_basicinfo($email) {
        // Get user data from temp
        $this->db->where('email', $email);
        $query = $this->db->get('temp');
        
        if ($query->num_rows() > 0) {
            $user = $query->row_array();
            
            // Remove id field since it's auto increment in basicinfo
            unset($user['id']);
            
            // Add form_progress field
            $user['form_progress'] = 1;
            
            // Insert into basicinfo table and get the new id
            $this->db->trans_start();
            $this->db->insert('basicinfo', $user);
            $new_id = $this->db->insert_id();
            
            // Insert into professionaldetail table with same id
            $this->db->insert('professionaldetail', ['id' => $new_id]);
            
            // Insert into payment table with same id
            $this->db->insert('payment', ['id' => $new_id]);
            
            // Insert into eventprefrences table with same id 
            $this->db->insert('eventprefrences', ['id' => $new_id]);
            
            // Delete from temp table
            $this->db->where('email', $email);
            $this->db->delete('temp');
            $this->db->trans_complete();
            
            if ($this->db->trans_status()) {
                return $new_id;
            }
        }
        return false;
    }

    public function update_professional_details($user_id, $data) {
        $this->db->where('id', $user_id);
        return $this->db->update('professionaldetail', $data);
    }

    public function update_form_progress($user_id, $progress) {
        $this->db->where('id', $user_id);
        return $this->db->update('basicinfo', ['form_progress' => $progress]);
    }

    public function update_event_preferences($user_id, $data) {
        $this->db->where('id', $user_id);
        return $this->db->update('eventprefrences', $data);
    }

    public function update_payment_details($user_id, $data) {
        $this->db->where('id', $user_id);
        return $this->db->update('payment', $data);
    }

    
} 