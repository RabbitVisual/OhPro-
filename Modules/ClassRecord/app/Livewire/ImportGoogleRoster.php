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

        $selectedData = collect($this->students)
            ->whereIn('id', $this->selectedStudents)
            ->map(function ($s) {
                return [
                    'email' => $s['email'],
                    'name' => $s['name'],
                    'user_id' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->values();

        if ($selectedData->isEmpty()) {
            session()->flash('success', "Nenhum aluno selecionado.");
            return redirect()->route('workspace.show', $class->id);
        }

        // Bulk create/update students
        // We only update updated_at to preserve existing data (like name) if the student already exists,
        // matching the behavior of firstOrCreate.
        Student::upsert($selectedData->toArray(), ['email'], ['updated_at']);

        // Get IDs of all students by email
        $emails = $selectedData->pluck('email')->toArray();
        $studentIds = Student::whereIn('email', $emails)->pluck('id')->toArray();

        // Bulk attach to class: find missing ones and insert in bulk
        $existingStudentIds = $class->students()
            ->whereIn('student_id', $studentIds)
            ->pluck('student_id')
            ->toArray();

        $studentIdsToAttach = array_diff($studentIds, $existingStudentIds);
        $count = count($studentIdsToAttach);

        if (!empty($studentIdsToAttach)) {
            $pivotData = array_map(function ($id) use ($class) {
                return [
                    'school_class_id' => $class->id,
                    'student_id' => $id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $studentIdsToAttach);

            DB::table('school_class_student')->insert($pivotData);
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
