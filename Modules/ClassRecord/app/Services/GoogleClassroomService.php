<?php

namespace Modules\ClassRecord\Services;

use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class GoogleClassroomService
{
    protected string $baseUrl = 'https://classroom.googleapis.com/v1';

    /**
     * Get the redirect URL for Google login with Classroom scopes.
     */
    public function getRedirectUrl()
    {
        return Socialite::driver('google')
            ->scopes([
                'https://www.googleapis.com/auth/classroom.courses.readonly',
                'https://www.googleapis.com/auth/classroom.rosters.readonly',
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/userinfo.profile',
            ])
            ->redirect()
            ->getTargetUrl();
    }

    /**
     * Fetch courses from Google Classroom.
     * requires user token
     */
    public function listCourses(string $token)
    {
        $response = Http::withToken($token)
            ->get("{$this->baseUrl}/courses", [
                'courseStates' => 'ACTIVE',
            ]);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch courses from Google Classroom.');
        }

        return $response->json('courses') ?? [];
    }

    /**
     * Fetch students for a specific course.
     */
    public function listStudents(string $token, string $courseId)
    {
        $response = Http::withToken($token)
            ->get("{$this->baseUrl}/courses/{$courseId}/students");

        if ($response->failed()) {
            throw new \Exception('Failed to fetch students from Google Classroom.');
        }

        return $response->json('students') ?? [];
    }
}
