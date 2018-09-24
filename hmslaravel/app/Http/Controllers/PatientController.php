<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Patient;
// use App\Http\Resources\Patient;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::paginate(15);
        return $patients;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $patient = $request->isMethod('put') ? Patient:: findOrFail($request->id): new Patient;
        $patient->id = $request->input('id');
        $patient->name = $request->input('name');
        $patient->age = $request->input('age');
        $patient->weight = $request->input('weight');
        $patient->phone = $request->input('phone');
        $patient->disease = $request->input('disease');
        $patient->doctorid = $request->input('doctorid');
        if($patient->save()){
            return $patient;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient:: findOrFail($id);
        
        return $patient;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $input = $request->all();
        $validator = Validator::make($input, [

        'fname' => 'required',
        'age' => 'required',
        'weight' => 'required',
        'phone' => 'required',
        'disease' => 'required',
        'doctorid' => 'required',
        ]);

        if($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors(), 422); 
        }

        $post = Patient::find($id);
        if (is_null($post)) {
        return $this->sendError(' Not found.');
        }

        $post->name = $input['fname'];
        $post->age = $input['age'];
        $post->weight = $input['weight'];
        $post->phone = $input['phone'];
        $post->disease= $input['disease'];
        $post->doctorid= $input['doctorid'];

        $post->save();

        return $this->sendResponse($post->toArray(), 'Details updated successfully.');
        }
            

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = Patient:: findOrFail($id);
        if($patient->delete());
        return $patient;
    }
}
