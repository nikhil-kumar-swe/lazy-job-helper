<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New application</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                @if (session('status'))
                    <p class="mb-4 text-green-700">{{ session('status') }}</p>
                @endif
                @error('ai')
                    <p class="mb-4 text-red-600">{{ $message }}</p>
                @enderror

                <form method="POST" action="{{ route('applications.store') }}" class="space-y-5"
      onsubmit="const b=document.getElementById('go'); b.disabled=true; b.textContent='Generating... (up to 1 minute)';">
                    @csrf

                    <div>
                        <x-input-label for="job_title" value="Job title" />
                        <x-text-input id="job_title" name="job_title" class="mt-1 block w-full" :value="old('job_title')" required />
                        <x-input-error :messages="$errors->get('job_title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="job_description" value="Job description" />
                        <textarea id="job_description" name="job_description" rows="8" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('job_description') }}</textarea>
                        <x-input-error :messages="$errors->get('job_description')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="resume_text" value="Your resume (plain text)" />
                        <textarea id="resume_text" name="resume_text" rows="8" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('resume_text') }}</textarea>
                        <x-input-error :messages="$errors->get('resume_text')" class="mt-2" />
                    </div>

                    <p class="text-sm text-gray-500">
                        Your text is sent to Google's Gemma API, and on the free tier Google may use it to improve its models. Leave out phone numbers, home address and ID numbers.
                    </p>

                    <x-primary-button id="go">Generate</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>