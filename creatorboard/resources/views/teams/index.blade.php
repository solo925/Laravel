<x-app-layout>
    <div class="max-w-3xl mx-auto py-10">
        <h2 class="text-xl font-semibold mb-4">Your Teams</h2>

        <ul>
            @foreach ($teams as $team)
                <li class="py-2 border-b">{{ $team->name }}</li>
            @endforeach
        </ul>

        <a href="{{ route('teams.create') }}" class="mt-4 inline-block text-blue-500 hover:underline">+ Create New Team</a>
    </div>
</x-app-layout>
