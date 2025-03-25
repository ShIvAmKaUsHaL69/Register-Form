<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function check_email_exists($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('basicinfo');
        return $query->num_rows() > 0;
    }

    public function insert_user($data) {
        // Start transaction
        $this->db->trans_start();
        
        // Insert into basicinfo
        $this->db->insert('basicinfo', $data);
        $user_id = $this->db->insert_id();
        
        // Insert into other tables with same id
        $this->db->insert('professionaldetail', ['id' => $user_id]);
        $this->db->insert('payment', ['id' => $user_id]);
        $this->db->insert('eventprefrences', ['id' => $user_id]);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status()) {
            return $user_id;
        }
        return false;
    }

    public function verify_login($email, $password) {
        $this->db->where('email', $email);
        $query = $this->db->get('basicinfo');
        
        if ($query->num_rows() > 0) {
            $user = $query->row();
            if ($password === $user->password) {
                return $user;
            }
        }
        return false;
    }

    public function get_user_by_id($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('basicinfo');
        return $query->row();
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

    public function update_registration_details($user_id, $data) {
        $this->db->where('id', $user_id);
        return $this->db->update('basicinfo', $data);
    }

    public function get_professional_details($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('professionaldetail');
        return $query->row();
    }

    public function get_event_preferences($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('eventprefrences');
        return $query->row();
    }

    public function get_payment_details($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('payment');
        return $query->row();
    }
} 