<?php

namespace Modules\Support\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TeacherSupportController extends Controller
{
    /**
     * Display the support page for teachers.
     */
    public function index(): View
    {
        return view('support::teacher.index', [
            'title' => 'Suporte'
        ]);
    }
}
