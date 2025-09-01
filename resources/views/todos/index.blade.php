<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
        }
        .container {
            width: 100%;
            max-width: 600px;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #2563eb;
            margin-bottom: 20px;
        }

        /* Alerts */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            font-weight: bold;
        }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .alert-warning { background: #fef3c7; color: #92400e; }
        .alert button {
            background: none;
            border: none;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        /* Form */
        form.add-form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        form.add-form input {
            flex: 1;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }
        form.add-form button {
            padding: 12px 18px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.2s;
        }
        form.add-form button:hover {
            background: #1e40af;
        }

        /* Todo List */
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background: #f9fafb;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 10px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        li:hover {
            transform: translateY(-2px);
        }
        li span {
            font-size: 16px;
        }
        li span.completed {
            text-decoration: line-through;
            color: #6b7280;
        }

        /* Buttons inside list */
        .btn {
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            transition: 0.2s;
        }
        .btn-toggle {
            background: #6b7280;
            color: white;
            margin-right: 10px;
        }
        .btn-toggle.done {
            background: #10b981;
        }
        .btn-toggle:hover {
            opacity: 0.9;
        }
        .btn-delete {
            background: #ef4444;
            color: white;
        }
        .btn-delete:hover {
            background: #b91c1c;
        }

        /* Responsive */
        @media (max-width: 600px) {
            form.add-form {
                flex-direction: column;
            }
            form.add-form button {
                width: 100%;
            }
            li {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>

    <script>
        // Auto dismiss alerts after 4 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(el => el.remove());
        }, 4000);
    </script>
</head>
<body>
<div class="container">
    <h1>✨ Todo App</h1>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()">×</button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()">×</button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-warning">
            <ul style="margin:0; padding-left: 16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button onclick="this.parentElement.remove()">×</button>
        </div>
    @endif

    {{-- Add Todo --}}
    <form action="{{ route('todos.store') }}" method="POST" class="add-form">
        @csrf
        <input type="text" name="title" placeholder="Enter todo..." required>
        <button type="submit">Add</button>
    </form>

    {{-- Todo List --}}
    <ul>
        @forelse($todos as $todo)
            <li>
                <div style="display:flex; align-items:center;">
                    <form action="{{ route('todos.toggle', $todo->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-toggle {{ $todo->completed ? 'done' : '' }}">
                            {{ $todo->completed ? '✔ Done' : '⏳ Pending' }}
                        </button>
                    </form>
                    <span class="{{ $todo->completed ? 'completed' : '' }}">
                        {{ $todo->title }}
                    </span>
                </div>

                <form action="{{ route('todos.destroy', $todo->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-delete">🗑 Delete</button>
                </form>
            </li>
        @empty
            <p style="text-align:center; color:#6b7280;">No todos yet. Add one above 👆</p>
        @endforelse
    </ul>
</div>
</body>
</html>
