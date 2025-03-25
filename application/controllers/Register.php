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
            foreach (['name', 'email', 'phone_no', 'country'] as $field) {
                if (form_error($field)) {
                    $errors[$field] = strip_tags(form_error($field));
                }
            }
            echo json_encode([
                'status' => 'error',
                'errors' => $errors
            ]);
        } else {
            $email = $this->input->post('email');
            $user_id = $this->input->post('user_id');

            // If user_id is provided, it's an update
            if ($user_id) {
                $this->update_registration();
                return;
            }

            // Check if email already exists for new registration
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
                'password' => substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8),
                'form_progress' => 1
            );

            $user_id = $this->user_model->insert_user($data);
            if ($user_id) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Registration successful! Please complete your professional details.',
                    'user_id' => $user_id
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Registration failed. Please try again.'
                ]);
            }
        }
    }

    public function update_registration() {
        // Set validation rules (excluding email)
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('phone_no', 'Phone Number', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('user_id', 'User ID', 'required');

        if ($this->form_validation->run() == FALSE) {
            $errors = array();
            foreach (['name', 'phone_no', 'country'] as $field) {
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
            'name' => $this->input->post('name'),
            'phone_no' => $this->input->post('phone_no'),
            'country' => $this->input->post('country')
        );

        if ($this->user_model->update_registration_details($user_id, $data)) {
            // Get current form progress
            $user = $this->user_model->get_user_by_id($user_id);
            echo json_encode([
                'status' => 'success',
                'message' => 'Registration details updated successfully!',
                'form_progress' => $user->form_progress
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update registration details. Please try again.'
            ]);
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
            echo json_encode([
                'status' => 'success',
                'message' => 'Login successful!',
                'user_id' => $user->id,
                'name' => $user->name,
                'form_progress' => $user->form_progress
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid email or password. Please try again.'
            ]);
        }
    }

    public function check_progress() {
        $user_id = $this->input->post('user_id');
        if ($user_id) {
            $user = $this->user_model->get_user_by_id($user_id);
            if ($user) {
                echo json_encode([
                    'status' => 'success',
                    'form_progress' => $user->form_progress,
                    'name' => $user->name
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'User not found.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No user ID provided.'
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
        } else {
            $data['payment'] = '1000';
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

    public function get_registration_data() {
        $user_id = $this->input->post('user_id');
        if ($user_id) {
            $data = $this->user_model->get_user_by_id($user_id);
            if ($data) {
                echo json_encode([
                    'status' => 'success',
                    'data' => $data
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No data found.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No user ID provided.'
            ]);
        }
    }

    public function get_professional_data() {
        $user_id = $this->input->post('user_id');
        if ($user_id) {
            $data = $this->user_model->get_professional_details($user_id);
            if ($data) {
                echo json_encode([
                    'status' => 'success',
                    'data' => $data
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No data found.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No user ID provided.'
            ]);
        }
    }

    public function get_preferences_data() {
        $user_id = $this->input->post('user_id');
        if ($user_id) {
            $data = $this->user_model->get_event_preferences($user_id);
            if ($data) {
                echo json_encode([
                    'status' => 'success',
                    'data' => $data
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No data found.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No user ID provided.'
            ]);
        }
    }

    public function get_payment_data() {
        $user_id = $this->input->post('user_id');
        if ($user_id) {
            $data = $this->user_model->get_payment_details($user_id);
            if ($data) {
                echo json_encode([
                    'status' => 'success',
                    'data' => $data
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No data found.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No user ID provided.'
            ]);
        }
    }

    public function download_pdf() {
        $user_id = $this->input->post('user_id');
        if (!$user_id) {
            show_error('Invalid request');
            return;
        }

        // Load all user data
        $basic_info = $this->user_model->get_user_by_id($user_id);
        $professional_info = $this->user_model->get_professional_details($user_id);
        $preferences = $this->user_model->get_event_preferences($user_id);
        $payment_info = $this->user_model->get_payment_details($user_id);

        if (!$basic_info || !$payment_info) {
            show_error('User data not found');
            return;
        }

        // Load FPDF library
        require(APPPATH . 'libraries/fpdf/fpdf.php');

        // Create new PDF document
        $pdf = new FPDF();
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('Arial', 'B', 16);

        // Title
        $pdf->Cell(0, 10, 'Registration Details', 0, 1, 'C');
        $pdf->Ln(10);

        // Basic Information
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->Cell(0, 10, 'Basic Information', 0, 1, 'L', true);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(5);
        
        $pdf->Cell(40, 8, 'Name:', 0);
        $pdf->Cell(0, 8, $basic_info->name, 0, 1);
        
        $pdf->Cell(40, 8, 'Email:', 0);
        $pdf->Cell(0, 8, $basic_info->email, 0, 1);
        
        $pdf->Cell(40, 8, 'Phone:', 0);
        $pdf->Cell(0, 8, $basic_info->phone_no, 0, 1);
        
        $pdf->Cell(40, 8, 'Country:', 0);
        $pdf->Cell(0, 8, $basic_info->country, 0, 1);
        $pdf->Ln(10);

        // Professional Details
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Professional Details', 0, 1, 'L', true);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(5);
        
        $pdf->Cell(60, 8, 'Organization:', 0);
        $pdf->Cell(0, 8, $professional_info->organization_detail, 0, 1);
        
        $pdf->Cell(60, 8, 'Job Title:', 0);
        $pdf->Cell(0, 8, $professional_info->job_title, 0, 1);
        
        $pdf->Cell(60, 8, 'Industry:', 0);
        $pdf->Cell(0, 8, $professional_info->industry, 0, 1);
        
        $pdf->Cell(60, 8, 'Experience:', 0);
        $pdf->Cell(0, 8, $professional_info->experience . ' years', 0, 1);
        $pdf->Ln(10);

        // Event Preferences
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Event Preferences', 0, 1, 'L', true);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(5);
        
        $pdf->Cell(60, 8, 'Sessions:', 0);
        $pdf->Cell(0, 8, $preferences->sessions, 0, 1);
        
        $pdf->Cell(60, 8, 'Attendance Mode:', 0);
        $pdf->Cell(0, 8, $preferences->attendence, 0, 1);
        
        $pdf->Cell(60, 8, 'Dietary Preference:', 0);
        $pdf->Cell(0, 8, $preferences->preferences, 0, 1);
        $pdf->Ln(10);

        // Payment Details
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Payment Details', 0, 1, 'L', true);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(5);
        
        $pdf->Cell(60, 8, 'Ticket Type:', 0);
        $pdf->Cell(0, 8, $payment_info->ticket_type, 0, 1);
        
        $pdf->Cell(60, 8, 'Payment Mode:', 0);
        $pdf->Cell(0, 8, $payment_info->payment_mode, 0, 1);
        
        $pdf->Cell(60, 8, 'Amount Paid:', 0);
        $pdf->Cell(0, 8, '$' . $payment_info->payment, 0, 1);
        
        $pdf->Cell(60, 8, 'Coupon Applied:', 0);
        $pdf->Cell(0, 8, $payment_info->coupon ? $payment_info->coupon : 'None', 0, 1);
        $pdf->Ln(10);

        // Registration Information
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Registration Information', 0, 1, 'L', true);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(5);
        
        $pdf->SetTextColor(0, 128, 0); // Green color for important information
        $pdf->Cell(60, 8, 'Registration ID:', 0);
        $pdf->Cell(0, 8, $payment_info->registration_id, 0, 1);
        
        $pdf->Cell(60, 8, 'Payment ID:', 0);
        $pdf->Cell(0, 8, $payment_info->payment_id, 0, 1);

        // Output PDF
        $pdf->Output('D', 'registration_details_' . $basic_info->name . '.pdf');
    }
} 