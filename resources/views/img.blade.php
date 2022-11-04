@include('header')


<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>


<style type="text/css">
img {
display: block;
max-width: 100%;
}
.preview {
overflow: hidden;
width: 160px; 
height: 160px;
margin: 10px;
border: 1px solid red;
}
.modal-lg{
max-width: 1000px !important;
}
</style>

<div class="container text-center mt-4">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
        @if (count($errors) > 0)
         <div class = "alert alert-danger">
            <ul>
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
      @endif
            <h4>Upload product images <span style="font-weight: 600;">(Max - 4 images)</span></h4> <p style="font-weight: 600;">* Each image should be less than 10MB.</p><hr>
            <form action="/post" method="post" enctype='multipart/form-data'>
                 {{ csrf_field() }}
                 @if($image < '4')
                 <img id="target">
                <div class="form-group">
                    <input type="file" id="src" name="photos" class="form-control image">
                </div>
                <input type="hidden" id="prod_id" name="data" value="<?php echo $lstprodid; ?>">
                
                
                @else
                <p>Maximum 4 images are allowed.</p>
                @endif
            </form>
        </div>
        <div class="col-3"></div>
    </div>

    <div class="row mt-4">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="row">
            @foreach ($ProImage as $proimg)
                <div class="col-3">                                   
                <img src="{{asset('images')}}/{{ $proimg->pro_img_path }}" class="img-fluid" alt="">
                <form method="post">
                <input type="hidden" name="img_path_name" value="{{ $proimg->pro_img_path }}">
                
                <a onclick="return confirmbox()" href="{{ url('delprodimage/'.$proimg->pro_id . '/' . $proimg->prod_img_prod_id . '/' . $proimg->pro_img_path) }}" class="btn btn-clear-primary"><i style="color: #ff4757; font-size: 16px;" class="fas fa-trash"></i></a>
                </form>
                </div>
            @endforeach
            </div>

            <p>&nbsp;</p>

            @if(count($finish) > 0)
            <a class="btn btn-success" style="float: right; border-radius: 8px !important;" href="/liveproduct/<?php echo $lstprodid; ?>">Finish</a>
            @endif
            

            

            
            <a class="btn btn-dark" style="float: right; border-radius: 8px !important;margin-right: 20px;" href="/sellerdraftprod/<?php echo $lstprodid; ?>">Save as draft</a> 

            <a class="btn btn-outline-primary" style="float: right; border-radius: 25px; border-radius: 8px !important; margin-right: 20px;" href="/addmoreproduct/<?php echo $lstprodid; ?>">Add more product</a>

             
            
            </a>
        </div>
        <div class="col-3"></div>
    </div>
</div>





<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    
    <div class="modal-body">
    <div class="img-container">
    <div class="row">
    <div class="col-md-8">
    <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
    </div>
    <div class="col-md-4">
    <div class="preview"></div>
    </div>
    </div>
    </div>
    </div>
    <div class="modal-footer">
    <button onclick="search()" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-primary" id="crop">Crop</button>
    </div>
    </div>
    </div>
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
    
    <script>
        function search(){
            $("#modal").modal("hide");
            window.location.href = "/sellerimgupld/<?php echo $lstprodid; ?>"
        }


    </script>

<script>
    function showImage(src,target) {
    
      var fr=new FileReader();
      // when image is loaded, set the src of the image where you want to display it
      fr.onload = function(e) { target.src = this.result; };
      src.addEventListener("change",function() {
        // document.getElementById("target").style.display = "block";
        // document.getElementById("faadd").style.display = "none";
        // document.getElementById("fadel").style.display = "block";
        // document.getElementById("src").style.height = "20px";
        
        // fill fr with image data    
        fr.readAsDataURL(src.files[0]);
      });
    }
    
    var src = document.getElementById("src");
    var target = document.getElementById("target");
    showImage(src,target);
    </script>
    
    <style>
        #target {
            object-fit: cover;
            width: 250px;
            height: 150px;
            display: none;
        }
        #fadel {
            display: none;
        }
    </style>

<script>
    var $modal = $('#modal');
    var image = document.getElementById('image');
    var prod_id = document.getElementById('prod_id').value;
    var cropper;
    $("body").on("change", ".image", function(e){
    var files = e.target.files;
    var done = function (url) {
    image.src = url;
    $modal.modal('show');
    };
    var reader;
    var file;
    var url;
    if (files && files.length > 0) {
    file = files[0];
    if (URL) {
    done(URL.createObjectURL(file));
    } else if (FileReader) {
    reader = new FileReader();
    reader.onload = function (e) {
    done(reader.result);
    };
    reader.readAsDataURL(file);
    }
    }
    });
    $modal.on('shown.bs.modal', function () {
    cropper = new Cropper(image, {
    viewMode: 3,
    preview: '.preview'
    });
    }).on('hidden.bs.modal', function () {
    cropper.destroy();
    cropper = null;
    });
    $("#crop").click(function(){
    $("#crop").html("Uploading... Please Wait...")
    $("#crop").prop("disabled", true)
    canvas = cropper.getCroppedCanvas({
    width: 300,
    height: 300,
    });
    canvas.toBlob(function(blob) {
    url = URL.createObjectURL(blob);
    var reader = new FileReader();
    reader.readAsDataURL(blob); 
    reader.onloadend = function() {
    var base64data = reader.result; 
    $.ajax({
    type: "POST",
    dataType: "json",
    url: "/post",
    data: {'_token': $('meta[name="csrf-token"]').attr('content'), 'image': base64data, 'prod_id': prod_id},
    success: function(data){
    console.log(data);
    $modal.modal('hide');
    // alert(data.success);
    window.location.href = '/sellerimgupld/<?php echo $lstprodid; ?>';
    }
    });
    }
    });
    })
    </script>

    
