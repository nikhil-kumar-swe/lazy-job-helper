<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">History</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <p class="text-green-700 px-4 sm:px-0">{{ session('status') }}</p>
            @endif

            <a href="{{ route('applications.create') }}" class="inline-block px-4 py-2 bg-gray-800 text-white rounded-md">New application</a>

            @forelse ($applications as $application)
                <div class="bg-white shadow sm:rounded-lg p-4 flex items-center justify-between gap-4">
                    <div>
                        <a href="{{ route('applications.show', $application->id) }}" class="font-semibold text-indigo-600">{{ $application->job_title }}</a>
                        <p class="text-sm text-gray-500">{{ $application->created_at->diffForHumans() }}</p>
                    </div>
                    <form method="POST" action="{{ route('applications.destroy', $application->id) }}"
                          onsubmit="return confirm('Delete this application?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 text-sm">Delete</button>
                    </form>
                </div>
            @empty
                <p class="text-gray-500 px-4 sm:px-0">Nothing here yet.</p>
            @endforelse

            {{ $applications->links() }}
        </div>
    </div>
</x-app-layout>