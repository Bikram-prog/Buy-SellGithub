<?php

namespace App\Http\Controllers;
use App\Product;
use App\Orders;
use App\SellerUser;
use App\BuyerAddress;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Stripe;
use Mail;


class apiController extends Controller
{
public function viewCategrory() {

    $category = DB::table('category')->where('cate_img', '!=', 'none')->get();
    return json_encode($category);
}

public function viewCatProducts($id) {
      
      $products = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = '".$id."' AND u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active'");

      $category = DB::table('category')->where('cate_id', '=', $id)->select('cate_id','cate_title')->first();

      $subcategoryall = DB::select("SELECT * FROM sub_category WHERE sub_cate_cate_id = $id");

      $sub_cat_all= [];
      foreach($subcategoryall as $sub){
        $sub_cat_all[] = array(
            'sub_id' => $sub->sub_cate_id,
            'sub_title' => $sub->sub_cate_title
        );
      }
      
      
      $prod_arr = [];
      foreach($products as $prod){
        
        $subcategory = DB::table('sub_category')->where('sub_cate_id', '=', $prod->prod_sub_cate_id)->select('sub_cate_id','sub_cate_title')->first();

        $prod_arr[] = array(
            'prod_id' => $prod->prod_id,
            'title' => $prod->prod_title,
            'price' => $prod->prod_price,
            'img' => "https://buyandsell.click/images/".$prod->pro_img_path,
            'cat_name' => $category->cate_title,
            'cat_id' => $category->cate_id,
            'sub_cat_id' => $subcategory->sub_cate_id,
            'sub_cat_name' => $subcategory->sub_cate_title
        );
      }

    return json_encode([$prod_arr,$sub_cat_all]);

}

public function viewProductDetails($id) {

    
      $prod = [];
      $product = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_id = '".$id."'");

      $prod = array(
        'id' => $product[0]->prod_id,
        'title' => $product[0]->prod_title,
        'long_desc' => $product[0]->prod_long_desc,
        'price' => $product[0]->prod_price,
        'conditions' => $product[0]->prod_cndtn,
        'quantity' => $product[0]->prod_quantity,
        'prod_delivery_days' => $product[0]->prod_delivery_days,
      );

    return json_encode($prod);

}

public function viewProductReviews($id) {

    $review = DB::table('buyer_reviews')
                ->leftJoin('buyer_users', 'buyer_users.buyer_id', '=', 'buyer_reviews.review_buyer_id')
                ->where('buyer_reviews.review_prod_id', '=', $id)
                ->get();

    return json_encode($review);

}

public function viewProductSellerId($id) {

    $seller = DB::table('products')
                ->leftJoin('seller_users', 'seller_users.s_id', '=', 'products.prod_seller_id')
                ->where('products.prod_id', '=', $id)
                ->get();


    return json_encode($seller);

}

public function viewProductRatings($id) {

   $ratings = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$id."'");


    return json_encode($ratings);

}

public function viewRelatedProducts($id) {

   $result = DB::table('products')->select('prod_cate_id')->where('prod_id', $id)->first();
      $catId = $result->prod_cate_id;
      

      $category = DB::table('category')
                ->where('cate_id', '=', $catId)
                ->get();

      $relPro =   DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = $catId AND u.prod_id NOT IN ($id) LIMIT 4");


    return json_encode($relPro);

}

public function viewProductImages($id) {

    $prodImg = DB::table('pro_images')
                ->where('prod_img_prod_id', '=', $id)
                ->get();

    return json_encode($prodImg);
}

public function viewBuyerOrders($id) {

  $orderss = DB::table('orders')
                           ->leftJoin('products', 'products.prod_id', '=', 'orders.order_prod_id')
                           ->leftJoin('seller_users', 'seller_users.s_id', '=', 'orders.ord_seller_id')
                           ->where('orders.ord_buyer_id', '=', $id)
                           ->orderBy('orders.order_date_time', 'DESC')
                           ->get();

$orders= [];
foreach($orderss as $new){

  $category = DB::table('category')->where('cate_id', '=', $new->prod_cate_id)->select('cate_id','cate_title')->first();

  $newArrivals = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id AND u.prod_id = '".$new->prod_id."' ORDER BY pro_id ASC LIMIT 1 )ORDER BY u.prod_date_time DESC LIMIT 4"); 

        $orders[] = array(
          'prod_id' => $new->prod_id,
          'prod_title' => $new->prod_title,
          'prod_price' => $new->prod_price,
          'prod_cndtn' => $new->prod_cndtn,
          'cate_title'=> $category->cate_title,
          'pro_img_path' => "https://buyandsell.click/images/".$newArrivals[0]->pro_img_path,
          'ord_uniq_id'=> $new->ord_uniq_id,
          'ord_quantity'=> $new->ord_quantity,
          'ord_amount'=> $new->ord_amount,
          'ord_paid_amount'=> $new->ord_paid_amount,
          'ord_delivery_add'=> $new->ord_delivery_add,
          'seller_comp_name'=> $new->seller_comp_name,
        );

}


    return json_encode($orders);
}

