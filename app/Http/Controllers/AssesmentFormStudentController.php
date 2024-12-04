<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\IndustryClass\AssesmentFormStudentInterface;
use App\Models\Student;
use Illuminate\Http\Request;

class AssesmentFormStudentController extends Controller
{
    private AssesmentFormStudentInterface $assesmentFormStudent;

    public function __construct(AssesmentFormStudentInterface $assesmentFormStudent)
    {
        $this->assesmentFormStudent = $assesmentFormStudent;
    }
}
