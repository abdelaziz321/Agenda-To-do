<?php

namespace App\Http\Controllers;

use App\Helpers\DeadlineHelper;
use App\Http\Requests\StoreTaskRequest;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    private $deadline;

    public function __construct(DeadlineHelper $deadline)
    {
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
            'overdue'  => $user->tasks()->latest()->filterSection('overdue')->get(),
        ];

        $notes = $user->notes()->latest()->get();

        return view('index', compact('tasks', 'user', 'notes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTaskRequest $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function store(StoreTaskRequest $request)
    {
        $date = $request->input('date');
        $time = $request->input('time');
        $deadline = Carbon::createFromFormat('Y-m-d H:i', "$date  $time");

        $task = new Task([
            'deadline' => $deadline->toDateTimeString(),
            'body'     => $request->input('body'),
            'priority' => $request->input('priority'),
        ]);

        Auth::user()->tasks()->save($task);

        return response()->json([
            'status'  => 'New task has been added successfully',
            'section' => $this->deadline->getDeadlineSection($deadline),
            'newTask' => view('todo.task', compact('task'))->render(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreTaskRequest $request
     * @param  int             $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function update(StoreTaskRequest $request, $id)
    {
        $date = $request->input('date');
        $time = $request->input('time');
        $deadline = Carbon::createFromFormat('Y-m-d H:i', $date.' '.$time);

        $task = Task::findOrFail($id);
        $task->deadline = $deadline->toDateTimeString();
        $task->body = $request->input('body');
        $task->priority = $request->input('priority');

        $task->save();

        return response()->json([
            'status'  => 'Your task has been updated successfully',
            'section' => $this->deadline->getDeadlineSection($deadline),
            'newTask' => view('todo.task', compact('task'))->render(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::whereUserId(Auth::id())->findOrFail($id)->delete();

        return response()->json([
            'status' => 'Your Task has been deleted successfully',
        ]);
    }

    /**
     * Move Task Between Sections
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function move(Request $request, $id)
    {
        $sectionTo = $request->input('sectionTo');
        $sectionFrom = $request->input('sectionFrom');

        $task = Task::findOrFail($id);
        $task->update(['deadline' => $this->deadline->makeDeadline($sectionTo)]);

        return response()->json([
            'task'    => view('todo.task', compact('task'))->render(),
            'section' => $sectionTo,
            'status'  => "task moved From '$sectionFrom' To '$sectionTo'",
        ]);
    }
}
