@include('header')

<style>
  .category-horizontal li {
    line-height: 30px;
    
  }

  .category-horizontal {
    padding-left: 0rem !important;
  }

  /*-- testimonial Section CSS --*/
#testimonial {
    margin-top: 30px;
    padding: 30px 0px 20px;
    color: #fff;
    background-color: #283270;
}
#testimonial h2 {
    font-style: italic;
    color: #fff;
    font-size: 26px;
    text-align: center;
}
#testimonial .client-img {
    width: 80px;
    height: 80px;
    overflow: hidden;
    border: 3px solid #fff;
    margin: 0px auto;
    border-radius: 100%;
    position: absolute;
    left: 0px;
}
#testimonial .carousel-content {
    padding: 20px 0px 20px 100px;
    width: 70%;
    margin: 0 auto;
    position: relative;
}
#testimonial h3 {
    font-size: 17px;
    color: #fff;
    margin-bottom: 30px;
    font-style: italic;
    text-align: right;
}
#testimonial p {
    font-size: 15px;
}
#testimonial .client-img img {
    width: 100%;
}
#testimonial .carousel-control-prev,
#testimonial .carousel-control-next {
    font-size: 36px;
}

@media (max-width: 576px) {
#testimonial .carousel-content {
    padding: 20px 0px 20px 0px;
    width: 100%;
}
#testimonial .client-img {
    margin: 20px auto;
    position: static;
}
#testimonial h3, #testimonial p {
    text-align: center;
}
}
/*-- End Testimonial Section CSS --*/


.highlight {
  font-weight: bold !important;
  color: #283171 !important;
  font-size: 1.3rem;
}

.default-light {
  font-weight: 400 !important;
}


  </style>

<div class="container">
          <div class="row">
              <div class="col-12 mt-2">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                  <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
                  </div>
                    <div class="carousel-inner">

                      <div class="carousel-item active">
                        <img src="/images/megahealth.jpg" class="d-block w-100" alt="product banner">
                      </div>

                      <div class="carousel-item ">
                        <img src="/images/banner_new.jpeg" class="d-block w-100" alt="product banner">
                      </div>

                      <div class="carousel-item">
                        <img src="/images/banner-02.jpg" class="d-block w-100" alt="product banner">
                      </div>

                      <div class="carousel-item">
                        <img src="/images/banner-03.jpg" class="d-block w-100" alt="product banner">
                      </div>

                      <div class="carousel-item">
                        <a target="_blank" href="https://globallove.online"><img src="/images/banner_06.webp" class="d-block w-100" alt="product banner"></a>
                      </div>

                      
                      
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                  </div>
              </div>
          </div>
</div>

