{{-- </body>

</html> --}}

<!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        

        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
        <script src="https://unpkg.com/cropperjs"></script>
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
        <script src="{{asset('frontend')}}/js/moment.min.js"></script>
        <script src="{{asset('frontend')}}/js/daterangepicker.js"></script>

        <!------------------------------- Chat start ---------------------------------------->

        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.1.1/socket.io.js" integrity="sha512-oFOCo2/3DtjrJG4N27BjSLQWoiBv171sK6a+JiWjp/7agxC2nCUP358AqzxkBUb5jX8g6CYLPdSKQTbC0weCwA==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
 
    <style>
        .progress { position:relative; width:100%; }
        .bar { background-color: #b5076f; width:0%; height:20px; }
        .percent { position:absolute; display:inline-block; left:50%; color: #040608;}
   </style>

   <!-------------------------------- chat end script and style -------------------------------->

    <script>
            $('#sandbox-container .input-daterange').datepicker({
    format: "dd/mm/yyyy",
    todayHighlight: true
});
</script>
        <script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

        <script>
            $(document).ready( function () {
    $('#datatbl').DataTable();
} );
</script>

        <!-- <script src="{{asset('frontend')}}/js/popper.js"></script>
        <script src="{{asset('frontend')}}/js/bootstrap.min.js"></script>
        <script src="{{asset('frontend')}}/js/jquery.magnific-popup.min.js"></script>
        <script src="{{asset('frontend')}}/js/isotope.pkgd.min.js"></script>
        <script src="{{asset('frontend')}}/js/imagesloaded.pkgd.min.js"></script>
        <script src="{{asset('frontend')}}/js/jquery.counterup.min.js"></script>
        <script src="{{asset('frontend')}}/js/waypoints.min.js"></script>
        <script src="{{asset('frontend')}}/js/ajax-mail.js"></script>
        <script src="{{asset('frontend')}}/js/owl.carousel.min.js"></script>
        <script src="{{asset('frontend')}}/js/plugins.js"></script>
        <script src="{{asset('frontend')}}/js/main.js"></script> -->

        <script>
          function add_suggstn() {
            $('#suggstn_modal').modal('show');
        }
        
          function hidesuggstn() {
            $('#suggstn_modal').modal('hide');
          }
        </script>

<script>
  function add_testimonial() {
    $('#testimonial_modal').modal('show');
}

  function hideModalTstmnl() {
    $('#testimonial_modal').modal('hide');
  }

  </script>

        <script type="text/javascript">
  
  $( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 5000,
      values: [ 0, 3000 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range" ).slider( "values", 1 ) );
  } );
  $('#reservation').daterangepicker({
       locale: {
        format: 'YYYY/MM/DD'
      }
    });
  </script>

        <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<!-- script for adding dropdown images -->
        <script>
Dropzone.options.myDropzone = {
  url: 'https://www.easyasthat.shop/post',
  headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    },
    init: function() {
                this.on("sending", function(file, xhr, formData){
                        let prodid = document.getElementById('hd_prod_id').value;
                        formData.append("data", prodid);
                });
            },
         maxFilesize: 12,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
               return time+file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 5000,

  transformFile: function(file, done) {
  // Create Dropzone reference for use in confirm button click handler
  var myDropZone = this;
  // Create the image editor overlay
  var editor = document.createElement('div');
  editor.style.position = 'fixed';
  editor.style.left = 0;
  editor.style.right = 0;
  editor.style.top = 0;
  editor.style.bottom = 0;
  editor.style.zIndex = 9999;
  editor.style.backgroundColor = '#000';
  document.body.appendChild(editor);
  // Create confirm button at the top left of the viewport
  var buttonConfirm = document.createElement('button');
  buttonConfirm.style.position = 'absolute';
  buttonConfirm.style.left = '10px';
  buttonConfirm.style.top = '10px';
  buttonConfirm.style.zIndex = 9999;
  buttonConfirm.textContent = 'Confirm';
  editor.appendChild(buttonConfirm);
  buttonConfirm.addEventListener('click', function() {
    // Get the canvas with image data from Cropper.js
    var canvas = cropper.getCroppedCanvas({
      width: 512,
      height: 512
    });
    // Turn the canvas into a Blob (file object without a name)
    canvas.toBlob(function(blob) {
      // Create a new Dropzone file thumbnail
      myDropZone.createThumbnail(
        blob,
        myDropZone.options.thumbnailWidth,
        myDropZone.options.thumbnailHeight,
        myDropZone.options.thumbnailMethod,
        false, 
        function(dataURL) {
          
          // Update the Dropzone file thumbnail
         var a =  myDropZone.emit('thumbnail', file, dataURL);
          //console.log(a.files[0].dataURL);
          // Return the file to Dropzone
          console.log(a);
          done(blob);
      });
    });
    // Remove the editor from the view
    document.body.removeChild(editor);
  });
  // Create an image node for Cropper.js
  var image = new Image();
  image.src = URL.createObjectURL(file);
  editor.appendChild(image);
  
  // Create Cropper.js
  var cropper = new Cropper(image, {viewMode: 1}); //, { aspectRatio: 1 }
}
};
</script>

<script type="text/javascript">
        Dropzone.options.dropzone =
         {
            maxFilesize: 12,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
               return time+file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 50000,
            removedfile: function(file) 
            {
                var name = file.upload.filename;
                $.ajax({
                    headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                    type: 'POST',
                    url: 'delete',
                    data: {filename: name},
                    success: function (data){
                        console.log("File has been successfully removed!!");
                    },
                    error: function(e) {
                        console.log(e);
                    }});
                    var fileRef;
                    return (fileRef = file.previewElement) != null ? 
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
       
            success: function(file, response) 
            {
                console.log(response);
            },
            error: function(file, response)
            {
               return false;
            }
};
</script>
<!-- script for adding dropdown images end -->


<!-- Script for stripe payment gateway -->

<script type="text/javascript">
$(function() {
    var $form         = $(".require-validation");
  $('form.require-validation').bind('submit', function(e) {
    var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('hide');
 
        $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
      var $input = $(el);
      if ($input.val() === '') {
        $input.parent().addClass('has-error');
        $errorMessage.removeClass('hide');
        e.preventDefault();
      }
    });
  
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
        number: $('.card-number').val(),
        cvc: $('.card-cvc').val(),
        exp_month: $('.card-expiry-month').val(),
        exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }
  
  });
  
  function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
  
});
</script>  

