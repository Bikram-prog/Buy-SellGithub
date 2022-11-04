<?php

namespace App\Http\Middleware\CorsApi;
use App\Http\Middleware\CorsApi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BotmanController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('comingsoon::comingsoon');
// });

Route::get('/test', function () {
	$category = DB::table('category')->get();
    return view('test')->with(['category'=>$category]);
});

Route::post('/test-payment', function () {
    return '1';
});



Route::get('/','homeAllProdController@viewHome');

Route::get('/buyersignup','BuyerLoginController@viewSignup');
Route::post('/buyersignupaction','BuyerLoginController@buyerSignup');
Route::get('/buyerlogin','BuyerLoginController@viewLogin');
Route::post('/buyerloginaction','BuyerLoginController@buyerLogin');
Route::get('/logout','BuyerLoginController@logoutUser');

Route::get('/verifyaccount/{id}','BuyerLoginController@viewVerifyAccount');
Route::get('/mail','BuyerLoginController@sendMail');

Route::get('/terms','BuyerLoginController@viewTerms');
Route::get('/privacy','BuyerLoginController@viewPrivacy');
Route::get('/cookies','BuyerLoginController@viewCookies');
Route::get('/shipping&delivery','BuyerLoginController@viewShippingDelivery');
Route::get('/return','BuyerLoginController@viewReturn');
Route::get('/contact-us','BuyerLoginController@viewContactUs');

Route::POST('/suggestionupdatepost','BuyerLoginController@suggestionUpdatePost');
Route::POST('/testimonialupdatepost','BuyerLoginController@testimonialUpdatePost');





Route::get('/addbuyeraddress','BuyerLoginController@viewAddressForm');
Route::post('/edituserloginaction','BuyerLoginController@addAddress');
Route::get('/buyeraccount/{id}','BuyerLoginController@viewBuyerAccount');
Route::get('/editprofile/{id}','BuyerLoginController@viewProfile');
Route::post('/editproffileaction','BuyerLoginController@editProfile');

Route::get('/changepassword','BuyerLoginController@changePassword');
Route::post('/changepasswordaction','BuyerLoginController@editPassword');
Route::get('/manageaddress','BuyerLoginController@viewAddress');
Route::get('/buyerorders','BuyerLoginController@viewOrders');
Route::get('/orderdetails/{id}','BuyerLoginController@viewOrdersDetails');

Route::get('/buyersettings','BuyerLoginController@changeProfilePic');
Route::post('/buyerprofilepic','BuyerLoginController@profilePicUpdate');

Route::get('/buyerreview/{id}','BuyerLoginController@viewReviewForm');
Route::post('/buyerreviewaction','BuyerLoginController@addReviews');

Route::get('/website-review','BuyerLoginController@viewWebReviewForm');
Route::post('/webreviewaction','BuyerLoginController@addWebReviews');

Route::post('/delvryaddress','BuyerLoginController@delAddress');

Route::get('/buyereditaddress/{id}', 'BuyerLoginController@editAddressForm');
Route::post('/buyerprimaryadd', 'BuyerLoginController@makePrimaryAddress');

Route::post('/editaddressaction', 'BuyerLoginController@editAddress');
Route::get('/deladdress/{id}', 'BuyerLoginController@deleteAddress');



Route::get('/home','homeAllProdController@viewHome');
Route::post('/variationprice','homeAllProdController@variationPrice');

Route::get('/index','homeAllProdController@index');
Route::get('/currency/{id}','homeAllProdController@currency');

Route::get('/searchproduct','homeAllProdController@viewSearch');
Route::get('/searchaction','homeAllProdController@search');

Route::get('/category/{id}/{title}','homeAllProdController@category');
Route::get('/subcategory/{id}/{Cat_id}/{title}','homeAllProdController@subcategory');

Route::get('/sellerproduct/{id}/{title}','homeAllProdController@sellerProduct');

Route::get('/p/{id}','homeAllProdController@productDetails');


