@include('header')
@if($cover[0]->seller_cover_pic == '')
        <!-- seller CTA-->
        <div class="container card sell mt-4">
            <div class="row card-body">
                <div class="col-md-6">
                    <img src="{{asset('frontend')}}/imgs/sell.svg" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <div class="ml-6" style="margin-top: 70px;
                    margin-left: 70px;">
                        <h2>Sell On Bescrow From Today</h2>
                        <p style="font-weight: 700;">No fees, Only $1 for Selling Product First Time</p>
                        <a href="/seller" class="btn btn-primary btn-lg crow-btn">Start Selling</a>
                    </div>
                    
                </div>
            </div>
        </div>
@endif


    <!-- category page-->

    <div class="container mt-6" style="margin-top: 20px;">
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
              <h1>{{ $title }} <span class="badge badge-info" style="font-weight: 500;"><?php echo number_format($ratings_seller[0]->AverageRatings, 1); ?> <i class="fas fa-star"></i></span> </h1>
                <p>
                    <!-- // seller ratings -->
                </p>
                <hr />
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 left-sidebar">

                <form action="" method="get">
                    
                    <div class="card" style="">
                        <div class="card-header">
                          Categories
                        </div>
                        <ul class="list-group list-group-flush">
                        @foreach($category as $cat)
                          <a style="color:#222;" href="/category/{{ $cat->cate_id }}/{{ $cat->cate_title }}"> <li class="list-group-item">{{ $cat->cate_title }}</li></a>
                        @endforeach
                        </ul>
                      </div>
                      
                      <div class="card mt-2" style="">
                        <div class="card-header">
                          Filter
                        </div>
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="New" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                  New
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Used" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                  Used
                                </label>
                              </div>
                              <hr>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                  $10 and below
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                  $10 - $50
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                  $50 - $100
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                  $200 - $300
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                  $400 - $600
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                  $600 - $800
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                  Above $800+
                                </label>
                              </div>
                              <hr>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" checked value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                  Exclude Out Of Stock
                                </label>
                              </div>
                              <button style="border-radius: 4px !important;" type="submit" class="mt-2 btn btn-primary btn-block">Filter</button>
                        </div>
                        
                      </div>
                      
                </form>
            </div>
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