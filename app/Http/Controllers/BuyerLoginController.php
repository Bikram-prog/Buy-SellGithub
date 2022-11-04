<?php

namespace App\Http\Controllers;
use App\SellerUser;
use App\BuyerUser;
use App\BuyerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Mail;


class BuyerLoginController extends Controller
{
    public function viewSignup(){
      $category = DB::table('category')->take(10)->get();

        return view('buyersignup',['category'=>$category]);
    }
    public function buyerSignup(Request $request){

      try{

        $category = DB::table('category')->take(10)->get();
        $register_info = new SellerUser(); 
        $register_info->name = request('name');
        $register_info->email  = request('email');
        $register_info->password = md5(request('password'));
        // $register_info->buyer_sex = request('gender'); 

        $data = DB::select('select * from seller_users where email  =?',[request('email')]);
        if(count($data) == '1'){
          return view('buyersignup',['category'=>$category, 'msg'=>'This email already exist.']);

        } elseif(request('password') == request('repassword')){
        $register_info->save();

        $buyer_info = new BuyerAddress(); 
        $buyer_info->buyer_del_phn_no = request('phn_no');
        $buyer_info->buyer_del_email = request('del_email');
        $buyer_info->buyer_del_address = request('address');
        $buyer_info->buyer_del_country = request('country');
        $buyer_info->buyer_del_city = request('city');
        $buyer_info->buyer_del_state = request('state');
        $buyer_info->buyer_del_postcode = request('postcode');
        $buyer_info->buyer_del_add_buy_id = $register_info->id;
        $buyer_info->make_primary = '1';
        $buyer_info->save();

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

         return redirect('/buyerlogin')->with(['regsucmsg' => 'Please check your email for verify your account.']);
      } else {
        //-------
      }

      } catch(\Throwable $th){
        return $th->getMessage();
      }

      
    }

    public function viewVerifyAccount($id){

      $day = date('Y/m/d H:i:s');

      SellerUser::where('s_id', $id)->update(['email_verified_at' => $day]);

      $user = SellerUser::where('s_id', '=', $id)->first();

      $mail = $user->email;
      $dataa = $user;

      Mail::send(['html'=>'email_welcome_template'], ['text'=>$dataa], function($message) use ($mail, $dataa)  {
          $message->to($mail)->subject
             ('Welcome to Buy & Sell');
          $message->from('no-reply@wwwmedia.world','Buy & Sell');
       });
         

      return redirect('/buyerlogin')->with(['regsucmsg' => 'E-mail verified successfully']);
  }

  public function sendMail(){
    $email = DB::Select('SELECT * FROM seller_users');

    foreach ($email as $ema) {
        $mail= $ema->email;

        $dataa = "https://buyandsell.click/verifyaccount/" . $ema->s_id;
  Mail::send(['html'=>'email_verification_template'], ['text'=>$dataa], function($message) use ($mail, $dataa)  {
     $message->to($mail)->subject
        ('Verify Account.');
     $message->from('no-reply@wwwmedia.world','Buy & Sell');
  });
    }

    return redirect('/buyerlogin')->with(['msg' => 'Please check your email for verify your account.']);

}

    public function viewLogin(){
      $category = DB::table('category')->take(10)->get();

        return view('buyerlogin',['category'=>$category]);
    }


