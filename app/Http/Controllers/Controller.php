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

        DB::insert('insert into USERS (email,password) values (?, ?)', [$_POST['email'], $_POST['password']]);

        return redirect('/');
    }

    public function pi()
    {
        return view('pi');
    }
}