<!-- Script for stripe payment gateway end --> 


<!------------------------------------ chatbot------------------------------------------------>

{{-- <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script> --}}


<script>
//     var botmanWidget = {
//     aboutText: 'Powered by WWWMEDIA.WORLD',
//     title: 'BescrowBot',
//     introMessage: 'Hello, how are you, I am your BescrowBot friend, and I am here to assist you. I will ask you a series of questions, please respond with <span style="font-weight: bold;">1/2/3/4/5 Or 6</span>. <br /> <span style="font-size: 18px; font-weight: bold;">1</span>. Would you like to sign up, this will only take a few minutes. <br /> <span style="font-size: 18px; font-weight: bold;">2</span>. Would you like more information about our monthly and yearly cash And prize giveaways? <br /> <span style="font-size: 18px; font-weight: bold;">3</span>. Would you like to download our app’s for your mobile? <br /> <span style="font-size: 18px; font-weight: bold;">4</span>. Would you like to know a bit more about GlobalLove? <br /><span style="font-size: 18px; font-weight: bold;">5</span>. Would you like more information on having a career with GlobalLove? <br /> <span style="font-size: 18px; font-weight: bold;">6</span>. What about Women Protection? <br /> <span style="font-size: 18px; font-weight: bold;">7</span>. Did you forget your password?',
//     mainColor: '#F15052',
//     bubbleAvatarUrl: 'https://globallove.online/images/robot.png',
//     userId: 456
// };

var botmanWidget = {
    aboutText: 'Powered by WWWMEDIA.WORLD',
    title: 'Buy & Sell Bot',
    introMessage: "Notes: Hello, how are you, I am your Buy & Sell Virtual Assistant, and I am here to assist you. I will ask you a series of questions, please respond with <span style='font-weight: bold;'>1/2/3/4/5 Or 6</span>. <br /> 1. Would you like to sign up, this will only take a few minutes. <br /> 2. Would you like more information on Buy & Sell? <br /> 3. Would you like to download our app’s for your mobile? <br /> 4. Would you like to see our Products currently posted on Buy & Sell? <br /> 5. Would you like to see Buy & Sell's Golf Ball Range? <br /> 6. What you like to see the Terms and Conditions? <br /> 7. Did you forget your password? <br /> 8. Would you like to Chat to Customer Service? ",
    mainColor: '#F15052',
    bubbleAvatarUrl: 'https://globallove.online/images/robot.png',
    userId: 456
};