    public function buyerLogin(Request $request){
        
        $login_info = new SellerUser();
        $login_info->email = request('email');
        $login_info->password = request('psw');
        $data = DB::select('select * from seller_users where email  =? and password =? and mmbr_user_status =?',[request('email'),md5(request('psw')),'0']);
        
        if(count($data) == '1'){

          if($data[0]->email_verified_at == ""){
            return redirect('/buyerlogin')->with('errrmessage','Please verify your email first to be able to login.');
        }

          setcookie('UserEmail', Crypt::encryptString($data[0]->email), time() + (86400 * 365), "/");
          setcookie('UserFullName', Crypt::encryptString($data[0]->name), time() + (86400 * 365), "/");
          setcookie('UserIds', Crypt::encryptString($data[0]->s_id), time() + (86400 * 365), "/");
          setcookie('UserCompName', Crypt::encryptString($data[0]->seller_comp_name), time() + (86400 * 365), "/");
          setcookie('UserStatus', Crypt::encryptString($data[0]->mmbr_user_status), time() + (86400 * 365), "/");


          
          return redirect('/home');
        }else{
       return redirect('/buyerlogin')->with('errrmessage','Please check your information');
      }   
}

public function viewMemberLogin(){

  if(isset($_COOKIE['MemberEmail'])){
    return redirect('/member');
  }

  $category = DB::table('category')->take(10)->get();

  return view('memberlogin',['category'=>$category]);
}

public function memberLogin(Request $request){
  try{    
  $data = DB::select('select * from seller_users where email  =? and password =? and mmbr_user_status=?',[request('email'),request('psw'),'1']);
  
  if(count($data) == '1'){

    setcookie('MemberEmail', Crypt::encryptString($data[0]->email), time() + (86400 * 365), "/");
    setcookie('MemberFullName', Crypt::encryptString($data[0]->name), time() + (86400 * 365), "/");
    setcookie('MemberUserIds', Crypt::encryptString($data[0]->s_id), time() + (86400 * 365), "/");
    setcookie('MemberUserCompName', Crypt::encryptString($data[0]->seller_comp_name), time() + (86400 * 365), "/");
    setcookie('MemberUserStatus', Crypt::encryptString($data[0]->mmbr_user_status), time() + (86400 * 365), "/");

    // setcookie('UserEmail', Crypt::encryptString($data[0]->email), time() + (86400 * 365), "/");
    // setcookie('UserFullName', Crypt::encryptString($data[0]->name), time() + (86400 * 365), "/");
    // setcookie('UserIds', Crypt::encryptString($data[0]->s_id), time() + (86400 * 365), "/");
    // setcookie('UserCompName', Crypt::encryptString($data[0]->seller_comp_name), time() + (86400 * 365), "/");
    // setcookie('UserStatus', Crypt::encryptString($data[0]->mmbr_user_status), time() + (86400 * 365), "/");
    
    return redirect('/member');
  }else{
 return redirect('/memberlogin')->with('errrmessage','Please check your information');
}
  }catch(\Throwable $th){
    return $th->getMessage();
  }  
}

public function viewMember(Request $request){

  

  try{
    $category = DB::table('category')->get();
  
    $offset = ($request->input('q') ?  $request->input('q') : '0');

    $limit = 21;

      $newArrivals = DB::select("SELECT u.*, p.* FROM products AS u INNER JOIN pro_images AS p ON p.pro_id = ( SELECT pro_id FROM pro_images AS p2 WHERE p2.prod_img_prod_id = u.prod_id AND u.prod_live_status = '1' AND u.prod_quantity > '0' AND u.prod_status = 'Active' AND u.prod_apprve_status = '1' AND u.prod_mmbr_sctn = 'Yes' ORDER BY pro_id ASC LIMIT 1 ) ORDER BY u.prod_title ASC limit $offset, $limit");

      $ratings_new = [];
      foreach($newArrivals as $rev){
        $ratings_new[] = DB::select("SELECT AVG(review_ratings) AS AverageRatings FROM buyer_reviews WHERE review_prod_id = '".$rev->prod_id."' AND review_status='1'");
      }

    $next = $offset + $limit;
    $prev = $offset - $limit;

    return view('member')->with(['newArrivals' => $newArrivals, 'category' => $category, 'ratings_new' => $ratings_new, 'next' => $next, 'prev' => $prev]);
  }catch(\Throwable $th){
    return $th->getMessage();
  }
}

public function logoutMember() {
  setcookie("MemberEmail", "", time() - 3600);
  setcookie("MemberFullName", "", time() - 3600);
  setcookie("MemberUserIds", "", time() - 3600);
  setcookie("MemberUserCompName", "", time() - 3600);
  setcookie("MemberUserStatus", "", time() - 3600);
    \Cart::clear();
    return redirect('/home');
}

public function viewMemberOrders(){
  if(!isset($_COOKIE['MemberUserIds'])){
          return view('memberlogin');
      }else{  

      $category = DB::table('category')->take(10)->get();

      //paginate
    $perPage = 10;
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    $startAt = $perPage * ($page - 1);

        $id = Crypt::decryptString($_COOKIE['MemberUserIds']);

    $orders_count = DB::select( "SELECT t1.*,t2.*,t3.* FROM orders t1 LEFT JOIN products t2 ON (t1.order_prod_id=t2.prod_id) LEFT JOIN seller_users t3 ON (t1.ord_seller_id=t3.s_id) WHERE t1.ord_buyer_id = $id");

    

    $orders = DB::select( "SELECT t1.*,t2.*,t3.* FROM orders t1 LEFT JOIN products t2 ON (t1.order_prod_id=t2.prod_id) LEFT JOIN seller_users t3 ON (t1.ord_seller_id=t3.s_id) WHERE t1.ord_buyer_id = '".$id."' ORDER BY t1.order_date_time DESC LIMIT $startAt, $perPage");

    $totalPages = ceil(count($orders_count) / $perPage);  
                         

    // DB::select('select * from orders where ord_buyer_id="'.Session::get('BuyerIds').'"');
    

      return view('memberorders',['orders'=>$orders,'category'=>$category,'orders_count'=>$orders_count,'totalPages'=>$totalPages,'page'=>$page]);
  }
}



