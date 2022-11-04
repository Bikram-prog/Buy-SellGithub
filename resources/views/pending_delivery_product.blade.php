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

 <div class="col-md-12">
   <h2>Pending Delivery Orders</h2>
 </div>

 <div class="col-md-12">
    @foreach($totalpendingearning as $pending)
            <h3 style="font-size: 15px;color: #eb4d4b;"><i class="fas fa-wallet"></i> Pending Balance: ${{ $pending->TotalPendingIEarning  }}</h3>
             
    @endforeach
  <h3 style="font-size: 15px;">Pending Delivery: {{ count($totalpendingeprod) }}</h3>
</div>
 
<table class="table table-bordered table-striped">
  <thead class="thead-light">
    <tr>
      <th scope="col">Poduct Name</th>
      <th scope="col">Quantity</th>
      <th scope="col">Buyer Name</th>
      <!-- <th scope="col">Order Number</th> -->
      <th scope="col">Order Amount</th>
      <th scope="col">Order Date & Time</th>
      <th scope="col">Order Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach($totalpendingeprod as $order)
            <tr>
             <td>{{ $order->prod_title  }}
             @if( $order->ord_variation != '')
              <p style="font-weight: bold;">Variation: {{ $order->ord_variation  }}</p>
              @endif
              <p style="font-weight: bold; color: #eb4d4b;">Deliver to:</p>
              <p style="font-weight: bold;">{{ $order->ord_delivery_add }}</p>
            </td>
             <td>{{ $order->ord_quantity }}</td>
             <td>{{ $order->buyer_f_name }}</td>
             <!-- <td>{{ $order->ord_uniq_id }}</td> -->
             <td>${{ ($order->ord_quantity * $order->ord_amount) }}</td>
             <td>{{ $order->order_date_time }}</td>
             <td>{{ $order->ord_status }}</td>
            </tr>
    @endforeach
   
   </tbody>
 </table>

 

 </div>
</div>
</div>
</div>



@include('footer')