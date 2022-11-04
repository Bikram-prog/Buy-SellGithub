@include('header')

<style>
.card {
    min-height: 560px !important;
    max-height: 560px !important;
}
</style>


    <!-- category page-->

    <div class="container-xl mt-6">
        <div class="row text-center">
            <div class="col-md-12">
            @if($cover[0]->seller_cover_pic != '')
              <img src="{{asset('images')}}/{{ $cover[0]->seller_cover_pic }}" class="img-fluid" style="max-height: 312px; max-width: 820px;">
              @endif 
              <br>
              @if($cover[0]->seller_prfl_pic != '')
              <img src="{{asset('images')}}/{{ $cover[0]->seller_prfl_pic }}" class="prod-img" style="margin-top: -40px;">
              @endif  
              <br>
              <h1>{{ $title }} <span class="badge bg-primary" style="font-weight: 500;"><?php echo number_format($ratings_seller[0]->AverageRatings, 1); ?> <i class="fas fa-star"></i></span> </h1>
                
                {{-- <h4 class="text-left">{{ $text }}</h4> --}}
                
                    <h4 class="text-left mt-2">My products</h4>
                
                
            </div>
        </div>
        
          <div class="row">
          
            @include('buyeraccsidebar')
        
        
            
            <div class="col-md-9 text-center">
                <div class="row">
                    
                @if (Session::has('succmsg'))
                    <div class="alert alert-success"><center>{{Session::get('succmsg')}}</center></div>
                @endif
                    
                <?php $j = 0; ?>
                    @foreach ($users as $user)
                    <?php //$offerpercnt = 100-(($user->prod_price*100)/$user->prod_reg_price); $offer = round($offerpercnt,0);
                    $price = number_format($user->prod_price, 2); 
                    $substr = substr($user->prod_title , 0, 40);
                    ?>
                    
                    @php
                      $prodImg = DB::table('pro_images')
                                ->where('prod_img_prod_id', '=', $user->prod_id)
                                ->where('prod_default_status', '=', '1')
                                ->get();
                    @endphp
                        
                    
                        <div class="col-md-4 mt-2">
                            <div class="card">
                        <div class="card-body">
                        @if(count($prodImg) > 0)
                            <a href="/p/{{ $user->prod_id }}"><img style="object-fit: contain;" src="{{asset('images')}}/{{ $prodImg[0]->pro_img_path }}" class="card-img-top" alt="name"></a>
                    @else
                            <a href="/p/{{ $user->prod_id }}"><img style="object-fit: contain;" src="{{asset('images')}}/{{ $user->pro_img_path }}" class="card-img-top" alt="name"></a>
                    @endif
                    <h4 style="font-size: 14px; font-weight: bold;" class="prod-title mt-2"><a style="color: #000;" href="/p/{{ $user->prod_id }}">{{ $substr }}</a></h4>
                            <p style="font-weight: 500;"><span class="badge bg-info"><?php echo number_format($ratings_sel_pro[$j][0]->AverageRatings, 1); ?> <i class="fas fa-star"></i></span> </p>
                            
                            <p style="font-size: 1.1rem; font-weight: bold;" class="prod-price">${{ $price }}</p>
                            <p style="font-size: 1.1rem; font-weight: bold;" class="prod-price"><span class="badge <?php echo ($user->prod_quantity > 0 ? 'bg-primary' : 'bg-danger'); ?>">Quantity: {{ $user->prod_quantity }}</p>
                            @if($user->prod_draft_status == '1')
                            <p style="color: red; font-weight: bold;">Draft</p>
                           
                            @endif
                            
                        
                        <p>
                <a href="{{ url('sellereditproduct/'.$user->prod_id)}}" class="btn btn-outline-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                    @if($user->prod_status == "Active")
                    <a onclick="return confirmbox()" href="{{ url('delproduct/'.$user->prod_id)}}" class="btn btn-outline-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                    @elseif($user->prod_status == "Inactive")
                    <p style="color: #eb4d4b; font-weight: bold;">This Product is Inactive.</p><p style="color: #6ab04c; font-weight: 700;"> <a onclick="return confirmbox()" href="{{ url('activeproduct/'.$user->prod_id)}}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> Activate this product</a></p>
                    
                    @endif

                    <p style="color: #6ab04c; font-weight: 700;"> <a href="{{ url('buyerreview/'.$user->prod_id)}}" class="btn btn-dark"><i class="fas fa-pen"></i> Add a review</a></p>
            </p>

        </div>
                    </div>
                </div>
                
                <?php $j++; ?>
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