</script>

<style type="text/css">

.desktop-closed-message-avatar {

}

#botmanWidgetRoot > div {
  /* width: 310px !important;
  height: 500px !important; */
  min-width: 100px !important;
  min-height: 110px !important;
  z-index: 5000 !important;
  
}

  #botmanWidgetRoot > div > div > div {
    color: #fff !important;
    font-weight: 700 !important;
  }

  .desktop-closed-message-avatar {
    background-color: #F15052 !important;
    position: fixed !important;
    bottom: 10px !important;
    top: inherit !important;
  }


</style>

{{-- <div class="open_bot_txt" style="
    position: fixed;
    bottom: 69px;
    right: 0px;
    width: 140px;
    height: 60px;
    z-index: 1000;
    background: #E31E27;
    color: #fff;
    padding: 5px;
    border-radius: 10px;
    transform: rotate(3deg);
    
">
  <p>
  Please open me to help you
  </p>
</div> --}}

<!-----------------------------------------------lol------------------------------------------------>


<div class="toast_notify" style="position: fixed;bottom: 50px;left: 10px; width: 100%;"></div>

<!--------------------------------------chat box ------------------------------------------->

<style>
  .wrapper {
    display: none;
}
.ui-dialog-titlebar-close {
    visibility: hidden;
}
.main {
    background-color: #eee;
    width: 320px;
    position: fixed;
    bottom: 0;
    right: 330px;
    border-radius: 8px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    /* padding: 6px 0px 0px 0px */
}

.scroll {
    overflow-y: scroll;
    scroll-behavior: smooth;
    height: 325px
}

.img1 {
    border-radius: 50%;
    background-color: #66BB6A
}

.name {
    font-size: 13px
}

.msg {
    background-color: #5C54AD;
    font-size: 16px;
    padding: 5px;
    border-radius: 5px;
    font-weight: 500;
    color: #fff;
}

.msg_other {
  background-color: #fff;
  font-size: 16px;
  padding: 5px;
  border-radius: 5px;
  font-weight: 500;
  color: #2c2c2c;
}

.between {
    font-size: 8px;
    font-weight: 500;
    color: #a09e9e
}


.caution-msg{
  border-bottom-right-radius: 8px;
    background: #fff;
    padding: 0px 20px;
    font-size: 12px;
    border-bottom-left-radius: 8px;
    box-shadow: 0 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%);
}



.icon1 {
    color: #7C4DFF !important;
    font-size: 18px !important;
    cursor: pointer
}

.icon2 {
    color: #512DA8 !important;
    font-size: 18px !important;
    position: relative;
    left: 8px;
    padding: 0px;
    cursor: pointer
}

.icondiv {
    border-radius: 50%;
    width: 15px;
    height: 15px;
    padding: 2px;
    position: relative;
    bottom: 1px
}
.header-chat {
  background-color: #fff;
  padding: 10px;
  border-radius: 8px;
  border: 1px solid #ccc;
  font-weight: 700;
}


