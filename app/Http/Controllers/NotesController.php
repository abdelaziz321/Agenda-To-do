<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;
use Auth;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:20|unique:notes',
            'body'  => 'required'
        ]);

        $note = new Note;
        $userId = Auth::user()->id;

        $note->title = $request->input('title');
        $note->body = $request->input('body');
        $note->user_id = $userId;

        $note->save();

        return response()->json([
            'newNote' => view('todo.note', compact('note'))->render(),
            'status' => 'Your note has been added successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $note = Note::find($id);

        return response()->json([
            'title'=> $note->title,
            'body' => $note->body,
            'id' => $id,
            'created' => $note->created_at
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
        $request->validate([
            'title' => 'required',
            'body'  => 'required'
        ]);

        $note = Note::find($id);

        $note->title = $request->input('title');
        $note->body = $request->input('body');

        $note->save();

        return response()->json([
            'id' => $id,
            'newNote' => view('todo.note', compact('note'))->render(),
            'status' => 'Your note has been updated successfully'
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
        if (Note::find($id)->user_id == Auth::user()->id) {
            Note::destroy($id);
        }

        return response()->json([
            'id' => $id,
            'status' => 'Note has been deleted successully'
        ]);
    }
}
