
const form = document.getElementById('loginForm');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');

const emailError = document.getElementById('emailError');
const passwordError = document.getElementById('passwordError');

form.addEventListener('submit', function (event) {
    let formIsValid = true;

    if (!emailInput.checkValidity()) {
        emailInput.classList.add('border-red-500');
        emailError.classList.remove('hidden');
        formIsValid = false;
    } else {
        emailInput.classList.remove('border-red-500');
        emailError.classList.add('hidden');
    }

    if (passwordInput.value.length < 6) {
        passwordInput.classList.add('border-red-500');
        passwordError.classList.remove('hidden');
        formIsValid = false;
    } else {
        passwordInput.classList.remove('border-red-500');
        passwordError.classList.add('hidden');
    }

    if (!formIsValid) {
        event.preventDefault();
    }
});
