<?php

namespace App\Http\Controllers;
use App\SellerUser;
use App\Product;
use App\Orders;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Stripe;
use Mail;
use App\Clients\PayPalClient;
use Exception;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\InputFields;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\WebProfile;


class homeAllProdController extends Controller
{

   public function comingsoon($id) {
   
    return view('comingsoon')->with(['name' => $id]);
    }

    public function trackParcel($id, $title) {
      $category = DB::table('category')->take(10)->get();
      // aftership api for tracking data
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,"https://api.aftership.com/v4/trackings/?tracking_number=" . $id);
      // curl_setopt($ch, CURLOPT_POST, 1);
      // curl_setopt($ch, CURLOPT_POSTFIELDS,$vars);  //Post Fields
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $headers = [
          'Content-Type: application/json',
          'aftership-api-key: a7dda32b-038d-4413-a289-612c261c0d45'
      ];

      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      $server_output = curl_exec ($ch);

      curl_close ($ch);

      // echo '<pre>';
      // var_dump($server_output);
      // die();

      
      //-----------------
      return view('tracking_parcel')->with(['category'=> $category, 'tracking_no'=> $id, 'tracking_title'=> $title, 'server_output'=> json_decode($server_output)]);
      }
    
  public function viewHome() {

    try{

      if(isset($_COOKIE['MemberEmail'])){
        return redirect('/member');
      }

      $category = DB::table('category')
                  ->orderBy('cate_title', 'ASC')
                  ->get();

      
      $featured = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id AND u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active' AND u.prod_apprve_status = '1' AND u.prod_featured_status = '1' ORDER BY pro_id ASC LIMIT 1 )");

      $ratings_featured = [];
      foreach($featured as $ftrd){
        
        $ratings_featured[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$ftrd->prod_id."' AND review_status='1'");

        }

       $newArrivals = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id AND u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active' AND u.prod_apprve_status = '1' ORDER BY pro_id ASC LIMIT 1 )GROUP BY u.prod_cate_id ORDER BY u.prod_date_time DESC LIMIT 12");

       $ratings_new = [];
       foreach($newArrivals as $rev){
        
         $ratings_new[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$rev->prod_id."' AND review_status='1'");
          
        
       }

       $allProd = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id AND u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active' AND u.prod_apprve_status = '1' AND u.prod_cate_id = '2'  ORDER BY pro_id ASC LIMIT 1 )LIMIT 4");

       $ratings_all = [];
       foreach($allProd as $rev){
        
         $ratings_all[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$rev->prod_id."' AND review_status='1' ");
          
        
       }

        $bannerProd = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id IN (1,2)");

        $sporsProd = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = '3' ORDER BY u.prod_id DESC LIMIT 4");

        $elecProd = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = '1' ORDER BY u.prod_id DESC LIMIT 4");

        $clothingProd = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = '2' ORDER BY u.prod_id DESC LIMIT 4");

        $webreview = DB::table('website_review')
                    ->leftJoin('seller_users', 'seller_users.s_id', '=', 'website_review.review_user_id')
                    ->where('website_review.review_status', '=', '1')
                    ->get();


        return view('index')->withTitle('E-COMMERCE STORE | SHOP')->with(['featured' => $featured,'newArrivals' => $newArrivals, 'category' => $category, 'allProd' => $allProd, 'bannerProd' => $bannerProd, 'sporsProd' => $sporsProd, 'elecProd' => $elecProd, 'clothingProd' => $clothingProd, 'ratings_all' => $ratings_all, 'ratings_new' => $ratings_new, 'ratings_featured' => $ratings_featured, 'webreview' => $webreview]);

    }catch(\Throwable $th){
      return $th->getMessage();
    }
    
      
   }

     public function index() {
    

      $category = DB::table('category')->take(10)->get();
       $users = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 )");

        return view('home')->withTitle('E-COMMERCE STORE | SHOP')->with(['users' => $users, 'category' => $category
      ]);
   }

   public function currency($id){

      $category = DB::table('category')->take(10)->get();
        
      Session::put('Currency', $id);


       $newArrivals = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) ORDER BY u.prod_id DESC LIMIT 10");

       $allProd = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) ");

       

        $bannerProd = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id IN (1,2)");

        $sporsProd = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = '3' ORDER BY u.prod_id DESC LIMIT 4");

        $elecProd = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = '1' ORDER BY u.prod_id DESC LIMIT 4");

        $clothingProd = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = '2' ORDER BY u.prod_id DESC LIMIT 4");
     

         return view('index')->withTitle('E-COMMERCE STORE | SHOP')->with(['newArrivals' => $newArrivals, 'category' => $category, 'allProd' => $allProd, 'bannerProd' => $bannerProd, 'sporsProd' => $sporsProd, 'elecProd' => $elecProd, 'clothingProd' => $clothingProd
      ]);
    }

   public function viewSearch() {
      $category = DB::table('category')->take(10)->get();
       $users = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id  ORDER BY pro_id ASC LIMIT 1 )");

        return view('searchproduct')->withTitle('E-COMMERCE STORE | SHOP')->with(['users' => $users, 'category' => $category
      ]);
   }

    public function search(Request $request) {

      $category = DB::table('category')->take(10)->get();

      
      $search = $request->input('search');

      

     $users = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 )WHERE MATCH(u.prod_title,u.prod_long_desc) AGAINST('".$search."' IN NATURAL LANGUAGE MODE)  AND u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active'");

     $perPage = 20;
      $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
      $startAt = $perPage * ($page - 1);

     if($request->input('amount') || $request->input('condition')) {
      $condition = $request->input('condition');
      $searchact = $request->input('searchact');

      
      $price_ten = $request->input('price_ten');
      $amount_rem = str_replace('$', '', $request->input('amount'));
      $explode = explode('-', $amount_rem);

      $query = "SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 )WHERE MATCH(u.prod_title,u.prod_long_desc) AGAINST('".$searchact."' IN NATURAL LANGUAGE MODE) ";
      
      if(isset($explode)) {
        $query .= "AND u.prod_price BETWEEN $explode[0] AND $explode[1] ";
      } 
      if(isset($condition)) {
        $impcond = implode("','",$condition);
        $query .= "AND u.prod_cndtn IN ( '".$impcond."') ";
      }  
      if($request->input('out')) {
        $query .= "AND u.prod_quantity > 0 ";
      } 

      


      $users = DB::select($query . "LIMIT $startAt, $perPage");

      

      $users_count = DB::select("SELECT u.prod_id, p.pro_id FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 )LIMIT 200");
      
      
       
        //$users = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = $id AND (u.prod_cndtn = '".$condition."' OR u.prod_cndtn = '".$condition_used."') LIMIT $startAt, $perPage");
      
      

    } 

       $ratings_cat = [];
      foreach($users as $rev){
       
        $ratings_cat[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$rev->prod_id."' AND review_status='1'");
         
       
      }

