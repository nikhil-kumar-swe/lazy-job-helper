<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $application->job_title }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-2">Cover letter</h3>
                <p class="whitespace-pre-line text-gray-800">{{ $application->cover_letter }}</p>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-2">Missing keywords</h3>
                <div class="flex flex-wrap gap-2">
                    @forelse ($application->keyword_gaps ?? [] as $item)
                        <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-sm">{{ is_scalar($item) ? $item : json_encode($item) }}</span>
                    @empty
                        <p class="text-gray-500">None found.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-2">Resume bullet suggestions</h3>
                <ul class="list-disc pl-5 space-y-2 text-gray-800">
                    @foreach ($application->bullet_suggestions ?? [] as $item)
                        <li>{{ is_scalar($item) ? $item : json_encode($item) }}</li>
                    @endforeach
                </ul>
                <details class="mt-4">
                    <summary class="cursor-pointer text-sm text-indigo-600">Compare with your original resume</summary>
                    <p class="mt-2 whitespace-pre-line text-sm text-gray-600">{{ $application->resume_text }}</p>
                </details>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-2">Interview questions</h3>
                <ol class="list-decimal pl-5 space-y-2 text-gray-800">
                    @foreach ($application->interview_questions ?? [] as $item)
                        <li>{{ is_scalar($item) ? $item : json_encode($item) }}</li>
                    @endforeach
                </ol>
            </div>

            <p class="text-sm text-gray-500 px-4 sm:px-0">
                These are AI suggestions. Check every line against your real experience before using it.
            </p>

            <div class="flex gap-4 px-4 sm:px-0">
                <a href="{{ route('applications.index') }}" class="text-indigo-600">Back to history</a>
                <a href="{{ route('applications.create') }}" class="text-indigo-600">New application</a>
            </div>
        </div>
    </div>
</x-app-layout>