Route::get('/cart', 'homeAllProdController@cart')->name('cart');
// Route::post('/add', 'homeAllProdController@add')->name('cart.store');
Route::post('/update', 'homeAllProdController@update')->name('update');
Route::get('/remove/{id}', 'homeAllProdController@remove')->name('remove');
// Route::post('/clear', 'homeAllProdController@clear')->name('cart.clear');


Route::get('/w/{p_id}', 'homeAllProdController@watchlist');
Route::get('/rw/{p_id}', 'homeAllProdController@removeWatchlist');

Route::get('/checkout', 'homeAllProdController@checkout');
Route::get('/track/{id}/{title}', 'homeAllProdController@trackParcel');
Route::post('buyerstripe', 'homeAllProdController@stripePost')->name('buyerstripe');
Route::get('/filter', 'homeAllProdController@filter');
Route::get('/watchlist', 'homeAllProdController@viewWatchlist');



//Seller-Part/////

Route::get('/seller','SellerLoginController@sellerHome');
Route::get('/prodattributes/{id}/{title}','SellerLoginController@sellerProductVariation');
Route::get('/sellerdashboard','SellerLoginController@sellerAccount');

Route::get('/sellersettings','SellerLoginController@changeCoverPic');
Route::post('/sellercoverpic','SellerLoginController@coverPicUpdate');

Route::get('/apply-seller','SellerLoginController@viewSellerInfo');
Route::post('/sellerinfopost','SellerLoginController@sellerInfoPost');

Route::get('/editprodattributes/{id}','SellerDashboardController@editProductVariation');
Route::get('/editvariation/{id}','SellerDashboardController@sellerEditVariation');
Route::get('/delattributes/{id}/{prod_id}', 'SellerDashboardController@delAttributes');
Route::post('/editprodattributesadd','SellerDashboardController@sellerEditProductVariationAddt');
Route::get('/delvariation/{id}/{prod_id}', 'SellerDashboardController@delVariation');
Route::post('/editvariationpost','SellerDashboardController@editVariationPost');

Route::get('/pendingdelivery','SellerDashboardController@sellerPendingDelivery');
Route::get('/sellercomission','SellerDashboardController@sellerProductComission');
Route::get('/sellerwithdraw','SellerDashboardController@sellerWithdraw');
Route::post('/selleraccntpost','SellerDashboardController@sellerAccntPost');
Route::post('/sellerwithdrwalpost','SellerDashboardController@sellerWithdrawlAmount');
Route::get('/selleraddbankdtls','SellerDashboardController@sellerBankDetails');


Route::get('/searchorderhistry','SellerDashboardController@sellersellerSearchOrder');
Route::get('/searchorder','SellerDashboardController@sellerSearchProductOrder');
Route::get('/pndingsearchorderhistry','SellerDashboardController@pndingsellersellerSearchOrder');
Route::get('/pndingsearchorder','SellerDashboardController@pndingsellerSearchProductOrder');
Route::get('/cmssnsearchorderhistry','SellerDashboardController@cmssnsellersellerSearchOrder');
Route::get('/cmssnsearchorder','SellerDashboardController@cmssnsellerSearchProductOrder');

Route::get('/subcateajax/{id}','SellerDashboardController@subCateAjax');






Route::post('/prodvariationattribute','SellerLoginController@sellerProductVariationAddt');

 Route::get('/variation/{id}','SellerLoginController@sellerVariation');
Route::post('/variationpost','SellerLoginController@variationPost');

// Route::get('/variation/{id}/{catid}','SellerDashboardController@sellerVariation');
Route::post('/addvariationpost','SellerDashboardController@addVariationPost');
Route::get('/delprodvariation/{id}','SellerDashboardController@delProdVariation');

Route::get('/editvariation/{id}/{catid}','SellerDashboardController@editSellerVariation');
Route::post('/addeditvariationpost','SellerDashboardController@addEditVariationPost');

Route::get('/productrelist/{id}','SellerDashboardController@productRelist');



Route::get('/sellersignup', 'SellerLoginController@viewSignup');
Route::post('/sellersignupaction', 'SellerLoginController@sellerSignup');

