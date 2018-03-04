<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteStoreRequest;
use App\Note;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
    /**
     * get the note dialog to create|update Note.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNoteDialog()
    {
        return view('todo.addnote');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NoteStoreRequest $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function store(NoteStoreRequest $request)
    {
        $note = new Note($request->all());

        Auth::user()->notes()->save($note);

        return response()->json([
            'newNote' => view('todo.note', compact('note'))->render(),
            'status'  => 'Your note has been added successfully',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $note = Note::findOrFail($id);

        return response()->json([
            'title'   => $note->title,
            'body'    => $note->body,
            'id'      => $id,
            'created' => $note->created_at,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NoteStoreRequest $request
     * @param  int             $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function update(NoteStoreRequest $request, $id)
    {
        $note = Note::findOrFail($id);

        $note->update($request->all());

        return response()->json([
            'id'      => $id,
            'newNote' => view('todo.note', compact('note'))->render(),
            'status'  => 'Your note has been updated successfully',
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
        Note::whereUserId(Auth::id())->findOrFail($id)->delete();

        return response()->json([
            'id'     => $id,
            'status' => 'Note has been deleted successully',
        ]);
    }
}
