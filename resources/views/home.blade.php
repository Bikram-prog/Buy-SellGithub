@include('header')


<div class="container-xl mt-4">
        <div class="row">
            <div class="col-12">
                <h2 style="font-weight: bold; font-size: 22px; margin-bottom: 20px;">{{ $catetitle }}</h2>
            </div>
            <div class="col-md-3">
            @if(count($subcategory) > 0)
            <div class="card mb-2" style="padding: 20px;">
            <h4 class="mb-3" style="font-size: 16px; font-weight: bold;">Sub Category</h4>
            <ul class="list-group list-group-flush">
            @foreach($subcategory as $sub)
            <li class="list-group-item"><a href="/subcategory/{{ $sub->sub_cate_id }}/{{ $sub->sub_cate_cate_id }}/{{ $sub->sub_cate_title }}" style="color: #000;">{{ $sub->sub_cate_title }}</a></li>
            @endforeach
            </ul>
            </div>
            @endif

                <div class="card" style="padding: 20px;">
                    <h4 class="mb-3" style="font-size: 16px; font-weight: bold;">Filters</h4>
                    <form action="" method="get">
                    <div class="form-check mb-2">
                        <input class="form-check-input" <?php echo (isset($_GET['condition']) && $_GET['condition'] == 'New' ? 'checked' : ''); ?> name="condition[]" type="checkbox" value="New" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">
                          New
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" <?php echo (isset($_GET['condition']) && $_GET['condition'] == 'Used' ? 'checked' : ''); ?>
                        name="condition[]" type="checkbox" value="Used" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">
                          Used
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" checked class="form-check-input" name="out" value="Out" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">
                          Exclude Out Of Stock
                        </label>
                    </div>

                    <div class="form-price-range-filter mt-2">
                      <label for="amount">Price range:</label>
                      <input type="text" id="amount" name="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                    <div id="slider-range"></div>
                    
                    </div>

                    <button type="submit" class="mt-2 btn btn-dark">Search</button>

                    </form>
                    
                </div>
            </div>
            <div class="col-md-9">

            
                
              <div class="row">
                <?php $j = 0; ?>
                    @foreach ($users as $user)
                    <?php //$offerpercnt = 100-(($user->prod_price*100)/$user->prod_reg_price); $offer = round($offerpercnt,0);
                    $price = number_format($user->prod_price, 2); 
                    $substr = substr($user->prod_title , 0, 20);
                    ?>
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
                      <h5 class="card-subtitle mb-2">{{ $catetitle }}</h5>
                      <h5 class="card-title mb-3">{{ $substr }}</h5>
                      <p class="card-text price mb-2">${{ $price }}</p>
                      <p style="font-weight: 500;" ><span class="badge bg-warning"><?php echo number_format($ratings_cat[$j][0]->AverageRatings, 1); ?> <i class="fas fa-star"></i></span> </p>
                    </div>
                    
                  </div>
              </div>

                  <?php $j++; ?>
                @endforeach

                  

                    

                    

                    

                    
                  
                </div>
            </div>
        </div>
    </div>

    @include('footer')