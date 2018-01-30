<?php

namespace App\Http\Controllers;

use App\Helpers\DeadlineHelper;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use App\Task;
use Auth;

class TasksController extends Controller
{
    private $deadline;

    public function __construct(DeadlineHelper $deadline) {
        $this->deadline = $deadline;
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
            'today'    => $user->tasks()->latest()->filterSection('today')->get(),
            'tomorrow' => $user->tasks()->latest()->filterSection('tomorrow')->get(),
            'comming'  => $user->tasks()->latest()->filterSection('comming')->get(),
            'overdue'  => $user->tasks()->latest()->filterSection('overdue')->get()
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
            'body' => 'required',
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
            'section'   => $this->deadline->getDeadlineSection($deadline),
            'newTask'   => view('todo.task', compact('task'))->render()
        ]);
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
            'body' => 'required',
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
            'section'   => $this->deadline->getDeadlineSection($deadline),
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

    /**
     * Move Task Between Sections
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request, $id)
    {
        $sectionTo = $request->input('sectionTo');
        $sectionFrom = $request->input('sectionFrom');

        $task = Task::find($id);
        $task->deadline = $this->deadline->makeDeadline($sectionTo);
        $task->save();

        return response()->json([
            'task' => view('todo.task', compact('task'))->render(),
            'section' => $sectionTo,
            'status' => "task moved From ${sectionFrom} To ${sectionTo}"
        ]);
    }
}
