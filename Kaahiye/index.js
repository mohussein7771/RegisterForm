// Get the registration form
const registrationForm = document.getElementById('registrationForm');

// Add a submit event listener to the form
registrationForm.addEventListener('submit', function(event) {
  // Check if the form is valid and the passwords match
  if (!registrationForm.checkValidity() || !checkPasswordsMatch()) {
    // If the form is invalid or passwords don't match, prevent the form from submitting
    event.preventDefault();
    event.stopPropagation();
  }
  // Mark all the fields as touched to display custom validation messages
  registrationForm.classList.add('was-validated');
});

// Add a blur event listener to each field to validate it as the user leaves it
const fields = registrationForm.querySelectorAll(':required');
fields.forEach((field) => {
  field.addEventListener('blur', function() {
    // Validate the field and show custom validation messages
    if (!this.checkValidity()) {
      this.classList.add('is-invalid');
      this.nextElementSibling.textContent = this.validationMessage;
    } else {
      this.classList.remove('is-invalid');
      this.nextElementSibling.textContent = '';
    }
    // Check if the passwords match and show custom validation messages
    if (this.type === 'password' && this.value !== '') {
      if (!checkPasswordsMatch()) {
        confirmPasswordInput.classList.add('is-invalid');
        confirmPasswordInput.nextElementSibling.textContent = "Passwords don't match";
      } else {
        confirmPasswordInput.classList.remove('is-invalid');
        confirmPasswordInput.nextElementSibling.textContent = '';
      }
    }
  });
});

// Add an input event listener to the confirm password field to check if the passwords match
const confirmPasswordInput = document.getElementById('confirmPassword');
const passwordInput = document.getElementById("password");

confirmPasswordInput.addEventListener('input', function() {
  if (this.value !== passwordInput.value) {
    this.setCustomValidity("Passwords don't match");
  } else {
    this.setCustomValidity('');
  }
});

// Function to check if the passwords match
function checkPasswordsMatch() {
  const passwordInput = document.getElementById('password');
  const confirmPasswordInput = document.getElementById('confirmPassword');
  return passwordInput.value === confirmPasswordInput.value;
}
