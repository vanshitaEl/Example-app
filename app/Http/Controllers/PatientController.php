<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        // $patients = Patient::get();

        // if ($request->has('view_delete')) {

        //     $patients = Patient::onlyTrash()->get();
        // }

        return view('patient');
    }
    public function list()
    {
        return Patient::where('doctor_id', Auth::guard('doctor')->id())->latest()->paginate();
        // return Patient::with('doctor', Auth::guard('doctor')->id())->latest()->paginate();
        return Auth::guard('doctor')->user()->patients()->latest()->paginate();
    }

    public function doctors()
    {

        return Patient::with('doctor')->find(4);
    }

    // public function patients()
    // {
    //     return Patient::with('doctors')->where('doctor_id')->get('patients');
    // }

    public function store(PatientRequest $request)
    {
        // $request->validated();

        $data = $request->only('name', 'contact');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            // $file->move(\public_path("/file"), $filename);
            $path = $file->storeAs('public/file', $filename);
            $data['file'] = $filename;
        }


        $data['doctor_id'] = Auth::guard('doctor')->id();
        $patient = Patient::create($data);
        return back();
        if ($patient) {
            $response = [
                'status' => 'ok',
                'success' => true,
                'message' => 'Record created succesfully!'
            ];
            return $response;
        } else {
            $response = [
                'status' => 'ok',
                'success' => false,
                'message' => 'Record created failed!'
            ];
            return $response;
        }
    }

    // public function show(Patient $patient)
    // {
    //     return view('show', compact('patient'));
    // }

    public function edit($id)
    {
        $patient = Patient::find($id);
        return $patient;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'contact' => 'required',
        ]);

        $patient = Patient::find($id);

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
            return $response;
        } else {
            $response = [
                'status' => 'ok',
                'success' => false,
                'message' => 'Record updated failed!'
            ];
            return $response;
        }
    }

    public function trash()
    {
        $patients = Patient::onlyTrashed()->get();
        return View::make('patient_SoftDelete')->with('patients', $patients);
        //   return response()->json($patients);
    }



    // public function restoreJob(Request $request, $id)
    // {
    //     Patient::withTrashed()->find($id)->restore();
    // }




    public function delete(Request $request)
    {
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
            return $response;
        } else {
            $response = [
                'status' => 'ok',
                'success' => false,
                'message' => 'Record deleted failed!'
            ];
            return $response;
        }
    }
}
// return view('patient', compact('patient'))->with((request()->input('page', 1) - 1) * 5);