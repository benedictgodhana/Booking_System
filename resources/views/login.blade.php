<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body,
input {
  font-family: "Poppins", sans-serif;
}


.home-btn{
    margin-left:1680px;
    text-decoration: none;
    border: 2px solid;
}

.container {
  position: relative;
  width: 100%;
  background-color: #fff;
  min-height: 100vh;
  overflow: hidden;
}

.forms-container {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
}

.signin-signup {
  position: absolute;
  top: 50%;
  transform: translate(-50%, -50%);
  left: 75%;
  width: 50%;
  transition: 1s 0.7s ease-in-out;
  display: grid;
  grid-template-columns: 1fr;
  z-index: 5;
}

form {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  padding: 0rem 5rem;
  transition: all 0.2s 0.7s;
  overflow: hidden;
  grid-column: 1 / 2;
  grid-row: 1 / 2;
}

form.sign-up-form {
  opacity: 0;
  z-index: 1;
}

form.sign-in-form {
  z-index: 2;
}

.title {
  font-size: 2.2rem;
  color: #444;
  margin-bottom: 10px;
}

.input-field {
  max-width: 380px;
  width: 100%;
  background-color:white;
  margin: 10px 0;
  height: 55px;
  border-radius: 55px;
  display: grid;
  grid-template-columns: 15% 85%;
  padding: 0 0.4rem;
  position: relative;
  border: 1px solid #ccc;
}

.input-field i {
  text-align: center;
  line-height: 55px;
  color: #acacac;
  transition: 0.5s;
  font-size: 1.1rem;
}

.input-field input {
  background: none;
  outline: none;
  border: none;
  line-height: 1;
  font-weight: 600;
  font-size: 1.1rem;
  color: #333;
  
}

.input-field input::placeholder {
  color: #aaa;
  font-weight: 500;
}

.social-text {
  padding: 0.7rem 0;
  font-size: 1rem;
}

.social-media {
  display: flex;
  justify-content: center;
}

.social-icon {
  height: 46px;
  width: 46px;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 0.45rem;
  color: #333;
  border-radius: 50%;
  border: 1px solid #333;
  text-decoration: none;
  font-size: 1.1rem;
  transition: 0.3s;
}

.social-icon:hover {
  color: #4481eb;
  border-color: #4481eb;
}

.btn {
  width: 380px;
  background-color:darkblue;
  border: none;
  outline: none;
  height: 49px;
  border-radius: 49px;
  color: #fff;
  text-transform: uppercase;
  font-weight: 600;
  margin: 10px 0;
  cursor: pointer;
  transition: 0.5s;
}

.btn:hover {
  background-color:green;
}
.panels-container {
  position: absolute;
  height: 100%;
  width: 100%;
  top: 0;
  left: 0;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
}

.container:before {
  content: "";
  position: absolute;
  height: 2000px;
  width: 2000px;
  top: -10%;
  right: 48%;
  transform: translateY(-50%);
  background:darkblue;
  transition: 1.8s ease-in-out;
  border-radius: 50%;
  z-index: 6;
}

.image {
  width: 100%;
  transition: transform 1.1s ease-in-out;
  transition-delay: 0.4s;
}

.panel {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  justify-content: space-around;
  text-align: center;
  z-index: 6;
}

.left-panel {
  pointer-events: all;
  padding: 3rem 17% 2rem 12%;
}

.right-panel {
  pointer-events: none;
  padding: 3rem 12% 2rem 17%;
}

.panel .content {
  color: #fff;
  transition: transform 0.9s ease-in-out;
  transition-delay: 0.6s;
  margin-top: -220px;
}

.panel h3 {
  font-weight: 600;
  line-height: 1;
  font-size: 1.5rem;
  margin-left: -300px;
}

.panel p {
  font-size: 0.95rem;
  padding: 0.7rem 0;
  margin-left: -210px;

}

.btn.transparent {
  margin: 0;
  background: none;
  border: 2px solid #fff;
  width: 230px;
  height: 41px;
  font-weight: 600;
  font-size: 0.8rem;
  margin-left: -220px;
  text-decoration: none;
}
.btn.transparent a{
    color:white;
    text-decoration: none;
}   