Route::get('/sellerlogin', 'SellerLoginController@viewLogin');
Route::get('/sellerlogout', 'SellerLoginController@logoutSeller');
Route::post('/sellerloginaction', 'SellerLoginController@sellerLogin');
//Route::get('/sellerdashboard', 'SellerDashboardController@viewDash');
Route::get('/sellerviewproddtls/{id}','SellerDashboardController@sellerproductDetails');
Route::get('/addproduct', 'SellerDashboardController@addProductForm');
Route::post('/selleraddprodloginaction', 'SellerDashboardController@addProduct');

Route::get('/addmoreproduct/{id}', 'SellerDashboardController@addMoreProductForm');

Route::get('/sellerprofile', 'SellerDashboardController@sellerProfile');

Route::get('/sellereditproduct/{id}', 'SellerDashboardController@editProductForm');
Route::post('/editproductaction', 'SellerDashboardController@editProduct');
Route::get('/editimage/{id}', 'SellerDashboardController@editImageForm');
Route::get('/delimage/{id}/{pro_id}/{imgpath}', 'SellerDashboardController@delImage');
Route::get('/delprodimage/{id}/{pro_id}/{imgpath}', 'SellerDashboardController@delProductImage');
Route::get('/defaultimage/{id}/{pro_id}', 'SellerDashboardController@defaultImage');


Route::get('/productpayment/{id}', 'SellerDashboardController@productPayment');
Route::post('stripeproduct', 'SellerDashboardController@stripePost')->name('stripeproduct.post');
Route::post('stripepending', 'SellerDashboardController@stripePendingPost')->name('stripepending.post');
Route::post('/pendingpayment', 'SellerDashboardController@stripePendingPayment');

Route::get('/pendingpaymentproduct', 'SellerDashboardController@stripePendingPaymentProduct');





Route::get('/delproduct/{id}', 'SellerDashboardController@delProduct');
Route::get('/activeproduct/{id}', 'SellerDashboardController@activeProduct');


Route::get('/orderhistory', 'SellerDashboardController@orderHistory');
Route::post('/trackpost','SellerDashboardController@trackingNumberPost');

Route::get('/sellerimgupld/{id}', 'SellerDashboardController@imgUpload');
Route::post('/post','SellerDashboardController@fileStore');
Route::post('/editpost','SellerDashboardController@editfileStore');

Route::get('/sellerdraftprod/{id}', 'SellerDashboardController@sellerDraftProduct');
Route::get('/liveproduct/{id}', 'SellerDashboardController@liveProduct');

Route::post('delete','SellerDashboardController@fileDestroy');

Route::get('/selleraddmore/{id}/{prodtitle}', 'SellerDashboardController@addMore');
Route::post('/selleraddmoreaction','SellerDashboardController@addMoreAction');

Route::get('/payment/{id}/{prodtitle}', 'SellerDashboardController@payment');
Route::post('stripe', 'SellerDashboardController@stripePost')->name('stripe.post');


Route::get('/sellerimgupld11', 'SellerDashboardController@imgUpload1');

Route::get('/sellerpaymenthistory', 'SellerDashboardController@paymentHistory');
Route::get('/sellerorderstatuschange/{id}/{val}', 'SellerDashboardController@sellerOrderStatusChange');

Route::get('/selleractiveproduct', 'SellerDashboardController@sellerActiveProduct');
Route::get('/sellerinactiveproduct', 'SellerDashboardController@sellerInactiveProduct');
Route::get('/selleralldraftproduct', 'SellerDashboardController@sellerAllDraftProduct');
Route::get('/sellersoldproduct', 'SellerDashboardController@sellerSoldProduct');

Route::get('/myaccount', 'SellerDashboardController@myAccount');

Route::get('/prodimage/{id}', 'SellerDashboardController@ProdImage');

Route::get('/editprodimage/{id}', 'SellerDashboardController@editProdImage');