.lds-roller {
  display: inline-block;
  position: relative;
  width: 64px;
  height: 64px;
}
.lds-roller div {
  animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  transform-origin: 32px 32px;
}
.lds-roller div:after {
  content: " ";
  display: block;
  position: absolute;
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: #F15052;
  margin: -3px 0 0 -3px;
}
.lds-roller div:nth-child(1) {
  animation-delay: -0.036s;
}
.lds-roller div:nth-child(1):after {
  top: 50px;
  left: 50px;
}
.lds-roller div:nth-child(2) {
  animation-delay: -0.072s;
}
.lds-roller div:nth-child(2):after {
  top: 54px;
  left: 45px;
}
.lds-roller div:nth-child(3) {
  animation-delay: -0.108s;
}
.lds-roller div:nth-child(3):after {
  top: 57px;
  left: 39px;
}
.lds-roller div:nth-child(4) {
  animation-delay: -0.144s;
}
.lds-roller div:nth-child(4):after {
  top: 58px;
  left: 32px;
}
.lds-roller div:nth-child(5) {
  animation-delay: -0.18s;
}
.lds-roller div:nth-child(5):after {
  top: 57px;
  left: 25px;
}
.lds-roller div:nth-child(6) {
  animation-delay: -0.216s;
}
.lds-roller div:nth-child(6):after {
  top: 54px;
  left: 19px;
}
.lds-roller div:nth-child(7) {
  animation-delay: -0.252s;
}
.lds-roller div:nth-child(7):after {
  top: 50px;
  left: 14px;
}
.lds-roller div:nth-child(8) {
  animation-delay: -0.288s;
}
.lds-roller div:nth-child(8):after {
  top: 45px;
  left: 10px;
}
@keyframes lds-roller {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.chat_d:hover{
  text-decoration:none
}
</style>

<div class="wrapper">
    <div class="main">
      <div class="header-chat" style="margin-bottom: 10px;">
        <p class="" style="margin-bottom: 0px;"> 
        <span class="header-name"></span> 
        
        <span style="float: right;"><a onclick="hideBox()" href="javascript:void(0)"><i class="fas fa-times"></i></a></span></p>
        <div class="typing" style="color:#66BB6A; font-weight: 700;"></div>
      </div>

      <input type="hidden" id="hd_t" value="">
      <input type="hidden" id="emchat" value="">

      <div style="display: none;" class="lds-roller"><div></div></div>

      <div class="px-2 scroll" id="chat_messenger">


        </div>

        <div class="progress">
        <div class="progress-bar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width: 0%; display: none;">
          0%
        </div>
        </div>
        <div id="success"></div>
        <div id="preview_gl"></div>

        <nav class="navbar bg-white navbar-expand-sm d-flex justify-content-between"> 
         

          <form method="post" id="gl_file_upload" action="/sendfile" enctype="multipart/form-data">
          @csrf
          <input type="file" name="file[]" multiple id="imgupload" style="display:none"/>
          <input type="hidden" name="to" id="hd_to_img">
          
          {{-- <div id="OpenImgUpload" class="icondiv d-flex justify-content-start align-content-center text-center ml-2">  <i class="fas fa-plus-circle" style="
          color: #512DA8 !important;
          font-size: 18px !important;
          position: relative;
          left: 5px;
          padding: 0px;
          cursor: pointer;
          "></i>
            </div> --}}
          
          <input type="submit" id="upload_start_gl_file" name="upload" value="Upload" class="btn btn-success" style="display: none;" />

        </form>


        <input oninput="typing_alert(this.value)" type="text" name="text" style="width: 80% !important;" class="form-control message-input" id="message-input-id" placeholder="Type a message...">

          <div class="icondiv d-flex justify-content-end align-content-center text-center ml-2" onclick="newMessage()"> <!--<i class="fa fa-paperclip icon1"></i>-->  <i style="margin-right: 10px;" class="far fa-paper-plane icon2"></i>
          </div>
          
        </nav>

        {{-- <div class="caution-msg"><i class="fa fa-exclamation-triangle" style="color: #cd201f;"></i> This chat is being monitored by GlobalLove, any bad language, and soliciting of any kind will result in temporary suspension</div> --}}
    </div>
</div>




<!-----------------------------------------chat end ---------------------------------------->
<script>
var input = document.getElementById("message-input-id");
input.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
   event.preventDefault();
   newMessage();
   //document.getElementById("sendChat").click();
  }
});


</script>


