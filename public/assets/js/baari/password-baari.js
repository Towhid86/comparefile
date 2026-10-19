 document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll('.toggle-password').forEach(icon => {
    icon.addEventListener('click', function () {
      const input = this.closest('.password-wrapper').querySelector('input[type="password"], input[type="text"]');

      if (!input) return;

      const isPassword = input.type === 'password';
      input.type = isPassword ? 'text' : 'password';

      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  });
});
    /*
$(document).ready(function () {
    const passwordRules = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;

    // Shared validation functions
    function validatePasswordField($field, $errorBox) {
        const value = $field.val().trim();
        const valid = passwordRules.test(value);

        $field.css('border-color', valid ? 'green' : 'red');
        $errorBox.text(valid ? '' : 'Password must be at least 8 characters and include an uppercase letter, number, and special character.');
        return valid;
    }

    function validateConfirmPassword($password, $confirm, $errorBox) {
        const match = $password.val() === $confirm.val() && $confirm.val() !== '';

        $confirm.css('border-color', match ? 'green' : 'red');
        $errorBox.text(match ? '' : 'Passwords do not match.');
        return match;
    }

    // Run this for all forms with .password-form
    $('.passwordForm').each(function () {
        const $form = $(this);
        const $password = $form.find('input[name="password"]');
        const $confirm = $form.find('input[name="password_confirmation"]');
        const $passwordError = $form.find('.password-error');
        const $confirmError = $form.find('.confirm-error');

        // Live validation
        $password.on('input', function () {
            validatePasswordField($password, $passwordError);
            validateConfirmPassword($password, $confirm, $confirmError);
        });

        $confirm.on('input', function () {
            validateConfirmPassword($password, $confirm, $confirmError);
        });

        // Prevent form submit if invalid
        $form.on('submit', function (e) {
            const validPassword = validatePasswordField($password, $passwordError);
            const validConfirm = validateConfirmPassword($password, $confirm, $confirmError);

            if (!validPassword || !validConfirm) {
                e.preventDefault();
                (!validPassword ? $password : $confirm).focus();
                return false;
            }
        });
    });
});*/
