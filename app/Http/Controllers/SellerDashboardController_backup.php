<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProImage;
use App\SellerPayment;
use App\SellerUser;
use App\BuyerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Stripe;

class SellerDashboardController extends Controller
{

 
    public function viewDash(){
      $category = DB::table('category')->take(10)->get();
      
      if(!isset($_COOKIE['UserIds'])){
            return view('seller_login')->with(['category'=>$category]);
        }else{ 
      
      
      
      $id = Crypt::decryptString($_COOKIE['UserIds']);

      $users = DB::select("SELECT u.*, p.* FROM products AS u LEFT JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_seller_id = $id ORDER BY p.pro_id IS NULL");

      $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");
      
        return view('seller_view_prod')->with(['users' => $users,'totalearning'=>$totalearning, 'category'=>$category]);
    }
  }

 

  public function sellerProfile(){

      $category = DB::table('category')->take(10)->get();
      
      $id = Crypt::decryptString($_COOKIE['UserIds']);
      $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");
       
       return view('sellerprofile')->with(['category'=>$category,'totalearning'=>$totalearning]);
    }

     public function sellerproductDetails($id) {

      $category = DB::table('category')->take(10)->get();

      $user = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_id = $id");

      $prodImg = DB::table('pro_images')
                ->where('prod_img_prod_id', '=', $id)
                ->get();

      $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");
      // $users = Product::where('prod_id', '=', [$id])->get();
      // $users = DB::select('select * from products where prod_id =?',[$id]);
      return view('seller_view_prod_dtls')->with(['user'=>$user[0],'prodImg'=>$prodImg,'totalearning'=>$totalearning, 'category'=>$category]);
   }

   public function addMoreProductForm($id){

      //Session::push('addmoreproduct',$id);
    DB::insert('insert into add_more_prod_tmprry(add_prod_id, add_seller_id) values (?, ?)', [$id, Crypt::decryptString($_COOKIE['UserIds'])]);
       
       return redirect('addproduct');
    }

    public function addProductForm(){
      if(Crypt::decryptString($_COOKIE['UserCompName']) == ''){
        return redirect('/apply-seller');
    }else{ 

      $users = DB::select("SELECT * FROM category");
      
       $category = DB::table('category')->get();
$id = Crypt::decryptString($_COOKIE['UserIds']);


    $title = Crypt::decryptString($_COOKIE['UserCompName']);
    
    $products = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_seller_id = $id LIMIT 4");
    
    
    $ratings_sel_pro = [];
    foreach($products as $rev){
      // $review[] = DB::table('buyer_reviews')
      // ->leftJoin('buyer_users', 'buyer_users.buyer_id', '=', 'buyer_reviews.review_buyer_id')
      // ->where('buyer_reviews.review_prod_id', '=', $rev->prod_id)
      // ->get();
      $ratings_sel_pro[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$rev->prod_id."'");
    }

    // $ratings_seller = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_seller_id = $id");
       $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");
       
       return view('seller_add_prod_form')->with(['users' => $users,'totalearning'=>$totalearning, 'category'=>$category, 'products'=>$products, 'ratings_sel_pro'=>$ratings_sel_pro]);
    }
    }

    public function addProduct(Request $request){

    //   $this->validate($request,[
    //     'cate_id'=>'required',
    //     'title'=>'required|max:100',
    //     'prod_cndtn'=>'required',
    //     'quantity'=>'required|numeric:value',
    //     'lg_desc'=>'required|max:5000',
    //     //'tags'=>'required',
    //     //'price'=>'required|numeric:value',
    //     'offrprice'=>'required|numeric:value'
    //  ]);
      
    $offr_price = request('offrprice');
    //$actual_price = round($offr_price+($offr_price/100)*18);
    $actual_price = $offr_price;
    $day = date('YmdHis');
    $uniqid =  $day . uniqid();
    $mail= Crypt::decryptString($_COOKIE['UserIds']);
    $mailunq = $mail . $uniqid; 
    $produniqid = hash('sha256', $mailunq);
    
    

      $product_info = new Product(); 
        $product_info->prod_country = request('contry_id');
        $product_info->prod_cate_id = request('cate_id');
        $product_info->prod_cndtn = request('prod_cndtn');
        $product_info->prod_sub_cate_id = request('sbcatgry_id');
        $product_info->prod_title = request('title');
        $product_info->prod_long_desc = request('lg_desc');
        //$product_info->prod_tags = request('tags');
        $product_info->prod_quantity = request('quantity');
        //$product_info->prod_reg_price = request('price');
        $product_info->prod_price = $actual_price;
        $product_info->prod_seller_id = request('seller_id');
        $product_info->prod_id = $produniqid;

        

         $product_info->save();
        
        
         $uniq_id = $product_info->prod_id;
        //  $title = $product_info->prod_title;
       return redirect('sellerimgupld/'.$uniq_id)->with(['prodsucmsg' => 'Your Product Added Sucessfully.']);
    }

