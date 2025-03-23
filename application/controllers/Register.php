<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('register_view');
    }

    public function submit() {
        // Set validation rules
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone_no', 'Phone Number', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');

        if ($this->form_validation->run() == FALSE) {
            $errors = array();
            foreach (['name', 'email', 'phone_no', 'country', 'password'] as $field) {
                if (form_error($field)) {
                    $errors[$field] = strip_tags(form_error($field));
                }
            }
            echo json_encode([
                'status' => 'error',
                'errors' => $errors
            ]);
        } else {
            // Check if email already exists
            $email = $this->input->post('email');
            if ($this->user_model->check_email_exists($email)) {
                echo json_encode([
                    'status' => 'error',
                    'errors' => [
                        'email' => 'This email address is already registered. Please try a different email or Login'
                    ]
                ]);
                return;
            }

            $data = array(
                'name' => $this->input->post('name'),
                'email' => $email,
                'phone_no' => $this->input->post('phone_no'),
                'country' => $this->input->post('country'),
                'password' => substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8)
            );

            if ($this->user_model->insert_user($data)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Registration successful! Please login to continue.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Registration failed. Please try again.'
                ]);
            }
        }
    }

    public function verify_login() {
        $email = $this->input->post('login_email');
        $password = $this->input->post('login_password');

        // Validate required fields
        if (empty($email) || empty($password)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Please enter both email and password.'
            ]);
            return;
        }

        // Verify login credentials
        $user = $this->user_model->verify_login($email, $password);

        if ($user) {
            // Move data to basicinfo table and get new ID
            $new_id = $this->user_model->move_to_basicinfo($email);
            if ($new_id) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Login successful!',
                    'user_id' => $new_id
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error processing your request. Please try again.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid email or password. Please try again.'
            ]);
        }
    }

    public function update_professional() {
        // Set validation rules
        $this->form_validation->set_rules('organization_detail', 'Organization Detail', 'required');
        $this->form_validation->set_rules('job_title', 'Job Title', 'required');
        $this->form_validation->set_rules('industry', 'Industry', 'required');
        $this->form_validation->set_rules('experience', 'Experience', 'required|numeric');
        $this->form_validation->set_rules('user_id', 'User ID', 'required');

        if ($this->form_validation->run() == FALSE) {
            $errors = array();
            foreach (['organization_detail', 'job_title', 'industry', 'experience'] as $field) {
                if (form_error($field)) {
                    $errors[$field] = strip_tags(form_error($field));
                }
            }
            echo json_encode([
                'status' => 'error',
                'errors' => $errors
            ]);
            return;
        }

        $user_id = $this->input->post('user_id');
        $data = array(
            'organization_detail' => $this->input->post('organization_detail'),
            'job_title' => $this->input->post('job_title'),
            'industry' => $this->input->post('industry'),
            'experience' => $this->input->post('experience')
        );

        if ($this->user_model->update_professional_details($user_id, $data)) {
            // Update form_progress in basicinfo table
            $this->user_model->update_form_progress($user_id, 2);
            echo json_encode([
                'status' => 'success',
                'message' => 'Professional details updated successfully!'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update professional details. Please try again.'
            ]);
        }
    }

    public function update_preferences() {
        // Validate user_id and attendance
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('attendance', 'Attendance Mode', 'required');

        // Custom validation for sessions array
        if (empty($this->input->post('sessions'))) {
            echo json_encode([
                'status' => 'error',
                'errors' => [
                    'sessions' => 'Please select at least one session time'
                ]
            ]);
            return;
        }

        if ($this->form_validation->run() == FALSE) {
            $errors = array();
            foreach (['attendance'] as $field) {
                if (form_error($field)) {
                    $errors[$field] = strip_tags(form_error($field));
                }
            }
            echo json_encode([
                'status' => 'error',
                'errors' => $errors
            ]);
            return;
        }

        $user_id = $this->input->post('user_id');
        $sessions = $this->input->post('sessions');
        
        $data = array(
            'sessions' => is_array($sessions) ? implode(',', $sessions) : $sessions,
            'attendence' => $this->input->post('attendance'),
            'preferences' => $this->input->post('preferences') 
        );

        if ($this->user_model->update_event_preferences($user_id, $data)) {
            // Update form_progress in basicinfo table
            $this->user_model->update_form_progress($user_id, 3);
            echo json_encode([
                'status' => 'success',
                'message' => 'Event preferences updated successfully!'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update event preferences. Please try again.'
            ]);
        }
    }

    public function update_payment() {
        // Set validation rules
        $this->form_validation->set_rules('ticket_type', 'Ticket Type', 'required');
        $this->form_validation->set_rules('payment_mode', 'Payment Mode', 'required');
        $this->form_validation->set_rules('user_id', 'User ID', 'required');

        if ($this->form_validation->run() == FALSE) {
            $errors = array();
            foreach (['ticket_type', 'payment_mode'] as $field) {
                if (form_error($field)) {
                    $errors[$field] = strip_tags(form_error($field));
                }
            }
            echo json_encode([
                'status' => 'error',
                'errors' => $errors
            ]);
            return;
        }

        $user_id = $this->input->post('user_id');
        $data = array(
            'ticket_type' => $this->input->post('ticket_type'),
            'payment_mode' => $this->input->post('payment_mode'), 
            'payment_id' => rand(1000000,9999999),
            'registration_id' => rand(1000000,9999999),
        );

        // Add coupon if provided
        $coupon = $this->input->post('coupon');
        if (!empty($coupon)) {
            if($coupon == 'COUPON5'){
                $data['payment'] = '950';
            }
            else if($coupon == 'COUPON10'){
                $data['payment'] = '900';
            }
            else if($coupon == 'COUPON15'){
                $data['payment'] = '850';
            }else {
                $data['payment'] = '1000';
            }

            $data['coupon'] = $coupon;
        }

        if ($this->user_model->update_payment_details($user_id, $data)) {
            // Update form_progress in basicinfo table
            $this->user_model->update_form_progress($user_id, 4);
            echo json_encode([
                'status' => 'success',
                'message' => 'Details updated successfully!'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update payment details. Please try again.'
            ]);
        }
    }
} 