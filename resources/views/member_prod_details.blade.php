@include('member_header')

<style>
    .right-review {
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        margin-bottom: 10px;
    }
    
    
    
    /* .zoom {
      padding: 80px;
      transition: transform .2s;
      width: 520px;
      height: 520px;
      margin: 0 auto;
    } */
    
    .zoom:hover {
      -ms-transform: scale(1.5); /* IE 9 */
      -webkit-transform: scale(1.5); /* Safari 3-8 */
      transform: scale(1.5); 
    }
    </style>
    
    <div class="container-xl mt-4 px-4 ">
            <div class="row gx-5">
                        <div class="col-md-5" style="background-color: #fff; padding: 20px; border-radius: 10px;border: 1px solid #eee;  ">
                            <div class="row">
                                <div class="col-md-4">
                                    {{-- <img class="mb-2 img-fluid round" style="width: 100px; object-fit: cover;" src="{{asset('images')}}/{{ $user->pro_img_path }}"> --}}
                                    
                                    @foreach ($prodImg as $prodimg)
                                    <a href="#"><img onclick="zoomImage(this.src);" class="mb-2 img-fluid round" style="width: 100px; object-fit: cover;" src="{{asset('images')}}/{{ $prodimg->pro_img_path }}"></a>
                                    @endforeach
                                </div>
                                @php
                                $prodImg = DB::table('pro_images')
                                        ->where('prod_img_prod_id', '=', $user->prod_id)
                                        ->where('prod_default_status', '=', '1')
                                        ->get();
                                @endphp
                                <div class="col-md-8" style="margin-top: 30px;">
                                @if(count($prodImg) > 0)
                                @if($user->prod_id == '037a1c0d07f099726f9b94914f2e3b7e6f4550e1a0d24dd51af9b4ddb2b6ef02')
                                <video class="img-fluid round" controls>
                                    <source src="https://buyandsell.click/images/label_mini_printer.mp4" type="video/mp4">
                                  Your browser does not support the video tag. Please update your browser or use latest Google Chrome.
                                  </video>
                                  @else
                                <a href="#"><img onclick="zoomImage(this.src)" src="{{asset('images')}}/{{ $prodImg[0]->pro_img_path }}" class="img-fluid round"></a>
                                @endif
                                @else
                                    <a href="#"><img onclick="zoomImage(this.src)" src="{{asset('images')}}/{{ $user->pro_img_path }}" class="img-fluid round"></a>
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-5" style="background-color: #fff; padding: 20px; border-radius: 10px; border: 1px solid #eee; ">
                        @if (isset($_COOKIE['MemberUserIds']) && Crypt::decryptString($_COOKIE['MemberUserCompName']) != '' && $user->prod_seller_id != Crypt::decryptString($_COOKIE['MemberUserIds']) && $prodQuantity > 0 && $prodStatus != "Inactive")
                        <a style="float: right; background: #dcdcdc; font-weight: 600; color: #222;" onclick="return confirm('Are you sure?')" href="/productrelist/{{ $user->prod_id }}" class="btn btn-light btn-sm mb-2"><i class="far fa-copy"></i> Relist</a>
                        @endif
                            @foreach ($category as $cat)
                            <h5 style="font-size: 14px; color:rgb(168, 168, 168)"><a style="font-size: 14px; color:rgb(168, 168, 168); text-decoration: none;" href="/category/{{ $cat->cate_id }}/{{ $cat->cate_title }}">{{ $cat->cate_title }}</a></h5>
                            @endforeach
                            <h4>{{ $user->prod_title }}</h4>
                            @foreach ($seller as $sel)
                            <p style="color: #00BADB; font-weight: 600; font-size: 14px;">by Buy & Sell</p>
                            @endforeach
    
                            <div class="rating-number mb-3" style="margin-top: -10px;">
                                <div class="quick-view-rating">
                                    @foreach($ratings as $rat)
                                    <?php $stars = $rat->AverageRatings; ?>
                                     @foreach(range(1,5) as $i)
                            <span class="fa-stack" style="width:1em">
                                <i class="far fa-star fa-stack-1x" style="color:#f1c40f"></i>
                                @if($stars > 0)
                                @if($stars > 0.5)
                                    <i class="fas fa-star fa-stack-1x" style="color:#f1c40f"></i>
                                @else
                                    <i class="fas fa-star-half fa-stack-1x" style="color:#f1c40f"></i>
                                @endif
                                @endif
                                @php $stars--; @endphp
    
                            </span>
                            @endforeach
                            @endforeach
                                    <a href="#review_l"><span style="font-weight: 500;">{{ $review->count() }} Ratings &amp; Reviews</span></a>
                                    
                                </div>
                            </div>
    
                            <?php 
                    //$offerpercnt = 100-(($user->prod_price*100)/$user->prod_reg_price); 
                               //$offer = round($offerpercnt,0); 
                               //$saveprice= number_format($user->prod_reg_price-$user->prod_price);
                               //$pricereg = number_format($user->prod_reg_price, 2);
                               $price = number_format($user->prod_mmbr_price, 2);
                               ?>
    
                            <!-- <p class="badge bg-danger">Save $200</p> -->
                            <p>Condition <span class="badge <?php echo ($user->prod_cndtn == 'New' ? 'bg-success' : 'bg-info'); ?> ">{{ $user->prod_cndtn }}</span></p>
    
                            
                            <?php 
                            $variation= DB::Select("Select * FROM variations WHERE var_prod_id='".$user->prod_id."'");
    
                            if(count($variation) > 0) {
                            
                            $numbers = array_column($variation, 'var_price');
                            $min = min($numbers);
                            $max = max($numbers);
                            ?>
    
                            
    
                            
                            
                            <p class="price_main">${{ $min }} - ${{ $max }}</p>
    
                            <?php } else { ?>
                            <p class="price_main">${{ $price }}</p>
                            <?php } ?>
    
    
                            @if($prodStatus  == "Inactive")
                            <p style="font-weight: 700;">CURRENTLY UNAVAILABLE</p>
                            @elseif($prodQuantity > 10)
                            <p style="font-weight: 700;">IN STOCK</p>
                            @elseif($prodQuantity == 0)
                            <p style="font-weight: 700;">OUT OF STOCK</p>
                            @elseif($prodQuantity <= 10)
                            <p style="font-weight: 700;">HURRY,ONLY {{ $prodQuantity }} PRODUCTS LEFT</p>
                            @endif
    
                            <p style="font-weight: 700;">Quantity Left: {{ $prodQuantity }} Pcs.</p>
    
                            @if($user->prod_sub_cate_id == '10')
                            
                            
                            
                                <p class="zoom"><img style="width: 520px;
                                    height: 520px;object-fit: cover;" src="{{asset('images')}}/womandressmeasurement.jpeg" class="img-fluid"></p>
                            
                            
    
                            <p style="font-weight: 700;">Measurement:</p>
    
                            <p style="font-weight: 700; color: #888;">Bust: {{ $user->prod_wmn_bust }}; Waist: {{ $user->prod_wmn_waist }}; Bottom: {{ $user->prod_wmn_bottom }}; Armpit: {{ $user->prod_wmn_armpit }}; Shoulder: {{ $user->prod_wmn_shoulder }}</p>
    
                            @endif
    
                            
                            <form action="{{ route('membercart') }}" method="GET">
                                {{ csrf_field() }}
                                @if(count($prodImg) > 0)
                                <input type="hidden" value="{{asset('images')}}/{{ $prodImg[0]->pro_img_path }}" name="prod_img">
                                @else
                                <input type="hidden" value="{{asset('images')}}/{{ $user->pro_img_path }}" name="prod_img">
                                @endif
                                
                                <input type="hidden" value="{{ $user->prod_id }}" id="prod_id" name="prod_id">
                                <input type="hidden" value="{{ $user->prod_title }}" id="name" name="name">
                                <input type="hidden" value="{{ $user->prod_mmbr_price }}" id="price" name="price">
                                <input type="hidden" value="{{ $user->prod_seller_id }}" id="sellerid" name="sellerid">
    
                                @if($user->prod_delivery_days != '')
                                <input type="hidden" value="{{ $user->prod_delivery_days }}" id="dlvrydays" name="dlvrydays">
                                @else
                                <input type="hidden" value="10" id="dlvrydays" name="dlvrydays">
                                @endif
    
                                @php
                                $variation= DB::Select("Select * FROM variations WHERE var_prod_id='".$user->prod_id."'");
                            @endphp
                            @if(count($variation) > 0)
                            <select onchange="getVariationPrice(this.value)" name="var" class="form-control mb-2" required>
                                <option value="">Select Variation</option>
                            @foreach($variation as $var)
                                <option value="{{ $var->var_value }}">{{ $var->var_value }}</option>
                            @endforeach
                            </select>
                            @endif
    
                                <p style="font-weight: 700;">Choose Quantity: <input type="number" min="1" max="5" value="01" name="quantity" class="form-control" style="width: 100%;" required></p>
    
    @if (isset($_COOKIE['MemberUserIds']) && $user->prod_seller_id != Crypt::decryptString($_COOKIE['MemberUserIds']) &&$prodQuantity > 0 && $prodStatus != "Inactive" && count($watch) > 0 )
                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <div class="d-grid gap-2">
                                        
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg">Add to cart <i class="fas fa-shopping-cart"></i></button>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="d-grid gap-2">
                                    
                                </div>
                            </div>
                        </div>
                            @elseif (isset($_COOKIE['MemberUserIds']) && $user->prod_seller_id != Crypt::decryptString($_COOKIE['MemberUserIds']) &&$prodQuantity > 0 && $prodStatus != "Inactive" && count($watch) == 0)
    
                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <div class="d-grid gap-2">
                                        
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg">Add to cart <i class="fas fa-shopping-cart"></i></button>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="d-grid gap-2">
                                    
                                </div>
                            </div>
                        </div>
    
                            @elseif(!isset($_COOKIE['MemberUserIds']) && count($watch) == 0)
    
                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <div class="d-grid gap-2">
                                        
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg">Add to cart <i class="fas fa-shopping-cart"></i></button>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="d-grid gap-2">
                                    
                                </div>
                            </div>
                        </div>
    
                            @elseif(!isset($_COOKIE['MemberUserIds']) && count($watch) > 0)
    
                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <div class="d-grid gap-2">
                                        
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg">Add to cart <i class="fas fa-shopping-cart"></i></button>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="d-grid gap-2">
                                    
                                </div>
                            </div>
                        </div>
    
                            @endif
    
                            @if($user->prod_delivery_days != '')
                            <p class="text-center mt-2" style="font-size: 12px; color: #1F2C69; font-weight: 600;">Usually takes {{ $user->prod_delivery_days }} days to deliver</p>
                            @else
                            <p class="text-center mt-2" style="font-size: 12px; color: #1F2C69; font-weight: 600;">Usually takes 7-10 days to deliver</p>
                            @endif
    
                            <p class="text-center mt-2" style="font-size: 12px; color: #1F2C69; font-weight: 600;">Free Shipping</p>
    
                            <p class="text-center mt-2" style="font-size: 12px; color: #1F2C69; font-weight: 600;">Seller not paid by Buy & Sell until item(s) is delivered</p>
    
                            <p class="text-center mt-2" style="font-size: 12px; color: #1F2C69; font-weight: 600;">Pay with multiple payment method</p>
    
                            <p style="font-size: 35px;" class="text-center">
                                <i style="color: #0ACBCB;" class="fab fa-cc-stripe"></i> <i style="color: #1A1F71;" class="fab fa-cc-visa"></i> <i style="color: #F79E1B;" class="fab fa-cc-mastercard"></i> <i style="color: #006FCF;" class="fab fa-cc-amex"></i>
                            </p>
    
                        </form>
    
                            
    
                        </div>
                    
                
            </div>
          </div>
    
    
          
    
          <div class="container-xl mt-4">
              @if($user->prod_id == "e148c52e23250bb9768a715882ae7de6eba61fa9ddd22c77ec4e156a8d92546d")
              <div class="row">
                  <div class="col-3"></div>
                  <div class="col-6">
                    <div class="ratio ratio-4x3" style="border-radius: 10px;">
                        <video style="border-radius: 10px;" autoplay controls controlsList="nodownload" poster="/placeholder.jpeg">
                            <source src="/golf-scooter1.mp4" type="video/mp4">
                            <source src="/golf-scooter1.mp4" type="video/ogg">
                          Your browser does not support the video tag.
                          </video>
                      </div>
                  </div>
                  <div class="col-3"></div>
              </div>
              @endif
            <div class="row">
                <div class="col-md-12" style="background-color: #fff; padding: 20px; border-radius: 10px;border: 1px solid #eee;  ">
                    <h4>Description</h4>
    
                    <p>
                        {!! $user->prod_long_desc !!}
                    </p>
    
    
    
                </div>
            </div>
        </div>
    
    
        
    
        <!-- rating and reviews-->
    
        <div class="container mt-4" id="review_l">
            <div class="row">
                {{-- <div class="col-12">
                    <h4 class="text-center" style="margin-bottom: 20px;">Ratings & Reviews</h4>
                </div> --}}
                <div class="col-md-4 left-review text-center">
                    <h4>Customer reviews</h4>
                    <div class="rating-number">
                        <div class="quick-view-rating">
                            @foreach($ratings as $rat)
                            <?php $stars = $rat->AverageRatings; ?>
                             @foreach(range(1,5) as $i)
                                  <span class="fa-stack" style="width:1em">
                                      <i class="far fa-star fa-stack-1x" style="color:#f1c40f"></i>
                                        @if($stars > 0)
                                          @if($stars > 0.5)
                                              <i class="fas fa-star fa-stack-1x" style="color:#f1c40f"></i>
                                          @else
                                              <i class="fas fa-star-half fa-stack-1x" style="color:#f1c40f"></i>
                                          @endif
                                          @endif
                                       
                                      @php $stars--; @endphp
                                  </span>
    
                            @endforeach
    
                            @endforeach
    
                        @foreach($ratings as $rat)
                        <?php 
                        $stars = $rat->AverageRatings; 
                        $stars1 = round($stars,1); 
                        ?>
                        <span style="font-weight: 700;">{{ $stars1 }} out of 5</span>
                        @endforeach
                        </div>
                    </div>
                    <hr />
                    <div class="text-center">
                        <p style="font-weight: 600;">Have you used this product?</p>
                        <p>Rate it on scale of 5</p>
                        <a style="font-weight: 600;" class="btn btn-primary" href="{{ url('buyerreview/'.$user->prod_id )}}">Write a product review</a>
                    </div>
                   
                </div>
    
                
    
                <div class="col-md-8">
                    @if(count($review) == 0)
                    <p style="margin-left: 35px;">No Reviews.</p>
                    @else
                    @foreach($review as $rev)
                    <?php $stars = $rev->review_ratings; ?>
                    <div class="right-review">
                    @if($rev->seller_prfl_pic != '')
                    <p style="font-weight: 500;"><span class="badge badge-info" style="color:#f1c40f">{{ $stars }} <i class="fas fa-star"></i></span></p>
                    @else
                    <p style="font-weight: 500;"><span class="badge badge-info" style="color:#f1c40f">{{ $stars }} <i class="fas fa-star"></i></span> </p>
                    @endif
                        <p></p>
                        <p>
                            {{ $rev->review_comments }}
                        </p>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>

@include('member_footer')

<script>
    function getVariationPrice(str) {
       var prod_id = document.getElementById("prod_id").value;
       
       var csrf = $('meta[name="_token"]').attr('content');
       $.ajax({
          type:'POST',
          url:'/variationprice',
          data: {
   "_token": "{{ csrf_token() }}",
   "str": str,
   "prod_id": prod_id,
   },
          success:function(data) {

           
             $(".price_main").html(data.msg[0].var_price);
             $("#price").val(data.msg[0].var_price);
          }
       });
    }
 </script>

 <!-- zoom image Modal -->
<div class="modal fade" id="zoom_image" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
        <div class="modal-body">
          <img src="" id="zoom_img" style="" class="img-fluid">
        </div>
      </div>
    </div>
  </div>

  <script>
      function zoomImage(str) {
          $("#zoom_image").modal("show")
          document.getElementById("zoom_img").src = str;
      }
      </script>