<?php if(isset($_COOKIE['UserEmail'])) { ?>
<!-------------------------------- chat script ------------------------------------------>

<script>
  //-------------------- socket connection established-------------------------------------
  //ajax chat messages with socket------------------------------------------------------------------------

  // https://worldwidemedia.online

var socket = io('https://cschatonly.com', {transports: ['websocket']});
socket.emit('join', {email: '<?php echo Crypt::decryptString($_COOKIE['UserEmail']); ?>', id: '<?php echo Crypt::decryptString($_COOKIE['UserIds']); ?>'});

// from video call request 
socket.on("new_msg_call_req", function(data) {
  $("#calling_from").html(data.toname);
  $("#room").val(data.room)
  $("#videocallDiolog").modal("show");
});




//get message from server
socket.on("new_msg", function(data) {
	$(".typing").html('');
  // $('.toast').show();
  // $(".toast-body").html(data.msg);
  // $('.toast').toast('show');

  if(data.msg !=''){
    $('.toast_notify').append(`<div onclick="loadChat('${data.to}','${data.toname}','${data.toemail}','')" style="cursor: pointer; opacity: 1 !important; background: #F15052;color: #fff; width: 100%;" class="toast" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header" style="color:#000;"><i class="far fa-comment"></i> &nbsp; <strong class="mr-auto">${data.toname}</strong><small class="text-muted"> </small><button style="background: transparent;border: none;" type="button" class="ml-2 mb-1" onclick="hidechatbox()"><i class="fas fa-times"></i></button></div><div class="toast-body">${data.msg}</div></div>`);
  } else {
    $('.toast_notify').append(`<div onclick="loadChat('${data.to}','${data.toname}','${data.toemail}','')" style="cursor: pointer; opacity: 1 !important; background: #F15052;color: #fff; width: 100%;" class="toast" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header" style="color:#000;"><i class="far fa-comment"></i> &nbsp; <strong class="mr-auto">${data.toname}</strong><small class="text-muted"> </small><button style="background: transparent;border: none;" type="button" class="ml-2 mb-1" onclick="hidechatbox()"><i class="fas fa-times"></i></button></div><div class="toast-body"><i class="fas fa-camera-retro"></i> Photo</div></div>`);
  }
  




  $("#badge_"+data.to).text('1+');
  $("#badge_notif_messages").text('1').show();
  console.log(data)
//	$(".preview_typing").html('');
	
  var toid = $("#hd_t").val();
  $("#idd_"+data.to+" .preview").html('<span> </span>' + data.msg)
    if(toid == data.to) {
      if(data.msg != '') {
        $("#chat_messenger").append('<div class="d-flex align-items-center"><div class="text-left pr-1"></div><div class="pr-2 pl-1"> <span class="name"></span><p class="msg">'+data.msg+'</p></div></div>');
        $("#idd_"+toid+".active .preview").html('<span> </span>' + data.msg);
        $(".scroll").stop().animate({ scrollTop: $(".scroll")[0].scrollHeight}, 100);
      } else {
        $("#chat_messenger").append('<div class="d-flex align-items-center"><div class="text-left pr-1"></div><div class="pr-2 pl-1"> <span class="name"></span><p class="msg"><img loading="lazy" src="'+data.img+'"></p></div></div>');
        $("#idd_"+toid+".active .preview").html('<span> </span>' + data.msg);
        $(".scroll").stop().animate({ scrollTop: $(".scroll")[0].scrollHeight}, 100);
      }
      

    }
});

//typing from server
socket.on("typing_from_server", function(data) {
  var toid = $("#hd_t").val();
  $("#idd_"+data.to+" .preview_typing").html('<span> </span>' + data.msg)
    if(toid == data.to) {
      $(".typing").html(data.msg);
      $("#idd_"+toid+" .preview_typing").html('<span> </span>' + data.msg);
      $(".scroll").stop().animate({ scrollTop: $(".scroll")[0].scrollHeight}, 100);
    }
});

var online_status = '';

function loadChat(str,name,email,$status) {
  $("#customer_support_broadcast_notify").modal("hide");
  online_status = $status;
  var pic = true;
  let _token   = $('meta[name="csrf-token"]').attr('content');
  var suspended = false;
  var block = false;  

  $(".wrapper").show();
	$(".typing").html('');
	$(".preview_typing").html('');
    $(".header-name").html('<a href="/userprofile/'+str+'">' + name + '</a>')
    $("#emchat").val(email)
    $("#hd_t").val(str)
    $("#hd_to_img").val(str)
    $(".lds-roller").show();
    $(".contact").removeClass("active");
    $("#idd_"+str).addClass("active");
    $("#chat_messenger").html("");
    $("#badge_notif_messages").hide();
    $(".toast").hide();
    
  
    $.ajax({
    type: "POST",
    url: '/chatdisplay', // This is what I have updated
    data:{
          id: str,
          _token: _token
        },
    }).done(function( msg ) {
      
      console.log('bal')
      console.log(msg)
      

      $(".lds-roller").hide();

        for(var i = 0; i<=msg.length; i++) {
          
            if(msg[i].chat_from_id == <?php echo Crypt::decryptString($_COOKIE['UserIds']); ?>) {
              
              if(msg[i].chat_msg == null && msg[i].chat_files != null) {
                $("#chat_messenger").append('<div class="d-flex align-items-center text-right justify-content-end "><div class="pr-2"> <span class="name"></span><a  data-toggle="tooltip" data-placement="top" title="" class="chat_d"  href="javascript:void(0)" data-original-title="'+moment(msg[i].chat_date_time).format('MMMM Do YYYY, h:mm:ss a')+'"><p class="msg_other"><img loading="lazy" src="'+msg[i].chat_files+'"></p></a></div><div></div></div>');
              } else {
                $("#chat_messenger").append('<div class="d-flex align-items-center text-right justify-content-end "><div class="pr-2"> <span class="name"></span><a  data-toggle="tooltip" data-placement="top" title="" class="chat_d"  href="javascript:void(0)" data-original-title="'+moment(msg[i].chat_date_time).format('MMMM Do YYYY, h:mm:ss a')+'"><p class="msg_other">'+msg[i].chat_msg+'</p></a></div><div></div></div>');
              }

       

            } else {

              if(msg[i].chat_msg == null && msg[i].chat_files != null) {
                $("#chat_messenger").append('<div class="d-flex align-items-center"><div class="text-left pr-1"></div><div class="pr-2 pl-1"> <span class="name"></span><a  data-toggle="tooltip" data-placement="top" title="" class="chat_d"  href="javascript:void(0)" data-original-title="'+moment(msg[i].chat_date_time).format('MMMM Do YYYY, h:mm:ss a')+'"><p class="msg"><img loading="lazy" src="'+msg[i].chat_files+'"></p></a></div></div>');
              } else {
                $("#chat_messenger").append('<div class="d-flex align-items-center"><div class="text-left pr-1"></div><div class="pr-2 pl-1"> <span class="name"></span><a  data-toggle="tooltip" data-placement="top" title="" class="chat_d"  href="javascript:void(0)" data-original-title="'+moment(msg[i].chat_date_time).format('MMMM Do YYYY, h:mm:ss a')+'"><p class="msg">'+msg[i].chat_msg+'</p></a></div></div>');
              }

              
              
                
            }
                
            $(".lds-roller").hide();
            $(".scroll").stop().animate({ scrollTop: $(".scroll")[0].scrollHeight}, 100);
        }
        
        
    });
}




//--------------- send message
function newMessage() {
  $(".toast").hide();
	$(".preview_typing").html('');
	$(".typing").html('');
    let _token   = $('meta[name="csrf-token"]').attr('content');
    message = $(".message-input").val();

    too = $("#hd_t").val();
    em = $("#emchat").val()

    if(too != '') {
        
        if($.trim(message) == '') {
            return false;
        }
        $.ajax({
        type: "POST",
        url: '/chatinsert', // This is what I have updated
        data:{
              msg: message,
              from_id: <?php echo Crypt::decryptString($_COOKIE['UserIds']); ?>,
              to_id: too,
              _token: _token
            },
        }).done(function( msg ) {
           
            socket.emit('send_msg_server', { user: em, msg: msg, to: <?php echo Crypt::decryptString($_COOKIE['UserIds']); ?>, toname: '<?php echo Crypt::decryptString($_COOKIE['UserFullName']); ?>', toemail: '<?php echo Crypt::decryptString($_COOKIE['UserEmail']); ?>'}); //socket
            
            $(".scroll").stop().animate({ scrollTop: $(".scroll")[0].scrollHeight}, 100);
            $("#chat_messenger").append('<div class="d-flex align-items-center text-right justify-content-end "><div class="pr-2"> <span class="name"></span><p class="msg_other">'+message+'</p></div><div></div></div>');
            $('.message-input').val(null);
            $('.contact.active .preview').html('<span>You: </span>' + message);
          
          
  
        });

        

        
    }
    
}


function typing_alert(str) {
	too = $("#hd_t").val();
    em = $("#emchat").val()
	if(str.length > 0) {
		socket.emit('typing', { user: em, msg: 'typing...', to: <?php echo Crypt::decryptString($_COOKIE['UserIds']); ?>}); //socket
	} else {
		socket.emit('typing', { user: em, msg: '', to: <?php echo Crypt::decryptString($_COOKIE['UserIds']); ?>}); //socket
	}
	
}

function typing_alert(str) {
	too = $("#hd_t").val();
    em = $("#emchat").val()
	if(str.length > 0) {
		socket.emit('typing', { user: em, msg: 'typing...', to: <?php echo Crypt::decryptString($_COOKIE['UserIds']); ?>}); //socket
	} else {
		socket.emit('typing', { user: em, msg: '', to: <?php echo Crypt::decryptString($_COOKIE['UserIds']); ?>}); //socket
	}
	
}

function hideBox() {
  $(".wrapper").hide();
}

function hidechatbox() {
  $(".toast").hide();
}

</script>
<?php } ?>



<!------- modal for customer support broadcast notification -------------->







  </body>
</html>