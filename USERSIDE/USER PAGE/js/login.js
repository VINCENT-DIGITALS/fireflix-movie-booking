const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");
const passwordInput = document.getElementById('password');
const confirmPasswordInput = document.getElementById('cpassword');
const submitButton = document.getElementById('submit_button');
const confirmPassDiv = document.getElementById('cpassdiv');

sign_up_btn.addEventListener("click",() => {
  container.classList.add("sign_in_mode");
});
sign_in_btn.addEventListener("click",() => {
  container.classList.add("sign_in_mode");
});


passwordInput.addEventListener('input', function () {
  if (passwordInput.value !== '') {
    if (passwordInput.value.length < 8) {
      passwordInput.style.color = 'red';
      passwordInput.classList.add('error');
    } else {
      passwordInput.classList.remove('error');
      passwordInput.style.color = '';
    }
  } else {
    passwordInput.classList.remove('error');
    passwordInput.style.color = 'black';
  }
});


confirmPasswordInput.addEventListener('input', function () {
  if (confirmPasswordInput.value !== '') {
    if (confirmPasswordInput.value !== passwordInput.value) {
      confirmPasswordInput.style.color = 'red';
      confirmPasswordInput.classList.add('error');
    } else {
      confirmPasswordInput.classList.remove('error');
      confirmPasswordInput.style.color = '';
    }
  } else {
    confirmPasswordInput.classList.remove('error');
    confirmPasswordInput.style.color = 'black';
  }
});

submitButton.addEventListener('click', function (e) {
  if (confirmPasswordInput.value !== passwordInput.value) {
    e.preventDefault();
    confirmPassDiv.classList.add('error');
  } else if (passwordInput.value.length < 8) {
    e.preventDefault();
    passwordInput.classList.add('error');
  }else {
    confirmPassDiv.classList.remove('error');
    
  }
});



