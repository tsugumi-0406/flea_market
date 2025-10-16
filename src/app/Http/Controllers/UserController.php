<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class UserController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function login()
    {
        return view('login');
    }

    public function address()
    {
        return view('address');
    }

    public function mypage(Request $request)
    {
         $page = $request->query('page', 'sell');
        switch ($page) {
            case 'buy':
                // マイリストを取得（ログインしていない場合は空）
                $items = auth()->check()
                    ? auth()->user()->likes()->with('item')->get()->pluck('item')
                    : collect();
                break;

            case 'sell':
            default:
                $items = Item::all();
                break;
        }
        return view('mypage', compact('items', 'page'));
    }

    public function profile()
    {
        return view('profile');
    }
}
