<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UsersMeta;
use App\Models\UserPhotos;
use App\Models\Connectionsfinal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Google\Cloud\Translate\V2\TranslateClient;
use DateTime;
use Mail;
use Twilio\Rest\Client;

class MessagesController extends Controller
{
    public $contacts = [];
	
    public function viewMessages(){

        // if(!$this->isUserLoginExist()){
        //     $this->logout();
        //     return redirect('/login')->with(['msg' => 'You have to login to view your account']);

        // } 

        $chatUsers = DB::Select("SELECT t1.*,t2.* FROM users_chat_rooms t1 LEFT JOIN users t2 ON (t1.room_to_id=t2.id) WHERE t1.room_from_id = 0 ORDER BY t1.timedate DESC");
        foreach($chatUsers as $cu) {
            //$usersLastMsg = DB::Select("SELECT chat_msg FROM users_chat WHERE (chat_from_id = '".$cu->room_from_id."' AND chat_to_id = '".$cu->room_to_id."') OR (chat_from_id = '".$cu->room_to_id."' AND chat_to_id = '".$cu->room_from_id."') ORDER BY chat_date_time DESC LIMIT 1");



            $this->contacts[] = array(
                'propic' => $cu->prfl_photo_path,
                'name' => $cu->name,
                'email' => $cu->email,
                //'lmsg' => $usersLastMsg[0]->chat_msg,
                'user_id' => $cu->room_to_id,
                
            );

        }
        return view('users.message')->with(['users' => $this->contacts]);
    	
    }

    public function viewLeftMenuMessages(){
        $chatUsers = DB::Select("SELECT t1.*,t2.* FROM users_chat_rooms t1 LEFT JOIN users t2 ON (t1.room_to_id=t2.id) WHERE t1.room_from_id = 0 ORDER BY t1.timedate DESC");
        foreach($chatUsers as $cu) {
            //$usersLastMsg = DB::Select("SELECT chat_msg FROM users_chat WHERE (chat_from_id = '".$cu->room_from_id."' AND chat_to_id = '".$cu->room_to_id."') OR (chat_from_id = '".$cu->room_to_id."' AND chat_to_id = '".$cu->room_from_id."') ORDER BY chat_date_time DESC LIMIT 1");



            if($cu->prfl_approve_status == '0'){
                $propic = 'https://www.globallove.online/images/male-user-placeholder.png';
            } else{
                $propic = $cu->prfl_photo_path;
            }

            $this->contacts[] = array(
                'propic' => $propic,
                'name' => $cu->name,
                'email' => $cu->email,
                //'lmsg' => $usersLastMsg[0]->chat_msg,
                'user_id' => $cu->room_to_id,
                
            );

        }




        $returnHtml = view('users.message_userlist')->with(['users' => $this->contacts])->render();
        return response()->json( array('success' => true, 'html'=>$returnHtml) );
        
    }

    public function viewMobLeftMenuMessages(){
        $chatUsers = DB::Select("SELECT t1.*,t2.* FROM users_chat_rooms t1 LEFT JOIN users t2 ON (t1.room_to_id=t2.id) WHERE t1.room_from_id = ".Crypt::decryptString($_COOKIE['UserIds']). " ORDER BY t1.timedate DESC");
        foreach($chatUsers as $cu) {
            $usersLastMsg = DB::Select("SELECT chat_msg FROM users_chat WHERE (chat_from_id = '".$cu->room_from_id."' AND chat_to_id = '".$cu->room_to_id."') OR (chat_from_id = '".$cu->room_to_id."' AND chat_to_id = '".$cu->room_from_id."') ORDER BY chat_date_time DESC LIMIT 1");



            if($cu->prfl_approve_status == '0'){
                $propic = 'https://www.globallove.online/images/male-user-placeholder.png';
            } else{
                $propic = $cu->prfl_photo_path;
            }

            $this->contacts[] = array(
                'propic' => $propic,
                'name' => $cu->name,
                'email' => $cu->email,
                'lmsg' => $usersLastMsg[0]->chat_msg,
                'user_id' => $cu->room_to_id,
                
            );

        }

        


        //$returnHtml = view('users.mob_message_userlist')->with(['users' => $this->contacts])->render();
        return view('users.mob_message_userlist')->with(['users'=> $this->contacts]);
        //return response()->json( array('success' => true, 'html'=>$returnHtml) );
        
    }

    public function messangerr($id) {
        return view('users.messanger');
    }
    
    public function deleteChat(request $request){

        $update=DB::Select("UPDATE users_chat SET chat_from_id= '0', chat_to_id='0' WHERE (chat_from_id = ".Crypt::decryptString($_COOKIE['UserIds'])." AND chat_to_id = ".$request->chat_to_id.") OR (chat_from_id = ".$request->chat_to_id." AND chat_to_id = ".Crypt::decryptString($_COOKIE['UserIds']).") ORDER BY chat_date_time ASC");

	if($update){
		return response()->json(['success'=> 'done']);
	}
	return response()->json(['error'=> 'error in deleting']);
    }    

