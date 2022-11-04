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

<div class="container">

<div class="row">
  <div class="col-md-12">
    <h2>Selling Comissions</h2>
    <hr>
    <div class="row">
        <div class="col"> 
          <form action="/cmssnsearchorderhistry" method="GET">
         {{ csrf_field() }}
         <div style="width: 400px;" class="input-group mb-2">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="far fa-calendar-alt"></i>
                            </span>
                          </div>
                         
                          <input type="text" class="form-control" name="date" id="reservation">
                          
                          <button type="submit" class="btn btn-outline-info ml-2">Search</button>
                        
                          
                        </div>  
                        
                      </form>
                     </div>
        <div class="col">
         <form action="/cmssnsearchorder" method="GET">
           {{ csrf_field() }}
           <div style="width: 400px;" class="input-group mb-2">
                            
                           
                            <input type="text" class="form-control" name="order_srch" placeholder="Search with product id">
                            
                            <button type="submit" class="btn btn-outline-info ml-2">Search</button>
                          
                            
                          </div>  
                          
                        </form>
        </div>
      </div>
      @foreach($prodcomission as $comProd)
      @if($comProd->TotalComissionIEarning != '')
      <h5>Total Comission Paid:<span style="color:#eb4d4b;font-weight: bold;"> -${{ $comProd->TotalComissionIEarning }}</span></h5>
      @else
      <h5>Total Comission Paid:<span style="color:#eb4d4b;font-weight: bold;"> $0</span></h5>
      @endif
      @endforeach
  </div>
</div>
    <div class="row">

@include('buyeraccsidebar')

<div class="col-md-8">
<div class="row">

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



 
<table class="table table-bordered table-striped">
  <thead class="thead-light">
    <tr>
      <th scope="col">Image</th>
      <th scope="col">Poduct Name</th>
      <th scope="col">Comission Amount</th>
      <th scope="col">Comission Date & Time</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    foreach($Comissionprod as $comission) { 
    
      $proImg= DB::table('pro_images')
              ->where('prod_img_prod_id', '=', $comission->prod_id)
              
              ->get();
    ?>
            <tr>
            <td><img style="width: 100px;height: 100px;" src="{{asset('images')}}/<?php echo $proImg[0]->pro_img_path; ?>"></td>
             <td><?php echo $comission->prod_title; ?><p style="font-weight:700;">Product ID: <span><?php echo  $comission->prod_id; ?></span></p></td>
             <td><p style=color:#eb4d4b>-$<?php echo $comission->payment_amount; ?></p></td>
             <td><?php echo date('d/m/Y h:i a', strtotime($comission->created_at)) ?></td>
            </tr>
    <?php } ?>
   
   </tbody>
 </table>
 
 
 

 </div>
</div>
</div>
</div>



@include('footer')