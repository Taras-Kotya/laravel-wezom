<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
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

        DB::insert(
            'insert into users
        (name,email,password) values (?, ?, ?)',
            [$_POST['name'], $_POST['email'], $_POST['password']]
        );

        return redirect('/all_users');
    }


    public function deluser()
    {
        $users = DB::delete('delete from users where id=?', [$_GET['id']]);
        return redirect('/');
    }


    public function edit($id)
    {
        $user = DB::select('select * from users where id=?', [$id]);
        return view('edit_user', ['user' => $user[0]]);
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


    public function login()
    {
        return view('login');
    }



    public function logout(Request $request)
    {
        $request->session()->forget('is_auth');
        $request->session()->forget('name');
        $request->session()->forget('password');
        return redirect('/login');
    }


    public function login_post(Request $request)
    {
        $user = DB::select(
            'select * from `users` where `name`=? AND `password`=? LIMIT 1',
            [$_POST['name'], $_POST['password']]
        );


  

        if (!empty($user[0]->id)) {
            $request->session()->put('is_auth', 'true');
            $request->session()->put('name', $user[0]->name);
            $request->session()->put('password', $user[0]->password);
            $request->session()->flash('message', 'Hello!!!');
        } else {
            $request->session()->flash('message', 'Невірний логін чи пароль');
        }
        return redirect('/login');
    }
}
