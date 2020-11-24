<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Login;
class loginController extends Controller
{
   public function login(Request $request)
   {
      
   return view('login.index');
   }
   public function submit(Request $request)
   {
    $this->validate(request(),[
            'username'=>'required',
            'pass'=>'required'
    ],
    [
        'username.required'=>'Please enter username',
        'pass.required'=>'Please enter password'
    ]      
    );
    $username=htmlspecialchars(request('username'), ENT_QUOTES);
    $pass=htmlspecialchars(request('pass'), ENT_QUOTES);
    $objLogin = new Login();
    $loginArr = $objLogin->where([['username',$username],['password',$pass]])->get();
    
    if(isset($loginArr))
    {
    if(count($loginArr))
    {
        return redirect('/');
    }
    else
    {
        $request->session()->flash('REG-MSG','Login details entered not currect');
        return redirect('login');
    }
}

}
public function submitMob(Request $request)
   {
    $validator = \Validator::make($request->all(),[
            'username'=>'required',
            'pass'=>'required'
    ],
    [
        'username.required'=>'Please enter username',
        'pass.required'=>'Please enter password'
    ]      
    );
    if(!$validator->fails())
    {
        $arr['msg']='validation success';
    }
    else{
        $arr['msg']=$validator->errors();
        return json_encode($arr);
    }
    $username=htmlspecialchars(request('username'), ENT_QUOTES);
    $pass=htmlspecialchars(request('pass'), ENT_QUOTES);
    $objLogin = new Login();
    $loginArr = $objLogin->where([['username',$username],['password',$pass]])->get();
    /*
    $client = new \GuzzleHttp\client();
    $body['']='';
    */
    if(isset($loginArr))
    {
    if(count($loginArr))
    {
        $arr['status']=1;
        $arr['success']='Logined successfully';
    }
    else
    {
        $arr['status']=0;
        $arr['success']='Please check login details';
        
    }
   }
   return json_encode($arr);
}

}