// Route::get('/sellerimgupld', 'SellerLoginController@imgUpload');
// Route::post('/post', 'SellerLoginController@fileStore');

////////Api Part////////////////////

Route::get('/api/buyandsell/category', 'apiController@viewCategrory');
Route::get('/api/buyandsell/catproducts/{id}', 'apiController@viewCatProducts');
Route::get('/api/buyandsell/catproductssorting/{id}/{title}', 'apiController@viewCatProductsSorting');
Route::get('/api/buyandsell/productdetails/{id}', 'apiController@viewProductDetails');
Route::get('/api/buyandsell/productreview/{id}', 'apiController@viewProductReviews');
Route::get('/api/buyandsell/productsellerid/{id}', 'apiController@viewProductSellerId');
Route::get('/api/buyandsell/productratings/{id}', 'apiController@viewProductRatings');
Route::get('/api/buyandsell/relatedproducts/{id}', 'apiController@viewRelatedProducts');
Route::get('/api/buyandsell/productimages/{id}', 'apiController@viewProductImages');
Route::get('/api/buyandsell/buyerorders/{id}', 'apiController@viewBuyerOrders');
Route::get('/api/buyandsell/searchproduct/{keyword}', 'apiController@searchProduct');
Route::post('/api/buyandsell/mobstripepay', 'apiController@stripePostMobPayment');
Route::get('/api/buyandsell/buyeraddressess/{id}', 'apiController@buyersAddress');

Route::post('/api/buyerloginaction','apiController@buyerLogin');
Route::post('/api/buyersignupaction','apiController@buyerSignup');
Route::get('/api/myaccount/{id}', 'apiController@myAccount');
Route::post('/api/addaddress','apiController@addAddress');
Route::post('/api/changepasswordaction','apiController@editPassword');
Route::get('/api/newarrivals','apiController@viewHome');
Route::get('/api/recommendation','apiController@viewRecommendation');



// Route::get('example', array('middleware' => 'cors', 'uses' => 'ExampleController@dummy'));

/*
* Botman Routes 
*/

Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);


Route::post('/cs_chatinsert', 'MessagesController@cs_chatinsert');

Route::get('/u/messages', 'MessagesController@viewMessages');
Route::POST('/chatdisplay', 'MessagesController@loadMsgs');
Route::POST('/chatdisplayadmin', 'MessagesController@admin_loadMsgs');
Route::POST('/chatinsert', 'MessagesController@chatinsert');
Route::POST('/chatinsertadmin', 'MessagesController@admin_chatinsert');
Route::POST('/onlineupdate', 'MessagesController@online');
Route::POST('/offlineupdate', 'MessagesController@offline');
Route::POST('/offlinemessage', 'MessagesController@offlinemessage');

Route::get('/addnewmessage/{id}', 'MessagesController@viewAddNewMessage');
Route::POST('/addnewmessageaction', 'MessagesController@addNewMessageAction');

Route::get('/messanger/{id}', 'MessagesController@messangerr');

Route::get('/messageuserlist', 'MessagesController@viewLeftMenuMessages');

Route::POST('/sendfile', 'MessagesController@sendFile');

Route::get('messages/inbox', 'MessagesController@inbox');
Route::get('messages/sent', 'MessagesController@sent');



Route::get('/new-arrivals', 'homeAllProdController@newArrivals');
Route::get('/about', 'homeAllProdController@about');
Route::get('/coming-soon/{id}', 'homeAllProdController@comingsoon');

Route::post('/post/secure/add/testimonial', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'cate' => 'required',
        'username' => 'required',
        'country' => 'required',
        'remarks' => 'required'
    ]);
    
        try {

            DB::connection('mysql2')->table('testimonials')->insert([
                'category' => $request->input('cate'),
                'name' => $request->input('username'),
                'country' => $request->input('country'),
                'remarks' => $request->input('remarks')]);
    
            return back()->with('msg', "Your testimonial has been successfully submitted. It will under review process.");
        } catch (\Throwable $th) {
            dd("Some error occured.");
        }
    
    })->name('add.testimonial.post');