    public function subCateAjax($id){
      $subcate = DB::select("SELECT * FROM sub_category WHERE sub_cate_cate_id = $id");
       return response()->json(['subcate'=>$subcate]);

    }

    public function imgUpload($id){

      $category = DB::table('category')->take(10)->get();

      $ProImage = ProImage::where('prod_img_prod_id', '=', [$id])->get();

      $finish = DB::select("SELECT * FROM products WHERE prod_id = '".$id."' AND prod_cate_id != '0' AND prod_title != '' AND prod_price != '' AND prod_quantity != '' AND prod_long_desc != ''");

      

      $image = count($ProImage);

        return view('img')->with(['lstprodid' => $id, 'category'=>$category, 'ProImage'=>$ProImage, 'image'=>$image, 'finish'=>$finish]);
    }

    public function sellerDraftProduct($id){

      DB::table('products')->where('prod_id', $id )->update(['prod_draft_status' => '1']);
               
               // $delprod = Product::where('prod_id', '=', [$id])->delete();
               return redirect('/sellerdashboard')->with(['delprod'=>'Product save as a draft']);
            }

    public function liveProduct($id){

      DB::table('products')->where('prod_id', $id )->update(['prod_draft_status' => '0','prod_live_status' => '1']);
                
                // $delprod = Product::where('prod_id', '=', [$id])->delete();
                return redirect('/sellerdashboard')->with(['delprod'=>'Product added Successfully']);
            }

     public function imgUpload1(){

        return view('img');
    }

      public function fileStore(Request $request){
        $this->validate($request,[
          'file' => 'required|mimes:jpeg,jpg|max:10240',
      ]);
        
        $image = $request->file('file');
        $prodid = $request->input('data');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('images'),$imageName);
        $id = $request->input('hd_id');
        
