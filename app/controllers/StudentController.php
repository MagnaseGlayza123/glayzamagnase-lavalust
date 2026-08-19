<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentController extends Controller
{
    public function index()
    {
        $this->call->view('student_home');
    }

    public function profile()
    {
       $student = [
    'student_id' => '2024-00188',
    'name' => 'Magnase Glayza',
    'course' => 'BS Information Technology',
    'year' => '3rd Year',
    'section' => 'BSIT 3F4',
    'email' => 'glayzamagnase534@gmail.com'
];

        $this->call->view('student_profile', $student);
    }
}