@include('header')

<style>
  .regbox{
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: -1px 1px 20px 2px #eaeaea;
  }
  </style>

  <div class="container-xl mt-4">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4 regbox">
                <h4 class="mb-3 text-center" style="font-weight: bold; font-size: 2.2rem; letter-spacing: 2.4px;">Create an account</h4>
                <p class="mb-3 text-center" style="font-size: 0.8rem; color: #8A8D94;">Creating an account lets you track your order history and store addresses for fast and easy checkouts.</p>


                @if ($msg ?? '')
                  <div class="alert alert-danger">{{$msg}}</div>
                @endif

                <form action="/buyersignupaction" method="POST">
                {{ csrf_field() }}
                    <div class="form-group mb-2">
                        <input type="text" name="name" class="form-control" value="<?php echo (isset($_POST['name']) ? $_POST['name'] : '') ?>" id="name" placeholder="Full Name">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group mb-2">
                        <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required type="password" id="pass" name="password" class="form-control" placeholder="Password" autocomplete="off">
                    </div>
                    <div class="form-group mb-2">
                        <input type="password" id="repass" name="repassword" class="form-control" placeholder="Re-type password" autocomplete="off">
                    </div>

                    <h4 class="mb-3" style="font-weight: bold;">Address Details</h4>

                    <div class="form-group">
                      <label>Address</label>
                      <input type="text" name="address" class="form-control" placeholder="Enter your adrress" required>
                    </div>

                    <div class="form-group">
                      <label>City</label>
                      <input type="text" name="city" class="form-control" placeholder="Enter city name" required>
                    </div>
                      
                    <div class="form-group">
                        <label>Postcode</label>
                        <input type="text" name="postcode" class="form-control" placeholder="Enter your postcode" required> 
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <input type="text" name="state" class="form-control" placeholder="Enter state name" required>
                    </div>
                    <div class="form-group">
                      <label>Phone No</label>
                      <input type="text" name="phn_no" class="form-control" placeholder="Enter your phone no" required>
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="text" name="del_email" class="form-control" placeholder="Enter your e-mail" required>
                    </div>
                    <div class="form-group">
                      <label>Country</label>
                      <input type="text" name="country" class="form-control" value="Australia" readonly>
                    </div>

                    <div class="form-group mb-2">
                    <p class="text-center mt-3" style="font-size:14px">
                                    <input class="form-check-input" type="checkbox" value="" name="terms" checked required> By signing up, I affirm that I have read and agree to the<a class="login-signup" target="_blank" href="/terms"> Terms & Conditions</a></p>
                    </div>

                    <div class="text-center">
                    <button onclick="return validation();" type="submit" class="btn btn-danger mt-4">Create my account</button>
                    </div>
                    <p class="mt-4 text-center"><a href="/buyerlogin" class="btn btn-light btn-sm">Back to login</a></p>

                    
                </form>

                <div id="message" style="display: none; background-color: #fff; padding: 20px; border-radius: 10px; text-align: left !important;">
                <h3 class="text-center">Password must contain the following:</h3>
                <p id="letter" class="invalid text-center">A <b>lowercase</b> letter</p>
                <p id="capital" class="invalid text-center">A <b>capital (uppercase)</b> letter</p>
                <p id="number" class="invalid text-center">A <b>number</b></p>
                <p id="length" class="invalid text-center">Minimum <b>8 characters</b></p>
              </div>

            </div>
            <div class="col-md-4"></div>
        </div>
      </div>

 @include('footer')


<script type="text/javascript">
    function validation() {
        var name = document.getElementById("name").value;
        var email = document.getElementById("email").value;
        var pass = document.getElementById("pass").value;
        var repass = document.getElementById("repass").value;
        var regEmail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;


        // else if(regEmail.test(email) == false) {
        //     alert('Invalid Email Address. Please correct your email.');
        //     return false;
        // }

        if(name == "") {
            alert("Enter your name");
            return false;
        } else if(email == "") {
            alert("Enter your email");
            return false;
        }  else if(pass == "") {
            alert("Enter the password and it should be at least 8 characters long");
            return false;
        } else if(pass != repass) {
            alert("Both password should be match");
            return false;
        } else {
            return true;
        }
    }
</script>


<!-- password validation -->

<script>
var myInput = document.getElementById("pass");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>