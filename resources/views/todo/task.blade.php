
<div class="task {{ $task->priority }}" data-id="{{ $task->id }}" data-move="{{ route('tasks.move', $task->id) }}">

    <div class="info">
        <div class="btns">
            <a href="{{ route('tasks.update', $task->id) }}" class="edit_task" title="Edit Task">
                <i class="ion ion-wrench"></i>
            </a>
            <a href="{{ route('tasks.destroy', $task->id) }}" class="delete_task" title="Delete Task">
                <i class="ion ion-android-delete"></i>
            </a>
        </div>
        <p class="line"><span>deadLine:</span> {{ date('l j F Y h:i A', strtotime($task->deadline)) }}</p>
        <span class="hide" id="timestamp">{{ $task->deadline }}</span>
        <div class="description">{!! $task->body !!}</div>
    </div>

    <div class="restore_message hide">
        restore the deleted task?
        <a href="{{ route('tasks.restore', $task->id) }}">yes</a>
        <button type="button">no</button>
    </div>
</div>
