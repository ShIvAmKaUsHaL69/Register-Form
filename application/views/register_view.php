<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            position: relative;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        input:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.2);
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            display: none;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .field-error {
            border-color: #dc3545 !important;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            position: relative;
        }
        .close {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }
        .close:hover {
            color: #333;
        }

        /* Additional styles for checkboxes */
        .checkbox-group {
            margin-top: 10px;
        }
        .form-check {
            margin-bottom: 10px;
        }
        .form-check-input {
            width: auto;
            margin-right: 10px;
        }
        .form-check-label {
            display: inline;
        }
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        select:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.2);
        }

        /* Add styles for user info and login button */
        .user-info {
            position: absolute;
            top: 20px;
            right: 20px;
            display: none;
        }
        .user-info span {
            color: #333;
            font-weight: 500;
        }
        .login-button {
            position: absolute;
            top: 20px;
            width: 100px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        .login-button:hover {
            background-color: #45a049;
        }

        /* Add styles for back button */
        .back-button {
            background-color: #6c757d;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.3s;
            margin-right: 10px;
        }
        .back-button:hover {
            background-color: #5a6268;
        }
        .button-group {
            display: flex;
            gap: 10px;
        }
        .button-group button {
            flex: 1;
        }

        /* Add styles for download button */
        .download-button {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s;
            margin-top: 20px;
            display: none;
        }
        .download-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Add user info div -->
    <div class="user-info" id="userInfo">
        Welcome, <span id="userName"></span>
    </div>

    <!-- Add login button -->
    <button class="login-button" id="loginButton">Login</button>

    <div class="container">
        <h2>Registration Form</h2>
        
        <div class="alert alert-success" id="success-message"></div>
        <div class="alert alert-danger" id="error-message"></div>

        <form id="registrationForm" method="post">
            <input type="hidden" name="user_id" id="registration_user_id">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter your name">
                <div class="error" id="name-error"></div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email">
                <div class="error" id="email-error"></div>
            </div>

            <div class="form-group">
                <label for="phone_no">Phone Number</label>
                <input type="tel" name="phone_no" id="phone_no" placeholder="Enter your phone number">
                <div class="error" id="phone_no-error"></div>
            </div>

            <div class="form-group">
                <label for="country">Country</label>
                <input type="text" name="country" id="country" placeholder="Enter your country">
                <div class="error" id="country-error"></div>
            </div>

            <button type="submit">Next</button>
        </form>
    </div>

    <!-- Login Modal -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Login to Continue</h2>
            <div class="alert alert-danger" id="login-error" style="display: none;"></div>
            
            <form id="loginForm" method="post">
                <div class="form-group">
                    <label for="login_email">Email</label>
                    <input type="email" name="login_email" id="login_email" placeholder="Enter your email">
                    <div class="error" id="login_email-error"></div>
                </div>

                <div class="form-group">
                    <label for="login_password">Password</label>
                    <input type="password" name="login_password" id="login_password" placeholder="Enter your password">
                    <div class="error" id="login_password-error"></div>
                </div>

                <button type="submit">Login</button>
            </form>
        </div>
    </div>

    <!-- Professional Details Form -->
    <div id="professionalForm" class="container" style="display: none;">
        <h2>Professional Details</h2>
        
        <div class="alert alert-success" id="prof-success-message"></div>
        <div class="alert alert-danger" id="prof-error-message"></div>

        <form id="profDetailsForm" method="post">
            <div class="form-group">
                <label for="organization_detail">Organization Detail</label>
                <input type="text" name="organization_detail" id="organization_detail" placeholder="Enter your organization details">
                <div class="error" id="organization_detail-error"></div>
            </div>

            <div class="form-group">
                <label for="job_title">Job Title</label>
                <input type="text" name="job_title" id="job_title" placeholder="Enter your job title">
                <div class="error" id="job_title-error"></div>
            </div>

            <div class="form-group">
                <label for="industry">Industry</label>
                <select name="industry" id="industry">
                    <option value="">Select Industry</option>
                    <option value="Technology">Technology</option>
                    <option value="Healthcare">Healthcare</option>
                    <option value="Finance">Finance</option>
                    <option value="Education">Education</option>
                    <option value="Manufacturing">Manufacturing</option>
                    <option value="Retail">Retail</option>
                    <option value="Other">Other</option>
                </select>
                <div class="error" id="industry-error"></div>
            </div>

            <div class="form-group">
                <label for="experience">Experience (in years)</label>
                <input type="number" name="experience" id="experience" min="0" step="0.5" placeholder="Enter your experience">
                <div class="error" id="experience-error"></div>
            </div>

            <div class="button-group">
                <button type="button" class="back-button" onclick="showForm('registration')">Back</button>
                <button type="submit">Next</button>
            </div>
        </form>
    </div>

    <!-- Event Preferences Form -->
    <div id="preferencesForm" class="container" style="display: none;">
        <h2>Event Preferences</h2>
        
        <div class="alert alert-success" id="pref-success-message"></div>
        <div class="alert alert-danger" id="pref-error-message"></div>

        <form id="eventPreferencesForm" method="post">
            <div class="form-group">
                <label>Session Times</label>
                <div class="checkbox-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="sessions[]" value="morning" id="morning">
                        <label class="form-check-label" for="morning">Morning</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="sessions[]" value="noon" id="noon">
                        <label class="form-check-label" for="noon">Noon</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="sessions[]" value="evening" id="evening">
                        <label class="form-check-label" for="evening">Evening</label>
                    </div>
                </div>
                <div class="error" id="sessions-error"></div>
            </div>

            <div class="form-group">
                <label for="attendance">Attendance Mode</label>
                <select name="attendance" id="attendance">
                    <option value="">Select Attendance Mode</option>
                    <option value="virtual">Virtual</option>
                    <option value="in-person">In-person</option>
                </select>
                <div class="error" id="attendance-error"></div>
            </div>

            <div class="form-group">
                <label for="preferences">Dietary Preference</label>
                <select name="preferences" id="preferences">
                    <option value="">Select Dietary Preference</option>
                    <option value="veg">Vegetarian</option>
                    <option value="non-veg">Non-Vegetarian</option>
                </select>
                <div class="error" id="preferences-error"></div>
            </div>

            <div class="button-group">
                <button type="button" class="back-button" onclick="showForm('professional')">Back</button>
                <button type="submit">Next</button>
            </div>
        </form>
    </div>

    <!-- Payment Form -->
    <div id="paymentForm" class="container" style="display: none;">
        <h2>Payment Details</h2>
        
        <div class="alert alert-success" id="payment-success-message"></div>
        <div class="alert alert-danger" id="payment-error-message"></div>

        <form id="paymentDetailsForm" method="post">
            <div class="form-group">
                <label for="ticket_type">Ticket Type</label>
                <select name="ticket_type" id="ticket_type">
                    <option value="">Select Ticket Type</option>
                    <option value="General">General</option>
                    <option value="VIP">VIP</option>
                    <option value="VVIP">VVIP</option>
                </select>
                <div class="error" id="ticket_type-error"></div>
            </div>

            <div class="form-group">
                <label for="coupon">Coupon Code (Optional)</label>
                <input type="text" name="coupon" id="coupon" placeholder="Enter coupon code if available">
                <div class="error" id="coupon-error"></div>
            </div>

            <div class="form-group">
                <label for="payment_mode">Payment Mode</label>
                <select name="payment_mode" id="payment_mode">
                    <option value="">Select Payment Mode</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="PayPal">PayPal</option>
                    <option value="Net Banking">Net Banking</option>
                </select>
                <div class="error" id="payment_mode-error"></div>
            </div>

            <div class="button-group">
                <button type="button" class="back-button" onclick="showForm('preferences')">Back</button>
                <button type="submit">Complete Registration</button>
            </div>
        </form>

        <button class="download-button" id="downloadPDF" style="display: none;">
            <i class="fas fa-download"></i> Download Registration Details
        </button>
    </div>

    <script>
    $(document).ready(function() {
        var modal = $('#loginModal');
        var span = $('.close');
        var registrationContainer = $('.container').first();
        var professionalForm = $('#professionalForm');
        var preferencesForm = $('#preferencesForm');
        var paymentForm = $('#paymentForm');
        var loginButton = $('#loginButton');
        var userInfo = $('#userInfo');
        
        // Function to show form and load data
        window.showForm = function(formType) {
            const userId = localStorage.getItem('user_id');
            
            // Hide all forms and success messages first
            $('.container').hide();
            $('.alert').hide();
            
            // Show appropriate form
            switch(formType) {
                case 'registration':
                    registrationContainer.show();
                    loadRegistrationData(userId);
                    break;
                case 'professional':
                    professionalForm.show();
                    loadProfessionalData(userId);
                    break;
                case 'preferences':
                    preferencesForm.show();
                    loadPreferencesData(userId);
                    break;
                case 'payment':
                    paymentForm.show();
                    loadPaymentData(userId);
                    break;
            }
        };

        // Function to load professional data
        function loadProfessionalData(userId) {
            $.ajax({
                url: '<?php echo base_url("index.php/register/get_professional_data"); ?>',
                type: 'POST',
                data: { user_id: userId },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#organization_detail').val(response.data.organization_detail);
                        $('#job_title').val(response.data.job_title);
                        $('#industry').val(response.data.industry);
                        $('#experience').val(response.data.experience);
                    }
                }
            });
        }

        // Function to load preferences data
        function loadPreferencesData(userId) {
            $.ajax({
                url: '<?php echo base_url("index.php/register/get_preferences_data"); ?>',
                type: 'POST',
                data: { user_id: userId },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        // Set sessions
                        const sessions = response.data.sessions.split(',');
                        sessions.forEach(session => {
                            $(`input[name="sessions[]"][value="${session}"]`).prop('checked', true);
                        });
                        
                        // Set attendance and preferences
                        $('#attendance').val(response.data.attendence);
                        $('#preferences').val(response.data.preferences);
                    }
                }
            });
        }

        // Function to load payment data
        function loadPaymentData(userId) {
            $.ajax({
                url: '<?php echo base_url("index.php/register/get_payment_data"); ?>',
                type: 'POST',
                data: { user_id: userId },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#ticket_type').val(response.data.ticket_type);
                        $('#coupon').val(response.data.coupon);
                        $('#payment_mode').val(response.data.payment_mode);
                    }
                }
            });
        }

        // Function to load registration data
        function loadRegistrationData(userId) {
            if (!userId) {
                // For new registration, make email editable
                $('#email').prop('readonly', false);
                $('#registration_user_id').val('');
                return;
            }

            $.ajax({
                url: '<?php echo base_url("index.php/register/get_registration_data"); ?>',
                type: 'POST',
                data: { user_id: userId },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#registration_user_id').val(userId);
                        $('#name').val(response.data.name);
                        $('#email').val(response.data.email);
                        $('#phone_no').val(response.data.phone_no);
                        $('#country').val(response.data.country);
                        // Make email readonly for existing users
                        $('#email').prop('readonly', true);
                    }
                }
            });
        }

        // Function to show appropriate form based on progress
        function showFormByProgress(progress) {
            // Hide all forms first
            $('.container').hide();
            
            // Show appropriate form based on progress
            switch(progress) {
                case 1:
                    professionalForm.show();
                    loadProfessionalData(localStorage.getItem('user_id'));
                    break;
                case 2:
                    preferencesForm.show();
                    loadPreferencesData(localStorage.getItem('user_id'));
                    break;
                case 3:
                    paymentForm.show();
                    loadPaymentData(localStorage.getItem('user_id'));
                    break;
                case 4:
                    paymentForm.show();
                    loadPaymentData(localStorage.getItem('user_id'));
                    $('#payment-success-message').html('Registration completed successfully!').show();
                    break;
                default:
                    registrationContainer.show();
            }
        }

        // Check if user is already logged in
        const userId = localStorage.getItem('user_id');
        if (userId) {
            $.ajax({
                url: '<?php echo base_url("index.php/register/check_progress"); ?>',
                type: 'POST',
                data: { user_id: userId },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        // Show user name and hide login button
                        $('#userName').text(response.name);
                        userInfo.show();
                        loginButton.hide();
                        
                        // Show appropriate form
                        showFormByProgress(parseInt(response.form_progress));
                    } else {
                        localStorage.removeItem('user_id');
                        userInfo.hide();
                        loginButton.show();
                        registrationContainer.show();
                    }
                },
                error: function() {
                    localStorage.removeItem('user_id');
                    userInfo.hide();
                    loginButton.show();
                    registrationContainer.show();
                }
            });
        } else {
            // Show login button and registration form
            loginButton.show();
            userInfo.hide();
            registrationContainer.show();
        }

        // Login button click handler
        loginButton.click(function() {
            modal.css('display', 'flex');
        });

        span.click(function() {
            modal.hide();
        });

        $(window).click(function(event) {
            if (event.target == modal[0]) {
                modal.hide();
            }
        });

        $('#registrationForm').on('submit', function(e) {
            e.preventDefault();
            
            $('.error').html('');
            $('input').removeClass('field-error');
            $('.alert').hide();

            const userId = $('#registration_user_id').val();
            const formData = $(this).serialize();

            $.ajax({
                url: '<?php echo base_url("index.php/register/submit"); ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if(response.status === 'success') {
                        if (!userId) {
                            // New registration
                            localStorage.setItem('user_id', response.user_id);
                            localStorage.setItem('form_progress', '1');
                            $('#userName').text(response.name);
                            userInfo.show();
                            loginButton.hide();
                        } else {
                            // Update existing registration
                            localStorage.setItem('form_progress', response.form_progress);
                        }
                        
                        // Always show professional form next
                        registrationContainer.hide();
                        professionalForm.show();
                        loadProfessionalData(response.user_id || userId);
                        $('#prof-success-message').html(response.message).show();
                    } else {
                        if(response.errors) {
                            $.each(response.errors, function(field, error) {
                                $('#' + field).addClass('field-error');
                                $('#' + field + '-error').html(error);
                            });
                        } else {
                            $('#error-message').html(response.message).show();
                        }
                    }
                },
                error: function(xhr, status, error) {
                    $('#error-message').html('An error occurred. Please try again. Error: ' + error).show();
                }
            });
        });

        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            
            $('.error').html('');
            $('input').removeClass('field-error');
            $('#login-error').hide();

            $.ajax({
                url: '<?php echo base_url("index.php/register/verify_login"); ?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if(response.status === 'success') {
                        // Store user ID in localStorage
                        localStorage.setItem('user_id', response.user_id);
                        
                        // Show user name and hide login button
                        $('#userName').text(response.name);
                        userInfo.show();
                        loginButton.hide();
                        
                        // Hide login modal and registration form
                        modal.hide();
                        
                        // Show appropriate form based on progress
                        showFormByProgress(parseInt(response.form_progress));
                        
                        $('#success-message').html(response.message).show();
                    } else {
                        $('#login-error').html(response.message).show();
                    }
                },
                error: function(xhr, status, error) {
                    $('#login-error').html('An error occurred. Please try again.').show();
                }
            });
        });

        $('#profDetailsForm').on('submit', function(e) {
            e.preventDefault();
            
            $('.error').html('');
            $('input').removeClass('field-error');
            $('.alert').hide();

            const userId = localStorage.getItem('user_id');
            if (!userId) {
                $('#prof-error-message').html('Session expired. Please login again.').show();
                return;
            }

            var formData = $(this).serialize() + '&user_id=' + userId;

            $.ajax({
                url: '<?php echo base_url("index.php/register/update_professional"); ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if(response.status === 'success') {
                        // Hide professional form and show preferences form
                        $('#professionalForm').hide();
                        $('#preferencesForm').show();
                        $('#pref-success-message').html(response.message).show();
                    } else {
                        if(response.errors) {
                            $.each(response.errors, function(field, error) {
                                $('#' + field).addClass('field-error');
                                $('#' + field + '-error').html(error);
                            });
                        } else {
                            $('#prof-error-message').html(response.message).show();
                        }
                    }
                },
                error: function(xhr, status, error) {
                    $('#prof-error-message').html('An error occurred. Please try again.').show();
                }
            });
        });

        $('#eventPreferencesForm').on('submit', function(e) {
            e.preventDefault();
            
            $('.error').html('');
            $('input, select').removeClass('field-error');
            $('.alert').hide();

            const userId = localStorage.getItem('user_id');
            if (!userId) {
                $('#pref-error-message').html('Session expired. Please login again.').show();
                return;
            }

            // Check if at least one session is selected
            if ($('input[name="sessions[]"]:checked').length === 0) {
                $('#sessions-error').html('Please select at least one session time');
                return;
            }

            // Check if attendance is selected
            if (!$('#attendance').val()) {
                $('#attendance-error').html('Please select attendance mode');
                $('#attendance').addClass('field-error');
                return;
            }

            var formData = $(this).serialize() + '&user_id=' + userId;

            $.ajax({
                url: '<?php echo base_url("index.php/register/update_preferences"); ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if(response.status === 'success') {
                        // Hide preferences form and show payment form
                        $('#preferencesForm').hide();
                        $('#paymentForm').show();
                        $('#payment-success-message').html(response.message).show();
                    } else {
                        if(response.errors) {
                            $.each(response.errors, function(field, error) {
                                $('#' + field + '-error').html(error);
                                $('#' + field).addClass('field-error');
                            });
                        } else {
                            $('#pref-error-message').html(response.message).show();
                        }
                    }
                },
                error: function(xhr, status, error) {
                    $('#pref-error-message').html('An error occurred. Please try again.').show();
                    console.error(xhr.responseText);
                }
            });
        });

        $('#paymentDetailsForm').on('submit', function(e) {
            e.preventDefault();
            
            $('.error').html('');
            $('input, select').removeClass('field-error');
            $('.alert').hide();

            const userId = localStorage.getItem('user_id');
            if (!userId) {
                $('#payment-error-message').html('Session expired. Please login again.').show();
                return;
            }

            // Check required fields
            if (!$('#ticket_type').val()) {
                $('#ticket_type-error').html('Please select ticket type');
                $('#ticket_type').addClass('field-error');
                return;
            }

            if (!$('#payment_mode').val()) {
                $('#payment_mode-error').html('Please select payment mode');
                $('#payment_mode').addClass('field-error');
                return;
            }

            var formData = $(this).serialize() + '&user_id=' + userId;

            $.ajax({
                url: '<?php echo base_url("index.php/register/update_payment"); ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if(response.status === 'success') {
                        $('#payment-success-message').html(response.message).show();
                        // Show download button without hiding the form
                        $('#downloadPDF').show();
                    } else {
                        if(response.errors) {
                            $.each(response.errors, function(field, error) {
                                $('#' + field + '-error').html(error);
                                $('#' + field).addClass('field-error');
                            });
                        } else {
                            $('#payment-error-message').html(response.message).show();
                        }
                    }
                },
                error: function(xhr, status, error) {
                    $('#payment-error-message').html('An error occurred. Please try again.').show();
                    console.error(xhr.responseText);
                }
            });
        });

        // Add download PDF button handler
        $('#downloadPDF').on('click', function() {
            const userId = localStorage.getItem('user_id');
            if (!userId) {
                alert('Session expired. Please login again.');
                return;
            }

            // Create a form and submit it to download the PDF
            const form = $('<form>', {
                'method': 'POST',
                'action': '<?php echo base_url("index.php/register/download_pdf"); ?>'
            });

            $('<input>').attr({
                'type': 'hidden',
                'name': 'user_id',
                'value': userId
            }).appendTo(form);

            form.appendTo('body').submit().remove();
        });
    });
    </script>

    <!-- Add Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html> 