public function searchProduct($keyword){

    $products = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 )WHERE MATCH(u.prod_title,u.prod_long_desc) AGAINST('".$keyword."' IN NATURAL LANGUAGE MODE)  AND u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active' LIMIT 50");

      
      $prod_arr = [];
      foreach($products as $prod){
        
        $category = DB::table('category')->where('cate_id', '=', $prod->prod_cate_id)->select('cate_id','cate_title')->first();

        $subcategory = DB::table('sub_category')->where('sub_cate_id', '=', $prod->prod_sub_cate_id)->select('sub_cate_id','sub_cate_title')->first();

        $prod_arr[] = array(
            'prod_id' => $prod->prod_id,
            'title' => $prod->prod_title,
            'price' => $prod->prod_price,
            'img' => "https://buyandsell.click/images/".$prod->pro_img_path,
            'cat_name' => $category->cate_title,
            'cat_id' => $category->cate_id,
            'sub_cat_id' => $subcategory->sub_cate_id,
            'sub_cat_name' => $subcategory->sub_cate_title
        );
      }

    return json_encode($prod_arr);

}

public function stripePostMobPayment(Request $request) {
      
      $amount = $request->input('amount');
      $var = json_decode($request->cartItems);

        Stripe\Stripe::setApiKey('sk_test_51IOaN8JIlVvxjrBSICd432vgrKQUjVLZsLHII9bgYFewKUil0CDXnNTlqYS2kCxpgprw54FUJhbxC2L0xPzqpFPk00IibI1Oen');
        $test = Stripe\Charge::create ([
                "amount" => $amount * 100,
                "currency" => "AUD",
                "source" => $request->stripeToken,
                "receipt_email" =>$request->input('UserEmail'),
                "description" => "Buy&Sell Shopping Mob"
        ]);
        
        
        

      
      if($test->status == 'succeeded'){
        
       
        $day = date('YmdHis');
        $uniqid =  $day . uniqid();
        $mail= $request->input('UserEmail');
        $mailunq = $mail . $uniqid; 
        $orduniqid = hash('sha256', $mailunq);

        $buyerId= $request->input('UserID');
        $buyerDelvryAdd= $request->input('delvryadd');
       
      
      $arr=[];

       foreach($var as $cartinsrt){

        $seller_id = DB::table("products")->where("prod_id", $cartinsrt->prod_id)->select("prod_seller_id")->first();
        
        $sellerComission = DB::select('select * from seller_payments where payment_prod_id="'.$cartinsrt->prod_id.'"');
        if(count($sellerComission) == '0'){
          $comission= ($cartinsrt->prod_price * 1.75) / 100;
          if($comission >= 25){
            $comission = 25;
          } else {
            $comission = $comission;
          }
           DB::insert('insert into seller_payments(payment_prod_id, payment_sellr_id, payment_amount) values (?, ?,?)', [$cartinsrt->prod_id, $seller_id->prod_seller_id, $comission]);
        }

        $cart_info = new Orders(); 
        $cart_info->ord_buyer_id = $buyerId;
        $cart_info->order_prod_id = $cartinsrt->prod_id;
        $cart_info->ord_quantity = $cartinsrt->prod_quantity;
        $cart_info->ord_seller_id = $seller_id->prod_seller_id;
        

        $cart_info->ord_uniq_id = 'BES_'. md5($orduniqid . $cartinsrt->prod_id);
        $cart_info->ord_amount = $cartinsrt->prod_price;
        $cart_info->ord_currency = 'AUD';
        $cart_info->ord_payment_id = $test->id;
        $cart_info->ord_payment_trnsctn_id = $test->balance_transaction;
        $cart_info->ord_reciept_url = $test->receipt_url;
        if(count($sellerComission) == '0'){
          $cart_info->ord_paid_amount = ($cartinsrt->prod_price * $cartinsrt->prod_quantity) - $comission;
        } else{
           $cart_info->ord_paid_amount = $cartinsrt->prod_price * $cartinsrt->prod_quantity;
        }
       
        $cart_info->ord_delivery_add = $buyerDelvryAdd;
        $cart_info->save();
    Product::where('prod_id',  $cartinsrt->prod_id)->decrement('prod_quantity', $cartinsrt->prod_quantity);
 DB::table('variations')
    ->where('var_prod_id', $cartinsrt->prod_id)
    ->where('var_value', 'null')
    ->decrement('var_quantity', $cartinsrt->prod_quantity);

$arr[]=array(
  'order_id'=> $cart_info->ord_uniq_id,
  'order_total'=> $cart_info->ord_amount,
  'order_dlvry_add'=> $cart_info->ord_delivery_add,
  'order_prod_title'=> $cartinsrt->prod_name,
  'order_prod_image'=> $cartinsrt->prod_image,
  'order_prod_quantity'=> $cartinsrt->prod_quantity,
  'order_dlvry_days'=> '7'
);



       }

       
      
       

       
    //    Mail::send(['html'=>'email_order_cofirm'], ['order_dtls'=>$arr], function($message) use ($mail, $arr)  {
    //     $message->to($mail)->subject
    //        ('Your Buy&Sell Order Confirmation');
    //     $message->from('no-reply@wwwmedia.world','Buy & Sell');
    //  });

    //  $selmail= DB::Select("Select email From seller_users WHERE s_id= $cart_info->ord_seller_id");

    //  $mailsel=$selmail[0]->email;

    //  Mail::send(['html'=>'email_seller_ordr'], ['order_dtls'=>$arr], function($message) use ($mailsel, $arr)  {
    //   $message->to($mailsel)->subject
    //      ('You have a new order');
    //   $message->from('no-reply@wwwmedia.world','Buy & Sell');
    // });

       //return json_encode(['success', $request->cartItems]);
       return response()->json('success');
      } else {
        return json_encode(['failed']);
      }
       
      
      
    
}

