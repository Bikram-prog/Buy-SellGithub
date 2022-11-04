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
    <h2>Sold</h2>
    
</div>
</div>
    <div class="row">

@include('buyeraccsidebar')


<div class="col-md-9">
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

 <div class="col-md-12">
   
   
   <div class="row">
     <div class="col"> 
       <form action="/searchorderhistry" method="GET">
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
      <form action="/searchorder" method="GET">
        {{ csrf_field() }}
        <div style="width: 400px;" class="input-group mb-2">
                         
                        
                         <input type="text" class="form-control" name="order_srch" placeholder="Search with order id.">
                         
                         <button type="submit" class="btn btn-outline-info ml-2">Search</button>
                       
                         
                       </div>  
                       
                     </form>
     </div>
   </div>
  
               
 </div>
 @if (Session::has('msg'))
                          <div class="alert alert-danger">{{Session::get('msg')}}</div>
                    @endif
<table class="table table-bordered table-striped">
  <thead class="thead-light">
    <tr>
      <th scope="col">Image</th>
      <th scope="col">Poduct Name</th>
      <th scope="col">Poduct Condition</th>
      <th scope="col">Quantity</th>
      <th scope="col">Buyer Name</th>
      <!-- <th scope="col">Order Number</th> -->
      <th scope="col">Order Amount</th>
      <th scope="col">Order Date & Time</th>
      <th scope="col">Order Status</th>
      <th scope="col">Comission B & S (5%)</th>
      <th scope="col">Total to be paid</th>
    </tr>
  </thead>
  <tbody>
    @foreach($Orderprod as $order)

    
    
    @php
    $proImg= DB::table('pro_images')
              ->where('prod_img_prod_id', '=', $order->prod_id)
              ->get();

    $comission= $order->ord_amount - $order->ord_paid_amount;
    @endphp
            <tr>
              <td><img style="width: 100px;height: 100px;" src="{{asset('images')}}/<?php echo $proImg[0]->pro_img_path; ?>"></td>
             <td>{{ $order->prod_title  }}
             @if( $order->ord_variation != '')
              <p style="font-weight: bold;">Variation: {{ $order->ord_variation  }}</p>
              @endif
              <p style="font-weight: 700;">Delivery to: <br>
              {{ $order->ord_delivery_add }}</p>
              <p style="font-weight: bold;">Order ID: 
              {{ $order->ord_uniq_id }}</p><hr>

              <form action="/trackpost" method="POST">
              {{ csrf_field() }}

              <div class="form-group">
                <label>Carrier</label>
                <select class="form-control" name="carrier">
                <option value="Australia Post">Australia Post</option>
                <option value="Sendle">Sendle</option>
                <option value="Untracked Item">Untracked Item</option>
                </select>
                
            </div>

              <div class="form-group">
                    <label>Tracking Number</label>
                    
                    @if( $order->ord_tracking_no == '')
                    <input type="text" name="track_no" style="width:350px;" class="form-control">
                    @else
                    <input type="text" name="track_no" style="width:350px;" value="{{ $order->ord_tracking_no }}" class="form-control">
                    {{-- <p><a href="/track/{{ $order->ord_tracking_id }}/{{ $order->ord_tracking_no }}" class="btn btn-primary float-right" style="border-radius: 5px !important; margin-top: -40px;"><i class="fas fa-map-marker-alt"></i> Track</a></p> --}}
                    @endif
                </div>
                <input type="hidden" name="order_id" value="{{ $order->ord_id }}" class="form-control">
                {{-- @if( $order->ord_tracking_no == '') --}}
                <button type="submit" class="btn btn-primary" style="border-radius: 8px !important;">Save</button>
                {{-- @endif --}}
              </form>

            </td>
             <td>{{ $order->prod_cndtn }}</td>
             <td>{{ $order->ord_quantity }}</td>
             <td>{{ $order->name }}</td>
             <!-- <td>{{ $order->ord_uniq_id }}</td> -->
             <td>${{ ($order->ord_quantity * $order->ord_amount) }}</td>
             <td>{{ $order->order_date_time }}</td>
             <td>{{ $order->ord_status }}</td>
             <td>${{ $comission }}</td>
             <td>${{ $order->ord_paid_amount }}</td>
            </tr>
    @endforeach
   
   </tbody>
 </table>



 

 </div>
</div>
</div>
</div>

<script type="text/javascript">
  function edit_status(str) {
    var str = str;
    var orderid = document.getElementById("hd_ord_id").value;
    return window.location.href="/sellerorderstatuschange/" + orderid + "/" + str;
  }
</script>

@include('footer')