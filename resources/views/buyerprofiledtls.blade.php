@include('header')




<div class="container-fluid">
    <div class="row">
        @include('buyeraccsidebar')

<div class="col-md-2"></div>
      <div class="col-md-6" style="margin-top: 30px;">
<div class="row" style="margin-bottom: 20px;">  

      


<form action="/editproffileaction" method="post" enctype="multipart/form-data">
  <h2>Edit Profile</h2>
 {{ csrf_field() }}
 
      <input type="hidden" value="<?php echo Session::get('BuyerIds'); ?>" name="buyer_id">

  <div class="form-group">
    <label for="Subcategory-ID">Your name</label>
    <input type="text" value="<?php echo $Editprofile[0]->buyer_f_name; ?>" name="name" required>
  </div>
  <div class="form-group">
    <label for="ProductTitle">Your email</label>
    <input type="text" value="<?php echo $Editprofile[0]->buyer_email ; ?>" name="email" required>
    
  </div>
  <div class="form-check">
    <label class="form-check-label">Your gender</label><br><br>
         <input class="form-check-input" type="radio" name="gender" value="male" {{ $Editprofile[0]->buyer_sex == 'male' ? 'checked' : '' }}>
         <label class="form-check-label">Male</label><br>
         <input class="form-check-input" type="radio" name="gender" value="fe-male" {{ $Editprofile[0]->buyer_sex == 'fe-male' ? 'checked' : '' }}>
         <label class="form-check-label">Female</label>
  </div>

  
  <button type="submit" class="btn btn-danger btn-lg btn-block">Update Profile</button>
</form>



 </div>
</div>
 <div class="col-md-2"></div>


  
</div>
 </div>
</div>
</div>




@include('footer')