    public function loadMsgs(request $request) {

        if($request->id == '0') {
            //for admin
            $date= date('Y-m-d H:i:s');
            DB::Select("UPDATE users_chat_rooms SET room_status= '0', timedate= '".$date."' WHERE room_to_id= '".Crypt::decryptString($_COOKIE['UserIds'])."' AND room_from_id= '0'");
        }
        
        //for all users
        $update=DB::Select("UPDATE users_chat_rooms SET room_status= '0' WHERE room_to_id= '".$request->id."' AND room_from_id= '".Crypt::decryptString($_COOKIE['UserIds'])."'");

        $msgs = DB::Select("SELECT * FROM users_chat WHERE (chat_from_id = ".Crypt::decryptString($_COOKIE['UserIds'])." AND chat_to_id = ".$request->id.") OR (chat_from_id = ".$request->id." AND chat_to_id = ".Crypt::decryptString($_COOKIE['UserIds']).") ORDER BY chat_date_time ASC");
        $block = DB::Select("SELECT b_who_id from block_users where b_whom_id = '".Crypt::decryptString($_COOKIE['UserIds'])."' OR b_whom_id = '".$request->id."'");

        if(count($block) > 0) {
        	foreach($block as $b) {
            	$blockIDs[] = $b->b_who_id;
        	}
        } else {
        	$blockIDs[] = array('');
        }

        $moderator= DB::Select("SELECT * FROM chat_mod WHERE (mod_from_id= '".Crypt::decryptString($_COOKIE['UserIds'])."' AND mod_to_id='".$request->id."' AND mod_status='0') OR (mod_to_id='".Crypt::decryptString($_COOKIE['UserIds'])."' AND mod_from_id='".$request->id."' AND mod_status='0')");
        
        
        
        return response()->json([$msgs, $blockIDs,$moderator]);
    }

    public function admin_loadMsgs(request $request) {

        $update=DB::Select("UPDATE users_chat_rooms SET room_status= '0' WHERE room_to_id= '".$request->id."' AND room_from_id= '0'");

        $msgs = DB::Select("SELECT * FROM users_chat WHERE (chat_from_id = 0 AND chat_to_id = $request->id) OR (chat_from_id = $request->id AND chat_to_id = 0) ORDER BY chat_date_time ASC");
        $block = DB::Select("SELECT b_who_id from block_users where b_whom_id = '0' OR b_whom_id = '".$request->id."'");

        if(count($block) > 0) {
        	foreach($block as $b) {
            	$blockIDs[] = $b->b_who_id;
        	}
        } else {
        	$blockIDs[] = array('');
        }
        
        
        
        return response()->json([$msgs, $blockIDs]);
    }

