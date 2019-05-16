<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');        
    }
    public function shownote(){
        $notes = Note::all();
        return $notes;
    }
    public function storenote(Request $request){

        $note = new Note;
        $note->user_id = auth()->id();
        $note->label = 'test';
        $note->title = $request->title;
        $note->note = $request->note;
        $note->image = json_encode( ['test'], JSON_PRETTY_PRINT);
        $note->save();
    }
    public function destroy(Note $note)
    {
        //
    }
}
