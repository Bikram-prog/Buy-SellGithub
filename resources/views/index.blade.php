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
  color: #E50F00 !important;
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


<center><a href="https://apps.apple.com/us/app/buyandsell-click-shop/id1630902412"><img style="width:300px;height: 100px;margin-top: 15px;" src="/images/appstore.jpeg"></a></center>


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
                <li><a href="/new-arrivals" class="highlight">(Lets you know we have products there)</a></li>
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


                    
                
                    {{-- <div style="text-align: center; margin-top: 20px;">
                      <a style="
                            text-align: center;" class="btn btn-dark" href="/new-arrivals">View All <i class="fas fa-long-arrow-alt-right"></i></a>
                    </div> --}}
                    
                </div>
                
                
              </div>
          </div>
      </div>


    



@include('footer')