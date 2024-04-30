<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return $users;
    }


    public function store(Request $request)
    {
      
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        return "l'utilisateur à été crée avec succés magle !";
        
    }

    
    public function show($id)
    {
        
        $user= User::find($id);
        return $user;

    }

   


    public function update(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required',
            'password' => 'required',

        ]);
    
        $user = User::find($id);
        $user->update($request->all());
        return $user;
    }

    
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return "c'est supprmimer bouffon mais cette fois ci c'est le user c'est différent tu vois c'est comme les products mais pas trop";
        
   
    }
}