    public function chatinsert(request $request) {

        $today = date('Y-m-d H:i:s');

        $premium_login = DB::Select("select * from payment_transactions where pt_u_id = '".Crypt::decryptString($_COOKIE['UserIds'])."' and pt_end_date > '".$today."'");

        $premium_user = DB::Select("select * from payment_transactions where pt_u_id = '".$request->to_id."' and pt_end_date > '".$today."'");

        $getProfileApprove = DB::Select("select prfl_approve_status,prfl_photo_path from users where id = '".Crypt::decryptString($_COOKIE['UserIds'])."'");

        if(count($premium_login) == 0 && count($premium_user) == 0 && $request->to_id > 0){

            return response()->json("false");

        } elseif($getProfileApprove[0]->prfl_approve_status != 1 && $request->to_id > 0){

            return response()->json("apprvestatus");

        } else {

        //check if new message or now
        $chk_duplicate = DB::Select("select room_id from users_chat_rooms where (room_from_id = '".Crypt::decryptString($_COOKIE['UserIds'])."' and room_to_id = '".$request->to_id."') or (room_from_id = '".$request->to_id."' and room_to_id = '".Crypt::decryptString($_COOKIE['UserIds'])."')");

        // --------------------------------  translation -------------------------
        
        $get_to_lang = DB::Select("select users_lang from users where id = '".$request->to_id."'");

        $translate = new TranslateClient([
            'key' => 'AIzaSyBwmspSz56AoAju0gGPPOcP3NqFjaLJryo'
        ]);

        // Translate text from english to french.

       // if($request->to_id > 0){
            $result_trans = $translate->translate($request->msg, [
                'target' => ($request->to_id > 0 ? $get_to_lang[0]->users_lang : 'en')
            ]);
        //}
        

       
        // -------------------------------- end translation ----------------------

        if(count($chk_duplicate) > 0) {
            $insert = DB::Select("INSERT INTO users_chat (chat_from_id,chat_to_id,chat_msg,chat_msg_trans) VALUES ('".$request->from_id."','".$request->to_id."','".addslashes($request->msg)."', '".addslashes($result_trans['text'])."')");

            $last= DB::getPdo()->lastInsertId();

            $moderator= DB::Select("SELECT * FROM chat_mod WHERE (mod_from_id= '".Crypt::decryptString($_COOKIE['UserIds'])."' AND mod_to_id='".$request->to_id."' AND mod_status='0') OR (mod_to_id='".Crypt::decryptString($_COOKIE['UserIds'])."' AND mod_from_id='".$request->to_id."' AND mod_status='0')");

            



            if(count($moderator) > 0){
                DB::table('chat_mod')->insert([
                    'mod_from_id' => Crypt::decryptString($_COOKIE['UserIds']), 
                    'mod_to_id' => $request->to_id,
                    'mod_chat_id' => $last,
                    'mod_chat_msg' => addslashes($result_trans['text'])
                ]);
            }

            $date= date('Y-m-d H:i:s');

            $update = DB::Select("UPDATE users_chat_rooms SET room_status= '1', timedate= '".$date."' WHERE room_to_id= '".$request->from_id."' AND room_from_id= '".$request->to_id."'");

            $update2 = DB::Select("UPDATE users_chat_rooms SET timedate= '".$date."' WHERE room_to_id= '".$request->to_id."' AND room_from_id= '".$request->from_id."'");
        } else {

            DB::table('users_chat')->insert([
                'chat_from_id' => Crypt::decryptString($_COOKIE['UserIds']), 
                'chat_to_id' => $request->to_id,
                'chat_msg' => addslashes($request->msg)
            ]);

            $last= DB::getPdo()->lastInsertId();

            $moderator= DB::Select("SELECT * FROM chat_mod WHERE (mod_from_id= '".Crypt::decryptString($_COOKIE['UserIds'])."' AND mod_to_id='".$request->to_id."' AND mod_status='0') OR (mod_to_id='".Crypt::decryptString($_COOKIE['UserIds'])."' AND mod_from_id='".$request->to_id."' AND mod_status='0')");

            



            if(count($moderator) > 0){
                DB::table('chat_mod')->insert([
                    'mod_from_id' => Crypt::decryptString($_COOKIE['UserIds']), 
                    'mod_to_id' => $request->to_id,
                    'mod_chat_id' => $last,
                    'mod_chat_msg' => addslashes($request->msg)
                ]);
            }

            
    
            DB::table('users_chat_rooms')->insert([
                'room_from_id' => Crypt::decryptString($_COOKIE['UserIds']), 
                'room_to_id' => $request->to_id
                  
            ]);
    
            DB::table('users_chat_rooms')->insert([
                'room_from_id' => $request->to_id, 
                'room_to_id' => Crypt::decryptString($_COOKIE['UserIds'])
                  
            ]);

        }

        //send sms notify to admin customer support
        if($request->to_id == 0) {
            // send sms
            // $message = "You have a new customer support message on Globallove.";
            
            // // Your Account SID and Auth Token from twilio.com/console
            // $sid = env('TWILIO_ACCOUNT_SID');
            // $token = env('TWILIO_API_KEY_SECRET');
            // $client = new Client($sid, $token);

            // // Use the client to do fun stuff like send text messages!
            // $client->messages->create(
            //     // the number you'd like to send the message to
            //     '+61481817663',
            //     [
            //         // A Twilio phone number you purchased at twilio.com/console
            //         'from' => '+61488852385',
            //         // the body of the text message you'd like to send
            //         'body' => $message
            //     ]
            // );
        }

        return response()->json([$result_trans['text']]);

        }
                    

        
        
        

        
    }