//        SELECT * FROM products WHERE MATCH(prod_title)
// AGAINST('apple' IN NATURAL LANGUAGE MODE);

        return view('searchproduct')->withTitle('E-COMMERCE STORE | SHOP')->with(['users' => $users, 'search' => $search, 'category' => $category, 'ratings_cat' => $ratings_cat]);
   }
 

    public function category($id,$catTitle, Request $request) {

      $category = DB::table('category')->get();

      $subcategory = DB::select("SELECT * FROM sub_category WHERE sub_cate_cate_id = $id");

      
      //paginate
      $perPage = 200;
      $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
      $startAt = $perPage * ($page - 1);


      if($id == '37'){
        if($request->input('amount') || $request->input('condition')) {
          $condition = $request->input('condition');
  
          
          $price_ten = $request->input('price_ten');
          $amount_rem = str_replace('$', '', $request->input('amount'));
          $explode = explode('-', $amount_rem);
  
          $query = "SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active'";
          
          if(isset($explode)) {
            $query .= "AND u.prod_price BETWEEN $explode[0] AND $explode[1] ";
          } 
          if(isset($condition)) {
            $impcond = implode("','",$condition);
            $query .= "AND u.prod_cndtn IN ( '".$impcond."') ";
          }  
          if($request->input('out')) {
            $query .= "AND u.prod_quantity > 0 ";
          } 
  
          
  
  
          $users = DB::select($query . "LIMIT $startAt, $perPage");
  
          
  
          $users_count = DB::select("SELECT u.prod_id, p.pro_id FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) LIMIT 200");
          
          
           
            //$users = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = $id AND (u.prod_cndtn = '".$condition."' OR u.prod_cndtn = '".$condition_used."') LIMIT $startAt, $perPage");
          
          
  
        } else {
          $users_count = DB::select("SELECT u.prod_id, p.pro_id FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) LIMIT 200");
    
          $users = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) AND u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active' LIMIT $startAt, $perPage");
        }

      } else { 

      

      //filter
      if($request->input('amount') || $request->input('condition')) {
        $condition = $request->input('condition');

        
        $price_ten = $request->input('price_ten');
        $amount_rem = str_replace('$', '', $request->input('amount'));
        $explode = explode('-', $amount_rem);

        $query = "SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = $id AND u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active'";
        
        if(isset($explode)) {
          $query .= "AND u.prod_price BETWEEN $explode[0] AND $explode[1] ";
        } 
        if(isset($condition)) {
          $impcond = implode("','",$condition);
          $query .= "AND u.prod_cndtn IN ( '".$impcond."') ";
        }  
        if($request->input('out')) {
          $query .= "AND u.prod_quantity > 0 ";
        } 

        


        $users = DB::select($query . "LIMIT $startAt, $perPage");

        

        $users_count = DB::select("SELECT u.prod_id, p.pro_id FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = $id LIMIT 200");
        
        
         
          //$users = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = $id AND (u.prod_cndtn = '".$condition."' OR u.prod_cndtn = '".$condition_used."') LIMIT $startAt, $perPage");
        
        

      } else {
        $users_count = DB::select("SELECT u.prod_id, p.pro_id FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = $id LIMIT 200");
  
        $users = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = $id AND u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active' LIMIT $startAt, $perPage");
      }

    }
      

      //end filter

      $totalPages = ceil(count($users_count) / $perPage);   

      $ratings_cat = [];
      foreach($users as $rev){
        // $review[] = DB::table('buyer_reviews')
        // ->leftJoin('buyer_users', 'buyer_users.buyer_id', '=', 'buyer_reviews.review_buyer_id')
        // ->where('buyer_reviews.review_prod_id', '=', $rev->prod_id)
        // ->get();
        $ratings_cat[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$rev->prod_id."' AND review_status='1'");
         
       
      }

      
        return view('home',['users'=>$users, 'category' => $category, 'catetitle' => $catTitle, 'ratings_cat' => $ratings_cat, 'totalPages' => $totalPages, 'page'=> $page, 'subcategory'=> $subcategory]);
      
     
       
   }

   public function subcategory($id,$cat_id,$subTitle, Request $request) {

    $category = DB::table('category')->take(10)->get();

    $subcategory = DB::select("SELECT * FROM sub_category WHERE sub_cate_cate_id = $cat_id");

    $catetitle = DB::select("SELECT * FROM category WHERE cate_id = $cat_id");

    
    
    //paginate
    $perPage = 200;
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    $startAt = $perPage * ($page - 1);

    //filter
    if($request->input('amount') || $request->input('condition')) {
      $condition = $request->input('condition');
      
      $price_ten = $request->input('price_ten');
      $amount_rem = str_replace('$', '', $request->input('amount'));
      $explode = explode('-', $amount_rem);

      $query = "SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_sub_cate_id = $id AND u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active'";
      
      if(isset($explode)) {
        $query .= "AND u.prod_price BETWEEN $explode[0] AND $explode[1] ";
      } 
      if(isset($condition)) {
        $impcond = implode("','",$condition);
          $query .= "AND u.prod_cndtn IN ( '".$impcond."') ";
      }  
      if($request->input('out')) {
        $query .= "AND u.prod_quantity > 0 ";
      } 


      $users = DB::select($query . "LIMIT $startAt, $perPage");

      

      $users_count = DB::select("SELECT u.prod_id, p.pro_id FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_sub_cate_id = $id LIMIT 200");
      
      
       
        //$users = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = $id AND (u.prod_cndtn = '".$condition."' OR u.prod_cndtn = '".$condition_used."') LIMIT $startAt, $perPage");
      
      

    } else {
      $users_count = DB::select("SELECT u.prod_id, p.pro_id FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_sub_cate_id = $id LIMIT 200");

      $users = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_sub_cate_id = $id AND u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active' LIMIT $startAt, $perPage");
    }
    

    //end filter

    $totalPages = ceil(count($users_count) / $perPage);   

    $ratings_cat = [];
    foreach($users as $rev){
      // $review[] = DB::table('buyer_reviews')
      // ->leftJoin('buyer_users', 'buyer_users.buyer_id', '=', 'buyer_reviews.review_buyer_id')
      // ->where('buyer_reviews.review_prod_id', '=', $rev->prod_id)
      // ->get();
      $ratings_cat[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$rev->prod_id."' AND review_status='1'");
       
     
    }

    
   
     return view('subcategory',['users'=>$users, 'category' => $category, 'subtitle' => $subTitle, 'catetitle' => $catetitle, 'subcategory' => $subcategory,'ratings_cat' => $ratings_cat, 'totalPages' => $totalPages, 'page'=> $page, 'cat_id'=> $cat_id]);
 }

    public function sellerProduct($id,$title){
      $category = DB::table('category')->take(10)->get();

      $users = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_seller_id = $id");
      $SellerImage = SellerUser::where('s_id', '=', [$id])->get();
      $ratings_sel_pro = [];
      foreach($users as $rev){
        // $review[] = DB::table('buyer_reviews')
        // ->leftJoin('buyer_users', 'buyer_users.buyer_id', '=', 'buyer_reviews.review_buyer_id')
        // ->where('buyer_reviews.review_prod_id', '=', $rev->prod_id)
        // ->get();
        $ratings_sel_pro[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$rev->prod_id."' AND review_status='1'");
      }

      $ratings_seller = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_seller_id = $id");
      
      
        return view('view_seller_product')->with(['users' => $users, 'cover' => $SellerImage, 'category'=>$category, 'title' => $title, 'ratings_sel_pro' => $ratings_sel_pro, 'ratings_seller' => $ratings_seller]);
    
  }

   public function variationPrice(Request $request){

      $category = DB::table('category')->take(10)->get();

       
       $data = DB::select('select var_price from variations where var_prod_id= "'.$request->input("prod_id").'" and var_value = "'.$request->input('str').'"');

       

    return response()->json(array('msg'=> $data), 200);
    
  }

    public function productDetails($id) {
      $user = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_id = '".$id."'");

      $quantity = DB::table('products')->select('prod_quantity','prod_status')->where('prod_id', $id)->first();
      $prodQuantity = $quantity->prod_quantity;
      $prodStatus = $quantity->prod_status;

       

       $review = DB::table('buyer_reviews')
                ->leftJoin('seller_users', 'seller_users.s_id', '=', 'buyer_reviews.review_buyer_id')
                ->where('buyer_reviews.review_prod_id', '=', $id)
                ->where('buyer_reviews.review_status', '=', '1')
                ->get();

       $seller = DB::table('products')
                ->leftJoin('seller_users', 'seller_users.s_id', '=', 'products.prod_seller_id')
                ->where('products.prod_id', '=', $id)
                ->get();

      $ratings = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$id."' AND review_status='1'");


      $result = DB::table('products')->select('prod_cate_id')->where('prod_id', $id)->first();
      $catId = $result->prod_cate_id;
      
      if(isset($_COOKIE['UserIds'])) {
        $watch = DB::select("SELECT watch_id FROM watchlist WHERE watch_user_id = '".Crypt::decryptString($_COOKIE['UserIds'])."' AND watch_prod_id = '".$id."'");
      } else {
        $watch = array();
      }
      

    

      $category = DB::table('category')
                ->where('cate_id', '=', $catId)
                ->get();

      $attributes = DB::table('variations')
                ->where('var_prod_id', '=', $id)
                ->get();

      $prodImg = DB::table('pro_images')
                ->where('prod_img_prod_id', '=', $id)
                ->get();

        
      $relPro =   DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = $catId AND u.prod_id NOT IN ('".$id."') AND u.prod_live_status = '1' AND u.prod_status = 'Active' LIMIT 4");
      $ratings_rel = [];
      foreach($relPro as $rev){
        // $review[] = DB::table('buyer_reviews')
        // ->leftJoin('buyer_users', 'buyer_users.buyer_id', '=', 'buyer_reviews.review_buyer_id')
        // ->where('buyer_reviews.review_prod_id', '=', $rev->prod_id)
        // ->get();
        $ratings_rel[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$rev->prod_id."' AND review_status='1'");
         
       
      }
      
      
      return view('view_prod_dtls',['user'=>$user[0], 'relPro'=>$relPro, 'prodImg'=>$prodImg, 'category'=>$category, 'review'=>$review, 'ratings'=>$ratings, 'seller'=>$seller, 'prodQuantity'=>$prodQuantity,'prodStatus'=>$prodStatus,'attributes'=>$attributes, 'watch'=>$watch, 'ratings_rel'=> $ratings_rel]);
   }

     public function cart(Request $request)  {

      $category = DB::table('category')->take(10)->get();

      if($request->input('var') != '') {
        $variation = DB::select("SELECT var_price,var_quantity FROM variations WHERE var_prod_id = ? AND var_value = ?",[$request->input('prod_id'), $request->input('var')]);
        if($request->input('quantity') <= $variation[0]->var_quantity){
          \Cart::add(array(
             'id' => $request->input('prod_id'),
            'name' => $request->input('name'),
            'price' => $variation[0]->var_price,
            'quantity' => $request->input('quantity'),
            'dlvry_days' => $request->input('dlvrydays'),
            'attributes' => array('prodcartimg' => $request->input('prod_img') , 'sellerid' => $request->input('sellerid'), 'variation'=> $request->input('var'), 'dlvry_days' => $request->input('dlvrydays') )
            
        ));
        } else{

          return redirect('/p/' . $request->input('prod_id') . '?key=Your Requested Quantity Not In Stock.Please Choose Less Quantity');
        }


        
      } else {
        $product =  DB::select("SELECT prod_quantity FROM products WHERE prod_id = ?",[$request->input('prod_id')]);
        if($request->input('quantity') <= $product[0]->prod_quantity){
        \Cart::add(array(
             'id' => $request->input('prod_id'),
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
            'attributes' => array('prodcartimg' => $request->input('prod_img') , 'sellerid' => $request->input('sellerid'), 'variation'=> $request->input('var'), 'dlvry_days' => $request->input('dlvrydays') )
            
        ));
      }else {
          return redirect('/p/' . $request->input('prod_id') . '?key=Your Requested Quantity Not In Stock.Please Choose Less Quantity');
      }
    }

      
        $cartCollection = \Cart::getContent();


        
       return view('cart')->withTitle('E-COMMERCE STORE | CART')->with(['cartCollection' => $cartCollection, 'category'=>$category]);;
    }

    public function update(Request $request){

      $category = DB::table('category')->take(10)->get();

        \Cart::update($request->id,
            array(

                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
        ));

        
       $cartCollection = \Cart::getContent();
    
        return view('cart')->with(['cartCollection' => $cartCollection, 'category'=>$category]);
    }

    public function remove($id){
      
      $category = DB::table('category')->take(10)->get();

         \Cart::remove($id);
         $cartCollection = \Cart::getContent();
    
        return view('cart')->with(['cartCollection' => $cartCollection, 'category'=>$category]);
    }

    public function checkout(Request $request){
      
      $category = DB::table('category')->take(10)->get();

       if(!isset($_COOKIE['UserIds'])){
            return view('buyerlogin')->with(['category'=>$category]);
        }else{ 

      $data = DB::select('select * from buyer_addresses where buyer_del_add_buy_id="'.Crypt::decryptString($_COOKIE['UserIds']).'" AND make_primary="1"');

      $address = DB::select('select * from buyer_addresses where buyer_del_add_buy_id="'.Crypt::decryptString($_COOKIE['UserIds']).'"');

        
        $cartCollection = \Cart::getContent();


        return view('checkout')->with(['cartCollection' => $cartCollection,'data' => $data,'address' => $address, 'category'=>$category]);
      }
    }

    public function memberCheckout(Request $request){

      try{

        $category = DB::table('category')->take(10)->get();

       if(!isset($_COOKIE['MemberUserIds'])){
            return view('memberlogin')->with(['category'=>$category]);
        }else{ 

      $data = DB::select('select * from buyer_addresses where buyer_del_add_buy_id="'.Crypt::decryptString($_COOKIE['MemberUserIds']).'" AND make_primary="1"');

      $address = DB::select('select * from buyer_addresses where buyer_del_add_buy_id="'.Crypt::decryptString($_COOKIE['MemberUserIds']).'"');
        
        $cartCollection = \Cart::getContent();


        return view('membercheckout')->with(['cartCollection' => $cartCollection,'data' => $data,'address' => $address, 'category'=>$category]);
      }

      }catch(\Throwable $th){
        return $th->getMessage();
    }
      
      
    }

    public function watchlist($p_id){
      if(isset($_COOKIE['UserIds'])) {
        $category = DB::table('category')->take(10)->get();
      $day = date('YmdHis');

      DB::insert('insert into watchlist(watch_user_id, watch_prod_id, watch_date_time) values (?, ?,?)', [Crypt::decryptString($_COOKIE['UserIds']), $p_id, $day]);

      return redirect('/p/' . $p_id)->with(['category'=>$category]);
    } else {
       $category = DB::table('category')->take(10)->get();
      return redirect('/p/' . $p_id)->with(['category'=>$category]);
    }
      
    }

    public function viewWatchlist(){
      if(isset($_COOKIE['UserIds'])) {
        $category = DB::table('category')->take(10)->get();

        $users = DB::select("SELECT u.*, p.*,w.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) INNER JOIN watchlist w ON (u.prod_id = w.watch_prod_id) where w.watch_user_id = '".Crypt::decryptString($_COOKIE['UserIds'])."'");
        
        $ratings_sel_pro = [];
        foreach($users as $rev){
          // $review[] = DB::table('buyer_reviews')
          // ->leftJoin('buyer_users', 'buyer_users.buyer_id', '=', 'buyer_reviews.review_buyer_id')
          // ->where('buyer_reviews.review_prod_id', '=', $rev->prod_id)
          // ->get();
          $ratings_sel_pro[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$rev->prod_id."' AND review_status='1'");
        }
      return view('watchlist')->with(['category'=>$category, 'users'=>$users, 'ratings_sel_pro'=>$ratings_sel_pro]);
    } else {
       $category = DB::table('category')->get();
      return redirect('/buyerlogin')->with(['category'=>$category]);
    }
      
    }



    public function removeWatchlist($p_id){
      
      $category = DB::table('category')->take(10)->get();

      DB::table('watchlist')
      ->where('watch_user_id', Crypt::decryptString($_COOKIE['UserIds']))
      ->where('watch_prod_id', $p_id)
      ->delete();

      return redirect('/p/' . $p_id)->with(['category'=>$category]);
    }

    public function stripePost(Request $request)
    {
      $category = DB::table('category')->take(10)->get();

      $cartCollection = \Cart::getContent();
      
      $amount = \Cart::getTotal();
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $test = Stripe\Charge::create ([
                "amount" => $amount * 100,
                "currency" => "AUD",
                "source" => $request->stripeToken,
                "receipt_email" =>Crypt::decryptString($_COOKIE['UserEmail']),
                "description" => "Buy&Sell Shopping"
        ]);
        
      
      if($test->status == 'succeeded'){
        Session::flash('success', 'Payment successful!');
       
        $day = date('YmdHis');
        $uniqid =  $day . uniqid();
        $mail= Crypt::decryptString($_COOKIE['UserEmail']);
        $mailunq = $mail . $uniqid; 
        $orduniqid = hash('sha256', $mailunq);

        $buyerId= Crypt::decryptString($_COOKIE['UserIds']);
        $buyerDelvryAdd= $request->input('delvryadd');
       
      
      $arr=[];

       foreach($cartCollection as $cartinsrt){
         if($cartinsrt->attributes->variation != '') {
          $variationstr = $cartinsrt->attributes->variation;  
        }
        $sellerComission = DB::select('select * from seller_payments where payment_prod_id="'.$cartinsrt->id.'"');
        if(count($sellerComission) == '0'){
          $comission= ($cartinsrt->price * 1.75) / 100;
          if($comission >= 25){
            $comission = 25;
          } else {
            $comission = $comission;
          }
           DB::insert('insert into seller_payments(payment_prod_id, payment_sellr_id, payment_amount) values (?, ?,?)', [$cartinsrt->id, $cartinsrt->attributes->sellerid, $comission]);
        }

        $cart_info = new Orders(); 
        $cart_info->ord_buyer_id = $buyerId;
        $cart_info->order_prod_id = $cartinsrt->id;
        $cart_info->ord_quantity = $cartinsrt->quantity;
        $cart_info->ord_seller_id = $cartinsrt->attributes->sellerid;
        if($cartinsrt->attributes->variation != '') {
          $cart_info->ord_variation = $variationstr;
        }

        $cart_info->ord_uniq_id = 'BES_'. md5($orduniqid . $cartinsrt->id);
        $cart_info->ord_amount = $cartinsrt->price;
        $cart_info->ord_currency = 'AUD';
        $cart_info->ord_payment_id = $test->id;
        $cart_info->ord_payment_trnsctn_id = $test->balance_transaction;
        $cart_info->ord_reciept_url = $test->receipt_url;
        if(count($sellerComission) == '0'){
          $cart_info->ord_paid_amount = ($cartinsrt->price * $cartinsrt->quantity) - $comission;
        } else{
           $cart_info->ord_paid_amount = $cartinsrt->price * $cartinsrt->quantity;
        }
       
        $cart_info->ord_delivery_add = $buyerDelvryAdd;
        $cart_info->save();
    Product::where('prod_id',  $cartinsrt->id)->decrement('prod_quantity', $cartinsrt->quantity);
 DB::table('variations')
    ->where('var_prod_id', $cartinsrt->id)
    ->where('var_value', $cartinsrt->ord_variation)
    ->decrement('var_quantity', $cartinsrt->quantity);

$arr[]=array(
  'order_id'=> $cart_info->ord_uniq_id,
  'order_total'=> $cart_info->ord_amount,
  'order_dlvry_add'=> $cart_info->ord_delivery_add,
  'order_prod_title'=> $cartinsrt->name,
  'order_prod_image'=> $cartinsrt->attributes->prodcartimg,
  'order_prod_quantity'=> $cartinsrt->quantity,
  'order_dlvry_days'=> $cartinsrt->attributes->dlvry_days
);



       }

       
      
       setcookie("BuyerDelvryAdd", "", time() - 3600);
       \Cart::clear();

       ;
      //dd($arr[0]['order_id']);
       
       Mail::send(['html'=>'email_order_cofirm'], ['order_dtls'=>$arr], function($message) use ($mail, $arr)  {
        $message->to($mail)->subject
           ('Your Buy&Sell Order Confirmation');
        $message->from('no-reply@wwwmedia.world','Buy & Sell');
     });

     $selmail= DB::Select("Select email From seller_users WHERE s_id= $cart_info->ord_seller_id");

     $mailsel=$selmail[0]->email;

     Mail::send(['html'=>'email_seller_ordr'], ['order_dtls'=>$arr], function($message) use ($mailsel, $arr)  {
      $message->to($mailsel)->subject
         ('You have a new order');
      $message->from('no-reply@wwwmedia.world','Buy & Sell');
    });

       return redirect('/buyerorders');
      } else {
        Session::flash('Failed', $test->failure_message); 
      }
       
      
      
       
    }


    public function newArrivals(Request $request) {
      $category = DB::table('category')->get();
    
      $offset = ($request->input('q') ?  $request->input('q') : '0');

      $limit = 21;

      $newArrivals = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id AND u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active' AND u.prod_apprve_status = '1' ORDER BY pro_id ASC LIMIT 1 ) ORDER BY u.prod_date_time DESC limit $offset, $limit");

      $ratings_new = [];
      foreach($newArrivals as $rev){
        $ratings_new[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$rev->prod_id."' AND review_status='1'");
      }

      $next = $offset + $limit;
      $prev = $offset - $limit;

      return view('view_all')->with(['newArrivals' => $newArrivals, 'category' => $category, 'ratings_new' => $ratings_new, 'next' => $next, 'prev' => $prev]);
    }

    public function filtersView($text,Request $request) {

      try{
      $category = DB::table('category')->get();
    
      $offset = ($request->input('q') ?  $request->input('q') : '0');

      $limit = 21;

      
      
      if($text == 'Alphabetical Order'){

        $newArrivals = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id AND u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active' AND u.prod_apprve_status = '1' ORDER BY pro_id ASC LIMIT 1 ) ORDER BY u.prod_title ASC limit $offset, $limit");

        $ratings_new = [];
        foreach($newArrivals as $rev){
          $ratings_new[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$rev->prod_id."' AND review_status='1'");
        }

      }

      elseif($text == 'Lowest To Highest Price'){

        $newArrivals = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id AND u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active' AND u.prod_apprve_status = '1' ORDER BY pro_id ASC LIMIT 1 ) ORDER BY u.prod_price ASC limit $offset, $limit");

        $ratings_new = [];
        foreach($newArrivals as $rev){
          $ratings_new[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$rev->prod_id."' AND review_status='1'");
        }
        
      }

      elseif($text == 'Highest To Lowest Price'){

        $newArrivals = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id AND u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active' AND u.prod_apprve_status = '1' ORDER BY pro_id ASC LIMIT 1 ) ORDER BY u.prod_price DESC limit $offset, $limit");

        $ratings_new = [];
        foreach($newArrivals as $rev){
          $ratings_new[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$rev->prod_id."' AND review_status='1'");
        }
        
      }

      

      $next = $offset + $limit;
      $prev = $offset - $limit;

      return view('filters')->with(['newArrivals' => $newArrivals, 'category' => $category, 'ratings_new' => $ratings_new, 'next' => $next, 'prev' => $prev,'text'=> $text]);
    }catch(\Throwable $th){
      return $th->getMessage();
    }
    }

    public function about() {
      return view('about');
    }


    public function memberProductDetails($id) {
      $user = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_id = '".$id."'");

      $quantity = DB::table('products')->select('prod_quantity','prod_status')->where('prod_id', $id)->first();
      $prodQuantity = $quantity->prod_quantity;
      $prodStatus = $quantity->prod_status;

       

       $review = DB::table('buyer_reviews')
                ->leftJoin('seller_users', 'seller_users.s_id', '=', 'buyer_reviews.review_buyer_id')
                ->where('buyer_reviews.review_prod_id', '=', $id)
                ->where('buyer_reviews.review_status', '=', '1')
                ->get();

       $seller = DB::table('products')
                ->leftJoin('seller_users', 'seller_users.s_id', '=', 'products.prod_seller_id')
                ->where('products.prod_id', '=', $id)
                ->get();

      $ratings = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$id."' AND review_status='1'");


      $result = DB::table('products')->select('prod_cate_id')->where('prod_id', $id)->first();
      $catId = $result->prod_cate_id;
      
      if(isset($_COOKIE['MemberEmail'])) {
        $watch = DB::select("SELECT watch_id FROM watchlist WHERE watch_user_id = '".Crypt::decryptString($_COOKIE['MemberEmail'])."' AND watch_prod_id = '".$id."'");
      } else {
        $watch = array();
      }
      

    

      $category = DB::table('category')
                ->where('cate_id', '=', $catId)
                ->get();

      $attributes = DB::table('variations')
                ->where('var_prod_id', '=', $id)
                ->get();

      $prodImg = DB::table('pro_images')
                ->where('prod_img_prod_id', '=', $id)
                ->get();

        
      $relPro =   DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_cate_id = $catId AND u.prod_id NOT IN ('".$id."') AND u.prod_live_status = '1' AND u.prod_status = 'Active' LIMIT 4");
      $ratings_rel = [];
      foreach($relPro as $rev){
        // $review[] = DB::table('buyer_reviews')
        // ->leftJoin('buyer_users', 'buyer_users.buyer_id', '=', 'buyer_reviews.review_buyer_id')
        // ->where('buyer_reviews.review_prod_id', '=', $rev->prod_id)
        // ->get();
        $ratings_rel[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$rev->prod_id."' AND review_status='1'");
         
       
      }
      
      
      return view('member_prod_details',['user'=>$user[0], 'relPro'=>$relPro, 'prodImg'=>$prodImg, 'category'=>$category, 'review'=>$review, 'ratings'=>$ratings, 'seller'=>$seller, 'prodQuantity'=>$prodQuantity,'prodStatus'=>$prodStatus,'attributes'=>$attributes, 'watch'=>$watch, 'ratings_rel'=> $ratings_rel]);
   }



   public function memberCart(Request $request)  {

    $category = DB::table('category')->take(10)->get();

    if($request->input('var') != '') {
      $variation = DB::select("SELECT var_price,var_quantity FROM variations WHERE var_prod_id = ? AND var_value = ?",[$request->input('prod_id'), $request->input('var')]);
      if($request->input('quantity') <= $variation[0]->var_quantity){
        \Cart::add(array(
           'id' => $request->input('prod_id'),
          'name' => $request->input('name'),
          'price' => $variation[0]->var_price,
          'quantity' => $request->input('quantity'),
          'dlvry_days' => $request->input('dlvrydays'),
          'attributes' => array('prodcartimg' => $request->input('prod_img') , 'sellerid' => $request->input('sellerid'), 'variation'=> $request->input('var'), 'dlvry_days' => $request->input('dlvrydays') )
          
      ));
      } else{

        return redirect('/m/' . $request->input('prod_id') . '?key=Your Requested Quantity Not In Stock.Please Choose Less Quantity');
      }


      
    } else {
      $product =  DB::select("SELECT prod_quantity FROM products WHERE prod_id = ?",[$request->input('prod_id')]);
      if($request->input('quantity') <= $product[0]->prod_quantity){
      \Cart::add(array(
           'id' => $request->input('prod_id'),
          'name' => $request->input('name'),
          'price' => $request->input('price'),
          'quantity' => $request->input('quantity'),
          'attributes' => array('prodcartimg' => $request->input('prod_img') , 'sellerid' => $request->input('sellerid'), 'variation'=> $request->input('var'), 'dlvry_days' => $request->input('dlvrydays') )
          
      ));
    }else {
        return redirect('/m/' . $request->input('prod_id') . '?key=Your Requested Quantity Not In Stock.Please Choose Less Quantity');
    }
  }

    
      $cartCollection = \Cart::getContent();


      
     return view('membercart')->withTitle('E-COMMERCE STORE | CART')->with(['cartCollection' => $cartCollection, 'category'=>$category]);;
  }

  public function removeMember($id){
      
    $category = DB::table('category')->take(10)->get();

       \Cart::remove($id);
       $cartCollection = \Cart::getContent();
  
      return view('membercart')->with(['cartCollection' => $cartCollection, 'category'=>$category]);
  }

  public function updateMember(Request $request){

    $category = DB::table('category')->take(10)->get();

      \Cart::update($request->id,
          array(

              'quantity' => array(
                  'relative' => false,
                  'value' => $request->quantity
              ),
      ));

      
     $cartCollection = \Cart::getContent();
  
      return view('membercart')->with(['cartCollection' => $cartCollection, 'category'=>$category]);
  }


  public function memberStripePost(Request $request)
    {
      try {
      $category = DB::table('category')->take(10)->get();

      $cartCollection = \Cart::getContent();
      
      $amount = \Cart::getTotal();
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $test = Stripe\Charge::create ([
                "amount" => $amount * 100,
                "currency" => "AUD",
                "source" => $request->stripeToken,
                "receipt_email" =>Crypt::decryptString($_COOKIE['MemberEmail']),
                "description" => "Buy&Sell Shopping"
        ]);
        
      
      if($test->status == 'succeeded'){
        Session::flash('success', 'Payment successful!');
       
        $day = date('YmdHis');
        $uniqid =  $day . uniqid();
        $mail= Crypt::decryptString($_COOKIE['MemberEmail']);
        $mailunq = $mail . $uniqid; 
        $orduniqid = hash('sha256', $mailunq);

        $buyerId= Crypt::decryptString($_COOKIE['MemberUserIds']);
        $buyerDelvryAdd= $request->input('delvryadd');
       
      
      $arr=[];

       foreach($cartCollection as $cartinsrt){
         if($cartinsrt->attributes->variation != '') {
          $variationstr = $cartinsrt->attributes->variation;  
        }
        $sellerComission = DB::select('select * from seller_payments where payment_prod_id="'.$cartinsrt->id.'"');
        if(count($sellerComission) == '0'){
          $comission= ($cartinsrt->price * 1.75) / 100;
          if($comission >= 25){
            $comission = 25;
          } else {
            $comission = $comission;
          }
           DB::insert('insert into seller_payments(payment_prod_id, payment_sellr_id, payment_amount) values (?, ?,?)', [$cartinsrt->id, $cartinsrt->attributes->sellerid, $comission]);
        }

        $cart_info = new Orders(); 
        $cart_info->ord_buyer_id = $buyerId;
        $cart_info->order_prod_id = $cartinsrt->id;
        $cart_info->ord_quantity = $cartinsrt->quantity;
        $cart_info->ord_seller_id = $cartinsrt->attributes->sellerid;
        if($cartinsrt->attributes->variation != '') {
          $cart_info->ord_variation = $variationstr;
        }

        $cart_info->ord_uniq_id = 'BES_'. md5($orduniqid . $cartinsrt->id);
        $cart_info->ord_amount = $cartinsrt->price;
        $cart_info->ord_currency = 'AUD';
        $cart_info->ord_payment_id = $test->id;
        $cart_info->ord_payment_trnsctn_id = $test->balance_transaction;
        $cart_info->ord_reciept_url = $test->receipt_url;
        if(count($sellerComission) == '0'){
          $cart_info->ord_paid_amount = ($cartinsrt->price * $cartinsrt->quantity) - $comission;
        } else{
           $cart_info->ord_paid_amount = $cartinsrt->price * $cartinsrt->quantity;
        }
       
        $cart_info->ord_delivery_add = $buyerDelvryAdd;
        $cart_info->save();
    Product::where('prod_id',  $cartinsrt->id)->decrement('prod_quantity', $cartinsrt->quantity);
 DB::table('variations')
    ->where('var_prod_id', $cartinsrt->id)
    ->where('var_value', $cartinsrt->ord_variation)
    ->decrement('var_quantity', $cartinsrt->quantity);

$arr[]=array(
  'order_id'=> $cart_info->ord_uniq_id,
  'order_total'=> $cart_info->ord_amount,
  'order_dlvry_add'=> $cart_info->ord_delivery_add,
  'order_prod_title'=> $cartinsrt->name,
  'order_prod_image'=> $cartinsrt->attributes->prodcartimg,
  'order_prod_quantity'=> $cartinsrt->quantity,
  'order_dlvry_days'=> $cartinsrt->attributes->dlvry_days
);



       }

       
      
       setcookie("MemberDelvryAdd", "", time() - 3600);
       \Cart::clear();

       ;
      //dd($arr[0]['order_id']);
       
    //    Mail::send(['html'=>'email_order_cofirm'], ['order_dtls'=>$arr], function($message) use ($mail, $arr)  {
    //     $message->to($mail)->subject
    //        ('Your Buy&Sell Order Confirmation');
    //     $message->from('no-reply@wwwmedia.world','Buy & Sell');
    //  });

     $selmail= DB::Select("Select email From seller_users WHERE s_id= $cart_info->ord_seller_id");

     $mailsel=$selmail[0]->email;

     Mail::send(['html'=>'email_seller_ordr'], ['order_dtls'=>$arr], function($message) use ($mailsel, $arr)  {
      $message->to($mailsel)->subject
         ('You have a new order');
      $message->from('no-reply@wwwmedia.world','Buy & Sell');
    });

       return redirect('/memberorders');
      } else {
        Session::flash('Failed', $test->failure_message); 
      }

    }catch(\Throwable $th){
      return $th->getMessage();
  }
}

  public function paypalSuccess(Request $request){
    try{

      $category = DB::table('category')->take(10)->get();

      $cartCollection = \Cart::getContent();
      
      $amount = \Cart::getTotal();
       
        $day = date('YmdHis');
        $uniqid =  $day . uniqid();
        $mail= Crypt::decryptString($_COOKIE['MemberEmail']);
        $mailunq = $mail . $uniqid; 
        $orduniqid = hash('sha256', $mailunq);

        $data = DB::select('select * from buyer_addresses where buyer_del_add_buy_id="'.Crypt::decryptString($_COOKIE['MemberUserIds']).'" AND make_primary="1"');

        $buyerId= Crypt::decryptString($_COOKIE['MemberUserIds']);
        $buyerDelvryAdd= $data[0]->buyer_del_address.','.$data[0]->buyer_del_city.','.$data[0]->buyer_del_state.','.$data[0]->buyer_del_postcode.','.$data[0]->buyer_del_country.',Contact no:'.$data[0]->buyer_del_phn_no.',E-mail:'.$data[0]->buyer_del_email;
       
      
      $arr=[];

       foreach($cartCollection as $cartinsrt){
         if($cartinsrt->attributes->variation != '') {
          $variationstr = $cartinsrt->attributes->variation;  
        }
        $sellerComission = DB::select('select * from seller_payments where payment_prod_id="'.$cartinsrt->id.'"');
        if(count($sellerComission) == '0'){
          $comission= ($cartinsrt->price * 1.75) / 100;
          if($comission >= 25){
            $comission = 25;
          } else {
            $comission = $comission;
          }
           DB::insert('insert into seller_payments(payment_prod_id, payment_sellr_id, payment_amount) values (?, ?,?)', [$cartinsrt->id, $cartinsrt->attributes->sellerid, $comission]);
        }

        $cart_info = new Orders(); 
        $cart_info->ord_buyer_id = $buyerId;
        $cart_info->order_prod_id = $cartinsrt->id;
        $cart_info->ord_quantity = $cartinsrt->quantity;
        $cart_info->ord_seller_id = $cartinsrt->attributes->sellerid;
        if($cartinsrt->attributes->variation != '') {
          $cart_info->ord_variation = $variationstr;
        }

        $cart_info->ord_uniq_id = 'BES_'. md5($orduniqid . $cartinsrt->id);
        $cart_info->ord_amount = $cartinsrt->price;
        $cart_info->ord_currency = 'AUD';
        $cart_info->ord_payment_id = $orduniqid;
        $cart_info->ord_payment_trnsctn_id = $orduniqid;
        $cart_info->ord_reciept_url = "paypal_transaction";
        if(count($sellerComission) == '0'){
          $cart_info->ord_paid_amount = ($cartinsrt->price * $cartinsrt->quantity) - $comission;
        } else{
           $cart_info->ord_paid_amount = $cartinsrt->price * $cartinsrt->quantity;
        }
       
        $cart_info->ord_delivery_add = $buyerDelvryAdd;
        $cart_info->save();
    Product::where('prod_id',  $cartinsrt->id)->decrement('prod_quantity', $cartinsrt->quantity);
 DB::table('variations')
    ->where('var_prod_id', $cartinsrt->id)
    ->where('var_value', $cartinsrt->ord_variation)
    ->decrement('var_quantity', $cartinsrt->quantity);

$arr[]=array(
  'order_id'=> $cart_info->ord_uniq_id,
  'order_total'=> $cart_info->ord_amount,
  'order_dlvry_add'=> $cart_info->ord_delivery_add,
  'order_prod_title'=> $cartinsrt->name,
  'order_prod_image'=> $cartinsrt->attributes->prodcartimg,
  'order_prod_quantity'=> $cartinsrt->quantity,
  'order_dlvry_days'=> $cartinsrt->attributes->dlvry_days
);



       }

       
      
       setcookie("MemberDelvryAdd", "", time() - 3600);
       \Cart::clear();

       ;
      //dd($arr[0]['order_id']);
       
    //    Mail::send(['html'=>'email_order_cofirm'], ['order_dtls'=>$arr], function($message) use ($mail, $arr)  {
    //     $message->to($mail)->subject
    //        ('Your Buy&Sell Order Confirmation');
    //     $message->from('no-reply@wwwmedia.world','Buy & Sell');
    //  });

     $selmail= DB::Select("Select email From seller_users WHERE s_id= $cart_info->ord_seller_id");

     $mailsel=$selmail[0]->email;

     Mail::send(['html'=>'email_seller_ordr'], ['order_dtls'=>$arr], function($message) use ($mailsel, $arr)  {
      $message->to($mailsel)->subject
         ('You have a new order');
      $message->from('no-reply@wwwmedia.world','Buy & Sell');
    });

       return redirect('/memberorders');
      


    }catch(\Throwable $th){
      return $th->getMessage();
  }
  
       
      
      
       
    }

   







    
} // end class