public function buyersAddress($id) {
    $addressess = DB::table('buyer_addresses')->where('buyer_del_add_buy_id', '=', $id)->get();
    return response()->json($addressess);
}

public function buyerLogin(Request $request){
        
  $login_info = new SellerUser();
  $login_info->email = request('email');
  $login_info->password = request('psw');
  $data = DB::select('select * from seller_users where email  =? and password =?',[request('email'),md5(request('psw'))]);
  
  if(count($data) == '1'){

    if($data[0]->email_verified_at == ""){
      return response()->json(['msg'=>'Please verify your email first for login']);
  }

  return response()->json([$data[0]->email,$data[0]->s_id]);
  }else{
  return response()->json(['msg'=>'Please check your information']);

}   
}

public function buyerSignup(Request $request){

  $category = DB::table('category')->take(10)->get();
  $register_info = new SellerUser(); 
    $register_info->name = request('name');
    $register_info->email  = request('email');
    $register_info->password = md5(request('password'));
    // $register_info->buyer_sex = request('gender');

    $data = DB::select('select * from seller_users where email  =?',[request('email')]);
    if(count($data) == '1'){
      return response()->json(['msg'=>'This email already exist.']);

    } elseif(request('password') == request('repassword')){
        $register_info->save();

        $mail= request('email');

        $user = SellerUser::where('email', '=', [request('email')])->first();

    $dataa = "https://buyandsell.click/verifyaccount/" . $user->s_id;
  Mail::send(['html'=>'email_verification_template'], ['text'=>$dataa], function($message) use ($mail, $dataa)  {
     $message->to($mail)->subject
        ('Verify Account.');
     $message->from('no-reply@wwwmedia.world','Buy & Sell');
  });

  $mail2= 'cs@wwwmedia.world';
  Mail::send(['html'=>'email_new_user_alert'], ['name'=>$register_info->name,'email'=>$register_info->email], function($message) use ($mail2, $user)  {
    $message->to($mail2)->subject
       ('New User Alert.');
    $message->from('no-reply@wwwmedia.world','Buy & Sell');
 });
    return response()->json(['msg'=>'Please check your email (Inbox / SPAM) folder to verify your account.']);
  } else {
    //-------
  }
}

public function myAccount($id){
  $category = DB::table('category')->take(10)->get();

  $users = DB::table('seller_users')
    ->leftJoin('buyer_addresses', 'buyer_addresses.buyer_del_add_buy_id', '=', 'seller_users.s_id')
    ->where('seller_users.s_id', '=', $id)
    ->get();

    return response()->json($users);

}

