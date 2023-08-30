<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\News;

class NewsController extends Controller
{
    public function delete(string $id) {
        News::find($id)->delete();

        return redirect('/news');
    }
}
