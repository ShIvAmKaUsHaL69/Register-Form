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
    </style>
</head>
<body>
    <div class="container">
        <h2>Registration Form</h2>
        
        <div class="alert alert-success" id="success-message"></div>
        <div class="alert alert-danger" id="error-message"></div>

        <form id="registrationForm" method="post">
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

            <button type="submit">Register</button>
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

    <!-- Professional Details Form (Initially Hidden) -->
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

            <button type="submit">Next</button>
        </form>
    </div>

    <!-- Event Preferences Form (Initially Hidden) -->
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

            <button type="submit">Next</button>
        </form>
    </div>

    <!-- Payment Form (Initially Hidden) -->
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

            <button type="submit">Complete Registration</button>
        </form>
    </div>

    <script>
    $(document).ready(function() {
        var modal = $('#loginModal');
        var span = $('.close');
        var registrationContainer = $('.container').first();
        var professionalForm = $('#professionalForm');
        
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

            $.ajax({
                url: '<?php echo base_url("index.php/register/submit"); ?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if(response.status === 'success') {
                        $('#success-message').html(response.message).show();
                        modal.css('display', 'flex');
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
                        
                        // Hide login modal and registration form
                        modal.hide();
                        registrationContainer.hide();
                        
                        // Show professional details form
                        professionalForm.show();
                        
                        $('#success-message').html('Login successful! Please complete your professional details.').show();
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
                        $('#prof-success-message').html(response.message).show();
                        // Hide professional form and show preferences form
                        $('#professionalForm').hide();
                        $('#preferencesForm').show();
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
                        $('#pref-success-message').html(response.message).show();
                        // Hide preferences form and show payment form
                        $('#preferencesForm').hide();
                        $('#paymentForm').show();
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
                        // Redirect to home page or show completion message
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
    });
    </script>
</body>
</html> 