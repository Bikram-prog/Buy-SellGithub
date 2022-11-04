@include('header')
@if (Session::has('prodsucmsg'))
           <div class="alert alert-success"><center>{{Session::get('prodsucmsg')}}</center></div>
        @endif
      @if (Session::has('updatemsg'))
           <div class="alert alert-success"><center>{{Session::get('updatemsg')}}</center></div>
        @endif

    <div class="container addbox">
    <div class="row">



    <div class="col-md-12">
      <h2>Edit product</h2> <br>
      <div class="row">
      <div class="col-md-6">


      <style type="text/css">
        label {
          font-weight: 700 !important;
        }
      </style>

      
@if (count($errors) > 0)
         <div class = "alert alert-danger">
            <ul>
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
      @endif


<form action="/editproductaction" method="post">
  
 {{ csrf_field() }}

 <div class="row g-3">
 <label>Category & Sub Category</label>
  <div class="col-sm-7">
  @php
    $category= DB::select("Select * FROM category");
  @endphp
    
  <select onchange="subcate(this.value)" name="cate_id" class="form-control" required>
        <option value="">Choose category</option>
        @foreach($category as $cate)
        <option <?php echo ($Editpro[0]->cate_id == $cate->cate_id ? 'selected' : ''); ?> value="<?php echo $cate->cate_id; ?>"><?php echo $cate->cate_title; ?></option>
        @endforeach
    </select>
  </div>
  @php
    $sub_cate= DB::select("Select * FROM sub_category WHERE sub_cate_cate_id= '".$Editpro[0]->cate_id."'");
  @endphp
  <div class="col-sm">

  <div id="bichi" class=""></div>

  <select name="sbcatgry_id" id="sub_cate" class="form-control">
    
    @foreach($sub_cate as $sub)
    <option <?php echo ($Editpro[0]->prod_sub_cate_id == $sub->sub_cate_id ? 'selected' : ''); ?> value="<?php echo $sub->sub_cate_id; ?>"><?php echo $sub->sub_cate_title; ?></option>
    @endforeach

    
    </select>
  </div>
</div>

 <!-- <div class="form-group">
    <label for="Selectcategory">Category</label>
    
  </div> -->

  <div class="form-group">
    <label for="Selectcategory">Selling Country</label>
    <select name="contry_id" class="form-control">
        <option value="AUD" selected="selected">Australia</option>
        
    </select>
  </div>

  <div class="form-group">
    <label for="Selectcategory">Product Condition</label>
    <select name="prod_cndtn" class="form-control">
        <option value="New" {{ $Editpro[0]->prod_cndtn == 'New' ? 'selected' : '' }}>New</option>
        <option value="Used" {{ $Editpro[0]->prod_cndtn == 'Used' ? 'selected' : '' }}>Used</option>
    </select>
  </div>

 <div class="form-group">
    <label for="ProductTitle">Product Title</label>
    <input type="text" class="form-control" placeholder="Enter Product Title" value="<?php echo $Editpro[0]->prod_title; ?>" name="title" required> 
    
  </div>

  <!-- <div class="form-group">
    <label for="Selectategory">Category</label>
    

    
   
  </div> -->

  

  <!-- <div class="form-group">
    <label for="Subcategory-ID">Sub category</label>
    <select name="sbcatgry_id" class="form-control">
      <option>Select sub-category</option>
      <option>Demo1</option>
      <option>Demo2</option>
    </select>
  </div> -->
  
  <!-- <div class="form-group">
    <label for="shortDescription">Short Description(*Max 1200 characters supports)</label>
    <textarea name="sh_desc" class="form-control" rows="3" cols="30" placeholder="Write short description..."> echo $Editpro[0]->prod_short_desc; "</textarea>
  </div> -->

  <div class="form-group">
    <label for="Quantity">Quantity</label>
    <input type="text" class="form-control" placeholder="Enter Product's Quantity" value="<?php echo $Editpro[0]->prod_quantity; ?>" name="quantity" required>
  </div>

  <div class="form-group">
    <label for="Quantity">Delivery Days(In Days)</label>
    <input type="text" class="form-control" placeholder="Enter Approx Delivery Days" value="<?php echo $Editpro[0]->prod_delivery_days; ?>" name="dlvry_days" required>
  </div>
  <!-- <div class="form-group">
    <label for="Price">Regular Price</label>
    <input type="text" class="form-control" placeholder="Enter Product's Price" value="<?php echo $Editpro[0]->prod_reg_price; ?>" name="price" required>
  </div> -->

  
  
  </div>
 <div class="col-md-6">

  <div class="form-group">
    <label for="Selectcategory">Want to add this product on member section?</label>
    <select name="mmbr_cndtn" class="form-control" onchange="display(this.value)">
        <option value="Yes" {{ $Editpro[0]->prod_mmbr_sctn == 'Yes' ? 'selected' : '' }}>Yes</option>
        <option value="No" {{ $Editpro[0]->prod_mmbr_sctn == 'No' ? 'selected' : '' }}>No</option>
    </select>
  </div>

  @if($Editpro[0]->prod_mmbr_sctn == 'Yes')

  <div class="form-group" id="member_price">
    <label for="Price">Member Price</label>
    <input type="text" class="form-control" placeholder="Enter Product's Member Price" value="<?php echo $Editpro[0]->prod_mmbr_price; ?>" name="mmbr_price">
  </div>

  <div class="form-group" id="member_quantity">
    <label for="Price">Minimum Quantity</label>
    <input type="number" class="form-control" placeholder="Enter Product's Minimum Quantity" value="<?php echo $Editpro[0]->prod_mmbr_quantity; ?>" name="mmbr_minm_quantity">
  </div>

  @else

  <div class="form-group" id="member_price" style="display: none;">
    <label for="Price">Member Price</label>
    <input type="text" class="form-control" placeholder="Enter Product's Member Price" value="<?php echo $Editpro[0]->prod_mmbr_price; ?>" name="mmbr_price">
  </div>

  <div class="form-group" id="member_quantity" style="display: none;">
    <label for="Price">Minimum Quantity</label>
    <input type="number" class="form-control" placeholder="Enter Product's Minimum Quantity" value="<?php echo $Editpro[0]->prod_mmbr_quantity; ?>" name="mmbr_minm_quantity">
  </div>

  @endif



<div class="form-group">
    <label for="OfferPrice">Regular Price</label>
    <input type="text" class="form-control" placeholder="Enter Product's Price" value="<?php echo $Editpro[0]->prod_price; ?>"  name="offrprice" required>
  </div> 
<div class="form-group">
    <label for="LongDescription">Long Description(*Max 5000 characters supports)</label>
    <textarea name="lg_desc" class="form-control" rows="3" cols="30" placeholder="Write long description..."><?php echo $Editpro[0]->prod_long_desc; ?>"</textarea>
  </div>
  
  

  <hr />



 

  <div class="form-group">
  <input type="hidden" value="<?php echo Crypt::decryptString($_COOKIE['UserIds']); ?>" name="seller_id">
  </div>

  <div class="form-group">
  <input type="hidden" value="<?php echo $Editpro[0]->prod_id; ?>" name="proid">
  </div>
  
  <button type="submit" style="cursor: pointer; border-radius:8px !important; float: right;" class="btn btn-primary">NEXT</button>

  <br><br><br>

</form>







 </div>
</div>
</div>
</div>
</div>








@include('footer')


<!-- <script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="extra[]" placeholder="Enter your extra value" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  

       $('#submit').click(function(){            
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
       
 });  
 </script> -->

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
                     $("#sub_cate").hide();
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