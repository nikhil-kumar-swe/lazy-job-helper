<?php

namespace App\Http\Controllers;

use App\Services\ModelClient;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $applications = $request->user()->jobApplications()->latest()->paginate(10);

        return view('applications.index', compact('applications'));
    }

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
            $result = $client->analyze($data['resume_text'], $data['job_description'], $data['job_title']);
        } catch (\Throwable $e) {
            report($e);
            return back()->withInput()->withErrors([
                'ai' => 'The AI could not finish. Please try again in a minute.',
            ]);
        }

        $application = $request->user()->jobApplications()->create($data + $result);

        return redirect()->route('applications.show', $application->id);
    }

    public function show(Request $request, string $id)
    {
        $application = $request->user()->jobApplications()->findOrFail($id);

        return view('applications.show', compact('application'));
    }

    public function destroy(Request $request, string $id)
    {
        $request->user()->jobApplications()->findOrFail($id)->delete();

        return redirect()->route('applications.index')->with('status', 'Deleted.');
    }
}