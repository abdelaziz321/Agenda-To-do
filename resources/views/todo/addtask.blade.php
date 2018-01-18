
<!-- Add Btn -->
<div class="addbtn">
    <button type="button" class="btn" id="add_task"><i class="icon ion-plus-round"></i></button>
</div>

<!-- Task dialog -->
<div class="dialog hide">
    <div class="header">
        <p class="line">
            <i class="icon ion-star"></i>
            <span>Add New Task</span>
            <button type="button" class="btn_close" id="dialog_close"><i class="icon ion-close"></i></button>
        </p>
    </div>
    <div class="body">
        <form class="form-horizontal" method="post" action="{{ route('tasks.store') }}" data-route="{{ url('tasks') }}">
            <div class="task_editor">
                <textarea id="task_editor" name="body" required></textarea>
            </div>
            <div class="form-group">
                <div class="col-md-2">
                    <label class="control-label" for="date">Date: </label>
                </div>
                <div class="col-md-10">
                    <input type="date" name="date" id="date" class="form-control" value="{{ date("Y-m-d") }}" required />
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-2">
                    <label class="control-label" for="time">Time: </label>
                </div>
                <div class="col-md-10">
                    <input type="time" name="time" id="time" class="form-control" value="16:40" required />
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-2">
                    <label class="control-label">Priority: </label>
                </div>
                <div class="col-md-10">
                    <p class="radio-inline">
                        <input type="radio" id="low" name="priority" value="low" checked>
                        <label for="low">Low</label>
                    </p>
                    <p class="radio-inline">
                        <input type="radio" id="mid" name="priority" value="mid">
                        <label for="mid">medium</label>
                    </p>
                    <p class="radio-inline">
                        <input type="radio" id="high" name="priority" value="high">
                        <label for="high">High</label>
                    </p>
                </div>
            </div>

            <input type="hidden" id="id" />
            <div class="footer">
                <button type="submit" id="save_task" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
