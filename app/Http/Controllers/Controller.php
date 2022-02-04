<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return view('index');
    }


    public function all_users()
    {

        $users = DB::select('select * from `users`');
        $array = ['name' => 'Dima', 'users' => $users];
        
        return view('all_users', $array);
    }

    
    public function add_user()
    {
        return view('add_user');
    }


    public function add_user_post()
    {

        DB::insert('insert into users
        (name,email,password) values (?, ?, ?)',
        [$_POST['name'],$_POST['email'], $_POST['password']]);

        return redirect('/all_users');
    }


    public function deluser()
    {
        $users = DB::delete('delete from users where id=?', [$_GET['id']]);
        return redirect('/');
    }


    public function edit($id)
    {
        $user = DB::select('select * from users where id=?',[$id]);
        return view('edit_user',['user' => $user[0]]);
    }


    public function save_user($id)
    {
        DB::update('update users set email = ?, password=? where id = ?', [$_POST['email'], $_POST['password'], $id]);

        return redirect('/all_users');
    }


    public function pi()
    {
        return view('pi');
    }
}