    public function admin_chatinsert(request $request) {

        //check if new message or now
        $chk_duplicate = DB::Select("select room_id from users_chat_rooms where (room_from_id = '0' and room_to_id = '".$request->to_id."') or (room_from_id = '".$request->to_id."' and room_to_id = '0')");

        if(count($chk_duplicate) > 0) {
            $insert = DB::Select("INSERT INTO users_chat (chat_from_id,chat_to_id,chat_msg) VALUES ('".$request->from_id."','".$request->to_id."','".addslashes($request->msg)."')");

            $date= date('Y-m-d H:i:s');

            $update = DB::Select("UPDATE users_chat_rooms SET room_status= '1', timedate= '".$date."' WHERE room_to_id= '".$request->from_id."' AND room_from_id= '".$request->to_id."'");

            $update2 = DB::Select("UPDATE users_chat_rooms SET timedate= '".$date."' WHERE room_to_id= '".$request->to_id."' AND room_from_id= '".$request->from_id."'");
        } else {

            DB::table('users_chat')->insert([
                'chat_from_id' => 0, 
                'chat_to_id' => $request->to_id,
                'chat_msg' => addslashes($request->msg)
            ]);
    
            DB::table('users_chat_rooms')->insert([
                'room_from_id' => 0, 
                'room_to_id' => $request->to_id
                  
            ]);
    
            DB::table('users_chat_rooms')->insert([
                'room_from_id' => $request->to_id, 
                'room_to_id' => 0
                  
            ]);

        }

        $csuseremail= DB::select("SELECT * FROM users WHERE id= '".$request->to_id."'");

         //$mail = $user_info[0]->email;
         $mail = $csuseremail[0]->email;
         $msg= addslashes($request->msg);
         //$mail = "remorozadarrel@gmail.com";
         $dataa = '';
     Mail::send(['html'=>'users.email_cs_support_template'], ['msg'=>$msg], function($message) use ($mail, $dataa)  {
         $message->to($mail)->subject
             ('Message');
         $message->from('no-reply@wwwmedia.world','GlobalLove');
         });
        
        

        return response()->json([$insert]);
    }

    public function viewAddNewMessage($id){


        if(!$this->isUserLoginExist()){
            $this->logout();
            return redirect('/login')->with(['msg' => 'You have to login to view your account']);

        } 
        $payment= DB::Select("SELECT pt_u_id,pt_end_date,pt_start_date FROM payment_transactions WHERE pt_u_id= '".$id."' AND pt_end_date > '".date('Y-m-d H:i:s')."'");
        //dd(count($payment));

        $message= DB::Select("SELECT * FROM users_chat_rooms WHERE room_from_id= '".Crypt::decryptString($_COOKIE['UserIds'])."' AND room_to_id= '".$id."'");

        if (count($message) == 0) {
            $user = DB::table('users')
                ->leftJoin('users_metas', 'users_metas.user_id', '=', 'users.id')
                ->where('users.id', '=', $id)
                ->get();

                return view('users.addnewmessage')->with(['message'=> $user, 'to'=> $id, 'member'=> $payment]);
        }else {

            return redirect('/messages');
        }

    }

    public function addNewMessageAction(request $request) {

        



        DB::table('users_chat')->insert([
            'chat_from_id' => Crypt::decryptString($_COOKIE['UserIds']), 
            'chat_to_id' => $request->input('djsgdsg'),
            'chat_msg' => $request->input('msg')
        ]);

        DB::table('users_chat_rooms')->insert([
            'room_from_id' => Crypt::decryptString($_COOKIE['UserIds']), 
            'room_to_id' => $request->input('djsgdsg')
              
        ]);

        DB::table('users_chat_rooms')->insert([
            'room_from_id' => $request->input('djsgdsg'), 
            'room_to_id' => Crypt::decryptString($_COOKIE['UserIds'])
              
        ]);

        return redirect('/messages');
    }


    public function isUserLoginExist() {
    

        if (!isset($_COOKIE['UserIds']) ||  !isset($_COOKIE['LookingFor']) ) {
           return false;
        }
        $usercount =   User::where('id',Crypt::decryptString($_COOKIE['UserIds']))->count();
        if($usercount <= 0){
         return false;
        }
 
        return true;
 
       }
 
 
     public function logout() {
       setcookie("UserIds", "", time() - 3600);
       setcookie("UserEmail", "", time() - 3600);
       setcookie("UserFullName", "", time() - 3600);
       setcookie("UserSex", "", time() - 3600);
       setcookie("_gooDal", "", time() - 3600);
         return redirect('/login');
     }

     public function online(request $request) {
        foreach($request->email as $email) {
            DB::Select("update users set onln_status = 'online' where email = '".$email."'");
        }
        return response()->json(['done']);
     }

     public function offline(request $request) {
        foreach($request->email as $email) {
            DB::Select("update users set onln_status = 'offline' where email = '".$email."'");
        }
        return response()->json(['done']);
     }

      public function sendFile(Request $request) {
        $arr = [];
        foreach($request->file('file') as $image)
         {
              $new_name = rand() . time() . '.' . $image->getClientOriginalExtension();
              $image->move(public_path('chat_img'), $new_name);

              DB::table('users_chat')->insert([
                    'chat_from_id' => Crypt::decryptString($_COOKIE['UserIds']),
                    'chat_to_id' => request('to'),
                    'chat_files' => 'https://www.globallove.online/chat_img/' . $new_name
              
        ]);
              $arr[] = 'https://www.globallove.online/chat_img/' . $new_name;
         }
 
 
        return response()->json($arr);
    }

