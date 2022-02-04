<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function all_news()
    {
        $news = News::all();
        $array = ['news' => $news];
        
        return view('all_news', $array);
    }


    public function add_news()
    {
        return view('add_news');
    }
    
    public function add_news_post()
    {
        DB::insert('insert into `news`
        (title,text) values (?, ?)',
        [$_POST['title'],$_POST['text']]);
        return redirect('/add_news');
    }




    public function edit_news($id)
    {
        $user = DB::select('select * from `news` where id=?',[$id]);
        return view('edit_news',['news' => $user[0]]);
    }


    public function save_news($id)
    {
        DB::update('update `news` set 
        `title` = ?, `text`=? where `id` = ?', 
        [$_POST['title'], $_POST['text'], $id]);

        return redirect('/all_news');
    }

    


}
