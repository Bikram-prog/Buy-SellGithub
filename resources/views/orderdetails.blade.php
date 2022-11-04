@include('header')


<div class="container-fluid">
    <div class="row">
        @include('buyeraccsidebar')

 <div class="col-md-9">
<div class="row" style="margin-bottom: 20px;">
<div class="col-md-12">
 @foreach($ordersdtls as $orddtls) 

<div class="media">
 
  <!--   -->
  <div class="media-body">
    <h5 class="mt-0"><a href="{{ url('view_prod_dtls/'.$orddtls->prod_id )}}"> {{ $orddtls->prod_title  }}</a> </h5>
    Price: ₱{{ ($orddtls->ord_quantity  * $orddtls->ord_amount)  }}<br>
    Quantity: {{ $orddtls->ord_quantity  }}<br>
    Shipper Name: {{ $orddtls->seller_comp_name  }}<br>
    Shipper Contact-no: {{ $orddtls->seller_contct_no  }}<br>
    Date & Time: {{ $orddtls->order_date_time  }}
  </div>
 
</div>
 @endforeach
  
</div>
</div>
 </div>
</div>
</div>




@include('footer')