    public function viewOrders(){
    if(!isset($_COOKIE['UserIds'])){
            return view('buyerlogin');
        }else{  

        $category = DB::table('category')->take(10)->get();

        //paginate
      $perPage = 10;
      $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
      $startAt = $perPage * ($page - 1);

          $id = Crypt::decryptString($_COOKIE['UserIds']);

      $orders_count = DB::select( "SELECT t1.*,t2.*,t3.* FROM orders t1 LEFT JOIN products t2 ON (t1.order_prod_id=t2.prod_id) LEFT JOIN seller_users t3 ON (t1.ord_seller_id=t3.s_id) WHERE t1.ord_buyer_id = $id");

      

      $orders = DB::select( "SELECT t1.*,t2.*,t3.* FROM orders t1 LEFT JOIN products t2 ON (t1.order_prod_id=t2.prod_id) LEFT JOIN seller_users t3 ON (t1.ord_seller_id=t3.s_id) WHERE t1.ord_buyer_id = '".$id."' ORDER BY t1.order_date_time DESC LIMIT $startAt, $perPage");

      $totalPages = ceil(count($orders_count) / $perPage);  
                           

      // DB::select('select * from orders where ord_buyer_id="'.Session::get('BuyerIds').'"');
      

        return view('buyerorders',['orders'=>$orders,'category'=>$category,'orders_count'=>$orders_count,'totalPages'=>$totalPages,'page'=>$page]);
    }
  }

    public function viewOrdersDetails($id){

      $category = DB::table('category')->take(10)->get();
        
      $ordersdtls = DB::table('orders')
                           ->leftJoin('products', 'products.prod_id', '=', 'orders.order_prod_id')
                           ->leftJoin('seller_users', 'seller_users.s_id', '=', 'orders.ord_seller_id')
                           ->where('orders.ord_uniq_id', '=', $id)
                           ->orderBy('orders.order_date_time', 'DESC')
                           ->get();

        return view('orderdetails',['ordersdtls'=>$ordersdtls,'category'=>$category]);
    }

    public function viewProfile($id){

      $category = DB::table('category')->take(10)->get();

       $Editprofile = BuyerUser::where('buyer_id', '=', [$id])->get();

        return view('buyerprofiledtls',['Editprofile'=>$Editprofile, 'category'=>$category]);
    }

    public function editProfile(Request $request){
     

        DB::table('buyer_users')->where('buyer_id', $request->input('buyer_id') )->update(['buyer_f_name' => $request->input('name'),'buyer_email' => $request->input('email') , 'buyer_sex' => $request->input('gender')]);


        $Editpro = $request->input('buyer_id');
        return redirect('/editprofile/'.$Editpro);

    }

    public function changePassword(){

      $category = DB::table('category')->take(10)->get();

        return view('changepassword',['category'=>$category]);
    }

     public function editPassword(Request $request){
      
      
    $data = DB::select('select * from seller_users where s_id="'.Crypt::decryptString($_COOKIE['UserIds']).'"');
      
      if(md5($request->input('pass')) == $data[0]->password){
         if(request('nwpass') == request('renwpass')){
           DB::table('seller_users')->where('s_id', Crypt::decryptString($_COOKIE['UserIds']))->update(['password' => md5($request->input('renwpass'))]);
           return redirect('/changepassword')->with(['updatepas' => 'Password updated successfully.']);
           
         }
           
      }
        else{
           return redirect('/changepassword')->with(['errpas' => 'Error! Enter Your Correct Password.']);
         }
      
    }

    public function viewMemberAddress(){

      $category = DB::table('category')->take(10)->get();
      
      $data = DB::select('select * from buyer_addresses where buyer_del_add_buy_id="'.Crypt::decryptString($_COOKIE['MemberUserIds']).'" ORDER BY buyer_del_add_date_time DESC');

      return view('membermanageaddress',['data'=>$data,'category'=>$category]);
    }

    public function viewMemberAddressForm(){

      $category = DB::table('category')->take(10)->get();

        return view('addmemberaddress',['category'=>$category]);
    }

