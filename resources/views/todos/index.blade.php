<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script>
        // Auto-dismiss alerts after 4 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(el => el.remove());
        }, 4000);
    </script>
</head>
<body class="bg-gray-100 min-h-screen flex justify-center items-start py-10 px-4">

<div class="w-full max-w-2xl bg-white shadow-lg rounded-2xl p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-blue-600">✨ Todo App</h1>

    {{-- Success & Error Messages --}}
    @if(session('success'))
        <div class="alert flex items-center justify-between mb-4 p-4 bg-green-100 text-green-800 rounded-lg shadow">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-600 font-bold">×</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert flex items-center justify-between mb-4 p-4 bg-red-100 text-red-800 rounded-lg shadow">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-red-600 font-bold">×</button>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert mb-4 p-4 bg-yellow-100 text-yellow-800 rounded-lg shadow">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Add Todo --}}
    <form action="{{ route('todos.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3 mb-6">
        @csrf
        <input type="text" name="title" placeholder="Enter todo..."
               class="flex-1 border rounded-lg p-3 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
               required>
        <button class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-lg shadow-md transition">
            Add
        </button>
    </form>

    {{-- Todo List --}}
    <ul class="space-y-3">
        @forelse($todos as $todo)
            <li class="flex flex-col sm:flex-row items-center justify-between bg-gray-50 p-4 rounded-lg shadow hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <form action="{{ route('todos.toggle', $todo->id) }}" method="POST">
                        @csrf
                        <button class="px-3 py-1 text-sm font-medium rounded-lg transition
                            {{ $todo->completed ? 'bg-green-500 hover:bg-green-600 text-white' : 'bg-gray-400 hover:bg-gray-500 text-white' }}">
                            {{ $todo->completed ? '✔ Done' : '⏳ Pending' }}
                        </button>
                    </form>

                    <span class="text-lg {{ $todo->completed ? 'line-through text-gray-500' : 'text-gray-800 font-medium' }}">
                        {{ $todo->title }}
                    </span>
                </div>

                <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" class="mt-3 sm:mt-0">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg shadow-md transition text-sm">
                        🗑 Delete
                    </button>
                </form>
            </li>
        @empty
            <p class="text-center text-gray-500">No todos yet. Add one above 👆</p>
        @endforelse
    </ul>
</div>

</body>
</html>
