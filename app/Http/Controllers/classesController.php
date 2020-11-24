<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes;
use App\Students;

class classesController extends Controller
{
    public function add(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'code'=>'required|regex:/^[a-zA-Z0-9_\-]*$/',
            'name'=>'required|regex:/^[a-zA-Z0-9_\-]*$/',
            'description'=>'required|regex:/^[a-zA-Z0-9_\-]*$/'
           
    ],
    [
        'code.required'=>'Please enter code',
        'name.required'=>'Please enter name',
        'description.required'=>'Please enter description',
        'code.regex'=>'Please enter valid code',
        'name.regex'=>'Please enter valid name',
        'description.regex'=>'Please valid description'


        
    ]      
    );
    if(!$validator->fails())
    {
       $objClasses = new Classes();
       $objClasses->code = request('code');
       $objClasses->name = request('name');
       $objClasses->description = request('description');
       $objClasses->maximum_students = 10;
       $objClasses->status = 1;
       if($objClasses->save())
       {
        $arr['msg']='Class created successfully';
        return json_encode($arr);
       }
       else{
        $arr['msg']='Please check error occured';
        return json_encode($arr);
       }
    }
    else{
        $arr['msg']=$validator->errors();
        return json_encode($arr);
    }
    }
    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'id'=>'required|numeric',
            'code'=>'required|regex:/^[a-zA-Z0-9_\-]*$/',
            'name'=>'required|regex:/^[a-zA-Z0-9_\-]*$/',
            'description'=>'required|regex:/^[a-zA-Z0-9_\-]*$/'
           
    ],
    [
        'id.required'=>'Please enter id',
        'code.required'=>'Please enter code',
        'name.required'=>'Please enter name',
        'description.required'=>'Please enter description',
        'id.numeric'=>'Please enter valid id',
        'code.regex'=>'Please enter valid code',
        'name.regex'=>'Please enter valid name',
        'description.regex'=>'Please valid description'


        
    ]      
    );
    if(!$validator->fails())
    {
       $objClasses = Classes::find(request('id'));
       $objClasses->code = request('code');
       $objClasses->name = request('name');
       $objClasses->description = request('description');
       $objClasses->maximum_students = 10;
       $objClasses->status = 1;
       if($objClasses->save())
       {
        $arr['msg']='Class updated successfully';
        return json_encode($arr);
       }
       else{
        $arr['msg']='Please check error occured';
        return json_encode($arr);
       }
    }
    else{
        $arr['msg']=$validator->errors();
        return json_encode($arr);
    }
    }
    public function list()
    {
        $objClasses = array();
        $objClasses = Classes::all();
        if(count($objClasses)>0)
        {
            
            return json_encode($objClasses);
        }
        else
        {
            $objClasses['msg']='no data found';
            return json_encode($objClasses);
        }
    }


    public function view(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'id'=>'required|numeric'
            
    ],
    [
        'id.required'=>'Please enter id'
    ]      
    );
    if(!$validator->fails())
    {
        $objClasses = new Classes(); 
        $objStudents = new Students();
        $arrdetails       = $objClasses->where('id',request('id'))->get();
       if(count($arrdetails)>0)
       {
        $arr['details']=$arrdetails;
        $student_array = $objStudents->where('class',request('id'))->get();
        $arr['sub_details']=$student_array;
        return json_encode($arr);
       }
       else{
        $arr['msg']='no data';
        return json_encode($arr);
       }
    }
    else{
        $arr['msg']=$validator->errors();
        return json_encode($arr);
    }
    }
}
