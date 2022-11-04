@include('header')

      <style type="text/css">
        label {
          font-weight: 700 !important;
        }
        .btn-danger {
        border-radius: 25px;
        min-height: 40px !important;
    }

    .form-group {
      margin-bottom: 20px;
    }
      </style>


@if (Session::has('prodsucmsg'))
           <div class="alert alert-success"><center>{{Session::get('prodsucmsg')}}</center></div>
        @endif
      @if (Session::has('updatemsg'))
           <div class="alert alert-success"><center>{{Session::get('updatemsg')}}</center></div>
        @endif

    <div class="container">
      
    <div class="row">  

    <div class="col-md-12" style="margin-top: 30px; background: #fff; padding: 20px; border-radius: 10px; border: 1px solid #eee;">
      <h2>Add new product</h2> <br>
      <div class="row">
      <div class="col-md-6" style="">


      @if (count($errors) > 0)
         <div class = "alert alert-danger">
            <ul>
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
      @endif


<form action="/selleraddprodloginaction" method="post" >
  
 {{ csrf_field() }}

  <div class="form-group">
    <label for="Selectcategory">Selling Country</label>
    <select name="contry_id" class="form-control">
        <option value="AUD" selected="selected">Australia</option>
        
    </select>
  </div>

  <div class="form-group">
    <label for="Selectcategory">Product Condition</label>
    <select name="prod_cndtn" class="form-control">
        <option value="New">New</option>
        <option value="Used">Used</option>
    </select>
  </div>

 <div class="form-group">
    <label for="ProductTitle">Product Title</label>
    <input type="text" class="form-control" placeholder="Enter Product Title" name="title">
    
  </div>

  <div class="form-group">
    <label for="Selectategory">Category</label>
    <select onchange="subcate(this.value)" name="cate_id" id="catid" class="form-control">
        <option value="">Choose category</option>
        @foreach($users as $user)
         
        <option <?php echo (isset($_POST['cate_id']) && $_POST['cate_id'] == $user['cate_id'] ? 'selected' : ''); ?> value="<?php echo $user->cate_id; ?>"><?php echo $user->cate_title; ?></option>
        @endforeach
    </select>
  </div>
  <div id="bichi" class="form-group">
    
  </div>
  
  <!-- <div class="form-group">
    <label for="shortDescription">Short Description(*Max 1200 characters supports)</label>
    <textarea name="sh_desc" class="form-control" rows="3" cols="30" placeholder="Write short description..."></textarea>
  </div> -->

  <div class="form-group">
    <label for="Quantity">Quantity</label>
    <input type="text" class="form-control" placeholder="Enter Product's Quantity" name="quantity">
  </div>

  <div class="form-group">
    <label for="Quantity">Delivery Days(In Days)</label>
    <input type="text" class="form-control" placeholder="Enter Approx Delivery Days" name="dlvry_days">
  </div>

 <!-- <div class="form-group">
    <label for="Price">Regular Price</label>
    <input type="text" class="form-control" placeholder="Enter Product's Price" name="price" required>
  </div> -->

</div>
 <div class="col-md-6" style="">

  <div class="form-group">
    <label for="Selectcategory">Want to add this product on member section?</label>
    <select name="mmbr_cndtn" class="form-control" onchange="display(this.value)">
        <option value="No">No</option>
        <option value="Yes">Yes</option>
    </select>
  </div>

  <div class="form-group" id="member_price" style="display: none;">
    <label for="Price">Member Price</label>
    <input type="text" class="form-control" placeholder="Enter Product's Member Price" name="mmbr_price" >
  </div>

  <div class="form-group" id="member_quantity" style="display: none;">
    <label for="Price">Minimum Quantity</label>
    <input type="text" class="form-control" placeholder="Enter Product's Minimum Quantity" name="mmbr_minm_quantity" >
  </div>

<div class="form-group">
    <label for="OfferPrice">Regular Price</label>
    <input type="text" class="form-control" placeholder="Enter Product's Price" name="offrprice">
  </div> 
<div class="form-group">
    <label for="LongDescription">Long Description(*Max 5000 characters supports)</label>
    <textarea name="lg_desc" class="form-control" rows="3" cols="30" placeholder="Write long description..."></textarea>
  </div>
  
    
    <input type="hidden" class="form-control" placeholder="Separated By Comma ( , )" name="tags" value="tukli">

  

  <hr />



 

  <div class="form-group">
  <input type="hidden" value="<?php echo Crypt::decryptString($_COOKIE['UserIds']); ?>" name="seller_id">
  </div>
  
  <button type="submit" style="cursor: pointer; float: right; border-radius: 5px !important; " class="btn btn-primary btn-lg">NEXT</button>

  <br><br><br>

</form>







 </div>
</div>
</div>
</div>
</div>








@include('footer')


<script>  
 
function subcate(str){    
  //var selectList = document.createElement("select");  
          $("#formsub").remove();
           $.ajax({  
                url:"https://buyandsell.click/subcateajax/"+str,  
                method:"GET",  
                //data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     //data.subcate[0]
                     var sel = $('<select name="sbcatgry_id" class="form-control" id="formsub">').appendTo('#bichi');
                      $(data.subcate).each(function() {
                      sel.append($("<option>").attr('value',this.sub_cate_id).text(this.sub_cate_title));
                      });
                    //  for(var i = 0; i<= data.subcate.length; i++) {
                    //   document.createElement("option")
                      
                    //  }
                }  
           });  
      }

      function display(str){
        if(str == 'Yes'){
          document.getElementById('member_price').style.display= "block";
          document.getElementById('member_quantity').style.display= "block";
        }else{
          document.getElementById('member_price').style.display= "none";
          document.getElementById('member_quantity').style.display= "none";
        }
      }

 </script>

 <script>
                        CKEDITOR.replace( 'lg_desc' );
                        CKEDITOR.replace( 'sh_desc' );
                </script>