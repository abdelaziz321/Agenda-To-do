
<div class="note_dialog">
    <header>
        <i class="icon ion-compose"></i>
        <input type="text" name="title" id="title" form="note" value="untitled note" placeholder="Enter the note title" required />
        <button type="button" class="btn_close" id="note_close"><i class="icon ion-close"></i></button>
    </header>
    <div class="body">
        <form id="note" action="{{ route('notes.store') }}" data-route="{{ url('notes') }}">
            <textarea name="body" id="note_editor" required></textarea>
            <input type="hidden" id="id" value="0" />
            <div class="save_btn">
                <button type="submit" class="btn btn-primary" id="save_note">Save</button>
            </div>
        </form>
    </div>
    <footer>
        <p>Created at: <time>12:30 PM Monday 10/12/2017</time></p>
        <a href="{{ url('notes') }}" class="delete_note" id="delete_note" title="Delete The Note">
            <i class="ion ion-android-delete"></i>
        </a>
    </footer>
</div>
