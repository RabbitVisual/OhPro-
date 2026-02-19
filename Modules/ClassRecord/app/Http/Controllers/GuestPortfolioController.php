<?php

namespace Modules\ClassRecord\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\ClassRecord\Models\GuestAccessToken; // I need to create this model

class GuestPortfolioController extends Controller
{
    public function show(string $token)
    {
        $accessToken = DB::table('guest_access_tokens')
            ->where('token', $token)
            ->where('active', true)
            ->where('expires_at', '>', now())
            ->first();

        if (!$accessToken) {
            abort(404, 'Link inválido ou expirado.');
        }

        // Increment usage
        DB::table('guest_access_tokens')
            ->where('id', $accessToken->id)
            ->increment('usage_count', 1, ['last_used_at' => now()]);

        $student = Student::with(['schoolClasses', 'portfolioEntries' => function($query) {
             // Filter hidden entries if needed, assuming a 'visible_to_guest' column or similar logic exists
             // For now fetch all
             $query->latest();
        }])->findOrFail($accessToken->student_id);

        return view('classrecord::guest.portfolio', [
            'student' => $student,
            'token' => $accessToken,
        ]);
    }
}
