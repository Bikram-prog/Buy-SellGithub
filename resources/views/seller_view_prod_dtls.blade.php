@include('header')
<div class="container-fluid">
    <div class="row">
@include('sellersidebar')

      <div class="col-md-9">
<div class="row" style="margin-bottom: 20px;">  
    
        <div class="product-details ptb-100 pb-90">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-7 col-12">
                        <div class="product-details-img-content">
                            <div class="product-details-tab mr-70">
                                <div class="product-details-large tab-content">
                                    <div class="tab-pane active show fade" id="pro-details1" role="tabpanel">
                                        <div class="easyzoom easyzoom--overlay">
                                            <a href="{{asset('images')}}/{{ $user->pro_img_path }}">
                                                <img src="{{asset('images')}}/{{ $user->pro_img_path }}" alt="">
                                            </a>
                                        </div>
                                        <div style="margin-top: 20px; margin-left: 30px;">
                                        @foreach ($prodImg as $prodimg)
                                        
                                            <a href="{{asset('images')}}/{{ $prodimg->pro_img_path }}">
                                                <img class="img-thumbnail"src="{{asset('images')}}/{{ $prodimg->pro_img_path }}" alt="" style="object-fit: cover; width: 120px; height: 120px;">
                                            </a>
                                        
                                    @endforeach
                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-5 col-12">
                        <div class="product-details-content">
                            <h3>{{ $user->prod_title }}</h3>
                            <div class="rating-number">
                                <div class="quick-view-rating">
                                    <i class="pe-7s-star red-star"></i>
                                    <i class="pe-7s-star red-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                                <div class="quick-view-number">
                                    <span>2 Ratting (S)</span>
                                </div>
                            </div>
                            <?php $offerpercnt = 100-(($user->prod_price*100)/$user->prod_reg_price); $offer = round($offerpercnt,0) ?>

                           @if($offer >0)
                            <div class="details-price">
                                <span style="text-decoration: line-through;">₱{{$user->prod_reg_price}}</span>&nbsp; <span style="color: green;font-size: 15px;"> ({{$offer}}%off) </span>&nbsp; <span style="color: red;">₱{{ $user->prod_price }}</span>
                            </div>
                            @else
                             <div class="details-price">
                                 <span style="color: red;">₱{{ $user->prod_price }}</span>
                            </div>
                            @endif
                            <p>{{ $user->prod_short_desc }}</p>
                            
                           <!-- 
                            <div class="product-details-cati-tag mt-35">
                                <ul>
                                    <li class="categories-title">Categories :</li>
                                    <li><a href="#">fashion</a></li>
                                    <li><a href="#">electronics</a></li>
                                    <li><a href="#">toys</a></li>
                                    <li><a href="#">food</a></li>
                                    <li><a href="#">jewellery</a></li>
                                </ul>
                            </div>
                            <div class="product-details-cati-tag mtb-10">
                                <ul>
                                    <li class="categories-title">Tags :</li>
                                    <li><a href="#">fashion</a></li>
                                    <li><a href="#">electronics</a></li>
                                    <li><a href="#">toys</a></li>
                                    <li><a href="#">food</a></li>
                                    <li><a href="#">jewellery</a></li>
                                </ul>
                            </div> -->
                            <!-- <div class="product-share">
                                <ul>
                                    <li class="categories-title">Share :</li>
                                    <li>
                                        <a href="#">
                                            <i class="icofont icofont-social-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="icofont icofont-social-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="icofont icofont-social-pinterest"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="icofont icofont-social-flikr"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-description-review-area pb-90">
            <div class="container">
                <div class="product-description-review text-center">
                    <div class="description-review-title nav" role=tablist>
                        <a class="active" href="#pro-dec" data-toggle="tab" role="tab" aria-selected="true">
                            Description
                        </a>
                        <a href="#pro-review" data-toggle="tab" role="tab" aria-selected="false">
                            Reviews (0)
                        </a>
                    </div>
                    <div class="description-review-text tab-content">
                        <div class="tab-pane active show fade" id="pro-dec" role="tabpanel">
                            <p>{{ $user->prod_long_desc }}</p>
                        </div>
                        <div class="tab-pane fade" id="pro-review" role="tabpanel">
                            <a href="#">Be the first to write your review!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@include('footer')

        <!-- product area start -->
        