@include('member_header')

<style>
label {
    font-weight: 700;
}
</style>
    <!-- checkout page-->
    <div class="container mt-6" style="margin-top: 20px;">
        <div class="row text-center">
            
        </div>
        <div class="row">
            <div class="col-md-4 left-sidebar">


                <p><a href="/memberaddbuyeraddress" class="btn btn-primary btn-block"
                        style="border-radius: 5px !important; font-weight: 700;">Add new address</a></p>
                        <form action="/memberdelvryaddress" method="POST">
                            {{ csrf_field() }}
                            @foreach($address as $add)
                            @if( $add->make_primary == "1")
                <div class="card mb-2" style="">
                    <div class="card-body">
                        <input type="hidden" name="delvryadd" value="{{ $add->buyer_del_address  }},{{ $add->buyer_del_city  }},{{ $add->buyer_del_state  }}-{{ $add->buyer_del_postcode  }},{{ $add->buyer_del_country  }},Contact no: {{ $add->buyer_del_phn_no  }}">
                        <p>{{ $add->buyer_del_address  }}, {{ $add->buyer_del_city  }}, {{ $add->buyer_del_state  }}-{{ $add->buyer_del_postcode  }}, {{ $add->buyer_del_country  }}</p>
                        <p style="font-weight: 500;">Contact no: {{ $add->buyer_del_phn_no  }}</p>
                        <p style="font-weight: 500;">E-mail: {{ $add->buyer_del_email  }}</p>
                        <p style="font-weight: bold;" class="text-primary">This is your delivery address.</p>
                    </div>
                </div>
                @elseif( $add->make_primary == "0" )

                <div class="card mb-2" style="">
                    <div class="card-body">
                        <input type="hidden" name="delbuyadd" value="{{ $add->buyer_del_add_buy_id   }}">
                        <input type="hidden" name="deladd" value="{{ $add->buyer_del_id   }}">
                        <input type="hidden" name="delvryadd" value="{{ $add->buyer_del_address  }},{{ $add->buyer_del_city  }},{{ $add->buyer_del_state  }}-{{ $add->buyer_del_postcode  }},{{ $add->buyer_del_country  }},Contact no: {{ $add->buyer_del_phn_no  }}">
                        <p>{{ $add->buyer_del_address  }}, {{ $add->buyer_del_city  }}, {{ $add->buyer_del_state  }}-{{ $add->buyer_del_postcode  }}, {{ $add->buyer_del_country  }}</p>
                        <p style="font-weight: 500;">Contact no: {{ $add->buyer_del_phn_no  }}</p>
                        <p style="font-weight: 500;">E-mail: {{ $add->buyer_del_email  }}</p>

                        <!-- <p><a class="btn btn-outline-info btn-block" href="">Make delivery address</a></p> -->
                        <button class="btn btn-success btn-block">Deliver to this address</button>
                    </div>
                </div>
                @endif
                @endforeach
                </form>
                





            </div>
            <div class="col-md-8">
                <div class="your-order">
                    <h3>Your orders</h3>
                    <div class="your-order-table table-responsive">
                        <table class="table table-striped" style="background: #fff; padding: 20px; border-radius: 5px;">
                            <thead>
                                <tr>
                                    <th class="product-name">Product</th>
                                    <th class="product-total">Total</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartCollection as $item)
                                <tr class="cart_item">
                                    <td class="product-name">
                                        {{ $item->name }} <?php echo ($item->attributes['variation'] != '' ? '<br />' . $item->attributes['variation'] : ''); ?> <strong class="product-quantity"> X {{ $item->quantity }}</strong>
                                    </td>
                                    <td class="product-total">
                                        <span class="amount" style="font-size: 18px;">${{ \Cart::get($item->id)->getPriceSum() }}</span>
                                    </td>
                                    <td>
                                        <a onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" href="{{ url('memberremoveproduct/'.$item->id) }}"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                    
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr class="cart-subtotal">
                                    <th>Cart Subtotal</th>
                                    <td><span class="amount" style="font-size: 18px;">${{ \Cart::getTotal() }}</span></td>
                                </tr>
                                <tr class="order-total">
                                    <th>Order Total</th>
                                    <td><strong><span class="amount" style="font-size: 18px;">${{ \Cart::getTotal() }}</span></strong>
                                    </td>
                                </tr>
                                
                            </tfoot>
                        </table>
                    </div>
                    <div class="payment-method">
                        <div class="payment-accordion">
                            <div class="panel-group" id="faq">





                            </div>

                        </div>
                    </div>
                </div>

                <p>&nbsp;</p>

                <div class="row">
                    
                    <div class="col-md-12 mb-5">
                        <label for="credit">Please Select a Payment Option:</label>&nbsp;&nbsp;
                         <input type="radio" id="html" name="fav_language" value="Stripe" onchange="display(this.value)">
                         <label for="credit">Credit Or Debit Card</label>
                         <input type="radio" id="css" name="fav_language" value="Paypal" onchange="display(this.value)">
                         <label for="Paypal">Paypal</label>
                    </div>
                    
                </div>
                <!-- payment form-->
                <div class="padding" id="stripe" style="display: none;">
                    <div class="row">
                        <form class="col-md-8 require-validation" action="{{ route('memberstripe') }}" method="POST"
                        data-cc-on-file="false"
                       data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                       id="payment-form">
                       @csrf

                         @foreach($data as $add)
                                     @if( $add->make_primary == "1")
                                    <input type="hidden" name="delvryadd" value="{{ $add->buyer_del_address  }},{{ $add->buyer_del_city  }},{{ $add->buyer_del_state  }}-{{ $add->buyer_del_postcode  }},{{ $add->buyer_del_country  }},Contact no: {{ $add->buyer_del_phn_no  }},E-mail: {{ $add->buyer_del_email  }}">
                                    
                                        @endif
                                    @endforeach
                            <div>
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Credit/Debit Card</strong>
                                        
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group mb-2">
                                                    <label for="name">Card Name</label>
                                                    <input class="form-control" id="name" type="text"
                                                        placeholder="Enter card name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group mb-2">
                                                    <label for="ccnumber">Credit Card Number</label>
                                                    <div class="input-group">
                                                        <input class="form-control card-number" type="text" placeholder="Your card number" autocomplete="cc-number">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label for="ccmonth">Month</label>
                                                <select class="form-control card-expiry-month" id="ccmonth">
                                                    <option>01</option>
                                                    <option>02</option>
                                                    <option>03</option>
                                                    <option>04</option>
                                                    <option>05</option>
                                                    <option>06</option>
                                                    <option>07</option>
                                                    <option>08</option>
                                                    <option>09</option>
                                                    <option>10</option>
                                                    <option>11</option>
                                                    <option>12</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label for="ccyear">Year</label>
                                                <select class="form-control card-expiry-year" id="ccyear">
                                                   @php
                                                    for($i=2014; $i <= 2050; $i++) { 
                                                        echo "<option>".$i."</option>";
                                                    }
                                                   @endphp
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="cvv">CVV/CVC</label>
                                                    <input class="form-control card-cvc" id="cvv" type="text" placeholder="123">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        {{-- @foreach($data as $add) --}}
                                        @if(count($data) > 0 )
                                        <div class="d-grid gap-2 col-6 mx-auto">
                                            <button style="" class="text-center btn btn-lg btn-success float-right" type="submit">
                                            <i class="mdi mdi-gamepad-circle"></i> Pay Now</button>
                                        </div>
                                        @else 
                                        <div class="d-grid gap-2 col-6 mx-auto">
                                            <p class="text-danger text-bold text-center" style="font-weight: bold;">Please choose your delivery address first.</p>
                                        </div>
                                        @endif
                                        {{-- @endforeach --}}
                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="padding" id="paypall" style="display: none;">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6 text-center" style="border: 1px solid #444; background: #ccc; padding: 12px;">
                            <h2 class="fw-bold fs-2 mb-4 mt-2">Pay with Paypal</h2>
                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="paypal" id="paypal">

                                @foreach($data as $add)
                                     @if( $add->make_primary == "1")
                                    <input type="hidden" name="delvryadd" value="{{ $add->buyer_del_address  }},{{ $add->buyer_del_city  }},{{ $add->buyer_del_state  }}-{{ $add->buyer_del_postcode  }},{{ $add->buyer_del_country  }},Contact no: {{ $add->buyer_del_phn_no  }},E-mail: {{ $add->buyer_del_email  }}">
                                    
                                        @endif
                                    @endforeach

                                <!-- Prepopulate the PayPal checkout page with customer details, -->
                                <input type="text" name="first_name" class="form-control mb-2" placeholder="<?php echo "Firstname"?>" required>
                                <input type="text" name="last_name" class="form-control mb-2" placeholder="<?php echo "Lastname"?>" required>
                                <input type="text" name="email" class="form-control mb-2" placeholder="<?php echo "Email"?>" required>
                                <input type="text" name="address1" class="form-control mb-2" placeholder="<?php echo "Address"?>" required>
                                <input type="text" name="address2" class="form-control mb-2" placeholder="<?php echo "Address2 (Optional)"?>">
                                <input type="text" name="city" class="form-control mb-2" placeholder="<?php echo "City"?>" required>
                                <input type="text" name="zip" class="form-control mb-2" placeholder="<?php echo "Postcode"?>" required>
                                <input type="hidden" name="day_phone_a" value="">
                                <input type="hidden" name="day_phone_b" value="<?php echo "Mobile"?>">
                            
                                <!-- We don't need to use _ext-enter anymore to prepopulate pages -->
                                <!-- cmd = _xclick will automatically pre populate pages -->
                                <!-- More information: https://www.x.com/docs/DOC-1332 -->
                                <input type="hidden" name="cmd" value="_xclick" />
                                <input type="hidden" name="business" value="marizrbourne@yahoo.com.ph" />
                                <input type="hidden" name="cbt" value="Return to Your Business Name" />
                                <input type="hidden" name="currency_code" value="AUD" />
                                <input type="hidden" name="amount" value="{{ \Cart::getTotal() }}" />
                            
                                <!-- Allow the customer to enter the desired quantity -->
                                {{-- <input type="hidden" name="quantity" value="1" /> --}}
                                <input type="hidden" name="item_name" value="Buy And Sell Purchase" />
                            
                                <!-- Custom value you want to send and process back in the IPN -->
                                
                                <input type="hidden" name="return" value="https://buyandsell.click/paypal/success"/>
                                <input type="hidden" name="cancel_return" value="https://buyandsell.click/membercheckout" />
                            
                                <!-- Where to send the PayPal IPN to. -->
                                {{-- <input type="hidden" name="notify_url" value="/shop/paypal/process" /> --}}
                                
                                @if(count($data) > 0 )
                                <input type="image" name="submit" class="mt-4" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">
                                @else 
                                <div class="d-grid gap-2 col-6 mx-auto mt-4">
                                    <p class="text-danger text-bold text-center" style="font-weight: bold;">Please choose your delivery address first.</p>
                                </div>
                                @endif
                            </form>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </div>



            </div>
        </div>
    </div>

@include('member_footer')

<script>

function display(str){
    if(str == 'Stripe'){
      document.getElementById('stripe').style.display= "block";
    }else{
      document.getElementById('stripe').style.display= "none";
    }
    if(str == 'Paypal'){
      document.getElementById('paypall').style.display= "block";
    }else{
      document.getElementById('paypall').style.display= "none";
    }

  }

</script>
  