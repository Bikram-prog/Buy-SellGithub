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
      <h2>Edit Measurement</h2> <br>
      <div class="row">
      <div class="col-md-6" style="text-align: center;">


      <style type="text/css">
        label {
          font-weight: 700 !important;
        }
      </style>


      
<img style="width: 500px;height: 460px;object-fit: contain;" src="/images/womandressmeasurement.jpeg">
  
  </div>
 <div class="col-md-6">

    <form action="/editmeasurementaction" method="post">
  
        {{ csrf_field() }}

<div class="form-group">
    <label for="Bust">Bust</label>
    <input type="text" class="form-control" value="<?php echo $Editpro[0]->prod_wmn_bust; ?>"  name="bust" required>
  </div> 

  <div class="form-group">
    <label for="Waist">Waist</label>
    <input type="text" class="form-control" value="<?php echo $Editpro[0]->prod_wmn_waist; ?>"  name="waist" required>
  </div> 

  <div class="form-group">
    <label for="Bottom">Bottom</label>
    <input type="text" class="form-control" value="<?php echo $Editpro[0]->prod_wmn_bottom; ?>"  name="bottom" required>
  </div> 

  <div class="form-group">
    <label for="Armpit">Armpit</label>
    <input type="text" class="form-control" value="<?php echo $Editpro[0]->prod_wmn_armpit; ?>"  name="armpit" required>
  </div> 

  <div class="form-group">
    <label for="Shoulder">Shoulder</label>
    <input type="text" class="form-control" value="<?php echo $Editpro[0]->prod_wmn_shoulder; ?>"  name="shoulder" required>
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




 