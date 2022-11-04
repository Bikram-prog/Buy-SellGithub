@include('header')

<div class="container-xl mt-4">
    <div class="row">
        <div class="col-12">
            <h2 style="font-weight: bold; font-size: 22px; margin-bottom: 20px;">Search Result For: {{ $search }}</h2>
          <div class="row">
              <?php $j = 0; ?>
          @foreach ($users as $user)
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
            <div class="col-md-3 mt-2">
              <div class="card box">
              @if(count($prodImg) > 0)
                            <a href="/p/{{ $user->prod_id }}"><img style="object-fit: contain;" src="{{asset('images')}}/{{ $prodImg[0]->pro_img_path }}" class="card-img-top" alt="name"></a>
                    @else
                            <a href="/p/{{ $user->prod_id }}"><img style="object-fit: contain;" src="{{asset('images')}}/{{ $user->pro_img_path }}" class="card-img-top" alt="name"></a>
                    @endif
                <div class="card-body">
                  <!-- <h5 class="card-subtitle mb-2">Electronics</h5> -->
                  <a target="_blank" href="/p/{{ $user->prod_id }}" style="text-decoration: none;"><h5 class="card-title mb-3">{{ $substr }}</h5></a>
                  <p style="font-weight: 500;"><span class="badge bg-warning"><?php echo number_format($ratings_cat[$j][0]->AverageRatings, 1); ?> <i class="fas fa-star"></i></span> <small></small></p>
                  <p class="card-text price mb-2">${{ $price }}</p>
                  
                  <!-- <p style="color: #3E7903; font-weight: 700; font-size: 15px;">In Stock </p> -->
                </div>
                
              </div>
          </div>
              <?php $j++; ?>
              @endforeach
          </div>
        </div>
    </div>
</div>

@if(is_object($users) && $users->count())

<div class="container-xl mt-4">
    <div class="row">
        <div class="col-12">
            <h2 style="font-weight: bold; font-size: 22px; margin-bottom: 20px;">Search Result For: {{ $search }}</h2>
          <div class="card-group">
              <?php $j = 0; ?>
          @foreach ($users as $user)
          <?php //$offerpercnt = 100-(($user->prod_price*100)/$user->prod_reg_price); 
                  //$offer = round($offerpercnt,0);
                  $price = number_format($user->prod_price, 2);
                  $substr = substr($user->prod_title , 0, 20); ?>

              <div class="card">
                    @if(count($prodImg) > 0)
                            <a href="/p/{{ $user->prod_id }}"><img style="object-fit: contain;" src="{{asset('images')}}/{{ $prodImg[0]->pro_img_path }}" class="card-img-top" alt="name"></a>
                    @else
                            <a href="/p/{{ $user->prod_id }}"><img style="object-fit: contain;" src="{{asset('images')}}/{{ $user->pro_img_path }}" class="card-img-top" alt="name"></a>
                    @endif
                <div class="card-body">
                  <!-- <h5 class="card-subtitle mb-2">Electronics</h5> -->
                  <a href="/p/{{ $user->prod_id }}" style="text-decoration: none;"><h5 class="card-title mb-3">{{ $substr }}</h5></a>
                  <p class="card-text price mb-2">${{ $price }}</p>
                  <p style="font-weight: 500;"><span class="badge bg-warning"><?php echo number_format($ratings_cat[$j][0]->AverageRatings, 1); ?> <i class="fas fa-star"></i></span> <small></small></p>
                  <!-- <p style="color: #3E7903; font-weight: 700; font-size: 15px;">In Stock </p> -->
                </div>
                <div class="card-footer">
                  <div class="d-grid gap-2">
                      <a class="btn btn-danger btn-lg" href="/p/{{ $user->prod_id }}">Add to cart <i class="fas fa-shopping-cart"></i></a>
                  </div>
                  
                </div>
              </div>
              <?php $j++; ?>
              @endforeach
          </div>
        </div>
    </div>
</div>

@else
     
@endif
                                    

@include('footer')