    public function addMemberAddress(Request $request){
       
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
      
     return redirect('/membermanageaddress');
  }

    public function viewAddress(){

      $category = DB::table('category')->take(10)->get();
      
      $data = DB::select('select * from buyer_addresses where buyer_del_add_buy_id="'.Crypt::decryptString($_COOKIE['UserIds']).'" ORDER BY buyer_del_add_date_time DESC');

           return view('manageaddress',['data'=>$data,'category'=>$category]);
    }

     public function viewAddressForm(){

      $category = DB::table('category')->take(10)->get();

        return view('addbuyeraddress',['category'=>$category]);
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
        
       return redirect('/manageaddress');
    }

    public function delAddress(Request $request){

      $category = DB::table('category')->take(10)->get();

      setcookie('BuyerDelvryAdd', Crypt::encryptString($request->input('delvryadd')), time() + (86400 * 365), "/");

      //Session::put('BuyerDelvryAdd', $request->input('delvryadd'));

     
         DB::table('buyer_addresses')->where('buyer_del_add_buy_id', $request->input('delbuyadd') )->update(['make_primary' => '0']);

        DB::table('buyer_addresses')->where('buyer_del_id', $request->input('deladd') )->update(['make_primary' => '1']);

        return redirect('/checkout')->with(['category'=>$category]);

    }

    public function editAddressForm($id){

      $category = DB::table('category')->take(10)->get();

      $Editaddress = BuyerAddress::where('buyer_del_id', '=', [$id])->get();

        return view('editbuyeraddress',['category'=>$category,'Editaddress'=>$Editaddress,]);
    }

    public function editAddress(Request $request){
     

        DB::table('buyer_addresses')->where('buyer_del_id', $request->input('buyer_delvry_add_id') )->update(['buyer_del_phn_no' => $request->input('phn_no'),'buyer_del_email' => $request->input('email') , 'buyer_del_address' => $request->input('address'),'buyer_del_city' => $request->input('city'),'buyer_del_postcode' => $request->input('postcode'),'buyer_del_state' => $request->input('state'),'buyer_del_country' => $request->input('country')]);


        
        return redirect('/manageaddress');

    }

    public function makePrimaryAddress(Request $request){
     

       $category = DB::table('category')->take(10)->get();

       setcookie('BuyerDelvryAdd', Crypt::encryptString($request->input('delvryadd')), time() + (86400 * 365), "/");

     
         DB::table('buyer_addresses')->where('buyer_del_add_buy_id', $request->input('delbuyadd') )->update(['make_primary' => '0']);

        DB::table('buyer_addresses')->where('buyer_del_id', $request->input('deladd') )->update(['make_primary' => '1']);

        return redirect('/manageaddress')->with(['category'=>$category]);

    }

    public function deleteAddress($id){
               
               $deleteAdd = BuyerAddress::where('buyer_del_id', '=', [$id])->delete();

               return redirect('manageaddress')->with(['deleteAdd'=>'Address deleted successfully']);
            }

    public function makeMemberPrimaryAddress(Request $request){


      $category = DB::table('category')->take(10)->get();

      setcookie('MemberDelvryAdd', Crypt::encryptString($request->input('delvryadd')), time() + (86400 * 365), "/");

    
        DB::table('buyer_addresses')->where('buyer_del_add_buy_id', $request->input('delbuyadd') )->update(['make_primary' => '0']);

        DB::table('buyer_addresses')->where('buyer_del_id', $request->input('deladd') )->update(['make_primary' => '1']);

        return redirect('/membermanageaddress')->with(['category'=>$category]);

    }


    public function editMemberAddressForm($id){

      $category = DB::table('category')->take(10)->get();

      $Editaddress = BuyerAddress::where('buyer_del_id', '=', [$id])->get();

        return view('editmemberaddress',['category'=>$category,'Editaddress'=>$Editaddress,]);
    }

    public function editMemberAddress(Request $request){
     

      DB::table('buyer_addresses')->where('buyer_del_id', $request->input('buyer_delvry_add_id') )->update(['buyer_del_phn_no' => $request->input('phn_no'),'buyer_del_email' => $request->input('email') , 'buyer_del_address' => $request->input('address'),'buyer_del_city' => $request->input('city'),'buyer_del_postcode' => $request->input('postcode'),'buyer_del_state' => $request->input('state'),'buyer_del_country' => $request->input('country')]);


      
      return redirect('/membermanageaddress');

  }

