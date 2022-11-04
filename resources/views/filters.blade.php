@include('header')

<style>
.next {
    background: #171717;
    border-radius: 25px;
    margin-top: 10px;
    color: #fff;
    font-weight: bold;
    letter-spacing: 2.2px;
}

.next:hover {
    background: #171717;
    border-radius: 25px;
    margin-top: 10px;
    color: #fff;
    font-weight: bold;
    letter-spacing: 2.2px;
}

.prev {
    background: #171717;
    border-radius: 25px;
    margin-top: 10px;
    color: #fff;
    font-weight: bold;
    letter-spacing: 2.2px;
}

.prev:hover {
    background: #171717;
    border-radius: 25px;
    margin-top: 10px;
    color: #fff;
    font-weight: bold;
    letter-spacing: 2.2px;
}
</style>


<div class="container-xl mt-4">
        <div class="row">
            


            <div class="col-md-12">
                <h3 class="mb-3" style="font-size: 20px; font-weight: bold;">Filters &nbsp;>>&nbsp; {{ $text }}</h3>
              <div class="row">
                <?php $j = 0; ?>
                    @foreach ($newArrivals as $user)
                    <?php 
                    $price = number_format($user->prod_price, 2); 
                    $substr = substr($user->prod_title , 0, 20);
                    ?>
                <div class="col-md-3 mt-2">
                  <div class="card box">
                    <a style="color: #000;" href="/p/{{ $user->prod_id }}">
                    <img style="height: 300px; object-fit: cover; " src="{{asset('images')}}/{{ $user->pro_img_path }}" class="card-img-top" alt="name">
                  </a>
                    <div class="card-body">
                      <h5 class="card-title mb-3">{{ $substr }}</h5>
                      <p class="card-text price mb-2">${{ $price }}</p>
                      <p style="font-weight: 500;" ><span class="badge bg-warning"><?php echo number_format($ratings_new[$j][0]->AverageRatings, 1); ?> <i class="fas fa-star"></i></span> </p>
                    </div>
                    
                  </div>
              </div>

                  <?php $j++; ?>
                @endforeach

                </div>
                <div class="row">
                    <div class="col-6" style="text-align: left;">
                        @if($prev > -1)
                        <a class="btn prev" href="/new-arrivals?q={{ $prev }}"><i class="fas fa-arrow-left"></i> Prev</a>
                        @endif
                    </div>
                    
                    <div class="col-6" style="text-align: right;">
                        @if(!empty($newArrivals))
                        <a class="btn next" href="/new-arrivals?q={{ $next }}">Next <i class="fas fa-arrow-right"></i></a>
                        @endif
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>

    @include('footer')