    public function inbox2() {
        $users = [];
        $chatUsers = DB::Select("SELECT t1.*,t2.* FROM users_chat_rooms t1 right JOIN users t2 ON (t1.room_to_id=t2.id) WHERE t1.room_from_id = ".Crypt::decryptString($_COOKIE['UserIds']). " ORDER BY t1.timedate DESC");
        foreach($chatUsers as $cu) {
            $usersLastMsg = DB::Select("SELECT chat_msg FROM users_chat WHERE (chat_from_id = '".$cu->room_from_id."' AND chat_to_id = '".$cu->room_to_id."') OR (chat_from_id = '".$cu->room_to_id."' AND chat_to_id = '".$cu->room_from_id."') ORDER BY chat_date_time DESC LIMIT 1");


        $msgs = DB::Select("SELECT COUNT(*) AS msgCount FROM users_chat WHERE (chat_from_id = ".Crypt::decryptString($_COOKIE['UserIds'])." AND chat_to_id = ".$cu->room_to_id.") OR (chat_from_id = ".$cu->room_to_id." AND chat_to_id = ".Crypt::decryptString($_COOKIE['UserIds']).") ORDER BY chat_date_time ASC");

            if($cu->prfl_approve_status == '0'){
                $propic = 'https://www.globallove.online/images/male-user-placeholder.png';
            } else{
                $propic = $cu->prfl_photo_path;
            }
	    $lmsg = isset($usersLastMsg[0]->chat_msg) ? $usersLastMsg[0]->chat_msg : '';
            $users[] = array(
                'propic' => $propic,
                'name' => $cu->name,
                'email' => $cu->email,
                'lmsg' => $lmsg,
                'user_id' => $cu->id,
                'msgCount' => $msgs[0]->msgCount
            );

        }
	//var_dump($users); die();
        return view('users.inbox2')->with(['users' => $users]);
    }

    public function inbox() {
        $users = [];
        $chatUsers = DB::Select("SELECT t1.*,t2.* FROM users_chat_rooms t1 right JOIN users t2 ON (t1.room_to_id=t2.id) WHERE t1.room_from_id = ".Crypt::decryptString($_COOKIE['UserIds']). " ORDER BY t1.timedate DESC");
        foreach($chatUsers as $cu) {
            $usersLastMsg = DB::Select("SELECT chat_msg FROM users_chat WHERE (chat_from_id = '".$cu->room_from_id."' AND chat_to_id = '".$cu->room_to_id."') OR (chat_from_id = '".$cu->room_to_id."' AND chat_to_id = '".$cu->room_from_id."') ORDER BY chat_date_time DESC LIMIT 1");



            if($cu->prfl_approve_status == '0'){
                $propic = 'https://www.globallove.online/images/male-user-placeholder.png';
            } else{
                $propic = $cu->prfl_photo_path;
            }
	    $lmsg = isset($usersLastMsg[0]->chat_msg) ? $usersLastMsg[0]->chat_msg : '';
            $users[] = array(
                'propic' => $propic,
                'name' => $cu->name,
                'email' => $cu->email,
                'lmsg' => $lmsg,
                'user_id' => $cu->room_to_id,
                
            );

        }
        return view('users.inbox')->with(['users' => $users]);
    }

    public function sent() {
        $users = [];
        $chatUsers = DB::Select("SELECT t1.*,t2.* FROM users_chat_rooms t1 right JOIN users t2 ON (t1.room_to_id=t2.id) WHERE t1.room_from_id = ".Crypt::decryptString($_COOKIE['UserIds']). " ORDER BY t1.timedate DESC");
        foreach($chatUsers as $cu) {
            $usersLastMsg = DB::Select("SELECT chat_msg FROM users_chat WHERE (chat_from_id = '".$cu->room_from_id."' AND chat_to_id = '".$cu->room_to_id."') ORDER BY chat_date_time DESC LIMIT 1");

        $msgs = DB::Select("SELECT COUNT(*) AS msgCount FROM users_chat WHERE (chat_from_id = ".Crypt::decryptString($_COOKIE['UserIds'])." AND chat_to_id = ".$cu->room_to_id.") OR (chat_from_id = ".$cu->room_to_id." AND chat_to_id = ".Crypt::decryptString($_COOKIE['UserIds']).") ORDER BY chat_date_time ASC");

            if($cu->prfl_approve_status == '0'){
                $propic = 'https://www.globallove.online/images/male-user-placeholder.png';
            } else{
                $propic = $cu->prfl_photo_path;
            }

            $users[] = array(
                'propic' => $propic,
                'name' => $cu->name,
                'email' => $cu->email,
                'lmsg' => (isset($usersLastMsg[0]) ? $usersLastMsg[0]->chat_msg : ''),
                'user_id' => $cu->room_to_id,
                 'msgCount' => $msgs[0]->msgCount
            );

        }
        return view('users.sent')->with(['users' => $users]);
    }

    public function groupChatTerms(){
        if(!$this->isUserLoginExist()){
            $this->logout();
            return redirect('/login')->with(['msg' => 'You have to login to view your account']);
    
        } 
        
        return view('users.groupchatterms');
        
    }

