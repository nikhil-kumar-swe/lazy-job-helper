<?php

namespace App\Http\Controllers;

use App\Services\ModelClient;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function create()
    {
        return view('applications.create');
    }

    public function store(Request $request, ModelClient $client)
    {
        $data = $request->validate([
            'job_title' => ['required', 'string', 'max:150'],
            'job_description' => ['required', 'string', 'min:50', 'max:6000'],
            'resume_text' => ['required', 'string', 'min:50', 'max:6000'],
        ]);

        try {
            $result = $client->analyze(
                $data['resume_text'],
                $data['job_description'],
                $data['job_title']
            );
        } catch (\Throwable $e) {
            report($e);
            return back()->withInput()->withErrors([
                'ai' => 'The AI could not finish. Please try again in a minute.',
            ]);
        }

        $request->user()->jobApplications()->create($data + $result);

        return redirect()->route('applications.create')
            ->with('status', 'Saved! (The result page comes tomorrow.)');
    }
}