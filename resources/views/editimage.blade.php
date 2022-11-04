@include('header')
<style>
  .dropzone{
    border: 1px solid #ccc !important;
    border-radius: 10px !important;
  }
</style>
<div class="container">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6 mt-2">
     

      @if($image < '20')
      <div class="dropzone" id="myDropzone"></div>
      <input type="hidden" id="prod_id" value="<?php echo $lstprodid; ?>">
      <p class="text-center mt-2">You can upload upto 20 images.</p>
      <p class="text-center mt-2" style="color: #d63031;">*Please click the <i style="color: #2ecc71; font-size: 16px;" class="far fa-check-circle"></i> button below for set the image as your default product image.</p>
      @else
      <p>Maximum 20 images are allowed.</p>
      @endif

      
      <div class="lol"></div>
      <div class="row mt-4">
        
        <div class="col-12">
            <div class="row" id="img_loop">
            
                                                 
                
                
                
            
            </div>

            <p>&nbsp;</p>

            
            <a class="btn btn-success" style="float: right; border-radius: 8px !important;" href="/liveproduct/<?php echo $lstprodid; ?>">Finish</a>
            
            

            

            
            

             
            
            </a>
        </div>
        
    </div>
    </div>
    <div class="col-md-3">
      
    </div>
    <div>
</div>

<script type="text/javascript">
        function confirmbox() {
            var win = window.confirm("Are you sure?");
            if(win) {
                return true;
            } else {
                return false;
            }
        }
    
    </script>
    
@include('footer')
 <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
   <script src="https://unpkg.com/cropperjs"></script>
          





  <script>
Dropzone.options.myDropzone = {
  url: '/editpost',
  addRemoveLinks: false,
  headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    init: function() {
                this.on("sending", function(file, xhr, formData){
                		let prodid = document.getElementById('prod_id').value;
                        formData.append("prod_id", prodid);
                });
            },
            success: function(file,response) {
              if(response.error){
                $("#myDropzone").hide();
                $(".lol").html("<p>You have reached maximum number of images.</p>")
                alert(response.error)
              }
              ajaxCall();
            },
         maxFilesize: 12,
         maxFiles: {{$uploadCount}},
         dictDefaultMessage: "Drop or click here to upload images",
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
      width: 1000,
      height: 1000,
      // minWidth: 500,
      // minHeight: 500,
      // maxWidth: 500,
      // maxHeight: 500,
      // fillColor: '#fff',
      // imageSmoothingEnabled: false,
      // imageSmoothingQuality: 'high',
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
          
          done(blob);
      });
    }, 'image/jpeg', 0.95);
    // Remove the editor from the view
    document.body.removeChild(editor);
  });
  // Create an image node for Cropper.js
  var image = new Image();
  image.src = URL.createObjectURL(file);
  editor.appendChild(image);
  
  // Create Cropper.js
  var cropper = new Cropper(image, { viewMode: 1 });
  
}
};
</script>

<script>
  function ajaxCall(){
    $.get('/editprodimage/<?php echo $lstprodid; ?>',  // url
      function (data, textStatus, jqXHR) {  // success callback
        console.log(data)
        $("#img_loop").html('')
        data.ProImage.forEach(e => {
          <?php 
          $imgStats = DB::table('pro_images')
                                    ->where('prod_img_prod_id', '=', $lstprodid)
                                    ->where('prod_default_status', '=', '1')
                                    ->get();
          
          if(count($imgStats) == 0) { ?>
            $("#img_loop").append('<div class="col-3"><img style="width: 100px; height: 100px; object-fit: cover;" src="{{asset("images")}}/'+e.pro_img_path+'" class="img-thumbnail" alt=""> <form method="post"> <input type="hidden" name="img_path_name" value="'+e.pro_img_path+'"> <a onclick="return confirmbox()" href="/delimage/'+e.pro_id+'/'+e.prod_img_prod_id+'/'+e.pro_img_path+'" class="btn btn-clear-primary"><i style="color: #ff4757; font-size: 16px;"class="fas fa-trash"></i></a> <a onclick="return confirmbox()" href="/defaultimage/'+e.pro_id+'/'+e.prod_img_prod_id+'" class="btn btn-clear-primary"><i style="color: #2ecc71; font-size: 16px;" class="far fa-check-circle"></i></a></form></div>')
          
          <?php } else { ?>
          if(e.prod_default_status == 1) {
            $("#img_loop").append('<div class="col-3"><img style="width: 100px; height: 100px; object-fit: cover;" src="{{asset("images")}}/'+e.pro_img_path+'" class="img-thumbnail" alt=""> <form method="post"> <input type="hidden" name="img_path_name" value="'+e.pro_img_path+'"> <a onclick="return confirmbox()" href="/delimage/'+e.pro_id+'/'+e.prod_img_prod_id+'/'+e.pro_img_path+'" class="btn btn-clear-primary"><i style="color: #ff4757; font-size: 16px;"class="fas fa-trash"></i></a> <span class="badge bg-primary">Default image</span> </form></div>')
          } else {
            $("#img_loop").append('<div class="col-3"><img style="width: 100px; height: 100px; object-fit: cover;" src="{{asset("images")}}/'+e.pro_img_path+'" class="img-thumbnail" alt=""> <form method="post"> <input type="hidden" name="img_path_name" value="'+e.pro_img_path+'"> <a onclick="return confirmbox()" href="/delimage/'+e.pro_id+'/'+e.prod_img_prod_id+'/'+e.pro_img_path+'" class="btn btn-clear-primary"><i style="color: #ff4757; font-size: 16px;"class="fas fa-trash"></i></a> </form></div>')
          }
           
          <?php } ?>
          
        });
         //
    });
  }

  ajaxCall()
</script>
</body>


</html>


