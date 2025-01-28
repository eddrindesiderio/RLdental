<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/signup.css')}}">
    <title>Create Account</title>

</head>
<body>

<div class="main-container">
    <div class="form-container">
        <a href="{{route('welcome')}}" class="hover-link1" style="float: left;">Back</a>
        <p class="header-text">Start Creating Your User Account</p>
        <p class="sub-text">Make Sure You Remember Your Login Information.</p>
        <div class="form-body">
            
            <form action="{{route('signup-form')}}" method="post">
                @csrf
                <div class="label-td">
    <label class="form-label">Full Name:</label>
</div>
<div class="label-td">
    <input 
        type="text" 
        name="full_name" 
        class="input-text" 
        placeholder="Full Name" 
        required
        id="full_name"
    >
    @error('full_name')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    <!-- Error message for Full Name -->
    <div id="full-name-error" style="color: red; font-size: 14px; margin-top: 5px; display: none;">
        Full Name must contain at least a first name and a last name, and cannot exceed 8 words.
    </div>
</div>

<script>
    const fullNameInput = document.getElementById('full_name');
    const fullNameError = document.getElementById('full-name-error');

    // Input event listener for live validation
    fullNameInput.addEventListener('input', () => {
        const fullNameValue = fullNameInput.value.trim();
        
        // Split full name into words
        const words = fullNameValue.split(/\s+/);

        // Validate: Ensure there are at least 2 words (first and last name)
        const hasFirstAndLastName = words.length >= 2;
        
        // Validate: Maximum of 8 words
        const validWordCount = words.length <= 8;
        
        // Show error message if validation fails
        if (!hasFirstAndLastName || !validWordCount) {
            fullNameError.style.display = 'block';
        } else {
            fullNameError.style.display = 'none';
        }
    });

    // Form submission validation
    document.querySelector('form').addEventListener('submit', (e) => {
        const fullNameValue = fullNameInput.value.trim();
        const words = fullNameValue.split(/\s+/);

        // Check the validation conditions
        if (words.length < 2 || words.length > 8) {
            e.preventDefault(); // Prevent form submission if validation fails
            fullNameError.style.display = 'block'; // Show error message
        }
    });
</script>

                <div class="label-td">
                    <label class="form-label">Email:</label>
                </div>
                <div class="label-td">
                    <input type="email" name="email" class="input-text" placeholder="Email Address" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="label-td">
                    <label class="form-label">Mobile Number:</label>
                </div>
                <div class="label-td">
    <input 
        type="text" 
        name="number" 
        class="input-text" 
        placeholder="ex: 09071346898" 
        required 
        pattern="09\d{9}" 
        title="The number must start with 09 and have exactly 11 digits"
        maxlength="11">
    @error('number')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
                </div>
                <div class="label-td">
                    <label class="form-label">Address:</label>
                </div>
                <div class="label-td">
                    <input type="text" name="address" class="input-text" placeholder="Address" required>
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="label-td">
    <label class="form-label">Date of Birth:</label>
</div>
<div class="label-td">
    <input 
        type="date" 
        name="dob" 
        class="input-text" 
        placeholder="Date of Birth" 
        required 
        min="1950-01-01" 
    >
    @error('dob')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="label-td">
    <label class="form-label">Create New Password:</label>
</div>
<div class="label-td">
    <div style="position: relative; width: 100%;">
        <input 
            type="password" 
            id="password" 
            name="password" 
            class="input-text" 
            placeholder="New Password" 
            required 
            style="width: 100%; padding-right: 40px; height: 40px; line-height: 40px;" 
        >
        <span 
            id="togglePassword" 
            style="
                position: absolute;
                top: 38%;
                right: 10px;
                transform: translateY(-50%);
                cursor: pointer;
                font-size: 18px;
                color: #555;
            "
        >
            👁️
        </span>
    </div>
    <div id="password-requirements" style="font-size: 14px; color: red; margin-top: 5px; display: none;">
        <ul style="list-style: none; padding: 0;">
            <li id="uppercase" style="color: red;">• At least 1 uppercase letter</li>
            <li id="special" style="color: red;">• At least 1 special character (!@#$%^&*)</li>
            <li id="length" style="color: red;">• Minimum of 9 characters</li>
        </ul>
    </div>
    <div id="password-error" style="color: red; font-size: 14px; margin-top: 5px; display: none;">
        Password does not meet the requirements.
    </div>
    @error('password')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<script>
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const requirementsDiv = document.getElementById('password-requirements');
    const passwordError = document.getElementById('password-error');
    const requirements = {
        uppercase: document.getElementById('uppercase'),
        special: document.getElementById('special'),
        length: document.getElementById('length'),
    };

    // Toggle password visibility
    togglePassword.addEventListener('click', () => {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;

        // Change eye icon based on visibility
        togglePassword.textContent = type === 'password' ? '👁️' : '🙈';
    });

    // Validate password input
    passwordInput.addEventListener('input', () => {
        const value = passwordInput.value;

        // Show the requirements div only when typing starts
        if (value.length > 0) {
            requirementsDiv.style.display = 'block';
            passwordError.style.display = 'none'; // Hide error while typing
        } else {
            requirementsDiv.style.display = 'none';
        }

        // Check for at least one uppercase letter
        if (/[A-Z]/.test(value)) {
            requirements.uppercase.style.color = 'green';
        } else {
            requirements.uppercase.style.color = 'red';
        }

        // Check for at least one special character
        if (/[!@#$%^&*]/.test(value)) {
            requirements.special.style.color = 'green';
        } else {
            requirements.special.style.color = 'red';
        }

        // Check for minimum 10 characters
        if (value.length >= 9) {
            requirements.length.style.color = 'green';
        } else {
            requirements.length.style.color = 'red';
        }
    });

    // Add form submission validation
    document.querySelector('form').addEventListener('submit', (e) => {
        const value = passwordInput.value;

        // Validate all requirements
        const hasUppercase = /[A-Z]/.test(value);
        const hasSpecialChar = /[!@#$%^&*]/.test(value);
        const hasValidLength = value.length >= 9;

        if (!hasUppercase || !hasSpecialChar || !hasValidLength) {
            e.preventDefault(); // Prevent form submission
            passwordError.style.display = 'block'; // Show error message
        }
    });
</script>




                
                <div class="label-td">
                    <label class="form-label">Confirm Password:</label>
                </div>
                <div class="label-td">
                    <input type="password" name="password_confirmation" class="input-text" placeholder="Confirm Password" required>
                    @error('password_confirmation')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
                
                <div>
                <div>
                    <input type="submit" value="Sign Up" class="login-btn btn-primary btn">
                </div>
            </form>

            <div>
                <br>
                <label for="" class="sub-text">Already have an account? </label>
                <a href="{{route('signin')}}" class="hover-link1">Login</a>
                <br><br><br>
            </div>
        </div>
    </div>
</div>
</body>
</html>
