const form = document.getElementById('registrationForm');
const nameInput = document.getElementById('name');
const emailInput = document.getElementById('email');
const phoneInput = document.getElementById('phone');
const passwordInput = document.getElementById('password');
const confirmPasswordInput = document.getElementById('confirm_password');

const nameError = document.getElementById('nameError');
const emailError = document.getElementById('emailError');
const phoneError = document.getElementById('phoneError');
const passwordError = document.getElementById('passwordError');
const confirmPasswordError = document.getElementById('confirmPasswordError');
form.addEventListener('submit', function (event) {
    let formIsValid = true;

    if (!nameInput.value.trim()) {
        nameInput.classList.add('border-red-500');
        nameError.classList.remove('hidden');
        formIsValid = false;
    } else {
        nameInput.classList.remove('border-red-500');
        nameError.classList.add('hidden');
    }

    if (!emailInput.checkValidity()) {
        emailInput.classList.add('border-red-500');
        emailError.classList.remove('hidden');
        formIsValid = false;
    } else {
        emailInput.classList.remove('border-red-500');
        emailError.classList.add('hidden');
    }

    if (!phoneInput.checkValidity()) {
        phoneInput.classList.add('border-red-500');
        phoneError.classList.remove('hidden');
        formIsValid = false;
    } else {
        phoneInput.classList.remove('border-red-500');
        phoneError.classList.add('hidden');
    }

    if (passwordInput.value.length < 6) {
        passwordInput.classList.add('border-red-500');
        passwordError.classList.remove('hidden');
        formIsValid = false;
    } else {
        passwordInput.classList.remove('border-red-500');
        passwordError.classList.add('hidden');
    }

    if (confirmPasswordInput.value !== passwordInput.value) {
        confirmPasswordInput.classList.add('border-red-500');
        confirmPasswordError.classList.remove('hidden');
        formIsValid = false;
    } else {
        confirmPasswordInput.classList.remove('border-red-500');
        confirmPasswordError.classList.add('hidden');
    }

    if (!formIsValid) {
        event.preventDefault();
    }
});