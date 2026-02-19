<?php

namespace Modules\Notebook\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class StudentCardController extends Controller
{
    public function print(SchoolClass $schoolClass)
    {
        // Security Check
        if ($schoolClass->user_id !== auth()->id()) {
            abort(403);
        }

        $students = $schoolClass->students()->orderBy('name')->get();

        return view('notebook::print-cards', [
            'schoolClass' => $schoolClass,
            'students' => $students
        ]);
    }
}
