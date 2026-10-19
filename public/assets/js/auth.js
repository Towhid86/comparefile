document.querySelectorAll('.toggle-password').forEach(toggle => {
        toggle.addEventListener('click', function () {
            const passwordField = this.closest('.position-relative').querySelector('.password');
            const showIcon = this.querySelector('.show-icon');
            const hideIcon = this.querySelector('.hide-icon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                showIcon.style.display = 'inline';
                hideIcon.style.display = 'none';
            } else {
                passwordField.type = 'password';
                showIcon.style.display = 'none';
                hideIcon.style.display = 'inline';
            }
        });
    });
document.querySelectorAll('.hide-pass').forEach(toggle => {
        toggle.addEventListener('click', function () {
            const passwordField = this.closest('.position-relative').querySelector('.password');
            const showIcon = this.querySelector('.show-icon');
            const hideIcon = this.querySelector('.hide-icon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                showIcon.style.display = 'inline';
                hideIcon.style.display = 'none';
            } else {
                passwordField.type = 'password';
                showIcon.style.display = 'none';
                hideIcon.style.display = 'inline';
            }
        });
    });
// Fill email and password fields
function fillup(email, password) {
    $(".email").val(email);
    $(".password").val(password);
}

