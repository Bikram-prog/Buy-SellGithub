<style type="text/css">
/* The message box is shown when the user clicks on the password field */
#message {
  display:none;
  background: #f1f1f1;
  color: #000;
  position: relative;
  padding: 20px;
  margin-top: 10px;
}

#message p {
  padding: 10px 35px;
  font-size: 18px;
}

/* Add a green text color and a checkmark when the requirements are right */
.valid {
  color: green;
}

.valid:before {
  position: relative;
  left: -35px;
  content: "✔";
}

/* Add a red text color and an "x" when the requirements are wrong */
.invalid {
  color: red;
}

.invalid:before {
  position: relative;
  left: -35px;
  content: "✖";
}
  .register{
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
    margin-top: 3%;
    padding: 3%;
    border-radius: 10px;
}
.register-left{
    text-align: center;
    color: #fff;
    margin-top: 4%;
}
.register-left a{
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    width: 100%;
    background: #f8f9fa;
    font-weight: bold;
    color: #383d41;
    margin-top: 30%;
    margin-bottom: 3%;
    cursor: pointer;
}
.register-right{
    background: #EAF8F8;
    border-top-left-radius: 10% 50%;
    border-bottom-left-radius: 10% 50%;
}
.register-left img{
    margin-top: 15%;
    margin-bottom: 5%;
    width: 25%;
    -webkit-animation: mover 2s infinite  alternate;
    animation: mover 1s infinite  alternate;
}
@-webkit-keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
@keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
.register-left p{
    font-weight: lighter;
    padding: 12%;
    margin-top: -9%;
}
.register .register-form{
    padding: 10%;
    margin-top: 10%;
}
.btnRegister{
    float: right;
    margin-top: 10%;
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    background: #0062cc;
    color: #fff;
    font-weight: 600;
    width: 50%;
    cursor: pointer;
}
.register .nav-tabs{
    margin-top: 3%;
    border: none;
    background: #0062cc;
    border-radius: 1.5rem;
    width: 28%;
    float: right;
}
.register .nav-tabs .nav-link{
    padding: 2%;
    height: 34px;
    font-weight: 600;
    color: #fff;
    border-top-right-radius: 1.5rem;
    border-bottom-right-radius: 1.5rem;
}
.register .nav-tabs .nav-link:hover{
    border: none;
}
.register .nav-tabs .nav-link.active{
    width: 100px;
    color: #0062cc;
    border: 2px solid #0062cc;
    border-top-left-radius: 1.5rem;
    border-bottom-left-radius: 1.5rem;
}
.register-heading{
    text-align: center;
    margin-top: 8%;
    margin-bottom: -15%;
    color: #495057;
}
</style>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container register">
                <div class="row">
                    <div class="col-md-3 register-left">
                        <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
                        <h3>Bescrow</h3>
                        <p>You are 30 seconds away from earning your own money!</p>
                        <a href="/sellerlogin" class="btn btn-block" style="color: #000;">Login</a><br/>
                    </div>
                    <div class="col-md-9 register-right">
                        <!-- <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Employee</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Hirer</a>
                            </li>
                        </ul> -->
                        <div class="tab-content" id="myTabContent">
                          <form class="form-register" action="/sellersignupaction" method="post">
                      {{ csrf_field() }}
                      @if ($msg ?? '')
                        <div class="alert alert-danger">{{$msg}}</div>
                      @endif
                            
                            <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <h3  class="register-heading">Apply as a Seller</h3>
                                <div class="row register-form">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" required>
                                        </div>
                                        
                                        <div class="form-group">
                                          <input type="text" name="email" id="email" class="form-control" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" placeholder="example@email.com" required>
                                        </div>
                                        <div class="form-group">
                                          <input type="password" autocomplete="new-password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required id="pass" name="password" class="form-control" placeholder="Password">

                                          <div id="message">
                                            <h3>Password must contain the following:</h3>
                                            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                                            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                                            <p id="number" class="invalid">A <b>number</b></p>
                                            <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <input type="password" id="repass" name="repassword" placeholder="Re-type password" class="form-control">
                                          
                                        </div>

                                        <div class="form-group">
                                          <input type="text" class="form-control" name="cntctno" id="contact" placeholder="Your contact number" required>
                                        </div>


                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <input type="text" class="form-control input-border" name="address" id="add" placeholder="Your full address" required>
                                        </div>
                                        <div class="form-group">
                                          <input type="text" class="form-control input-border" name="city" id="city" placeholder="Your city" required>
                                        </div>
                                        <div class="form-group">
                                          <input type="text" class="form-control input-border" name="state" id="state" placeholder="Your state" required>
                                        </div>
                                        <div class="form-group">
                                          <input type="text" class="form-control input-border" name="pstcode" id="postcode" placeholder="Your postcode" required>
                                        </div>
                                        <div class="form-group">
                                          <input type="text" class="form-control input-border" name="comp_name" id="comp_name" placeholder="Your company name" required>
                                          <input type="hidden" class="form-control input-border" name="country" value="Australia" required>
                                          <p>If you don't have a company name then you can enter any unique name for your <span style="font-weight:700;">Bescrow store.</span></p>
                                        </div>
                                        <button type="submit" class="btnRegister">Register</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>

            </div>











































<script type="text/javascript">
    function validation() {
        var name = document.getElementById("name").value;
        var comp_name = document.getElementById("comp_name").value;
        var add = document.getElementById("add").value;
        var city = document.getElementById("city").value;
        var postcode = document.getElementById("postcode").value;
        var state = document.getElementById("state").value;
        var contact = document.getElementById("contact").value;
        var email = document.getElementById("email").value;
        var pass = document.getElementById("pass").value;
        var repass = document.getElementById("repass").value;
        var regEmail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        var regPostcode = /^[0-9]{4}$/;

        if(name == "") {
            alert("Enter your name");
            return false;
        } else if(add == "") {
            alert("Enter your address");
            return false;
        } else if(city == "") {
            alert("Enter your city");
            return false;
        } else if(postcode == "" && regPostcode.test(postcode) == false) {
            alert("Enter your postcode");
            return false;
        } else if(comp_name == "") {
            alert("Enter your Company name");
            return false;
        } else if(regPostcode.test(postcode) == false) {
            alert("Enter your valid postcode");
            return false;
        } else if(state == "") {
            alert("Enter your state");
            return false;
        } else if(email == "") {
            alert("Enter your email");
            return false;
        } else if(regEmail.test(email) == false) {
            alert('Invalid Email Address. Please correct your email.');
            return false;
        } else if(pass == "") {
            alert("Enter the password and it should be at least 8 characters long");
            return false;
        } else if(!contact.match(/^\D*0(\D*\d){9}\D*$/)) {
            alert('Phone Number is Invalid');
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