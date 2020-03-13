<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateBookmark;
use App\Http\Models\Bookmark;
use Symfony\Component\DomCrawler\Crawler;
use App\Http\Services\BookmarksParser;

class Bookmarks extends Controller
{
    public function add() {
        return view('Bookmarks.Add')->with('title', 'Добавление закладки');
    }

    public function create(CreateBookmark $request) {
        try {
            $parser = new BookmarksParser($request->url);
        } catch(\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['url' => 'Указанный сайт недоступен или страница не существует!']);
        }
        $bookmark = new Bookmark();
        $bookmark->fill($parser->toArray());
        if($bookmark->save()) {
            return redirect(route('Bookmarks.Add')); // пока так, дальше будет редиректить на список страниц
        }
    }
}
