<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Image;
use Cookie;

class UsersController extends Controller
{
    public function __constructor()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = \Auth::user();
        return view('user.profile')->with(compact('user'));
    }

    public function update(Request $request)
    {
        $user = \Auth::user();

        if ($request->hasFile('photo')) {
            // dd(Storage::url('public/images/uploads/profile/' . $user->photo));
            if($user->photo[0] != 'n') {
                File::delete('images/uploads/profile/' . $user->photo);
            }
            $photo = $request->file('photo');
            $filename = time() . '-' . $photo->getClientOriginalName();
            $user->photo = $filename;
            Image::make($photo)->fit(160)->save( public_path('images/uploads/profile/' . $filename ) );
        }

        $user->name = $request->input('name');
        $user->save();

        return response()->json([
            'status' => 'your profile has been updated successfully',
            'photo' => url('images/uploads/profile/' . $user->photo),
            'name' => $user->name
        ]);
    }

    // TODO: Crete tabel preference colors made by users (rate system) {more than 2 color}
    public function updateSkin(Request $request)
    {
        $skin = [
            'color1' => $request->color1,
            'color2' => $request->color2,
            'bcolor' => $request->bcolor
        ];

        Cookie::queue(Cookie::make('skin', json_encode($skin), 43200));

        return response()->json($skin);
    }
}
