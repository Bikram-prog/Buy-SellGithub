@include('header')


<div class="container-fluid">
    <div class="row">
        @include('sellersidebar')

 <div class="col-md-9">
<div class="row" style="margin-bottom: 20px;">


   <div class="cart-main-area pt-95 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h1 class="cart-heading">Cart</h1>
                        <form action="#">
                            <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Images</th>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Ratings</th>
                                            <th>Reviews</th>
                                            <th></th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <tr>
                                            <td class="product-remove"><a href="#"><i class="pe-7s-close"></i></a></td>
                                            <td class="product-thumbnail">
                                                <a href="#"><img src="assets/img/cart/1.jpg" alt=""></a>
                                            </td>
                                            <td class="product-name"><a href="#">Wooden Furniture </a></td>
                                            <td class="product-price-cart"><span class="amount">$165.00</span></td>
                                           <td class="product-name"><a href="#">Wooden Furniture </a></td>
                                           <td></td>
                                            
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                   <!--  <div class="coupon-all">
                                        <div class="coupon">
                                            <input id="coupon_code" class="input-text" name="coupon_code" value="" placeholder="Coupon code" type="text">
<input class="button" name="apply_coupon" value="Apply coupon" type="submit">
                                        </div>
                                        <div class="coupon2">
                                            <input class="button" name="update_cart" value="Update cart" type="submit">
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
</div>
 </div>
</div>
</div>
@include('footer')