        $imageUpload = new ProImage();
        $imageUpload->prod_img_prod_id = $prodid;
        $imageUpload->pro_img_path = $imageName;
        $imageUpload->save();
        //return response()->json(['success'=>$imageUpload]);
        return redirect('/sellerimgupld/' . $request->input('data'));
    }

    public function delProductImage(Request $request, $id, $prod_id, $imgpath){
            
             
             $delImage = ProImage::where('pro_id', '=', [$id])->delete();
             $path=public_path().'/images/'.$imgpath;
        if (file_exists($path)) {
            unlink($path);
        }

        return redirect('/sellerimgupld/'. $prod_id);
            }

      public function fileDestroy(Request $request)
    {
        $filename =  $request->get('filename');
        ProImage::where('pro_img_path',$filename)->delete();
        $path=public_path().'/images/'.$filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;  
    }

    //// Seller Edit Product Start ////

    public function editProductForm($id){

      $category = DB::table('category')->get();

       // $users = DB::table('category')->get();
       // $Editpro = Product::where('prod_id', '=', [$id])->get();

       $Editpro = DB::table('products')
                           ->leftJoin('category', 'category.cate_id', '=', 'products.prod_cate_id')
                           ->where('products.prod_id', '=', $id)
                           ->get();

       $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");

        return view('editproduct',['Editpro'=>$Editpro, 'totalearning'=>$totalearning, 'category'=>$category]);
    }

     public function editProduct(Request $request){

    //   $offr_price = request('offrprice');
    // $actual_price = round($offr_price+($offr_price/100)*18);

    $this->validate($request,[
      'cate_id'=>'required',
        'title'=>'required|max:100',
        'prod_cndtn'=>'required',
        'quantity'=>'required|numeric:value',
        'lg_desc'=>'required|max:5000',
        // 'tags'=>'required',
        //'price'=>'required|numeric:value',
        'offrprice'=>'required|numeric:value'
   ]);
     

        DB::table('products')->where('prod_id', $request->input('proid') )->update(['prod_country' => $request->input('contry_id'),'prod_cndtn' => $request->input('prod_cndtn'),'prod_cate_id' => $request->input('cate_id'),'prod_sub_cate_id' => $request->input('sbcatgry_id') , 'prod_title' => $request->input('title'),'prod_long_desc' => $request->input('lg_desc'),'prod_quantity' => $request->input('quantity'),'prod_price' => $request->input('offrprice'),'prod_tags' => $request->input('tags'),'prod_seller_id' => $request->input('seller_id')]);


        $Editpro = $request->input('proid');
        
        return redirect('/editimage/'.$Editpro);

    }

     public function editProductVariation($id){
        $category = DB::table('category')->take(10)->get();

        $attributes = DB::select('select * from attributes where att_prod_id = ? ', [$id]);
        return view('editprodattributes', ['category'=>$category, 'id' => $id, 'attributes' => $attributes]);
    }

      public function sellerEditProductVariationAddt(Request $request) {
      $i = 0;

      foreach ($request->input('key') as $value) {
        DB::insert('insert into attributes (att_prod_id, att_key, att_value) values (?, ?, ?)', [$request->input('prod_id'), $value, $request->input('val')[$i]]);
        $i++;
      }

      return redirect('/editprodattributes/' . $request->input('prod_id'));
      
      
    }

    public function delAttributes($id,$prodid){
               DB::table('attributes')->where('att_id', $id)->delete();
                
               return redirect('/editprodattributes/'.$prodid)->with(['delprod'=>'Product Inactivated successfully']);
            }

    public function sellerEditVariation($id){
        $category = DB::table('category')->take(10)->get();

       $attributes = DB::select('select * from attributes where att_prod_id = ? ', [$id]);

       $variation = DB::select('select * from variations where var_prod_id = ? ', [$id]);


        return view('editvariation', ['category'=>$category, 'attributes'=>$attributes, 'variation'=>$variation, 'id' => $id]);
    }

    public function editVariationPost(Request $request) {
      $imp = implode("|", $request->input('var'));
        DB::insert('insert into variations (var_prod_id, var_value, var_quantity, var_price) values (?, ?, ?, ?)', [$request->input('prod_id'), $imp, $request->input('quantity'), $request->input('price')]);
        
      

      return redirect('/editvariation/' . $request->input('prod_id'));
      
      
    }

     public function delVariation($id,$prodid){
               DB::table('variations')->where('var_id', $id)->delete();
                
               return redirect('/editvariation/'.$prodid)->with(['delprod'=>'Product Inactivated successfully']);
            }

    public function editImageForm($id){
      $category = DB::table('category')->take(10)->get();

      $payment = DB::select('select * from seller_payments where payment_prod_id = ? ', [$id]);



      $ProImage = ProImage::where('prod_img_prod_id', '=', [$id])->get();

      $image = count($ProImage);
        return view('editimage')->with(['lstprodid' => $id, 'ProImage'=>$ProImage, 'category'=>$category, 'payment'=>$payment, 'image'=>$image]);
    }

    public function editfileStore(Request $request){
        $this->validate($request,[
        'file' => 'required|mimes:jpeg,jpg|max:10240',
    ]);
        
        $image = $request->file('file');
        //if($image->get <= 800000){
          $prodid = $request->input('data');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('images'),$imageName);
        $id = $request->input('hd_id');
        
        $imageUpload = new ProImage();
        $imageUpload->prod_img_prod_id = $prodid;
        $imageUpload->pro_img_path = $imageName;
        $imageUpload->save();
        //return response()->json(['success'=>$imageUpload]);
        return redirect('/editimage/' . $request->input('data'));
        //} 
        
        // else{
        // return redirect('/editimage/' . $request->input('data'))->with(['msg'=>'Image should be less than 800KB']);

        // }
        
    }

    public function delImage(Request $request, $id, $prod_id, $imgpath){
            
             $delImage = ProImage::where('pro_id', '=', [$id])->delete();
             $path=public_path().'/images/'.$imgpath;
        if (file_exists($path)) {
            unlink($path);
        }

        return redirect('/editimage/'.$prod_id);
            }


    public function productPayment($prodid){
      $category = DB::table('category')->take(10)->get();
      
      $id = Crypt::decryptString($_COOKIE['UserIds']);
            
      $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");

        return view('/edit_prod_payment')->with(['prodid'=>$prodid, 'totalearning'=>$totalearning, 'category'=>$category]);
    }

     public function stripeproduct(Request $request){
      
        
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => 1 * 100,
                "currency" => "AUD",
                "source" => $request->stripeToken,
                "description" => "Easyasthat Seller Products"
        ]);
         $payment_info = new SellerPayment(); 
        $payment_info->payment_prod_id = request('prod_id');
        $payment_info->payment_prod_title = request('prod_title');
        $payment_info->payment_sellr_id = request('seller_id');
        $payment_info->payment_amount = 1;
        $payment_info->save();
      
        DB::table('add_more_prod_tmprry')->where('add_prod_id', $request->input('prod_id'))->delete();
       Session::flash('success', 'Payment successful!');
      return redirect('/sellerdashboard');
       
    }

    //// Seller Edit Product End ////

    public function stripePendingPaymentProduct(){
      $category = DB::table('category')->take(10)->get();
      
      $id = Crypt::decryptString($_COOKIE['UserIds']);
            
      $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");

        return view('/pendingpayment')->with(['totalearning'=>$totalearning, 'category'=>$category]);
    }


