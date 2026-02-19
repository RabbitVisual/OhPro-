<?php

namespace Modules\ClassRecord\Livewire;

use Livewire\Component;
use Modules\ClassRecord\Services\GoogleClassroomService;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class ImportGoogleRoster extends Component
{
    public $courses = [];
    public $selectedCourseId;
    public $students = [];
    public $selectedStudents = [];
    public $targetClassId;

    public $step = 1;
    public $isLoading = false;

    public function mount()
    {
        if (!session('google_token')) {
            return redirect()->route('google.redirect');
        }

        $this->fetchCourses();
    }

    public function fetchCourses()
    {
        $service = new GoogleClassroomService();
        try {
            $this->courses = $service->listCourses(session('google_token'));
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao buscar cursos: ' . $e->getMessage());
        }
    }

    public function selectCourse($courseId)
    {
        $this->selectedCourseId = $courseId;
        $this->fetchStudents($courseId);
        $this->step = 2;
    }

    public function fetchStudents($courseId)
    {
        $service = new GoogleClassroomService();
        try {
            $apiStudents = $service->listStudents(session('google_token'), $courseId);
            // Map to standard format
            $this->students = collect($apiStudents)->map(function ($s) {
                return [
                    'id' => $s['userId'],
                    'name' => $s['profile']['name']['fullName'],
                    'email' => $s['profile']['emailAddress'] ?? null,
                ];
            })->toArray();

            // Auto select all
            $this->selectedStudents = array_column($this->students, 'id');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao buscar alunos: ' . $e->getMessage());
        }
    }

    public function import()
    {
        $this->validate([
            'targetClassId' => 'required|exists:school_classes,id',
            'selectedStudents' => 'required|array|min:1',
        ]);

        $class = SchoolClass::find($this->targetClassId);
        $count = 0;

        foreach ($this->students as $s) {
            if (in_array($s['id'], $this->selectedStudents)) {
                // Find or create student
                $student = Student::firstOrCreate(
                    ['email' => $s['email']], // Assuming email is unique key, ideally composite with user_id but for import simplified
                    [
                        'name' => $s['name'],
                        'user_id' => auth()->id(), // Ownership
                        // 'google_id' => $s['id'] // If we had this column
                    ]
                );

                // Attach to class if not already
                if (!$class->students()->where('student_id', $student->id)->exists()) {
                    $class->students()->attach($student->id);
                    $count++;
                }
            }
        }

        session()->flash('success', "{$count} alunos importados com sucesso!");
        return redirect()->route('workspace.show', $class->id);
    }

    public function render()
    {
        return view('classrecord::livewire.import-google-roster', [
            'myClasses' => SchoolClass::where('user_id', auth()->id())->get(),
        ]);
    }
}
