<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes;
use App\Students;
use DB;
class studentsController extends Controller
{
    public function add(Request $request)
    {
        $validator = \Validator::make($request->all(),
        [
            'class'=>'required|numeric',
            'first_name'=>'required|regex:/^[a-zA-Z0-9_\-]*$/',
            'last_name'=>'required|regex:/^[a-zA-Z0-9_\-]*$/',
            'date_of_birth'=>'required',
           
    ],
    [
        'class.required'=>'Please enter class id',
        'first_name.required'=>'Please enter  name',
        'last_name.required'=>'Please enter last name',
        'date_of_birth.required'=>'Please enter DOB',
        'first_name.regex'=>'Please enter valid  firstname',
        'last_name.regex'=>'Please valid last name',
        'class.numeric'=>'Please class id  must be numeric',


        
    ]      
    );
    if(!$validator->fails())
    {
       
       
       $objStudents = new Students();
       $count = array();
       $count = $objStudents->where('class',request('class'))->get();
       if(count($count)<=10)
       {
       $objStudents->first_name = request('first_name');
       $objStudents->last_name = request('last_name');
       $objStudents->date_of_birth = date('Y-m-d',strtotime(request('date_of_birth')));
       $objStudents->class = request('class');
       
       if($objStudents->save())
       {
        $arr['msg']='student created successfully';
        return json_encode($arr);
       }
       else{
        $arr['msg']='Please check error occured';
        return json_encode($arr);
       }
      }
      else
      {
        $arr['msg']='You exceed the limit';
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
        $validator = \Validator::make($request->all(),
        [
            'id'=>'required|numeric',
            'class'=>'required|numeric',
            'first_name'=>'required|regex:/^[a-zA-Z0-9_\-]*$/',
            'last_name'=>'required|regex:/^[a-zA-Z0-9_\-]*$/',
            'date_of_birth'=>'required',
           
    ],
    [
        'id.required'=>'Please enter valid id',
        'class.required'=>'Please enter class id',
        'first_name.required'=>'Please enter  name',
        'last_name.required'=>'Please enter last name',
        'date_of_birth.required'=>'Please enter DOB',
        'first_name.regex'=>'Please enter valid  firstname',
        'last_name.regex'=>'Please valid last name',
        'class.numeric'=>'Please class id  must be numeric',


        
    ]      
    );
    if(!$validator->fails())
    {
       
       
       $objStudents = Students::find(request('id'));
       $objStudents->first_name = request('first_name');
       $objStudents->last_name = request('last_name');
       $objStudents->date_of_birth = date('Y-m-d',strtotime(request('date_of_birth')));
       $objStudents->class = request('class');
       
       if($objStudents->save())
       {
        $arr['msg']='student updated successfully';
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
        
        
        $students=DB::table('students')
            ->join('classes','students.class', '=', 'classes.id')
			->select('students.*','classes.name')
            ->get();
        if(count($students)>0)
        {
            
            return json_encode($students);
        }
        else
        {
            $students['msg']='no data found';
            return json_encode($students);
        }
    }
}