public function addAddress(Request $request){
       
  $buyer_info = new BuyerAddress(); 
  $buyer_info->buyer_del_phn_no = request('phn_no');
  $buyer_info->buyer_del_email = request('email');
  $buyer_info->buyer_del_address = request('address');
  $buyer_info->buyer_del_country = request('country');
  $buyer_info->buyer_del_city = request('city');
  $buyer_info->buyer_del_state = request('state');
  $buyer_info->buyer_del_postcode = request('postcode');
  $buyer_info->buyer_del_add_buy_id = request('buyer_id');
  $buyer_info->save();
  
  return response()->json(['msg'=>'Address added successfully.']);
}

public function editPassword(Request $request){
      
      
  $data = DB::select('select * from seller_users where s_id="'.request('UserIds').'"');
    
    if(md5($request->input('pass')) == $data[0]->password){
       if(request('nwpass') == request('renwpass')){
         DB::table('seller_users')->where('s_id', request('UserIds'))->update(['password' => md5($request->input('renwpass'))]);
         return response()->json(['msg'=>'Password updated successfully.']);
       }
         
    }
      else{
        return response()->json(['msg'=>'Error! Enter Your Correct Password.']);
       }
    
  }

  public function viewHome() {

      
      $newArrivals = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id AND u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active' ORDER BY pro_id ASC LIMIT 1 )ORDER BY u.prod_date_time DESC LIMIT 4"); 

      $prod = [];
      foreach($newArrivals as $new){

        $category = DB::table('category')->where('cate_id', '=', $new->prod_cate_id)->select('cate_id','cate_title')->first();

        $prod[] = array(
          'id' => $new->prod_id,
          'title' => $new->prod_title,
          'price' => $new->prod_price,
          'img' => "https://buyandsell.click/images/".$new->pro_img_path,
          'category'=> $category->cate_title,
        );

      }

      
 
     return json_encode([$prod]);
 
 }

 public function viewRecommendation() {

  $orders = DB::table('orders')
                           ->leftJoin('products', 'products.prod_id', '=', 'orders.order_prod_id')
                           ->where('products.prod_status','=', 'Active')
                           ->where('products.prod_live_status','=', '1')
                           ->where('products.prod_quantity','>', '0')
                           ->orderBy('orders.order_date_time', 'DESC')
                           ->groupBy('orders.order_prod_id')
                           ->take(4)
                           ->get();
$prod= [];
foreach($orders as $new){

  $category = DB::table('category')->where('cate_id', '=', $new->prod_cate_id)->select('cate_id','cate_title')->first();

  $newArrivals = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id AND u.prod_id = '".$new->prod_id."' ORDER BY pro_id ASC LIMIT 1 )ORDER BY u.prod_date_time DESC LIMIT 4"); 

        $prod[] = array(
          'id' => $new->prod_id,
          'title' => $new->prod_title,
          'price' => $new->prod_price,
          'category'=> $category->cate_title,
          'img' => "https://buyandsell.click/images/".$newArrivals[0]->pro_img_path,
        );

}


    return json_encode($prod);
}


public function viewCatProductsSorting($id,$title) {

  if($title == 'lh'){

    $products = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = '".$id."' AND u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active' ORDER BY u.prod_price ASC");

  }

  if($title == 'hl'){

    $products = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = '".$id."' AND u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active' ORDER BY u.prod_price DESC");

  }
      
  

  $category = DB::table('category')->where('cate_id', '=', $id)->select('cate_id','cate_title')->first();

  $subcategoryall = DB::select("SELECT * FROM sub_category WHERE sub_cate_cate_id = $id");

  $sub_cat_all= [];
  foreach($subcategoryall as $sub){
    $sub_cat_all[] = array(
        'sub_id' => $sub->sub_cate_id,
        'sub_title' => $sub->sub_cate_title
    );
  }
  
  
  $prod_arr = [];
  foreach($products as $prod){
    
    $subcategory = DB::table('sub_category')->where('sub_cate_id', '=', $prod->prod_sub_cate_id)->select('sub_cate_id','sub_cate_title')->first();

    $prod_arr[] = array(
        'prod_id' => $prod->prod_id,
        'title' => $prod->prod_title,
        'price' => $prod->prod_price,
        'img' => "https://buyandsell.click/images/".$prod->pro_img_path,
        'cat_name' => $category->cate_title,
        'cat_id' => $category->cate_id,
        'sub_cat_id' => $subcategory->sub_cate_id,
        'sub_cat_name' => $subcategory->sub_cate_title
    );
  }

return json_encode([$prod_arr,$sub_cat_all]);

}

 

}
