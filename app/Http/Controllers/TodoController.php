<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Exception;

class TodoController extends Controller
{
    public function index()
    {
        try {
            $todos = Todo::latest()->get();
            return view('todos.index', compact('todos'));
        } catch (Exception $e) {
            return back()->with('error', 'Failed to load todos. ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate(['title' => 'required']);
            Todo::create(['title' => $request->title]);
            return redirect('/')->with('success', 'Todo created successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to create todo. ' . $e->getMessage());
        }
    }

    public function toggle($id)
    {
        try {
            $todo = Todo::findOrFail($id);
            $todo->completed = !$todo->completed;
            $todo->save();
            return redirect('/')->with('success', 'Todo updated successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to update todo. ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            Todo::findOrFail($id)->delete();
            return redirect('/')->with('success', 'Todo deleted successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to delete todo. ' . $e->getMessage());
        }
    }
}
