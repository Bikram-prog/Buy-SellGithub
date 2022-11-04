<?php

namespace App\Http\Controllers;
use App\SellerUser;
use App\BuyerUser;
use App\ProImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;

class SellerLoginController extends Controller
{


    public function sellerHome(){
        $category = DB::table('category')->take(10)->get();
        return view('seller', ['category'=>$category]);
    }

    //  public function sellerProductVariation($id, $title){
    //     $category = DB::table('category')->take(10)->get();
    //     return view('product_variation', ['category'=>$category, 'id' => $id]);
    // }

    public function sellerProductVariation($id,$title){
      $category = DB::table('category')->take(10)->get();

      $attributes = DB::select('select * from attributes where att_prod_id = ? ', [$id]);

      return view('product_variation', ['category'=>$category, 'id' => $id, 'attributes' => $attributes]);
  }

     public function sellerVariation($id){
        $category = DB::table('category')->take(10)->get();

       $attributes = DB::select('select * from attributes where att_prod_id = ? ', [$id]);

       $variation = DB::select('select * from variations where var_prod_id = ? ', [$id]);


        return view('variation', ['category'=>$category, 'attributes'=>$attributes, 'variation'=>$variation, 'id' => $id]);
    }

    public function variationPost(Request $request) {
      $imp = implode("|", $request->input('var'));
        DB::insert('insert into variations (var_prod_id, var_value, var_quantity, var_price) values (?, ?, ?, ?)', [$request->input('prod_id'), $imp, $request->input('quantity'), $request->input('price')]);
        
      
        
      return redirect('/variation/' . $request->input('prod_id'));
      
      
    }

    public function sellerProductVariationAddt(Request $request) {
      $i = 0;

      if($request->input('key') != '') {
        foreach ($request->input('key') as $value) {
          DB::insert('insert into attributes (att_prod_id, att_key, att_value) values (?, ?, ?)', [$request->input('prod_id'), $value, $request->input('val')[$i]]);
          $i++;
        }
      } 

      
      return redirect('/prodattributes/' . $request->input('prod_id') . '/title');
      // return redirect('/variation/' . $request->input('prod_id') . '/title');
      
      
    }




     public function viewSignup(){
      
      $category = DB::table('category')->take(10)->get();

        return view('sellersignup',['category'=>$category]);
    }
    public function sellerSignup(Request $request){

      $category = DB::table('category')->take(10)->get();

      $register_info = new SellerUser(); 
        $register_info->name = request('name');
        $register_info->email   = request('email');
        $register_info->password = md5(request('password'));
        $register_info->seller_comp_name = request('comp_name');
        $register_info->seller_address = request('address');
        $register_info->seller_state  = request('state');
        $register_info->seller_country = request('country');
        $register_info->seller_city = request('city');
        $register_info->seller_postcode = request('pstcode');
        $register_info->seller_contct_no  = request('cntctno');

         $data = DB::select('select * from seller_users where email  =?',[request('email')]);
        if(count($data) == '1'){
          return view('sellersignup',['category'=>$category, 'msg'=>'This email already exist.']);

        } elseif(request('password') == request('repassword')){
            $register_info->save();

        $buyer_register_info = new BuyerUser(); 
        $buyer_register_info->buyer_f_name = request('name');
        $buyer_register_info->buyer_email  = request('email');
        $buyer_register_info->buyer_password = md5(request('password'));
        $buyer_register_info->save();

         return redirect('/sellerlogin')->with(['regsucmsg' => 'You have successfully registered.']);
      } else {
        //-------
      }    
    }

    public function viewSellerInfo(){
      
      $category = DB::table('category')->take(10)->get();

        return view('apply_seller',['category'=>$category]);
    }