.right-panel .image,
.right-panel .content {
  transform: translateX(800px);
}

/* ANIMATION */

.container.sign-up-mode:before {
  transform: translate(100%, -50%);
  right: 52%;
}

.container.sign-up-mode .left-panel .image,
.container.sign-up-mode .left-panel .content {
  transform: translateX(-800px);
}

.container.sign-up-mode .signin-signup {
  left: 25%;
}

.container.sign-up-mode form.sign-up-form {
  opacity: 1;
  z-index: 2;
}

.container.sign-up-mode form.sign-in-form {
  opacity: 0;
  z-index: 1;
}

.container.sign-up-mode .right-panel .image,
.container.sign-up-mode .right-panel .content {
  transform: translateX(0%);
}

.container.sign-up-mode .left-panel {
  pointer-events: none;
}

.container.sign-up-mode .right-panel {
  pointer-events: all;
}

@media (max-width: 870px) {
  .container {
    min-height: 800px;
    height: 100vh;
  }
  .signin-signup {
    width: 100%;
    top: 95%;
    transform: translate(-50%, -100%);
    transition: 1s 0.8s ease-in-out;
  }

  .signin-signup,
  .container.sign-up-mode .signin-signup {
    left: 50%;
  }

  .panels-container {
    grid-template-columns: 1fr;
    grid-template-rows: 1fr 2fr 1fr;
  }

  .panel {
    flex-direction: row;
    justify-content: space-around;
    align-items: center;
    padding: 2.5rem 8%;
    grid-column: 1 / 2;
  }

  .right-panel {
    grid-row: 3 / 4;
  }

  .left-panel {
    grid-row: 1 / 2;
  }

  .image {
    width: 200px;
    transition: transform 0.9s ease-in-out;
    transition-delay: 0.6s;
  }

  .panel .content {
    padding-right: 15%;
    transition: transform 0.9s ease-in-out;
    transition-delay: 0.8s;
  }

  .panel h3 {
    font-size: 1.2rem;
    
  }

  .panel p {
    font-size: 0.7rem;
    padding: 0.5rem 0;
  }

  .btn.transparent {
    width: 110px;
    height: 35px;
    font-size: 0.7rem;
  }
  .btn.transparent a{
    color:white;
    text-decoration: none;
}

  .container:before {
    width: 1500px;
    height: 1500px;
    transform: translateX(-50%);
    left: 30%;
    bottom: 68%;
    right: initial;
    top: initial;
    transition: 2s ease-in-out;
    background:darkblue;

  }

  .container.sign-up-mode:before {
    transform: translate(-50%, 100%);
    bottom: 32%;
    right: initial;
  }

  .container.sign-up-mode .left-panel .image,
  .container.sign-up-mode .left-panel .content {
    transform: translateY(-300px);
  }

  .container.sign-up-mode .right-panel .image,
  .container.sign-up-mode .right-panel .content {
    transform: translateY(0px);
  }

  .right-panel .image,
  .right-panel .content {
    transform: translateY(300px);
  }

  .container.sign-up-mode .signin-signup {
    top: 5%;
    transform: translate(-50%, 0);
  }
}

