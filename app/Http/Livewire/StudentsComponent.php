<?php

namespace App\Http\Livewire;

use App\Models\Students;
use Livewire\Component;

class StudentsComponent extends Component
{
    public $student_id, $student_fname, $student_mname, $student_lname, $student_email, $student_mobile, $student_delete_id;
    public $view_student_id, $view_student_fname, $view_student_mname, $view_student_lname, $view_student_email, $view_student_mobile;

    protected $rules = [
        'student_id' => 'required|unique:students', // 'students' is a table name
        'student_fname' => 'required',
        'student_lname' => 'required',
        'student_email' => 'required|email|unique:students',
        'student_mobile' => 'required|numeric|unique:students'
    ];

    protected $messages = [
        'student_id.required' => "Student ID is required.",
        'student_id.unique' => "Student ID must be unique.",
        'student_fname.required' => "First Name is required.",
        'student_lname.required' => "Last Name is required.",
        'student_email.required' => "Email Address is required.",
        'student_email.email' => "Email Address format is not valid.",
        'student_email.unique' => "Email Address is already existing.",
        'student_mobile.required' => "Mobile No. is required.",
        'student_mobile.numeric' => "Mobile No. must be numeric.",
        'student_mobile.unique' => "Mobile No. is already existing."
    ];

    // Input fields validation
    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function saveStudentData()
    {
        $this->validate();

        // Add Student
        $student = new Students();
        $student->student_id = $this->student_id;
        $student->student_fname = ucwords($this->student_fname);
        if($this->student_mname == "") {
            $student->student_mname = "";
        }
        else{
            $student->student_mname = ucwords($this->student_mname);
        }
        $student->student_lname = ucwords($this->student_lname);
        $student->student_email = $this->student_email;
        $student->student_mobile = $this->student_mobile;

        $student->save();

        session()->flash('message', 'Student has been added successfully!');

        $this->student_id = "";
        $this->student_fname = "";
        $this->student_mname = "";
        $this->student_lname = "";
        $this->student_email = "";
        $this->student_mobile = "";

        // Hide modal after submit
        $this->dispatchBrowserEvent('close-modal');
    }

    public function getStudentId($id)
    {
        $student = Students::where('id', $id)->first();
        $this->student_current_id = $student->id;
        $this->student_id = $student->student_id;
        $this->student_fname = $student->student_fname;
        $this->student_mname = $student->student_mname;
        $this->student_lname = $student->student_lname;
        $this->student_email = $student->student_email;
        $this->student_mobile = $student->student_mobile;

        $this->dispatchBrowserEvent('show-edit-student-modal');
    }

    public function editStudentData()
    {
        $this->validate([
            'student_id' => 'required|unique:students,student_id,'.$this->student_current_id, // 'students' is a table name. validation to ignore current ID
            'student_email' => 'required|unique:students,student_email,'.$this->student_current_id,
            'student_mobile' => 'required|unique:students,student_mobile,'.$this->student_current_id
        ]);

        $student = Students::where('id', $this->student_current_id)->first();
        $student->student_id = $this->student_id;
        $student->student_fname = $this->student_fname;
        if($this->student_mname == "") {
            $student->student_mname = "";
        }
        else{
            $student->student_mname = $this->student_mname;
        }
        $student->student_lname = $this->student_lname;
        $student->student_email = $this->student_email;
        $student->student_mobile = $this->student_mobile;

        $student->save();

        $this->student_id = "";
        $this->student_fname = "";
        $this->student_mname = "";
        $this->student_lname = "";
        $this->student_email = "";
        $this->student_mobile = "";

        session()->flash('message', 'Student information has been modified successfully!');

        $this->dispatchBrowserEvent('close-modal');
    }

    public function deleteConfirmation($id)
    {
        //$student = Students::where('id', $id)->first();
        $this->student_delete_id = $id; // Student ID
        $this->dispatchBrowserEvent('show-delete-confirmation-modal');
    }

    public function deleteStudentData()
    {
        $student = Students::where('id', $this->student_delete_id)->first();
        $student->delete();

        session()->flash('message', 'Student information has been deleted successfully!');
        $this->dispatchBrowserEvent('close-modal');

        $this->student_delete_id = '';
    }

    public function viewStudentData($id)
    {
        $student = Students::where('id', $id)->first();
        $this->view_student_id = $student->student_id;
        $this->view_student_fname = $student->student_fname;
        $this->view_student_lname = $student->student_lname;
        $this->view_student_mname = $student->student_mname;
        $this->view_student_email = $student->student_email;
        $this->view_student_mobile = $student->student_mobile;

        $this->dispatchBrowserEvent('show-view-student-modal');
    }

    public function resetForm()
    {
        $this->student_id = "";
        $this->student_fname = "";
        $this->student_mname = "";
        $this->student_lname = "";
        $this->student_email = "";
        $this->student_mobile = "";
    }

    public function cancel()
    {
        $this->student_delete_id = '';
    }

    public function closeViewStudentModal()
    {
        $this->view_student_id = '';
        $this->view_student_fname = '';
        $this->view_student_lname = '';
        $this->view_student_mname = '';
        $this->view_student_email = '';
        $this->view_student_mobile = '';
    }

    public function randomId()
    {
        $this->student_id = rand(0, 9999);
    }

    public function render()
    {
        // Fetch all students
        $students = Students::all();
        return view('livewire.students-component', ['students' => $students])->layout('livewire.layouts.base');
    }
}
