<?php

namespace App\Http\Controllers\api;

use App\Http\Requests\PatientRequest;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;
use App\Models\Patient;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\PatientResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PatientController extends Controller
{

    public function store(PatientRequest $request)
    {
        // dd(Auth::guard('doctor')->id());
        // dd($request->all());
        // $request->validated();

        $data = $request->only('name', 'contact', 'doctor_id');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            // $file->move(\public_path("/file"), $filename);
            $path = $file->storeAs('public/file', $filename);
            $data['file'] = $filename;
        }


        $data['doctor_id'] = $request->doctor_id;
        $patient = Patient::create($data);
        // return back();
        if ($patient) {
            $response = [
                'status' => 'ok',
                'success' => true,
                'message' => 'Record created succesfully!',
                'data' => $data
            ];
            return response()->json($response);
        } else {
            $response = [
                'status' => 'ok',
                'success' => false,
                'message' => 'Record created failed!'
            ];
            return response()->json($response);
        }
    }

    public function delete(Request $request)
    {
        // dd($request->id);
        $patient = Patient::find($request->id);

        $file_path = storage_path('app/public/file/' . $patient->file);
        // $file = Patient::where("patient_id", $patient->patient_id)->get();
        if (File::exists($file_path)) {

            unlink($file_path);
        }
        $patient->delete();
        if ($patient) {
            $response = [
                'status' => 'ok',
                'success' => true,
                'message' => 'Record deleted!'
            ];
            return response()->json($response);
        } else {
            $response = [
                'status' => 'ok',
                'success' => false,
                'message' => 'Record deleted failed!'
            ];
            return response()->json($response);
        }
    }

    public function update(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required',
            'contact' => 'required',
        ]);
        // dd($request->id);
        $patient = Patient::find($id);
        //  dd($patient);
        $data = $request->only('name', 'contact');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            // $file->move(\public_path("/file"), $filename);
            $path = $file->storeAs('file', $filename);
            $data['file'] = $filename;
        }
        $patient->update($data);
        if ($patient) {
            $response = [
                'status' => 'ok',
                'success' => true,
                'message' => 'Record updated!'
            ];
            return response()->json($response);
        } else {
            $response = [
                'status' => 'ok',
                'success' => false,
                'message' => 'Record updated failed!'
            ];
            return response()->json($response);
        }
    }

    public function edit(Patient $patient)
    {
        return response()->json($patient);
    }


    public function list(Request $request)
    {
       
        // dd($request->all()); 
        
        $response = [
            'status' => 'ok',
            'success' => true,
            'message' => 'Record list',
            'data'  => Patient::where('doctor_id', $request->doctor_id)->latest()->paginate()

        ];
        return response()->json($response);
        // return Patient::where('doctor_id',  $request->doctor_id)->latest()->paginate();

    }

    public function index()
    {
       
        $patient = Patient::where('doctor_id',9)->first();
        // dd($patient);
        return new PatientResource($patient);
        // return response()->json($patient);
    }


   
}