  public function deleteMemberAddress($id){
               
    $deleteAdd = BuyerAddress::where('buyer_del_id', '=', [$id])->delete();

    return redirect('membermanageaddress')->with(['deleteAdd'=>'Address deleted successfully']);
 }


    public function viewReviewForm($id){
      if(!isset($_COOKIE['UserIds'])){
        return view('buyerlogin');
    }else{ 

      $category = DB::table('category')->take(10)->get();

      $seller = DB::table('products')->select('prod_seller_id')->where('prod_id', $id)->first();
      $sellerid = $seller->prod_seller_id;

      

        return view('buyerreviews')->with(['prodid' => $id,'category'=>$category, 'sellerid'=>$sellerid]);
    }
    }

    public function addReviews(Request $request){
       
      $category = DB::table('category')->take(10)->get();
       
        DB::table('buyer_reviews')->insert(['review_buyer_id' => $request->input('buyer_id'),'review_seller_id' => $request->input('seller_id'), 'review_prod_id' => $request->input('prod_id'), 'review_ratings' => $request->input('rating_val'), 'review_comments' => $request->input('review')]);
        
       return redirect('/p/'. $request->input('prod_id'))->with(['category'=>$category, 'msg'=>'Your review has been published successfully']);
    }

    public function changeProfilePic() {
      $category = DB::table('category')->take(10)->get();
      
      $id = Crypt::decryptString($_COOKIE['UserIds']);
      $ProImage = SellerUser::where('s_id', '=', [$id])->get();
      return view('/buyer_img_upload')->with(['ProImage' => $ProImage, 'category' => $category]);
  }

  public function profilePicUpdate(Request $request){
        
    $image = $request->file('file');
    $imageName = $image->getClientOriginalName();
    $image->move(public_path('images'),$imageName);

    $id = Crypt::decryptString($_COOKIE['UserIds']);
    
    DB::table('seller_users')->where('s_id', $id )->update(['seller_prfl_pic' => $imageName]);
    return redirect('/buyersettings');
}

    public function logoutUser() {
      setcookie("UserIds", "", time() - 3600);
      setcookie("UserEmail", "", time() - 3600);
      setcookie("UserFullName", "", time() - 3600);
      setcookie("UserCompName", "", time() - 3600);
      setcookie("UserStatus", "", time() - 3600);
        \Cart::clear();
        return redirect('/home');
    }

    public function viewTerms(){
      

        return view('terms_condition');
    }

    public function viewPrivacy(){
      

      return view('privacy');
  }

  public function viewCookies(){
      

    return view('cookies');
}

public function suggestionUpdatePost(Request $request){

  $request->validate([
    'web_name' => 'required',
    'comment' => 'required'
]);
  
try {
  DB::connection('mysql2')->table('suggstn_box')->insert([
      'sggstn_author' => Crypt::decryptString($_COOKIE['UserFullName']),
      'sggstn_author_id' => Crypt::decryptString($_COOKIE['UserIds']),
      'sggstn_web_name' => request('web_name'),
      'sggstn_comment' => request('comment'),
      'sggstn_room_name' => 'buy&sell'
  ]);
  


  return back()->with('msg', "Your testimonial has been successfully submitted. It will under review process.");

} catch (\Throwable $th) {
  dd("Some error occured.");
}

 }

 public function testimonialUpdatePost(Request $request){

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

 }

    public function viewShippingDelivery(){
      

      return view('shipping_delivery');
  }

  public function viewReturn(){
      

    return view('how_return');
}

public function viewContactUs(){
      

  return view('contact_us');
}

public function viewReviewsAndTestimonials(){
      
try{
  $webreview = DB::table('website_review')
              ->leftJoin('seller_users', 'seller_users.s_id', '=', 'website_review.review_user_id')
              ->where('website_review.review_status', '=', '1')
              ->get();

  return view('reviewsandtestimonials')->with(['webreview'=>$webreview]);
}
  catch(\Throwable $th){
    return $th->getMessage();
}
}

    public function viewWebReviewForm(){
      if(!isset($_COOKIE['UserIds'])){
        return view('buyerlogin');
    }else{ 

      $category = DB::table('category')->take(10)->get();

    return view('webreviews')->with(['category'=>$category]);
    }
    }

    public function addWebReviews(Request $request){
       
        DB::table('website_review')->insert(['review_user_id' => $request->input('user_id'),'review_ratings' => $request->input('ratings'), 'review_comments' => $request->input('comments')]);
        
       return redirect('/')->with(['msg'=>'Your review has been published successfully']);
    }

}
