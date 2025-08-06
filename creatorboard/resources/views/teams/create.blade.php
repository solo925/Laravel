<x-app-layout>
    <div class="max-w-md mx-auto py-10">
        <h2 class="text-2xl font-semibold mb-4">Create Team</h2>

        <form method="POST" action="{{ route('teams.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Team Name</label>
                <input type="text" name="name" id="name" class="w-full rounded border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>

            <button type="submit" class="w-full bg-white text-black border-2 border-black px-6 py-3 rounded-lg font-semibold text-lg hover:bg-black hover:text-white transition-colors duration-200 shadow-lg">Create Team</button>
        </form>
    </div>
</x-app-layout>
