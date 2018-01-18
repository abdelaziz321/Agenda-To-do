<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Task;
use Auth;

class TasksController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $tasks = [
            'today'    => $user->tasks()->latest()->filterTime('today')->get(),
            'tomorrow' => $user->tasks()->latest()->filterTime('tomorrow')->get(),
            'comming'  => $user->tasks()->latest()->filterTime('comming')->get(),
            'overdue'  => $user->tasks()->latest()->filterTime('overdue')->get()
        ];

        $notes = $user->notes()->latest()->get();

        return view('index', compact('tasks', 'user', 'notes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i',
            'body' => 'required',   // TODO: secure
            'priority' => ['required', 'regex:(low|mid|high)']
        ]);

        $task = new Task;

        $date = $request->input('date');
        $time = $request->input('time');
        $deadline = Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $time);

        $task->deadline = $deadline->toDateTimeString();
        $task->body = $request->input('body');
        $task->priority = $request->input('priority');
        $task->user_id = Auth::user()->id;
        $task->save();

        return response()->json([
            'status'    => 'New task has been added successfully',
            'time'      => $this->filterTime($deadline),
            'newTask'   => view('todo.task', compact('task'))->render()
        ]);
    }

    private function filterTime($deadline)
    {
        if ($deadline->isToday()) {
            return 'today';
        } else if ($deadline->isTomorrow()) {
            return 'tomorrow';
        } else if ($deadline->isFuture()) {
            return 'comming';
        } else if ($deadline->isPast()) {
            return 'overdue';
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i',
            'body' => 'required',   // TODO: secure
            'priority' => ['required', 'regex:(low|mid|high)']
        ]);

        $date = $request->input('date');
        $time = $request->input('time');
        $deadline = Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $time);

        $task->deadline = $deadline->toDateTimeString();
        $task->body = $request->input('body');
        $task->priority = $request->input('priority');

        $task->save();

        return response()->json([
            'status'    => 'Your task has been updated successfully',
            'time'      => $this->filterTime($deadline),
            'newTask'   => view('todo.task', compact('task'))->render()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Task::find($id)->user_id == Auth::user()->id) {
            Task::destroy($id);
        }

        return response()->json([
            'status' => 'Your Task has been deleted successfully'
        ]);
    }
}
