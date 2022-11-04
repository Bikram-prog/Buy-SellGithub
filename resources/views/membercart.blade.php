@include('member_header')
    <!-- cart page-->

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h4>Cart</h4>

                <table class="table" style="background: #fff; padding: 20px;">
                    <thead>
                        <tr>
                            <th>Remove</th>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($cartCollection as $item)
                        <tr>
                            <td class="product-remove">
                                <a style="padding: 10px;
                                font-size: 20px; color: #000;" href="{{ url('memberremoveproduct/'.$item->id) }}">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                            <td class="product-thumbnail">
                                <a href="/p/{{ $item->id }}"><img class="img-thumbnail"
                                        src="{{ $item->attributes['prodcartimg'] }}"
                                        style="height: 100px; object-fit: cover;" alt=""></a>
                            </td>
                            <td class="product-name"><a style="text-decoration: none; color: #000;" href="/p/{{ $item->id }}">{{ $item->name }} <br /> {{ $item->attributes['variation'] }}</a></td>
                            <td class="product-price-cart"><span class="amount">${{ $item->price }}</span></td>
                            <td>
                            <form action="{{ route('memberupdateproduct') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    <input type="hidden" value="{{ $item->id }}" id="id" name="id">
                                    <input type="number" style="width: 100px;" class="form-control form-control-sm" value="{{ $item->quantity }}"
                                        id="quantity" name="quantity" style="margin-right: 10px;">
                                    <button style="width: 100px;" class="btn btn-primary btn-sm" style="">Update</button>
                                </div>
                            </form>

                            </td>
                            <td class="product-subtotal">${{ \Cart::get($item->id)->getPriceSum() }}<br>
                                {{--                                <b>With Discount: </b>${{ \Cart::get($item->id)->getPriceSumWithConditions() }}--}}<br>
                            </td>
                        </tr>
                        @endforeach 
                    </tbody>

                </table>






            </div>
        </div>
    </div>

    <div class="container" >
        <div class="row">
            <div class="col-4" ></div>
            <div class="col-4" ></div>
            <div class="col-4" >
                <div class="card" style="">
                    <div class="card-header">
                        Cart Total
                    </div>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item" style="font-weight: 500;">Subtotal <span>${{ \Cart::getTotal() }}</span></li>
                      <li class="list-group-item" style="font-weight: 500;">Total <span>${{ \Cart::getTotal() }}</span></li>
                      
                    </ul>
                    <a href="/membercheckout" class="btn btn-primary mt-2" style="border-radius: 5px !important;">Proceed to checkout</a>
                  </div>
            </div>
        </div>
    </div>

@include('member_footer')
    