    public function pickupLinesView(){
        if(!$this->isUserLoginExist()){
            $this->logout();
            return redirect('/login')->with(['msg' => 'You have to login to view your account']);
    
        } 
        
        return view('users.pickup_lines');
        
    }

    public function groupChatOnlineView(){
        if(!$this->isUserLoginExist()){
            $this->logout();
            return redirect('/login')->with(['msg' => 'You have to login to view your account']);
    
        } 

        $onlnuser = DB::table('group_chat_online')
                    ->leftJoin('users', 'users.id', '=', 'group_chat_online.onln_user_id')
                    ->leftJoin('users_metas', 'users_metas.user_id', '=', 'group_chat_online.onln_user_id')
                    ->where('group_chat_online.onln_room_name', '=', 'main')
                    ->where('group_chat_online.onln_status', '=', 'online')
                    ->where('users.prfl_approve_status', '=', '1')
                    ->where('users_metas.age', '!=', '')
                    ->get();
        
        // return view('users.groupchat')->with(['publicroom' => $publicroom]);
        // return response()->json(['html'=>$onlnuser]);
        //return response()->view('users.group-chat-onln-user', compact('onlnuser',$onlnuser));

        return response()->json([
            'html' => view('users.group-chat-onln-user')->with('onlnuser',$onlnuser)->render()
        ]);

        
        
    }

    public function groupChatView(){
        if(!$this->isUserLoginExist()){
            $this->logout();
            return redirect('/login')->with(['msg' => 'You have to login to view your account']);
    
        } 

        $publicroom = DB::table('gl_public_room')
                ->leftJoin('users', 'users.id', '=', 'gl_public_room.public_user_id')
                ->leftJoin('users_metas', 'users_metas.user_id', '=', 'users.id')
                ->orderBy('gl_public_room.public_room_id', 'DESC')
                ->get();
        
        return view('users.groupchat')->with(['publicroom' => $publicroom]);
        
    }

    public function groupChatAction(Request $request){
        if(!$this->isUserLoginExist()){
            $this->logout();
            return redirect('/login')->with(['msg' => 'You have to login to view your account']);
    
        } 

        

        DB::table('gl_public_room')->insert([
            'public_user_id' => Crypt::decryptString($_COOKIE['UserIds']),
            'public_user_name' => Crypt::decryptString($_COOKIE['UserFullName']), 
            'public_message' => $request->input('message'),
            'public_room' => 'gl_public_rom'
        ]);
        
        // return view('users.groupchat');

        return response()->json(['msg'=>'Added']);
        
    }

    public function chatPrefAction($id,$value){
        if(!$this->isUserLoginExist()){
            $this->logout();
            return redirect('/login')->with(['msg' => 'You have to login to view your account']);
        } 

        $pref_room = DB::table('chat_room_preferences')
                    ->where('room_pref_id', '=', $id)
                    ->where('room_pref_user_id', '=', Crypt::decryptString($_COOKIE['UserIds']))
                    ->get();
        
        if(count($pref_room) == 0){

            DB::table('chat_room_preferences')->insert([
                'room_pref_id' => $id,
                'room_pref_user_id' => Crypt::decryptString($_COOKIE['UserIds']), 
                'room_pref_name' => $value
            ]);
    
            return redirect('/group-chat-terms')->with(['msg' => 'Your Interest Submitted Successfully.']);

        }else{

            return redirect('/group-chat-terms')->with(['msg' => 'You Have Already Submitted This Interest.']);
        }

        

    }

    public function groupChatGayFemaleView(){
        if(!$this->isUserLoginExist()){
            $this->logout();
            return redirect('/login')->with(['msg' => 'You have to login to view your account']);
    
        } 

        $publicroom = DB::table('gl_gf_public_room')
                ->leftJoin('users', 'users.id', '=', 'gl_gf_public_room.public_user_id')
                ->leftJoin('users_metas', 'users_metas.user_id', '=', 'users.id')
                ->orderBy('gl_gf_public_room.public_room_id', 'DESC')
                ->get();
        
        return view('users.groupchatgayfemale')->with(['publicroom' => $publicroom]);
        
    }

    public function groupChatGayFemaleAction(Request $request){
        if(!$this->isUserLoginExist()){
            $this->logout();
            return redirect('/login')->with(['msg' => 'You have to login to view your account']);
    
        } 

        

        DB::table('gl_gf_public_room')->insert([
            'public_user_id' => Crypt::decryptString($_COOKIE['UserIds']),
            'public_user_name' => Crypt::decryptString($_COOKIE['UserFullName']), 
            'public_message' => $request->input('message'),
            'public_room' => 'gl_gf_public_rom'
        ]);
        
        // return view('users.groupchat');

        return response()->json(['msg'=>'Added']);
        
    }