    public function sellerInfoPost(Request $request){

      $category = DB::table('category')->take(10)->get();

      $id = Crypt::decryptString($_COOKIE['UserIds']);
    
      DB::table('seller_users')->where('s_id', $id )->update(['seller_comp_name' => $request->input('comp_name'), 'seller_address' => $request->input('address'), 'seller_state' => $request->input('state'), 'seller_country' => $request->input('country'), 'seller_city' => $request->input('city'), 'seller_postcode' => $request->input('postcode'), 'seller_contct_no' => $request->input('cntct_no')]);
      
      setcookie('UserCompName', Crypt::encryptString($request->input('comp_name')), time() + (86400 * 365), "/");

      return redirect('/addproduct')->with(['regsucmsg' => 'You have successfully registered.']);
        
    }


   public function viewLogin(){

      $category = DB::table('category')->take(10)->get();
    
        return view('seller_login',['category'=>$category]);
    }

     public function sellerLogin(){
        
        $login_info = new SellerUser();
        $login_info->email = request('email');
        $login_info->password = request('psw');
        $data = DB::select('select * from seller_users where email =? and password =? and seller_comp_name != ""',[request('email'),md5(request('psw'))]);
        if(count($data) == '1'){
          setcookie('UserEmail', Crypt::encryptString($data[0]->email), time() + (86400 * 365), "/");
          setcookie('UserFullName', Crypt::encryptString($data[0]->name), time() + (86400 * 365), "/");
          setcookie('UserIds', Crypt::encryptString($data[0]->s_id), time() + (86400 * 365), "/");
          setcookie('UserCompName', Crypt::encryptString($data[0]->seller_comp_name), time() + (86400 * 365), "/");
          return redirect('/sellerdashboard');
        }else{
       return redirect('/sellerlogin')->with('errrmessage','Please correct your information');
      } 
}


 public function imgUpload(){

        return view('img1');
    }

      public function fileStore(Request $request){

        $image = $request->file('file');
        $prodid = $request->input('data');
        $imageName = $image->getClientOriginalName();
        //$imageName = 'love.png';
        $image->move(public_path('images'),$imageName);
        
        $imageUpload = new ProImage();
        $imageUpload->prod_img_prod_id = $prodid;
        $imageUpload->pro_img_path = $imageName;
        $imageUpload->save();
        return response()->json(['success'=>$imageUpload]);
    }


    public function changeCoverPic() {
      $category = DB::table('category')->take(10)->get();
      $id = Crypt::decryptString($_COOKIE['UserIds']);
      $totalearning =  DB::select("SELECT SUM(ord_paid_amount) AS TotalIEarning FROM orders WHERE ord_seller_id = '".$id."' AND ord_status ='Delivered'");
      
      
      $ProImage = SellerUser::where('s_id', '=', [$id])->get();
      return view('/seller_img_upload')->with(['ProImage' => $ProImage, 'category' => $category, 'totalearning' => $totalearning]);
  }

  public function coverPicUpdate(Request $request){
        
    $image = $request->file('file');
    $imageName = $image->getClientOriginalName();
    $image->move(public_path('images'),$imageName);

    $id = Crypt::decryptString($_COOKIE['UserIds']);
    
    DB::table('seller_users')->where('s_id', $id )->update(['seller_cover_pic' => $imageName]);
    return redirect('/buyersettings');
  }

  public function sellerAccount(){
    $category = DB::table('category')->take(10)->get();
    $id = Crypt::decryptString($_COOKIE['UserIds']);
    $title = Crypt::decryptString($_COOKIE['UserCompName']);
    
    $users = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id ORDER BY pro_id ASC LIMIT 1 ) where u.prod_seller_id = $id AND u.prod_status != 'Inactive' ORDER BY pro_id DESC");
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
    
    
      return view('selleraccount')->with(['users' => $users, 'cover' => $SellerImage, 'title' =>$title, 'category'=>$category, 'ratings_sel_pro' => $ratings_sel_pro, 'ratings_seller' => $ratings_seller,'text'=> 'All Products']);
  
}

    public function logoutSeller() {
      setcookie("UserIds", "", time() - 3600);
      setcookie("UserEmail", "", time() - 3600);
      setcookie("UserFullName", "", time() - 3600);
      setcookie("UserCompName", "", time() - 3600);
        return redirect('/home');
    }



  
}
