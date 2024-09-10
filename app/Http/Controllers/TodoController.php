<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        return view('todo');
    }

    public function fetchTodos(Request $request)
    {

        $query = Todo::where('user_id', auth()->id());

        if (!$request->status) {
            $query->where('status', false);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('due_date', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Order by priority and status
        $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low') ASC")
            ->orderByRaw("status = false DESC");

        $todos = $query->get();
        return response()->json($todos);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
        ];
        $data = $request->all();


        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $data['user_id'] = auth()->user()->id;
        Todo::create($data);
        return response()->json(['success' => 'Task berhasil dibuat!']);
    }

    public function destroy($id)
    {
        $todo = Todo::where('id', $id)->where('user_id', auth()->id())->first();

        if ($todo) {
            $todo->delete();
            return response()->json(['success' => 'Todo berhasil dihapus.']);
        }

        return response()->json(['error' => 'Todo tidak ditemukan atau Anda tidak memiliki izin.'], 403);
    }

    public function toggleComplete($id)
    {
        $todo = Todo::where('id', $id)->where('user_id', auth()->id())->first();

        if ($todo) {
            // Toggle the completion status
            $todo->status = !$todo->status;
            $todo->save();

            return response()->json(['success' => 'Status berhasil diperbarui.', 'status' => $todo->status]);
        }

        return response()->json(['error' => 'Todo tidak ditemukan atau Anda tidak memiliki izin.'], 403);
    }
}