@media (max-width: 570px) {
  form {
    padding: 0 1.5rem;
  }

  .image {
    display: none;
  }
  .btn {
  width: 320px;
  background-color:darkblue;
  border: none;
  outline: none;
  height: 49px;
  border-radius: 49px;
  color: #fff;
  text-transform: uppercase;
  font-weight: 600;
  margin: 10px 0;
  cursor: pointer;
  transition: 0.5s;
}

.btn:hover {
  background-color:green;
}
    .panel .content {
        padding: 0.5rem 1rem;
    }
  .container {
    padding: 1.5rem;
  }

  .panel .content {
  color: #fff;
  transition: transform 0.9s ease-in-out;
  transition-delay: 0.6s;
  margin-top: 20px;
}


  .container:before {
    bottom: 72%;
    left: 50%;
    background:darkblue;

  }

  .container.sign-up-mode:before {
    bottom: 28%;
    left: 50%;
  }
  .panel h3 {
  font-weight: 600;
  line-height: 1;
  font-size: 1.5rem;
  margin-left: 20px;
}

.panel p {
  font-size: 0.95rem;
  padding: 0.7rem 0;
  margin-left: 20px;

}
.btn.transparent {
  margin: 0;
  background: none;
  border: 2px solid #fff;
  width: 230px;
  height: 41px;
  font-weight: 600;
  font-size: 0.8rem;
  margin-left: 20px;
  text-decoration: none;
}
.btn.transparent a{
    color:white;
    text-decoration: none;
}
.btn-d{
    width: 320px;
    margin-left: 159px;
    top:-20px;

}

}
    </style>
    <title>Login</title>
  </head>
  <body>
  @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

    <div class="container">
    
      <div class="forms-container">
     
        <div class="signin-signup">
            
        <form action="{{ route('login') }}" method="POST" onsubmit="return validateForm()">
                    @csrf   
            <h2 class="title">Sign in</h2>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input id="email" type="email" name="email" placeholder="Email" />
            </div>
                    @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
            
                    <div class="input-field">
    <i class="fas fa-lock"></i>
    <input id="password" type="password" name="password" placeholder="Password" />
    <!-- Place the eye icon inside the input field -->
    <span style="margin-left:340px;margin-top:-38px" class="fa fa-fw fa-eye field-icon toggle-password"></span>
</div>
@error('password')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

            <button type="submit" value="Submit" class="btn solid">Login</button>
            <div class="social-media">
            <p class="social-text">Forgot Password?</p>
            <a href="{{ route('password.request') }}" style="margin-left:10px;margin-top:10px">Reset Password</a>
            </div><br>
            <a href="/" style="margin-left:10px;margin-top:10px"><i class="fas fa-home mr-2"></i>Home</a>


          </form>
        </div>
      </div>
      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
          <img src="/logo/iLab white Logo-01.png" class="image" alt="" />

            <h3>New here?</h3>
            <p>
              Kindly Activate your Account
            </p><br>
            <button  class="btn transparent"><a href="{{ route('account.activate') }}">
              Activate account
            </a></button>
          </div>
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>One of us ?</h3>
            <p>
              To keep connected with us please login with your personal info
            </p>
            <button type="submit" class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <img src="img/register.svg" class="image" alt="" />
        </div>
      </div>
    </div>

    <script>
        const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});
    </script>
    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function showAlert(title, message, icon, timer = 6000) {
        Swal.fire({
            title: title,
            text: message,
            icon: icon,
            timer: timer,
            showConfirmButton: false
        });
    }

    function validateForm() {
        // Perform form validation here
        var email = document.getElementById('email');
        var password = document.getElementById('password');

        if (email.value === '' || password.value === '') {
            // Show a SweetAlert error notification
            showAlert('Error', 'Please fill in all fields', 'error');
            return false; // Prevent form submission
        }

        // Send an AJAX request to your server for login validation
        $.ajax({
            url: "{{ route('login.validate') }}", // Replace with your actual login validation route
            type: "POST",
            data: {
                email: email.value,
                password: password.value,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success) {
                    // If login is successful, display success message and redirect
                    showAlert('Success', 'Log in successfully!', 'success');
                    window.location.href = response.redirectTo;
                } else {
                    // If login fails, display an error message using SweetAlert
                    showAlert('Error', response.message, 'error');

                    // Check if password reset is required
                    if (response.resetPassword) {
                        // Trigger a SweetAlert to notify the user to reset the password
                        Swal.fire({
                            title: 'Password Reset Required',
                            text: response.message,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Reset Password',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect to the password reset page
                                window.location.href = "{{ route('password.request') }}";
                            }
                        });
                    }
                }
            },
            error: function () {
                // Handle AJAX error, if any
                showAlert('Error', 'An error occurred during login', 'error');
            }
        });

        return false; // Prevent form submission
    }
</script>

<script>
  // ... Your existing script

document.addEventListener('DOMContentLoaded', function () {
    const passwordToggle = document.querySelector('.toggle-password');
    const passwordInput = document.querySelector('#password');

    passwordToggle.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
});

// ... Your existing script

</script>
 </body>
</html>