public function stripePendingPayment(Request $request){

  $category = DB::table('category')->take(10)->get();
      
      $id = Crypt::decryptString($_COOKIE['UserIds']);
            
     $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");
      
       $imp = implode(",", $request->input('chk')); 
       $price = count($request->input('chk'));
        
      return view('/pendingpayment')->with(['prodids'=>$imp, 'price'=>$price, 'totalearning'=>$totalearning, 'category'=>$category]);
       
    }
    public function stripePendingPost(Request $request){
      
        $exp = explode(",", $request->input('hd_prod'));
        $exp_count_price = count($exp);

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => $exp_count_price * 100,
                "currency" => "AUD",
                "source" => $request->stripeToken,
                "description" => "Easyasthat Seller Products"
        ]);

        foreach($exp as $ex):
         $payment_info = new SellerPayment(); 
        $payment_info->payment_prod_id = $ex;
        $payment_info->payment_prod_title = $request->input('prod_title');
        $payment_info->payment_sellr_id = request('seller_id');
        $payment_info->payment_amount = 1;
        $payment_info->save();
        endforeach;
      
        foreach($exp as $ex):
        DB::table('add_more_prod_tmprry')->where('add_prod_id', $ex)->delete();
        endforeach;
       Session::flash('success', 'Payment successful!');
      return redirect('/sellerpaymenthistory');
       
    }

    public function delProduct($id){

      DB::table('products')->where('prod_id', $id )->update(['prod_status' => 'Inactive']);
               
               // $delprod = Product::where('prod_id', '=', [$id])->delete();
               return redirect('/sellerdashboard')->with(['delprod'=>'Product Inactivated successfully']);
            }

    public function activeProduct($id){

      DB::table('products')->where('prod_id', $id )->update(['prod_status' => 'Active']);
               
               // $delprod = Product::where('prod_id', '=', [$id])->delete();
               return redirect('/sellerdashboard')->with(['delprod'=>'Product activated successfully']);
            }

    public function orderHistory(){
      if(Crypt::decryptString($_COOKIE['UserCompName']) == ''){
        return redirect('/seller');
    }
      
      $category = DB::table('category')->take(10)->get();

            $id = Crypt::decryptString($_COOKIE['UserIds']);

            $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");
            
          
               $Orderprod = DB::table('orders')
                           ->leftJoin('products', 'products.prod_id', '=', 'orders.order_prod_id')
                           ->leftJoin('seller_users', 'seller_users.s_id', '=', 'orders.ord_buyer_id')
                           ->where('orders.ord_seller_id', '=', $id)
                           ->orderBy('orders.order_date_time', 'DESC')
                           ->get();
               return view('orderhistory',['Orderprod'=>$Orderprod,'totalearning'=>$totalearning,'Orderprod'=>$Orderprod, 'category'=>$category]);
            }

            public function sellersellerSearchOrder(Request $request){

              $category = DB::table('category')->take(10)->get();

            $id = Crypt::decryptString($_COOKIE['UserIds']);

            $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");
            
            $date = explode('-', $request->input('date'));
          
               $Orderprod = DB::select( "SELECT t1.*,t2.*,t3.* FROM orders t1 LEFT JOIN products t2 ON (t1.order_prod_id=t2.prod_id) LEFT JOIN seller_users t3 ON (t1.ord_buyer_id=t3.s_id) WHERE t1.ord_seller_id = '".$id."' AND t1.order_date_time BETWEEN '".$date[0]."' AND '".$date[1]."'");
               
               return view('orderhistory',['Orderprod'=>$Orderprod,'totalearning'=>$totalearning,'Orderprod'=>$Orderprod, 'category'=>$category]);
            }

            public function sellerSearchProductOrder(Request $request){

              $category = DB::table('category')->take(10)->get();

            $id = Crypt::decryptString($_COOKIE['UserIds']);

            $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");
            
          
               $Orderprod = DB::select( "SELECT t1.*,t2.*,t3.* FROM orders t1 LEFT JOIN products t2 ON (t1.order_prod_id=t2.prod_id) LEFT JOIN seller_users t3 ON (t1.ord_buyer_id=t3.s_id) WHERE t1.ord_seller_id = '".$id."' AND t1.ord_uniq_id = '".$request->input('order_srch')."' ");
               
               return view('orderhistory',['Orderprod'=>$Orderprod,'totalearning'=>$totalearning,'Orderprod'=>$Orderprod, 'category'=>$category]);
            }

    public function trackingNumberPost(Request $request){

      // Declare two dimensional associative 
// array and initilize it 
$arr = array ( 
  "tracking"=>array( 
      "tracking_number"=>$request->input('track_no'), 
      "emails" => array(
        "sumantasam1990@gmail.com"
      )
     
  )
); 

// Function to convert array into JSON 
$jsonBody = json_encode($arr); 

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,"https://api.aftership.com/v4/trackings");
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);  //Post Fields
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $headers = [
          'Content-Type: application/json',
          'aftership-api-key: a7dda32b-038d-4413-a289-612c261c0d45'
      ];

      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      $server_output = curl_exec ($ch);

      curl_close ($ch);
      $server_output = json_decode($server_output);

      if($server_output->meta->code == 201) {
        DB::table('orders')->where('ord_id', $request->input('order_id') )->update(['ord_tracking_no' => $request->input('track_no'), 'ord_tracking_id' => $server_output->data->tracking->id, 'ord_courier_name' => $server_output->data->tracking->slug]);
        return redirect('orderhistory');
      } else {
        return redirect('orderhistory')->with(['msg' => 'Please enter correct tracking number.']);
      }

    
    }

    public function sellerProductComission(){
      if(Crypt::decryptString($_COOKIE['UserCompName']) == ''){
        return redirect('/seller');
    }
      
      $category = DB::table('category')->take(10)->get();

            $id = Crypt::decryptString($_COOKIE['UserIds']);

            $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");

            $prodcomission =  DB::select("SELECT SUM(payment_amount) AS TotalComissionIEarning FROM seller_payments WHERE payment_sellr_id = '".$id."'");
            
          
               $Comissionprod = DB::table('seller_payments')
                           ->leftJoin('products', 'products.prod_id', '=', 'seller_payments.payment_prod_id')
                           ->where('seller_payments.payment_sellr_id', '=', $id)
                           ->orderBy('seller_payments.created_at', 'DESC')
                           ->get();

               return view('seller_comission',['Comissionprod'=>$Comissionprod,'totalearning'=>$totalearning, 'category'=>$category, 'prodcomission'=>$prodcomission]);
            }

            public function cmssnsellersellerSearchOrder(Request $request){

              $category = DB::table('category')->take(10)->get();

            $id = Crypt::decryptString($_COOKIE['UserIds']);

            $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");

            $prodcomission =  DB::select("SELECT SUM(payment_amount) AS TotalComissionIEarning FROM seller_payments WHERE payment_sellr_id = '".$id."'");
            
            $date = explode('-', $request->input('date'));
          
               $Comissionprod = DB::select( "SELECT t1.*,t2.* FROM seller_payments t1 LEFT JOIN products t2 ON (t1.payment_prod_id=t2.prod_id) WHERE t1.payment_sellr_id = '".$id."'  AND t1.created_at BETWEEN '".$date[0]."' AND '".$date[1]."'");
             
              

               return view('seller_comission',['Comissionprod'=>$Comissionprod,'totalearning'=>$totalearning, 'category'=>$category, 'prodcomission'=>$prodcomission]);
            }

            public function cmssnsellerSearchProductOrder(Request $request){

              $category = DB::table('category')->take(10)->get();

            $id = Crypt::decryptString($_COOKIE['UserIds']);

            $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");

            $prodcomission =  DB::select("SELECT SUM(payment_amount) AS TotalComissionIEarning FROM seller_payments WHERE payment_sellr_id = '".$id."'");
            
          
               $Comissionprod = DB::select( "SELECT t1.*,t2.* FROM seller_payments t1 LEFT JOIN products t2 ON (t1.payment_prod_id=t2.prod_id) WHERE t1.payment_sellr_id = '".$id."' AND t1.payment_prod_id = '".$request->input('order_srch')."' ");

               
               
               return view('seller_comission',['Comissionprod'=>$Comissionprod,'totalearning'=>$totalearning, 'category'=>$category, 'prodcomission'=>$prodcomission]);
            }

            public function sellerWithdraw(){
      
            $category = DB::table('category')->take(10)->get();

            $id = Crypt::decryptString($_COOKIE['UserIds']);

            $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");

            $prodcomission =  DB::select("SELECT SUM(payment_amount) AS TotalComissionIEarning FROM seller_payments WHERE payment_sellr_id = '".$id."'");

            $bank_dtls = DB::select("SELECT * FROM seller_bank_dtls WHERE bank_sel_id = '".$id."' AND make_primary = '1'");
          

               return view('seller_withdraw',['totalearning'=>$totalearning, 'category'=>$category, 'prodcomission'=>$prodcomission, 'bank_dtls'=>$bank_dtls]);
            }

            public function sellerAccntPost(Request $request){

      //Session::push('addmoreproduct',$id);
            DB::insert('insert into seller_bank_dtls(bank_sel_id, bank_name, bank_acc_hldr_name, bank_acc_no) values (?, ?, ?, ?)', [Crypt::decryptString($_COOKIE['UserIds']), $request->input('bank_name'), $request->input('accnthldr_name'), $request->input('bankacccnt_no')]);
       
       return redirect('selleraddbankdtls');
    }

     public function sellerBankDetails(){
            $category = DB::table('category')->take(10)->get();

            $id = Crypt::decryptString($_COOKIE['UserIds']);

            $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");

            $bank_dtls = DB::select("SELECT * FROM seller_bank_dtls WHERE bank_sel_id = '".$id."'");
      
       
       return view('seller_add_bank_dtls',['totalearning'=>$totalearning, 'category'=>$category, 'bank_dtls'=>$bank_dtls]);
    }

    public function sellerWithdrawlAmount(Request $request){
      if ($request->input('amount') > $request->input('balance')) {
        return redirect('sellerwithdraw')->with(['msg' => 'You have insufficient balance.']);
      }else{
      $today= date("Y-m-d h:i:s");
            DB::insert('insert into withdraw_seller(withdrw_sel_id, withdrw_bank_id, withdrw_amount, withdrw_date_time) values (?, ?, ?, ?)', [Crypt::decryptString($_COOKIE['UserIds']), $request->input('bank_id'), $request->input('amount'), $today]);
       
       return redirect('sellerwithdraw');
    }
   }

            public function sellerPendingDelivery(){
      
      $category = DB::table('category')->take(10)->get();

            $id = Crypt::decryptString($_COOKIE['UserIds']);

            $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");

            $totalpendingearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalPendingIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status !='Delivered'");

            $totalpendingeprod =  DB::table('orders')
                           ->leftJoin('products', 'products.prod_id', '=', 'orders.order_prod_id')
                           ->leftJoin('seller_users', 'seller_users.s_id', '=', 'orders.ord_buyer_id')
                           ->where('orders.ord_seller_id', '=', $id)
                           ->where('orders.ord_status', '!=', 'Delivered')
                           ->orderBy('orders.order_date_time', 'ASC')
                           ->get();


          
               $Orderprod = DB::table('orders')
                           ->leftJoin('products', 'products.prod_id', '=', 'orders.order_prod_id')
                           ->leftJoin('seller_users', 'seller_users.s_id', '=', 'orders.ord_buyer_id')
                           ->where('orders.ord_seller_id', '=', $id)
                           ->orderBy('orders.order_date_time', 'ASC')
                           ->get();
               return view('pending_delivery_product',['Orderprod'=>$Orderprod,'totalearning'=>$totalearning,'Orderprod'=>$Orderprod, 'category'=>$category,'totalpendingearning'=>$totalpendingearning,'totalpendingeprod'=>$totalpendingeprod]);
            }

            public function pndingsellersellerSearchOrder(Request $request){

              $category = DB::table('category')->take(10)->get();

            $id = Crypt::decryptString($_COOKIE['UserIds']);

            $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");

            $totalpendingearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalPendingIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status !='Delivered'");
            
            $date = explode('-', $request->input('date'));
          
               $totalpendingeprod = DB::select( "SELECT t1.*,t2.*,t3.* FROM orders t1 LEFT JOIN products t2 ON (t1.order_prod_id=t2.prod_id) LEFT JOIN seller_users t3 ON (t1.ord_buyer_id=t3.s_id) WHERE t1.ord_seller_id = '".$id."' AND t1.ord_status != 'Delivered' AND t1.order_date_time BETWEEN '".$date[0]."' AND '".$date[1]."'");
             
               $Orderprod = DB::table('orders')
               ->leftJoin('products', 'products.prod_id', '=', 'orders.order_prod_id')
               ->leftJoin('seller_users', 'seller_users.s_id', '=', 'orders.ord_buyer_id')
               ->where('orders.ord_seller_id', '=', $id)
               ->orderBy('orders.order_date_time', 'ASC')
               ->get();

               return view('pending_delivery_product',['Orderprod'=>$Orderprod,'totalearning'=>$totalearning,'Orderprod'=>$Orderprod, 'category'=>$category,'totalpendingearning'=>$totalpendingearning,'totalpendingeprod'=>$totalpendingeprod]);
            }

            public function pndingsellerSearchProductOrder(Request $request){

              $category = DB::table('category')->take(10)->get();

            $id = Crypt::decryptString($_COOKIE['UserIds']);

            $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");

            $totalpendingearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalPendingIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status !='Delivered'");
            
          
               $totalpendingeprod = DB::select( "SELECT t1.*,t2.*,t3.* FROM orders t1 LEFT JOIN products t2 ON (t1.order_prod_id=t2.prod_id) LEFT JOIN seller_users t3 ON (t1.ord_buyer_id=t3.s_id) WHERE t1.ord_seller_id = '".$id."' AND t1.ord_status != 'Delivered' AND t1.ord_uniq_id = '".$request->input('order_srch')."' ");

               $Orderprod = DB::table('orders')
               ->leftJoin('products', 'products.prod_id', '=', 'orders.order_prod_id')
               ->leftJoin('seller_users', 'seller_users.s_id', '=', 'orders.ord_buyer_id')
               ->where('orders.ord_seller_id', '=', $id)
               ->orderBy('orders.order_date_time', 'ASC')
               ->get();
               
               return view('pending_delivery_product',['Orderprod'=>$Orderprod,'totalearning'=>$totalearning,'Orderprod'=>$Orderprod, 'category'=>$category,'totalpendingearning'=>$totalpendingearning,'totalpendingeprod'=>$totalpendingeprod]);
            }

            public function addMore($prodid, $prodtitle){
      $category = DB::table('category')->take(10)->get();


        return view('/selleraddmore')->with(['prodid'=>$prodid, 'prodtitle'=>$prodtitle, 'category'=>$category]);
    }

    public function addMoreAction(Request $request){

      dd($request->input('extra'));
        
        // $image = $request->file('file');
        // $prodid = $request->input('data');
        // $imageName = $image->getClientOriginalName();
        // $image->move(public_path('images'),$imageName);
        // $id = $request->input('hd_id');
        
        // $imageUpload = new ProImage();
        // $imageUpload->prod_img_prod_id = $prodid;
        // $imageUpload->pro_img_path = $imageName;
        // $imageUpload->save();
        // return response()->json(['success'=>$imageUpload]);
    }

    public function payment($prodid, $prodtitle){
      $category = DB::table('category')->take(10)->get();
      
      $id = Crypt::decryptString($_COOKIE['UserIds']);

      //addmore product count//

      $prod_quantity = DB::select('select * from add_more_prod_tmprry where add_seller_id = ? ', [$id]);
      $prod_price = count($prod_quantity);

      
      
      $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");

      if($prod_price > 0){
        $prod_price = count($prod_quantity) + 1;
      }else{
        $prod_price = '1';
      }

        return view('/payment')->with(['prodid'=>$prodid, 'prodtitle'=>$prodtitle,'totalearning'=>$totalearning, 'category'=>$category, 'addmorecount'=>$prod_price]);
    }

     public function stripePost(Request $request)
    {
      //addmore product count//
      $prod_quantity = DB::select('select * from add_more_prod_tmprry where add_seller_id = ? ', [Crypt::decryptString($_COOKIE['UserIds'])]);
      $prod_price = count($prod_quantity) + 1;
      if($prod_price > 0){
        $prodTitle = $request->input('prod_title');
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => $prod_price * 100,
                "currency" => "AUD",
                "source" => $request->stripeToken,
                "description" => "Easyasthat Seller Products"
        ]);

        $payment_info = new SellerPayment(); 
        $payment_info->payment_prod_id = request('prod_id');
        $payment_info->payment_prod_title = request('prod_title');
        $payment_info->payment_sellr_id = request('seller_id');
        $payment_info->payment_amount = 1;
        $payment_info->save();
        foreach($prod_quantity as $pq):
         $payment_info = new SellerPayment(); 
         $payment_info->payment_prod_id = $pq->add_prod_id;
        $payment_info->payment_prod_title = 'title';
        $payment_info->payment_sellr_id = $pq->add_seller_id;
        $payment_info->payment_amount = 1;
        $payment_info->save();
      endforeach;
        }else{
        $prodTitle = $request->input('prod_title');
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => 1 * 100,
                "currency" => "AUD",
                "source" => $request->stripeToken,
                "description" => "Easyasthat Seller Products"
        ]);
         $payment_info = new SellerPayment(); 
        $payment_info->payment_prod_id = request('prod_id');
        $payment_info->payment_prod_title = request('prod_title');
        $payment_info->payment_sellr_id = request('seller_id');
        $payment_info->payment_amount = 1;
        $payment_info->save();
      }

      

      

       

        DB::table('add_more_prod_tmprry')->where('add_seller_id', Crypt::decryptString($_COOKIE['UserIds']))->delete();

       Session::flash('success', 'Payment successful!');

        
        
        return redirect('/sellerdashboard');
       
    }

    public function paymentHistory(){
      $category = DB::table('category')->take(10)->get();
      
            $id = Crypt::decryptString($_COOKIE['UserIds']);
               $Paymentprod = SellerPayment::where('payment_sellr_id', '=', [$id])->get();

            $pendingproduct = DB::select("SELECT t1.*,t2.* FROM products t1 LEFT JOIN seller_payments t2 ON (t1.prod_id=t2.payment_prod_id) WHERE t1.prod_seller_id = ? AND t2.prod_payment_id IS NULL", [Crypt::decryptString($_COOKIE['UserIds'])]);


            $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");

               return view('paymenthistory',['Paymentprod'=>$Paymentprod,'totalearning'=>$totalearning, 'category'=>$category, 'pendingproduct'=>$pendingproduct]);
            }

    public function sellerOrderStatusChange($id,$val){
      $explode = explode('|', $val);

      DB::table('orders')->where('ord_id', $explode[0] )->update(['ord_status' => $explode[1]]);

      return redirect('/orderhistory');
      
    }

    public function myAccount(){
      $category = DB::table('category')->take(10)->get();
      $id = Crypt::decryptString($_COOKIE['UserIds']);
      $title = Crypt::decryptString($_COOKIE['UserCompName']);
      
      
  
      $users = DB::table('seller_users')
        ->leftJoin('buyer_addresses', 'buyer_addresses.buyer_del_add_buy_id', '=', 'seller_users.s_id')
        ->where('seller_users.s_id', '=', $id)
        ->get();
  
        
      
      
        return view('myaccount')->with(['users' => $users]);
    
  }

    public function selleractiveproduct(){
      $category = DB::table('category')->take(10)->get();
      $id = Crypt::decryptString($_COOKIE['UserIds']);
      $title = Crypt::decryptString($_COOKIE['UserCompName']);
      
      $users = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id AND u.prod_live_status = '1' AND u.prod_status = 'Active' ORDER BY pro_id ASC LIMIT 1 ) where u.prod_seller_id = $id");
      $SellerImage = SellerUser::where('s_id', '=', [$id])->get();
      
      $ratings_sel_pro = [];
      foreach($users as $rev){
        // $review[] = DB::table('buyer_reviews')
        // ->leftJoin('buyer_users', 'buyer_users.buyer_id', '=', 'buyer_reviews.review_buyer_id')
        // ->where('buyer_reviews.review_prod_id', '=', $rev->prod_id)
        // ->get();
        $ratings_sel_pro[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$rev->prod_id."'");
      }
  
      $ratings_seller = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_seller_id = $id");
      
      
        return view('selleraccount')->with(['users' => $users, 'cover' => $SellerImage, 'title' =>$title, 'category'=>$category, 'ratings_sel_pro' => $ratings_sel_pro, 'ratings_seller' => $ratings_seller,'text'=> 'Active']);
    
  }

  public function sellerinactiveproduct(){
    $category = DB::table('category')->take(10)->get();
    $id = Crypt::decryptString($_COOKIE['UserIds']);
    $title = Crypt::decryptString($_COOKIE['UserCompName']);
    
    $users = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id AND u.prod_status = 'Inactive' ORDER BY pro_id ASC LIMIT 1 ) where u.prod_seller_id = $id");
    $SellerImage = SellerUser::where('s_id', '=', [$id])->get();
    
    $ratings_sel_pro = [];
    foreach($users as $rev){
      // $review[] = DB::table('buyer_reviews')
      // ->leftJoin('buyer_users', 'buyer_users.buyer_id', '=', 'buyer_reviews.review_buyer_id')
      // ->where('buyer_reviews.review_prod_id', '=', $rev->prod_id)
      // ->get();
      $ratings_sel_pro[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$rev->prod_id."'");
    }

    $ratings_seller = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_seller_id = $id");
    
    
      return view('selleraccount')->with(['users' => $users, 'cover' => $SellerImage, 'title' =>$title, 'category'=>$category, 'ratings_sel_pro' => $ratings_sel_pro, 'ratings_seller' => $ratings_seller,'text'=> 'Inactive']);
  
}