    public function groupChatOnlineGayFemaleView(){
        if(!$this->isUserLoginExist()){
            $this->logout();
            return redirect('/login')->with(['msg' => 'You have to login to view your account']);
    
        } 

        $onlnuser = DB::table('group_chat_online')
                    ->leftJoin('users', 'users.id', '=', 'group_chat_online.onln_user_id')
                    ->leftJoin('users_metas', 'users_metas.user_id', '=', 'group_chat_online.onln_user_id')
                    ->where('group_chat_online.onln_room_name', '=', 'Lesbian')
                    ->where('group_chat_online.onln_status', '=', 'online')
                    ->where('users.prfl_approve_status', '=', '1')
                    ->where('users_metas.age', '!=', '')
                    ->get();

        
        // return view('users.groupchat')->with(['publicroom' => $publicroom]);
        // return response()->json(['html'=>$onlnuser]);
        //return response()->view('users.group-chat-onln-user', compact('onlnuser',$onlnuser));

        return response()->json([
            'html' => view('users.group-chat-onln-user-gf')->with('onlnuser',$onlnuser)->render()
        ]);



    
}

public function groupChatTermsFemale(){
    if(!$this->isUserLoginExist()){
        $this->logout();
        return redirect('/login')->with(['msg' => 'You have to login to view your account']);

    } 
    
    return view('users.groupchattermsfemale');
    
}

public function groupChatGayMaleView(){
    if(!$this->isUserLoginExist()){
        $this->logout();
        return redirect('/login')->with(['msg' => 'You have to login to view your account']);

    } 

    $publicroom = DB::table('gl_gm_public_room')
            ->leftJoin('users', 'users.id', '=', 'gl_gm_public_room.public_user_id')
            ->leftJoin('users_metas', 'users_metas.user_id', '=', 'users.id')
            ->orderBy('gl_gm_public_room.public_room_id', 'DESC')
            ->get();
    
    return view('users.groupchatgaymale')->with(['publicroom' => $publicroom]);
    
}

public function groupChatGayMaleAction(Request $request){
    if(!$this->isUserLoginExist()){
        $this->logout();
        return redirect('/login')->with(['msg' => 'You have to login to view your account']);

    } 

    

    DB::table('gl_gm_public_room')->insert([
        'public_user_id' => Crypt::decryptString($_COOKIE['UserIds']),
        'public_user_name' => Crypt::decryptString($_COOKIE['UserFullName']), 
        'public_message' => $request->input('message'),
        'public_room' => 'gl_gm_public_room'
    ]);
    
    // return view('users.groupchat');

    return response()->json(['msg'=>'Added']);
    
}

public function groupChatOnlineGayMaleView(){
    if(!$this->isUserLoginExist()){
        $this->logout();
        return redirect('/login')->with(['msg' => 'You have to login to view your account']);

    } 

    $onlnuser = DB::table('group_chat_online')
                    ->leftJoin('users', 'users.id', '=', 'group_chat_online.onln_user_id')
                    ->leftJoin('users_metas', 'users_metas.user_id', '=', 'group_chat_online.onln_user_id')
                    ->where('group_chat_online.onln_room_name', '=', 'Gay')
                    ->where('group_chat_online.onln_status', '=', 'online')
                    ->where('users.prfl_approve_status', '=', '1')
                    ->where('users_metas.age', '!=', '')
                    ->get();

    
    // return view('users.groupchat')->with(['publicroom' => $publicroom]);
    // return response()->json(['html'=>$onlnuser]);
    //return response()->view('users.group-chat-onln-user', compact('onlnuser',$onlnuser));

    return response()->json([
        'html' => view('users.group-chat-onln-user-gm')->with('onlnuser',$onlnuser)->render()
    ]);




}

public function groupChatTermsMale(){
    if(!$this->isUserLoginExist()){
        $this->logout();
        return redirect('/login')->with(['msg' => 'You have to login to view your account']);

    } 
    
    return view('users.groupchattermsmale');
    
}

//////////////////////////////
public function groupChaTransexualView(){
    if(!$this->isUserLoginExist()){
        $this->logout();
        return redirect('/login')->with(['msg' => 'You have to login to view your account']);

    } 

    $publicroom = DB::table('gl_trans_public_room')
            ->leftJoin('users', 'users.id', '=', 'gl_trans_public_room.public_user_id')
            ->leftJoin('users_metas', 'users_metas.user_id', '=', 'users.id')
            ->orderBy('gl_trans_public_room.public_room_id', 'DESC')
            ->get();
    
    return view('users.groupchattransexual')->with(['publicroom' => $publicroom]);
    
}

public function groupChatTransexualAction(Request $request){
    if(!$this->isUserLoginExist()){
        $this->logout();
        return redirect('/login')->with(['msg' => 'You have to login to view your account']);

    } 

    

    DB::table('gl_trans_public_room')->insert([
        'public_user_id' => Crypt::decryptString($_COOKIE['UserIds']),
        'public_user_name' => Crypt::decryptString($_COOKIE['UserFullName']), 
        'public_message' => $request->input('message'),
        'public_room' => 'gl_trans_public_room'
    ]);
    
    // return view('users.groupchat');

    return response()->json(['msg'=>'Added']);
    
}

public function groupChatOnlineTransexualView(){
    if(!$this->isUserLoginExist()){
        $this->logout();
        return redirect('/login')->with(['msg' => 'You have to login to view your account']);

    } 

    $onlnuser = DB::table('group_chat_online')
                    ->leftJoin('users', 'users.id', '=', 'group_chat_online.onln_user_id')
                    ->leftJoin('users_metas', 'users_metas.user_id', '=', 'group_chat_online.onln_user_id')
                    ->where('group_chat_online.onln_room_name', '=', 'Transexual')
                    ->where('group_chat_online.onln_status', '=', 'online')
                    ->where('users.prfl_approve_status', '=', '1')
                    ->where('users_metas.age', '!=', '')
                    ->get();
    
    // return view('users.groupchat')->with(['publicroom' => $publicroom]);
    // return response()->json(['html'=>$onlnuser]);
    //return response()->view('users.group-chat-onln-user', compact('onlnuser',$onlnuser));

    return response()->json([
        'html' => view('users.group-chat-onln-user-tansexual')->with('onlnuser',$onlnuser)->render()
    ]);




}

public function groupChatTermsTransexual(){
    if(!$this->isUserLoginExist()){
        $this->logout();
        return redirect('/login')->with(['msg' => 'You have to login to view your account']);

    } 
    
    return view('users.groupchattermstransexual');
    
}

/////////////////////////////////

public function groupChatGayLesbianView(){
    if(!$this->isUserLoginExist()){
        $this->logout();
        return redirect('/login')->with(['msg' => 'You have to login to view your account']);

    } 

    $publicroom = DB::table('gl_gay_female_public_room')
            ->leftJoin('users', 'users.id', '=', 'gl_gay_female_public_room.public_user_id')
            ->leftJoin('users_metas', 'users_metas.user_id', '=', 'users.id')
            ->orderBy('gl_gay_female_public_room.public_room_id', 'DESC')
            ->get();
    
    return view('users.groupchatgaylesbian')->with(['publicroom' => $publicroom]);
    
}

public function groupChatGayLesbianAction(Request $request){
    if(!$this->isUserLoginExist()){
        $this->logout();
        return redirect('/login')->with(['msg' => 'You have to login to view your account']);

    } 

    

    DB::table('gl_gay_female_public_room')->insert([
        'public_user_id' => Crypt::decryptString($_COOKIE['UserIds']),
        'public_user_name' => Crypt::decryptString($_COOKIE['UserFullName']), 
        'public_message' => $request->input('message'),
        'public_room' => 'gl_gay_female_public_room'
    ]);
    
    // return view('users.groupchat');

    return response()->json(['msg'=>'Added']);
    
}

public function groupChatOnlineGayLesbianView(){
    if(!$this->isUserLoginExist()){
        $this->logout();
        return redirect('/login')->with(['msg' => 'You have to login to view your account']);

    } 

    $onlnuser = DB::table('users')
                ->leftJoin('users_metas', 'users_metas.user_id', '=', 'users.id')
                ->where('users_metas.sex', '=', 'Male')
                ->orWhere('users_metas.sex', '=', 'Female')
                ->get();
    
    // return view('users.groupchat')->with(['publicroom' => $publicroom]);
    // return response()->json(['html'=>$onlnuser]);
    //return response()->view('users.group-chat-onln-user', compact('onlnuser',$onlnuser));

    return response()->json([
        'html' => view('users.group-chat-onln-user-gay-female')->with('onlnuser',$onlnuser)->render()
    ]);




}

public function groupChatTermsGayLesbian(){
    if(!$this->isUserLoginExist()){
        $this->logout();
        return redirect('/login')->with(['msg' => 'You have to login to view your account']);

    } 
    
    return view('users.groupchattermsgayfemale');
    
}

public function cs_chatinsert(Request $request) {

    $today = date('Y-m-d H:i:s');
    return response()->json($today);
    //check if new message or now
   // $chk_duplicate = DB::connection('mysql2')->Select("select room_id from users_chat_rooms where (room_from_id = '".$request->from_id."' and room_to_id = '".$request->to_id."' and room_key = 'bes') or (room_from_id = '".$request->to_id."' and room_to_id = '".$request->from_id."' and room_key = 'bes')");

    
   

   

    
    
    

    
}

}
