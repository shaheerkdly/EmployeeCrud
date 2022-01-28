<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationMail;
use App\Models\Designation;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::get();
        return view('admin.index', compact('employees'));
    }

    public function create()
    {
        $designations = Designation::pluck('name', 'id');

        return view('admin.create', compact('designations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'designation' => 'required|exists:designations,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);
        $employee = new Employee();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->designation_id = $request->designation;
        $password = Str::random(8);
        $employee->password = Hash::make($password);
        $employee->save();
        if ($request->has('image')) {
            $this->imageUploadFunction($employee, $request->image);
        }
        $request->session()->flash('message', 'Created');
        $mail = Mail::to($employee->email)->send(new RegistrationMail($request->name, $password));

        return redirect()->route('index');
    }

    public function edit(Employee $employee)
    {
        $designations = Designation::pluck('name', 'id');

        return view('admin.edit', compact('employee', 'designations'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'designation' => 'required|exists:designations,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'delete_image' => 'nullable|in:1',
        ]);
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->designation_id = $request->designation;
        $employee->update();
        if ($request->has('image')) {
            if ($employee->image) {
                unlink("images/".$employee->image);
            }
            $this->imageUploadFunction($employee, $request->image);
        } elseif ($request->has('delete_image')) {
            if ($employee->image) {
                unlink("images/".$employee->image);
                $employee->image = null;
                $employee->update();
            }
        }
        $request->session()->flash('message', 'Updated');
        return redirect()->route('index');
    }

    public function destroy(Employee $employee, Request $request)
    {
        if ($employee->image) {
            unlink("images/".$employee->image);
        }
        $employee->delete();
        $request->session()->flash('message', 'Deleted');

        return redirect()->route('index');
    }

    public function imageUploadFunction($employee, $image)
    {

        $image_name = time().'.'.$image->extension();
        $image->move(public_path('images'), $image_name);

        $employee->image = $image_name;
        $employee->update();

        return true;
    }
}

