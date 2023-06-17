<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Country;

// use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $students =  Student::get();
       return response()->json($students);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'name'=>'required',
            'age'=>'required',
            'roll'=>'required'
        ]);
        if($validation->fails()){

            return response()->json([
                'status'=>400,
                'errors' => $validation->messages()
            ]);

        }else{
        $students = Student::create($request->all());
        return response()->json([
            'status' => 200,
            'message'=>"Student created successfully"
        ]);

        }

       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $students = Student::findOrFail($id);

      return response()->json($students);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       $data = Student::findOrFail($id);
       $response =  $data->update($request->all());
       return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);
        $student->delete();
        return response()->json('success');
    }

    public function country_city(){
        $Country = Country::find(1);

        $Country_city = $Country->cities;

        dd($Country_city);
    }
}
