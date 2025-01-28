@include('dentist.layout.header')

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    @include('dentist.layout.navbar')

    @include('dentist.layout.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Settings</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- Change Password Card -->
            <div class="col-md-4">
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title"><i class="fas fa-key"></i> Change Password</h3>
                </div>
                <div class="card-body">
                  <p>Keep your account secure by updating your password regularly.</p>
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#changePasswordModal">Change Password</button>
                </div>
              </div>
            </div>

            <!-- Edit User Profile Card -->
            <div class="col-md-4">
              <div class="card card-warning">
                <div class="card-header">
                  <h3 class="card-title"><i class="fas fa-user-edit"></i> Edit Profile</h3>
                </div>
                <div class="card-body">
                  <p>Update your personal information to keep your profile accurate and up-to-date.</p>
                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editProfileModal">Edit Profile</button>
                </div>
              </div>
            </div>

            <!-- Delete Account Permanently Card -->
            <div class="col-md-4">
              <div class="card card-danger">
                  <div class="card-header">
                      <h3 class="card-title"><i class="fas fa-trash-alt"></i> Delete Account Permanently</h3>
                  </div>
                  <div class="card-body">
                      <p>If you no longer wish to use this service, you can permanently delete your account.</p>
                      <button class="btn btn-danger" id="deleteAccountButton" data-toggle="modal" data-target="#confirmDeleteModal">Delete Account</button>
                  </div>
              </div>
            </div>

            <!-- Confirmation Modal -->
 <!-- Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Account Deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete your account? This action cannot be undone.</p>

        <!-- Reason for Deleting Account -->
        <div class="form-group">
          <label for="deletionReason">Reason for Deleting Account:</label>
          <textarea class="form-control" id="deletionReason" rows="3" placeholder="Please provide a reason..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete Account</button>
      </div>
    </div>
  </div>
</div>


          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form id="changePasswordForm">
                  @csrf
                  <!-- Display Validation Errors -->
                  <div class="alert alert-danger d-none" id="errorList"></div>

                  <div class="form-group">
                      <label for="currentPassword">Current Password</label>
                      <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                  </div>
                  <div class="form-group">
    <label for="newPassword">New Password</label>
    <div style="position: relative;">
        <!-- Password Input Field -->
        <input 
            type="password" 
            class="form-control" 
            id="newPassword" 
            name="new_password" 
            required 
            style="width: 100%; padding-right: 40px; height: 40px; line-height: 40px;"
            placeholder="Enter New Password"
        >

        <!-- Toggle Visibility Icon -->
        <span 
            id="togglePassword" 
            style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; font-size: 18px; color: #555;">
            👁️
        </span>
    </div>

    <!-- Password Requirements (Hidden initially) -->
    <div id="password-requirements" style="font-size: 14px; color: red; margin-top: 5px; display: none;">
        <ul style="list-style: none; padding: 0;">
            <li id="uppercase" style="color: red;">• At least 1 uppercase letter</li>
            <li id="special" style="color: red;">• At least 1 special character (!@#$%^&*)</li>
            <li id="length" style="color: red;">• Minimum of 10 characters</li>
        </ul>
    </div>

    <!-- Error Message (Hidden initially) -->
    <div id="password-error" style="color: red; font-size: 14px; margin-top: 5px; display: none;">
        Password does not meet the requirements.
    </div>

    <!-- Laravel Blade Error Message (if applicable) -->
    @error('new_password')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- JavaScript for Functionality -->
<script>
    const passwordInput = document.getElementById('newPassword');
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

        // Change the eye icon based on visibility
        togglePassword.textContent = type === 'password' ? '👁️' : '🙈';
    });

    // Password input validation
    passwordInput.addEventListener('input', () => {
        const value = passwordInput.value;

        // Show the requirements div only when typing starts
        if (value.length > 0) {
            requirementsDiv.style.display = 'block';
            passwordError.style.display = 'none'; // Hide error message while typing
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
        if (value.length >= 10) {
            requirements.length.style.color = 'green';
        } else {
            requirements.length.style.color = 'red';
        }
    });

    // Form submission validation
    document.querySelector('form').addEventListener('submit', (e) => {
        const value = passwordInput.value;

        // Validate all requirements
        const hasUppercase = /[A-Z]/.test(value);
        const hasSpecialChar = /[!@#$%^&*]/.test(value);
        const hasValidLength = value.length >= 10;

        if (!hasUppercase || !hasSpecialChar || !hasValidLength) {
            e.preventDefault(); // Prevent form submission
            passwordError.style.display = 'block'; // Show error message
        }
    });
</script>
                  <div class="form-group">
                      <label for="confirmPassword">Confirm New Password</label>
                      <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                  </div>
                  <button type="submit" class="btn btn-info">Update Password</button>
              </form>
          </div>
      </div>
  </div>
</div>
<!-- End Change Password Modal -->

      <!-- Edit Profile Modal -->
      <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{route('dentist.edit-profile')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$user->id}}">
                <div class="form-group">
  <label for="full_name">Full Name</label>
  <input 
    type="text" 
    class="form-control" 
    id="full_name" 
    name="full_name" 
    required 
    pattern="^[A-Za-z]+(?: [A-Za-z]+){1,7}$" 
    value="{{ old('full_name', $user->full_name) }}" 
    placeholder="Enter First Name and Last Name"
  >

  <!-- Error message for Full Name -->
  <div id="full-name-error" style="color: red; font-size: 14px; margin-top: 5px; display: none;">
    Full Name must contain at least a first name and a last name, and cannot exceed 8 words.
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const fullNameInput = document.getElementById('full_name');
  const fullNameError = document.getElementById('full-name-error');
  const form = document.querySelector('form');

  // Validate full name when the user types
  fullNameInput.addEventListener('input', function () {
    const fullNameValue = fullNameInput.value.trim();
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

  // Form submission validation to ensure full name is valid before submitting
  form.addEventListener('submit', function (e) {
    const fullNameValue = fullNameInput.value.trim();
    const words = fullNameValue.split(/\s+/);

    // Check if the full name has fewer than 2 words or more than 8 words
    if (words.length < 2 || words.length > 8) {
      e.preventDefault(); // Prevent form submission if validation fails
      fullNameError.style.display = 'block'; // Show error message
    } else {
      fullNameError.style.display = 'none'; // Hide error message on valid input
    }
  });
});
</script>


                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}" required>
                </div>
                <div class="form-group">
  <label for="number">Number</label>
  <input 
    type="text" 
    class="form-control" 
    id="number" 
    name="number" 
    required 
    pattern="09\d{9}" 
    title="The number must start with 09 and have exactly 11 digits"
    maxlength="11"
    value="{{ old('number', $user->number) }}"  <!-- Ensure it gets the old value or the user data -->
  
