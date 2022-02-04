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

        $users = DB::select('select * from USERS');
        $array = ['name' => 'Dima', 'users' => $users];

        return view('index', $array);
    }


    public function add_user()
    {
        return view('add_user');
    }


    public function add_user_post()
    {

        DB::insert('insert into USERS (email,password) values (?, ?)', [$_POST['email'], $_POST['password']]);

        return redirect('/');
    }


    public function deluser()
    {
        $users = DB::delete('delete from USERS where id=?', [$_GET['id']]);
        return redirect('/');
    }


    public function edit($id)
    {
        $user = DB::select('select * from USERS where id=?',[$id]);
        return view('add_user',['user' => $user[0]]);
    }


    public function save_user($id)
    {
        DB::update('update USERS set email = ?, password=? where id = ?', [$_POST['email'], $_POST['password'], $id]);

        return redirect('/');
    }


    public function pi()
    {
        return view('pi');
    }
}
