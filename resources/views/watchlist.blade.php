@include('header')
<style>
  .ul li{
    list-style:none;
    margin-left:15px;
    float:left;
    margin-bottom:15px;
  }
  .ul li a{
    color:#4834d4;
    font-weight:700;
    text-decoration:none;
  }
</style>
        <!-- seller CTA-->
   


    <!-- category page-->

    <div class="container mt-6" style="margin-top: 20px;">
        <div class="row text-center">
            <div class="col-md-12">
                <h4>Wishlist</h4>
                <hr />
            </div>
            <div class="col-md-12">
            </div>
        </div>
        <div class="row">
            
                @include('buyeraccsidebar')
                      
            
            <div class="col-md-8 text-center">
                <div class="row ow-cols-md-4">
                <?php $j = 0; ?>
                    @foreach ($users as $user)
                    <?php //$offerpercnt = 100-(($user->prod_price*100)/$user->prod_reg_price); $offer = round($offerpercnt,0);
                    $price = number_format($user->prod_price, 2); 
                    $substr = substr($user->prod_title , 0, 20);
                    ?>
                    
                    <a style="color: #000;" href="/p/{{ $user->prod_id }}">
                        
                    
                        <div class="col-6 col-sm-12 col-md-4 col-lg-3 directory-item">
                        <div class="card-body">
                            <img src="{{asset('images')}}/{{ $user->pro_img_path }}" class="prod-img">
                            <h4 class="prod-title">{{ $substr }}</h4>
                            
                            
                            <p style="font-weight: 500;"><span class="badge badge-info"><?php echo number_format($ratings_sel_pro[$j][0]->AverageRatings, 1); ?> <i class="fas fa-star"></i></span> </p>
                            
                            
                            <p class="prod-price">${{ $price }}</p>
                            
                        </div>
                        <a href="/p/{{ $user->prod_id }}"><div class="card-footer">
                            <i class="fas fa-bolt"></i> Buy Now
                        </div></a>
                    </div>
                </a>
                <?php $j++; ?>
                @endforeach
                
                    
                </div>

                
                
      
 

             
            </div>
        </div>
    </div>

    @include('footer')