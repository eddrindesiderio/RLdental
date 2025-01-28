  @include('admin.layout.header')

  <body class="hold-transition sidebar-mini">
    <div class="wrapper">

      @include('admin.layout.navbar')

      @include('admin.layout.sidebar')

      <!-------------------------------------- Main content ---------------------------------------->

      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title" style="font-size: 2em">Dentist's List</h3>
                <!-- Add New Account Button -->
                <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addAccountModal">
                  Add Dentist Account
                </button>
              </div>
              <div class="card-body">
                <table id="dentistTable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Full Name</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($dentists as $dentist)
                      <tr>
                        <td>{{ $dentist->full_name }}</td>
                        <td>{{ $dentist->email }}</td>
                        <td>{{ $dentist->status }}</td>
                        <td>
                          {{-- <a href=" {{ route('patients.view', $patient->id) }}" class="btn btn-success">View</a> --}}
                          <form action="{{ route('admin.dentist-delete', $dentist->id) }}" method="post" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this patient?');">Delete</button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    <!-- Modal for Adding New Account -->
    <div class="modal fade" id="addAccountModal" tabindex="-1" role="dialog" aria-labelledby="addAccountModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addAccountModalLabel">Add Dentist Account</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="addDentistForm">
            @csrf
            <div class="modal-body">
    <div class="form-group">
      <label for="fullName">Full Name</label>
      <input 
        type="text" 
        class="form-control" 
        id="fullName" 
        name="full_name" 
        required 
        pattern="^[a-zA-Z]+(?:\s[a-zA-Z]+)+$" 
        title="Full Name must contain at least two words with alphabetic characters and spaces"
        minlength="7"
      >
      <span class="text-danger error-text full_name_error"></span>
    </div>
  <!-- Form section -->
  <div class="form-group">
    <label for="email">Email</label>
    <input 
      type="text" 
      class="form-control" 
      id="email" 
      name="email" 
      required 
      placeholder="Enter your Gmail address"
    >
    <div class="error-container">
      <span class="text-danger error-text email_error"></span>
    </div>
  </div>

  <!-- Error Modal -->
  <div id="errorModal" class="error-modal">
    <div class="error-modal-content">
      <span class="error-modal-close" id="errorModalClose">&times;</span>
      <p id="modalMessage">Please enter a valid Gmail address.</p>
      <button id="modalOK" class="modal-ok-btn">OK</button>
    </div>
  </div>

  <!-- Styling for the Modal -->
  <style>
    .error-modal {
      display: none; /* Hidden by default */
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    }

    .error-modal-content {
      position: relative;
      margin: 15% auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      width: 300px;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .error-modal-close {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 30px;
      color: #aaa;
      cursor: pointer;
    }

    .error-modal-close:hover,
    .error-modal-close:focus {
      color: #000;
    }

    .modal-ok-btn {
      background-color: #007bff;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }

    .modal-ok-btn:hover {
      background-color: #0056b3;
    }
  </style>

  <!-- JavaScript for form and modal -->
  <script>
    document.getElementById('email').addEventListener('keyup', function() {
      const emailInput = this.value;
      const emailError = document.querySelector('.email_error');
      const emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;

      // Check if the email matches the Gmail pattern
      if (!emailPattern.test(emailInput)) {
        emailError.textContent = 'Please enter a valid Gmail address (e.g., example@gmail.com).';
        this.classList.add('is-invalid'); // Add red border to input field
      } else {
        emailError.textContent = ''; // Clear error message if email is valid
        this.classList.remove('is-invalid'); // Remove red border
      }
    });

    // Show modal function to display the error
    function showModal(message) {
      const modal = document.getElementById('errorModal');
      const modalMessage = document.getElementById('modalMessage');
      modalMessage.textContent = message;
      modal.style.display = "block"; // Display the modal
    }

    // Close modal function when clicking the close icon or OK button
    function closeModal() {
      const modal = document.getElementById('errorModal');
      modal.style.display = "none"; // Hide the modal
    }

    // Event listeners for closing the modal
    document.getElementById('errorModalClose').addEventListener('click', closeModal);
    document.getElementById('modalOK').addEventListener('click', closeModal); // Close modal on "OK" button click

    // Form submit event to validate email
    document.getElementById('addDentistForm').addEventListener('submit', function(e) {
      const emailInput = document.getElementById('email');
      const emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;

      // If email doesn't match the pattern, prevent form submission and show modal
      if (!emailPattern.test(emailInput.value)) {
        e.preventDefault(); // Prevent form submission
        showModal("Please enter a valid Gmail address.");
      }
    });
  </script>



              <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
                <span class="text-danger error-text address_error"></span>
              </div>
              <div class="form-group">
    <label for="dob">Date of Birth</label>
    <input 
      type="date" 
      class="form-control" 
      id="dob" 
      name="dob" 
      required 
      min="1950-01-01" 
      title="Date of Birth must be from 1950 onwards."
    >
    <span class="text-danger error-text dob_error"></span>
  </div>
              <div class="form-group">
      <label for="number">Mobile Number</label>
      <input 
          type="text" 
          class="form-control" 
          id="number" 
          name="number" 
          required 
          pattern="09\d{9}" 
          title="The number must start with 09 and have exactly 11 digits"
          maxlength="11"
      >
      <span class="text-danger error-text number_error"></span>
  </div>

  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" required>
    <div id="password-requirements" class="text-muted" style="display: none;">
      <p id="length-requirement" class="requirement">• Minimum 8 characters</p>
      <p id="uppercase-requirement" class="requirement">• At least 1 uppercase letter</p>
      <p id="special-char-requirement" class="requirement">• At least 1 special character</p>
    </div>
    <span class="text-danger error-text password_error"></span>
  </div>

  <script> 
    document.addEventListener('DOMContentLoaded', function () {
      const passwordInput = document.getElementById('password');
      const passwordRequirements = document.getElementById('password-requirements');
      const lengthRequirement = document.getElementById('length-requirement');
      const uppercaseRequirement = document.getElementById('uppercase-requirement');
      const specialCharRequirement = document.getElementById('special-char-requirement');

      passwordInput.addEventListener('input', function () {
        const password = passwordInput.value;

        // Show requirements when user starts typing
        if (password.length > 0) {
          passwordRequirements.style.display = 'block';
        } else {
          passwordRequirements.style.display = 'none';
        }

        // Validate length
        if (password.length >= 8) {
          lengthRequirement.style.color = 'green';
        } else {
          lengthRequirement.style.color = 'red';
        }

        // Validate uppercase letter
        if (/[A-Z]/.test(password)) {
          uppercaseRequirement.style.color = 'green';
        } else {
          uppercaseRequirement.style.color = 'red';
        }

        // Validate special character
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
          specialCharRequirement.style.color = 'green';
        } else {
          specialCharRequirement.style.color = 'red';
        }
      });
    });
  </script>

  <style>
    .requirement {
      margin: 0;
    }
  </style>

              <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" required>
                <span class="text-danger error-text password_confirmation_error"></span>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Add Account</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
  $(document).ready(function() {
    $('#addDentistForm').on('submit', function(e) {
      e.preventDefault(); // Prevent default form submission

      let formData = new FormData(this);
      $('span.error-text').text(''); // Clear previous errors

      let valid = true;

      // Full Name Validation
      const fullName = $('#fullName').val();
      if (!/^[a-zA-Z\s]+$/.test(fullName) || fullName.trim().length < 7) {
        $('span.full_name_error').text('Full Name must be at least 7 characters long and contain only letters and spaces.');
        valid = false;
      }

      // Email Validation
      const email = $('#email').val();
      const emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
      if (!emailPattern.test(email)) {
        $('span.email_error').text('A valid Gmail address is required.');
        valid = false;
      }

      // Address Validation
      const address = $('#address').val();
      if (address.trim() === '') {
        $('span.address_error').text('Address is required.');
        valid = false;
      }

      // Date of Birth Validation
      const dob = $('#dob').val();
      const birthYear = new Date(dob).getFullYear();
      if (birthYear < 1950) {
        $('span.dob_error').text('Date of Birth must be from 1950 onwards.');
        valid = false;
      }

      // Mobile Number Validation
      const number = $('#number').val();
      if (!/^09\d{9}$/.test(number)) {
        $('span.number_error').text('Mobile number must start with 09 and contain 11 digits.');
        valid = false;
      }

      // Password Validation
      const password = $('#password').val();
      const confirmPassword = $('#confirmPassword').val();
      if (password.length < 8 || !/[A-Z]/.test(password) || !/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
        $('span.password_error').text('Password must meet the specified requirements.');
        valid = false;
      }

      // Confirm Password Validation
      if (password !== confirmPassword) {
        $('span.password_confirmation_error').text('Passwords do not match.');
        valid = false;
      }

      // If validation fails, return early
      if (!valid) {
        return;
      }

      // If everything is valid, proceed with AJAX form submission
      $.ajax({
        url: "{{ route('admin.add-dentist') }}", // Your route
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          if (response.success === true) {
            $('#addAccountModal').modal('hide');
            Swal.fire({
              icon: 'success',
              title: 'Success!',
              text: 'Dentist account has been registered successfully!',
            });
            location.reload(); // Refresh page
          }
        },
        error: function(response) {
          if (response.status === 422) {
            let errors = response.responseJSON.errors;
            $.each(errors, function(field, error) {
              $('span.' + field + '_error').text(error[0]);
            });
          }
        }
      });
    });
  });
</script>

      @include('admin.layout.footer')
    </div>

    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
      $(function () {
        $("#dentistTable").DataTable({
          responsive: true,
          autoWidth: false,
        });
      });
    </script>

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
  </body>
  </html>
