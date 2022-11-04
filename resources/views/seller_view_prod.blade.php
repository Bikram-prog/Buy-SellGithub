@include('header')
@if (Session::has('delprod'))
           <div class="alert alert-danger"><center>{{Session::get('delprod')}}</center></div>
        @endif

<div class="container-fluid">
    <div class="row">
        @include('sellersidebar')

 <div class="col-md-9" style="margin-top: 30px;">
<div class="row" style="margin-bottom: 20px;">

    <div class="col-md-12">
        <h2>My Products</h2>
    </div>
   @foreach ($users as $user)
   <?php $offerpercnt = 100-(($user->prod_price*100)/$user->prod_reg_price); $offer = round($offerpercnt,0) ?>
             <div class="col-md-4">
                <div class="card">
                <!-- <a href="{{ url('sellerviewproddtls/'.$user->prod_id)}}"> 
 -->                  
@if($user->pro_img_path != '')
 <img src="{{asset('images')}}/{{ $user->pro_img_path }}" class="card-img-top" alt="...">
 @else
 <img src="{{asset('images')}}/download.png" class="card-img-top" alt="...">
 @endif

                  <div class="card-body">
                    <h5 class="card-title"> {{ $user->prod_title }}</h5>
                    @if($offer >0)
                                <span>${{ $user->prod_price }}</span>&nbsp; &nbsp;
                                <span style="color: red;font-size: 15px;">{{$offer}}%off</span>
                                @else
                                <span>${{ $user->prod_price }}</span>
                                @endif
                               

                    <a href="{{ url('sellereditproduct/'.$user->prod_id)}}" class="btn btn-clear-danger"><i style="color: #ffa502; font-size: 16px;" class="fas fa-edit"></i></a>
                    @if($user->prod_status == "Active")
                    <a onclick="return confirmbox()" href="{{ url('delproduct/'.$user->prod_id)}}" class="btn btn-clear-primary"><i style="color: #ff4757; font-size: 16px;" class="fas fa-trash"></i></a>
                    @elseif($user->prod_status == "Inactive")
                    <p style="color: #eb4d4b;">This Product is Inactive.</p><p style="color: #6ab04c; font-weight: 700;">Click this icon for activate the product. <a onclick="return confirmbox()" href="{{ url('activeproduct/'.$user->prod_id)}}" class="btn btn-clear-primary"><i class="fas fa-plus"></i></a></p>
                    
                    @endif
                  </div>
                </div>  
            <!-- <h4>{{ $user->prod_title }}</h4>
            <div><center><img src="https://www.ipcc.ch/site/assets/uploads/sites/3/2019/10/img-placeholder.png" height="200"></center></div>
            <br>
            <p>{{ $user->prod_short_desc }}</p>
            <div><a href="{{ url('sellerviewproddtls/'.$user->prod_id)}}">View Details</a></div>
            <div><a href="{{ url('sellereditproduct/'.$user->prod_id)}}">Edit Product</a></div>
            <div><a href="{{ url('delproduct/'.$user->prod_id)}}">Delete Product</a></div> -->
        </div>
          
 @endforeach
</div>
 </div>
</div>
</div>


<script type="text/javascript">
    function confirmbox() {
        var win = window.confirm("Are you sure?");
        if(win) {
            return true;
        } else {
            return false;
        }
    }
</script>

@include('footer')