{{-- <marquee scrollamount="12" style="padding: 20px;
font: bold 60px / 73px Montserrat;"><span style="color: #a7a7a7;">Free To Join.</span> &nbsp; <span style="color: #293A82;">Free Shipping.</span> <span style="color: #a7a7a7;">Credit Card Only.</span> &nbsp; <span style="color: #293A82;">Seller Not Paid Until You Receive Your Order.</span> &nbsp; <span style="color: #a7a7a7;">5% Seller Fees.</span></marquee> --}}

<center><a href="https://apps.apple.com/us/app/buyandsell-click-shop/id1630902412"><img style="width:300px;height: 100px;margin-top: 15px;" src="/images/appstore.jpeg"></a></center>

{{-- <div class="container">
  <div class="row mt-4">
    
    <div class="col-md-5 mx-auto">
      <div class="ratio ratio-16x9">
        <video width="320" height="240" controls>
          <source src="https://buyandsell.click/images/promo-boll.mp4" type="video/mp4">
        Your browser does not support the video tag. Please update your browser or use latest Google Chrome.
        </video>
      </div>
    </div>
    <div class="col-md-4 mx-auto">
      <a href="/website-review" target="_blank"><div class="card"  style="padding: 30px; border: 1px solid #5352ed;height: 240px;">
        <h4 style="font-size: 20px !important;
        text-align: center !important;
        color: #000000;
        font-weight: 700; font-family: Roboto;margin-top: 60px;" class="card-title2">Write A Review About <br>Buy & Sell?</h4>
      </a>
    </div>
      <div class="col-md-3"></div>
    </div>
  </div> --}}





{{-- <div class="container-xl mt-4">
  <div class="row">
    <div class="col-md-2">
      <a href="/category/29/Sports"><div class="card"  style="padding: 20px;">
        <i style="color: #4cd137;" class="fas fas-icon fa-running"></i>
        <h4 class="card-title2">Sports</h4>
      </div></a>
    </div>
    <div class="col-md-2">
      <a href="/subcategory/4/29/Golf"><div class="card"  style="padding: 20px;">
        <i style="color: #fbc531;" class="fas fas-icon fa-golf-ball"></i>
        <h4 class="card-title2">Golf</h4>
      </div> </a>
    </div>
    <div class="col-md-2">
      <a target="_blank" href="https://globallove.online/"><div class="card"  style="padding: 20px;">
      <img src="https://globallove.online/images/global-love-logo@2x.png" class="img-fluid">
      
      </div></a>
    </div>
    <div class="col-md-2">
      <a target="_blank" href="http://167.71.205.34/"><div class="card"  style="padding: 20px;">
      <i style="color: #9c88ff;" class="fas fas-icon fa-laptop-code"></i>
        <h4 class="card-title2">YourDeveloper.world</h4>
      </div></a>
    </div>
    
    
    <div class="col-md-2">
      <a href="/about" target="_blank"><div class="card"  style="padding: 20px; border: 1px solid #5352ed;">
        <h4 style="font-size: 20px !important;
        text-align: center !important;
        color: #000000;
        font-weight: 700; font-family: Roboto;margin-top: 25px;" class="card-title2">What Is <br>Buy & Sell?</h4>
      </div></a>
    </div>

    <div class="col-md-2">
      <a href="/website-review" target="_blank"><div class="card"  style="padding: 20px; border: 1px solid #5352ed;">
        <h4 style="font-size: 20px !important;
        text-align: center !important;
        color: #000000;
        font-weight: 700; font-family: Roboto;" class="card-title2">Write A Review About <br>Buy & Sell?</h4>
      </div></a>
    </div>
  </div>
</div> --}}


<div class="container-xl mt-4">
  <div class="row">
    <div class="col-10">
      
    </div>
    <div class="col-2">
      
    </div>
  </div>
          <div class="row">
            <div class="col-md-3">
              <h2 style="font-weight: bold; font-size: 22px; margin-bottom: 20px;">Filters</h2>
              <ul class="category-horizontal">
                <li><a href="/filters/Alphabetical Order">Alphabetical Order</a></li>
                <li><a href="/filters/Lowest To Highest Price">Lowest To Highest Price</a></li>
                <li><a href="/filters/Highest To Lowest Price">Highest To Lowest Price</a></li>
              </ul>
              <h2 style="font-weight: bold; font-size: 22px; margin-bottom: 20px;">Shop by category</h2>
              <ul class="category-horizontal">
                @foreach($category as $cat)
                @php
                $query = DB::select("select t1.cate_title,t2.prod_title from category t1 left join products t2 on(t1.cate_id=t2.prod_cate_id) where t2.prod_cate_id = '".$cat->cate_id."' and t2.prod_live_status = 1 and t2.prod_status = 'Active'");
                @endphp
               @if($cat->cate_id == '38')

               <li><a onclick="return confirm('Are you 18+?')" class="<?php echo (count($query) > 0 ? 'highlight': ''); ?>" href="/category/{{ $cat->cate_id }}/<?php echo  $cat->cate_title; ?>">{{ $cat->cate_title }}</a></li>

               @else
                <li><a class="<?php echo (count($query) > 0 ? 'highlight': ''); ?>" href="/category/{{ $cat->cate_id }}/<?php echo  $cat->cate_title; ?>">{{ $cat->cate_title }}</a></li>
              @endif
                
                @endforeach
              </ul>
            </div>
              <div class="col-9">
                  
                <div class="row">
                  <h2 style="font-weight: bold; font-size: 22px; margin-bottom: 20px;"><a style="text-decoration: none; color: unset;" href="/">Featured Products</a></h2>

                  <?php $j = 0; ?>
                @foreach ($featured as $user)
                <?php
                        $price = number_format($user->prod_price, 2);
                        $substr = substr($user->prod_title , 0, 40); ?>
                @php
                  $prodImg = DB::table('pro_images')
                            ->where('prod_img_prod_id', '=', $user->prod_id)
                            ->where('prod_default_status', '=', '1')
                            ->get();
                @endphp
                  <div class="col-md-4 mt-2">
                    <div class="card box">
                    @if(count($prodImg) > 0)
                            <a href="/p/{{ $user->prod_id }}"><img style="object-fit: contain;" src="{{asset('images')}}/{{ $prodImg[0]->pro_img_path }}" class="card-img-top" alt="name"></a>
                    @else
                            <a href="/p/{{ $user->prod_id }}"><img style="object-fit: contain;" src="{{asset('images')}}/{{ $user->pro_img_path }}" class="card-img-top" alt="name"></a>
                    @endif
                      <div class="card-body">
                        <a href="/p/{{ $user->prod_id }}" style="text-decoration: none;"><h5 style="text-align: left !important;" class="card-title mb-3">{{ $user->prod_title }}</h5></a>
                        <p class="card-text price mb-2">${{ $price }}</p>
                        <p style="font-weight: 500;"><span class="badge bg-warning"><?php echo number_format($ratings_featured[$j][0]->AverageRatings, 1); ?> <i class="fas fa-star"></i></span> <small></small></p>
                      </div>
                    </div>
                  </div>
                    <?php $j++; ?>
                    @endforeach

                  {{-- <h2 style="font-weight: bold; font-size: 22px; margin-bottom: 20px; margin-top: 10px;"><a style="text-decoration: none; color: unset;" href="/new-arrivals">New Arrivals</a></h2>
                    <?php $j = 0; ?>
                @foreach ($newArrivals as $user)
                <?php //$offerpercnt = 100-(($user->prod_price*100)/$user->prod_reg_price); 
                        //$offer = round($offerpercnt,0);
                        $price = number_format($user->prod_price, 2);
                        $substr = substr($user->prod_title , 0, 40); ?>
                @php
                  $prodImg = DB::table('pro_images')
                            ->where('prod_img_prod_id', '=', $user->prod_id)
                            ->where('prod_default_status', '=', '1')
                            ->get();
                @endphp
                  <div class="col-md-4 mt-2">

                    {{-- <a href="/p/{{ $user->prod_id }}"><img style="object-fit: cover; height: 300px;" src="{{asset('images')}}/{{ $prodImg[0]->pro_img_path }}" class="card-img-top" alt="name"></a> --}}

                    <div class="card box">
                    @if(count($prodImg) > 0)
                            <a href="/p/{{ $user->prod_id }}"><img style="object-fit: contain;" src="{{asset('images')}}/{{ $prodImg[0]->pro_img_path }}" class="card-img-top" alt="name"></a>
                    @else
                            <a href="/p/{{ $user->prod_id }}"><img style="object-fit: contain;" src="{{asset('images')}}/{{ $user->pro_img_path }}" class="card-img-top" alt="name"></a>
                    @endif
                      <div class="card-body">
                        <!-- <h5 class="card-subtitle mb-2">Electronics</h5> -->
                        <a href="/p/{{ $user->prod_id }}" style="text-decoration: none;"><h5 style="text-align: left !important;" class="card-title mb-3">{{ $user->prod_title }}</h5></a>
                        <p class="card-text price mb-2">${{ $price }}</p>
                        <p style="font-weight: 500;"><span class="badge bg-warning"><?php echo number_format($ratings_new[$j][0]->AverageRatings, 1); ?> <i class="fas fa-star"></i></span> <small></small></p>
                        <!-- <p style="color: #3E7903; font-weight: 700; font-size: 15px;">In Stock </p> -->
                      </div>
                      {{-- <div class="card-footer">
                        <div class="d-grid gap-2">
                            <a class="btn btn-danger btn-lg" href="/p/{{ $user->prod_id }}">Add to cart <i class="fas fa-shopping-cart"></i></a>
                        </div>
                        
                      </div> --}}
                    </div>
                  </div>
                    <?php $j++; ?>
                    @endforeach
                    <div style="text-align: center; margin-top: 20px;">
                      <a style="
                            text-align: center;" class="btn btn-dark" href="/new-arrivals">View All <i class="fas fa-long-arrow-alt-right"></i></a>
                    </div>
                    
                </div>
                
                
              </div>
          </div>
      </div>


      <div class="container-xl mt-4">
        <div class="row">
          <div class="col-10">
            <h2 style="font-weight: bold; font-size: 22px; margin-bottom: 20px;">Recommended Products For You</h2>
          </div>
          {{-- <div class="col-2">
            <a style="float: right; text-align: right;" class="btn btn-dark" href="">View all</a>
          </div> --}}
        </div>
        <div class="row">
            <div class="col-12">
                
              <div class="row">
              <?php $j = 0; ?>
                @foreach ($allProd as $all)
                @php
                  $prodImg = DB::table('pro_images')
                            ->where('prod_img_prod_id', '=', $all->prod_id)
                            ->where('prod_default_status', '=', '1')
                            ->get();
                @endphp
                <?php //$offerpercnt = 100-(($all->prod_price*100)/$all->prod_reg_price); 
                        //$offer = round($offerpercnt,0);
                        $price = number_format($all->prod_price, 2);
                        $substr = substr($all->prod_title , 0, 40); ?>
                  <div class="col-md-3 mt-2">
                    <div class="card box">

                    @if(count($prodImg) > 0)
                            <a href="/p/{{ $all->prod_id }}"><img style="object-fit: contain;" src="{{asset('images')}}/{{ $prodImg[0]->pro_img_path }}" class="card-img-top" alt="name"></a>
                    @else
                            <a href="/p/{{ $all->prod_id }}"><img style="object-fit: contain;" src="{{asset('images')}}/{{ $all->pro_img_path }}" class="card-img-top" alt="name"></a>
                    @endif
                   
                            <!-- <a href="/p/{{ $all->prod_id }}"><img style="object-fit: cover; height: 300px;" src="{{asset('images')}}/{{ $all->pro_img_path }}" class="card-img-top" alt="name"></a> -->
                    
                      <div class="card-body">
                        <!-- <h5 class="card-subtitle mb-2">Electronics</h5> -->
                        <a href="/p/{{ $all->prod_id }}" style="text-decoration: none;"><h5 class="card-title mb-3">{{ $all->prod_title }}</h5></a>
                        <p class="card-text price mb-2">${{ $price }}</p>
                        <p style="font-weight: 500;"><span class="badge bg-warning"><?php echo number_format($ratings_all[$j][0]->AverageRatings, 1); ?> <i class="fas fa-star"></i></span> <small></small></p>
                        <!-- <p style="color: #3E7903; font-weight: 700; font-size: 15px;">In Stock </p> -->
                      </div>
                      {{-- <div class="card-footer">
                        <div class="d-grid gap-2">
                            <a class="btn btn-danger btn-lg" href="/p/{{ $all->prod_id }}">Add to cart <i class="fas fa-shopping-cart"></i></a>
                        </div>
                        
                      </div> --}}
                    </div>
                  </div>
                  
                  <?php $j++; ?>
                    @endforeach

                    
                  
                </div>
            </div>
        </div>
    </div> --}}


    <div class="container">
      <div class="row mt-4">
        
        <div class="col-md-3"></div>
        <div class="col-md-6">
          <a href="/website-review" target="_blank"><div class="card"  style="padding: 30px; border: 1px solid #5352ed;height: 80px;">
            <h4 style="font-size: 20px !important;
            text-align: center !important;
            color: #000000;
            font-weight: 700; font-family: Roboto;margin-top: 30px;" class="card-title2">Write A Review About <br>Buy & Sell?</h4>
          </a>
        </div>
          <div class="col-md-3"></div>
        </div>
      </div>


    <!-- Testimonials Section -->
    <section id="testimonial">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <div class="section-title">
                      <h2>Customers Reviews</h2>
                  </div>
              </div>
              <div class="col-12">
                  <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                    {{-- <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button> --}}
                    
                      <div class="carousel-inner">
                          @php 
                          $i = 1;
                          @endphp
                          @foreach($webreview as $web)
                          <div class="carousel-item <?php echo ($i == 1 ? 'active' : ''); ?>">
                              <div class="carousel-content">
                                  {{-- <div class="client-img"><img src="images/user-img-2.jpg" alt="Testimonial Slider" /></div> --}}
                                  <p style="font-weight: 500;"><span class="badge bg-success">{{ $web->review_ratings }} <i class="fas fa-star"></i></span> <small></small></p>
                                  <p><i>{{ $web->review_comments }}</i></p>
                                  <!-- <h3><span>-</span> {{ $web->name }} <span>-</span></h3> -->
                              </div>
                          </div>
                          @php 
                          $i++;
                          @endphp
                          @endforeach
                          
                
                          
                      </div>
                      <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                      </button>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!-- End testimonials Section -->

  <!-- Testimonials Section -->
  <div style="height: 20px;">&nbsp;</div>
  <section id="testimonial">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Testimonial</h2>
                </div>
            </div>
            <div class="col-12">
              @php 
                $tstmnl = DB::connection('mysql2')->table('testimonials')->where('status', '=', '1')->get();
              @endphp
                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                  
                  
                    <div class="carousel-inner">
                      @php 
                      $i = 1;
                      @endphp
                      @foreach($tstmnl as $tst)
                      <div class="carousel-item <?php echo ($i == 1 ? 'active' : ''); ?>">
                          <div class="carousel-content">
                              <p style="font-weight: 500;"><span>{{ $tst->category }}</span> <small></small></p>
                              <p><i>{{ $tst->remarks }}</i></p>
                              
                              
                          </div>
                      </div>
                      @php 
                      $i++;
                      @endphp
                      @endforeach
                                                                            
                                                                            
                                                                            
                                                                            
              
                        
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End testimonials Section -->



@include('footer')