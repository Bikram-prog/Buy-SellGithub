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
   <h2>Withdraw</h2>
    <h4 style="color: #6ab04c; font-weight: 700;">Cleared Balance: ${{ $totalearning[0]->TotalIEarning }}</h4>
   <h4 style="color: #eb4d4b;">Not Cleared Balance: ${{ $prodcomission[0]->TotalComissionIEarning }}</h4><hr style="margin: 15px;">
   
 </div>

 <div class="col-md-6">
  <form action="sellerwithdrwalpost" method="POST">
    {{ csrf_field() }}
   @if (Session::has('msg'))
           <div class="alert alert-danger"><center>{{Session::get('msg')}}</center></div>
        @endif
      <div class="form-group">
      <label>Enter Amount</label>
       <input class="form-control" type="text" style="width: 260px;" name="amount" placeholder="Amount.">
       <input class="form-control" type="hidden" style="width: 260px;" name="balance" value="{{ $totalearning[0]->TotalIEarning }}">
       <input class="form-control" type="hidden" style="width: 260px;" name="bank_id" value="{{ $bank_dtls[0]->bank_id }}">
     </div>
     <button type="submit" class="btn btn-danger">Send Request</button>
     
   </form>
   
 </div>

 <div class="col-md-6">
  
   
 </div>

 


 

 </div>
</div>
</div>
</div>



@include('footer')