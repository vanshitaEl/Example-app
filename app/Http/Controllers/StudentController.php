<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StudentController extends Controller
{

    public function index()
    {
        $students = Student::latest()->paginate(10);
        return view('index', compact('students'))->with((request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'std' => 'required',
        ]);

        $student = Student::create($request->all());
        if ($request->hasFile("images")) {
            $files = $request->file("images");

            foreach ($files as $file) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(\public_path("/images"), $imageName);
                $data = [
                    'student_id' => $student->student_id,
                    'image' => $imageName
                ];
                Image::create($data);
            }
        }
        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        return view('show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('edit', compact('student'));
       
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'std' => 'required',
        ]);
         
        $student->update($request->all());

        if ($request->hasFile("images")) {
            $files = $request->file("images");

            foreach ($files as $file) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(\public_path("/images"), $imageName);
                $data = [
                    'student_id' => $student->student_id,
                    'image' => $imageName
                ];
                Image::create($data);
            }
        }
        return redirect()->route('students.index')->with('success', 'Student updated successfully');
    }

    public function destroy($id)
    {
        $student = Student::find($id);
        $image = Image::where("student_id", $student->student_id)->get();

        foreach ($image as $image) {

            if (File::exists("images/" . $image->image)) {
                File::delete("images/" . $image->image);
            }
        }
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully');
    }
}