public function sellerAllDraftProduct(){
  $category = DB::table('category')->take(10)->get();
  $id = Crypt::decryptString($_COOKIE['UserIds']);
  $title = Crypt::decryptString($_COOKIE['UserCompName']);
  
  $users = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id AND u.prod_draft_status = '1' ORDER BY pro_id ASC LIMIT 1 ) where u.prod_seller_id = $id");
  $SellerImage = SellerUser::where('s_id', '=', [$id])->get();
  
  $ratings_sel_pro = [];
  foreach($users as $rev){
    // $review[] = DB::table('buyer_reviews')
    // ->leftJoin('buyer_users', 'buyer_users.buyer_id', '=', 'buyer_reviews.review_buyer_id')
    // ->where('buyer_reviews.review_prod_id', '=', $rev->prod_id)
    // ->get();
    $ratings_sel_pro[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$rev->prod_id."'");
  }

  $ratings_seller = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_seller_id = $id");
  
  
    return view('selleraccount')->with(['users' => $users, 'cover' => $SellerImage, 'title' =>$title, 'category'=>$category, 'ratings_sel_pro' => $ratings_sel_pro, 'ratings_seller' => $ratings_seller,'text'=> 'Draft']);

}

public function sellerSoldProduct(){
  $category = DB::table('category')->take(10)->get();
  $id = Crypt::decryptString($_COOKIE['UserIds']);
  $title = Crypt::decryptString($_COOKIE['UserCompName']);
  
  $users = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id AND u.prod_quantity = '0' AND u.prod_draft_status = '0' ORDER BY pro_id ASC LIMIT 1 ) where u.prod_seller_id = $id");
  $SellerImage = SellerUser::where('s_id', '=', [$id])->get();
  
  $ratings_sel_pro = [];
  foreach($users as $rev){
    // $review[] = DB::table('buyer_reviews')
    // ->leftJoin('buyer_users', 'buyer_users.buyer_id', '=', 'buyer_reviews.review_buyer_id')
    // ->where('buyer_reviews.review_prod_id', '=', $rev->prod_id)
    // ->get();
    $ratings_sel_pro[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$rev->prod_id."'");
  }

  $ratings_seller = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_seller_id = $id");
  
  
    return view('selleraccount')->with(['users' => $users, 'cover' => $SellerImage, 'title' =>$title, 'category'=>$category, 'ratings_sel_pro' => $ratings_sel_pro, 'ratings_seller' => $ratings_seller, 'text'=> 'Sold']);

}
    
}