</div>
                <div class="form-group">
  <label for="date">Date of Birth</label>
  <input 
    type="date" 
    class="form-control" 
    id="date" 
    name="dob" 
    value="{{ old('dob', $user->dob ? \Carbon\Carbon::parse($user->dob)->format('Y-m-d') : '') }}" 
    required>
</div>

                <div class="form-group">
                  <label for="address">Address</label>
                    <input 
    type="text" 
    class="form-control" 
    id="address" 
    name="address" 
    required 
    pattern="^[A-Za-z]+([A-Za-z'.-]* [A-Za-z'.-]+)*$"
    value="{{ old('address', $user->address) }}" 
    placeholder="Enter First Name and Last Name"
  >
                </div>
                <button type="submit" class="btn btn-warning">Update Profile</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- End Edit Profile Modal -->

    </div>
    <!-- /.content-wrapper -->

    @include('dentist.layout.footer')
  </div>

  <!----Sweet Alert---->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
      @if (session('success'))
          Swal.fire({
              icon: 'success',
              title: 'Success!',
              text: '{{ session('success') }}',
              confirmButtonText: 'OK'
          });
      @endif

      @if (session('error'))
          Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: '{{ session('error') }}',
              confirmButtonText: 'Try Again'
          });
      @endif
  });
</script>

<script>
  $(document).ready(function() {
      $('#changePasswordForm').on('submit', function(event) {
          event.preventDefault(); // Prevent the default form submission
          
          $.ajax({
              url: '{{ route('dentist.change-password') }}', // Your route for changing password
              type: 'POST',
              data: $(this).serialize(), // Serialize the form data
              success: function(response) {
                  // Handle success response
                  $('#errorList').addClass('d-none').empty();
                  // Use SweetAlert for success message
                  Swal.fire({
                      icon: 'success',
                      title: 'Success!',
                      text: response.message,
                      confirmButtonText: 'OK'
                  });
                  $('#changePasswordModal').modal('hide'); // Close the modal
              },
              error: function(xhr) {
                  // Handle validation errors
                  $('#errorList').removeClass('d-none').empty();
                  let errors = xhr.responseJSON.errors;
                  $.each(errors, function(key, value) {
                      $('#errorList').append('<li>' + value[0] + '</li>');
                  });
                  // Use SweetAlert for error message
                  Swal.fire({
                      icon: 'error',
                      title: 'Oops!',
                      text: 'Please fix the errors below.',
                      confirmButtonText: 'OK'
                  });
              }
          });
      });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
  const confirmDeleteButton = document.getElementById('confirmDeleteButton');
  const deletionReason = document.getElementById('deletionReason');
  
  // Handle the deletion button click
  confirmDeleteButton.addEventListener('click', function () {
    const reason = deletionReason.value.trim();

    if (reason === "") {
      alert("Please provide a reason for deleting your account.");
    } else {
      // Proceed with the account deletion, you can call an API or send the reason to the backend
      // Example: Send the reason with a POST request
      fetch('/delete-account', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // If you're using CSRF protection
        },
        body: JSON.stringify({
          reason: reason
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert("Your account has been successfully deleted.");
          // Optionally, redirect or refresh the page
        } else {
          alert("There was an error deleting your account.");
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert("Something went wrong. Please try again.");
      });
    }
  });
});

  </script> 

</body>
</html>
