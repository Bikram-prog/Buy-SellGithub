@include('member_header')


    
          <div class="container mt-4">
            <div class="row">
              
              <?php $j = 0; ?>
                  @foreach ($newArrivals as $user)
                  <?php 
                  $price = number_format($user->prod_mmbr_price, 2); 
                  $substr = substr($user->prod_title , 0, 40);
                  ?>
                  @php
                  $prodImg = DB::table('pro_images')
                            ->where('prod_img_prod_id', '=', $user->prod_id)
                            ->where('prod_default_status', '=', '1')
                            ->get();
                @endphp
              <div class="col-md-3 mt-2">
                <div class="card box">
                  @if(count($prodImg) > 0)
                            <a href="/m/{{ $user->prod_id }}"><img style="object-fit: contain;" src="{{asset('images')}}/{{ $prodImg[0]->pro_img_path }}" class="card-img-top" alt="name"></a>
                    @else
                            <a href="/m/{{ $user->prod_id }}"><img style="object-fit: contain;" src="{{asset('images')}}/{{ $user->pro_img_path }}" class="card-img-top" alt="name"></a>
                    @endif
                  <div class="card-body">
                    <h5 class="card-title mb-3">{{ $substr }}</h5>
                    @if($user->prod_mmbr_quantity != '')
                    <h5 class="card-title mb-3">Minimum of {{ $user->prod_mmbr_quantity }}</h5>
                    @endif
                    <p class="card-text price mb-2">${{ $price }}</p>
                    <p style="font-weight: 500;" ><span class="badge bg-warning"><?php echo number_format($ratings_new[$j][0]->AverageRatings, 1); ?> <i class="fas fa-star"></i></span> </p>
                  </div>
                  
                </div>
            </div>

                <?php $j++; ?>
              @endforeach

              </div>
              
                
            </div>
        



 @include('member_footer')