@include('header')

<style type="text/css">
  .Delivered {
    border: 2px solid #6CE507 !important;
  }
  .Shipped {
    border: 2px solid #E5DB07 !important;
  }
  .Undelivered {
    border: 2px solid #E50718 !important;
  }
  .Order_placed {
    border: 2px solid #0780E5 !important;
  }
</style>

<div class="container-fluid">
    <div class="row">

@include('sellersidebar')

<div class="col-md-10" style="margin-top: 30px;">
<div class="row" style="margin-bottom: 20px;">

  <!-- search -->
<!--   <div style="padding: 10px;">
    <div class="col-md-3"><input type="text" name="" placeholder="Date from" class="form-control"></div>
    <div class="col-md-3"><input type="text" name="" placeholder="Date to" class="form-control"></div>
    <div class="col-md-3"><select class="form-control" name=""><option>CSV</option><option>PDF</option></select></div>
    <div class="col-md-3"><button type="button" class="cart-btn btn-hover"><i class="fas fa-file-download"></i> Search</button></div>
  </div> -->

<!--   <table class="table table-bordered table-striped">
  <thead class="thead-light">
    <tr>
      <th scope="col">Seller Name: {{Session::get('UserFullName')}}</th>
      
    </tr>
  </thead>
  <tbody>
    @foreach($totalearning as $total)
            <tr>
             <td>Total Earning: ₱{{ $total->TotalIEarning  }}</td>
             </tr>
    @endforeach
   
   </tbody>
 </table> -->

<style type="text/css">
  label{
    font-weight: bold;

  }
  .btn-danger{
    border-radius: 25px;
    width: 260px;
    height: 40px;
  }
</style>
 <div class="col-md-12">
   <h2>Add Bank Account</h2><hr style="margin: 15px;">
   
 </div>

 <div class="col-md-8">
   <form action="/selleraccntpost" method="POST">
    {{ csrf_field() }}
     <div class="form-group">
      <label>Account holder name</label>
       <input class="form-control" type="text" style="width: 260px;" name="accnthldr_name" >
     </div>

     <div class="form-group">
      <label>Bank name</label>
       <input class="form-control" type="text" style="width: 260px;" name="bank_name" >
     </div>

     <div class="form-group">
      <label>Account number</label>
       <input class="form-control" type="text" style="width: 260px;" name="bankacccnt_no" >
     </div>
     <button type="submit" class="btn btn-danger">Save</button>
   </form>
  
   
 </div>

 <div class="col-md-4">
   
 </div>

 


 

 </div>
</div>
</div>
</div>



@include('footer')