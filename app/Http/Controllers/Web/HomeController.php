<?php

namespace App\Http\Controllers\Web;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;

class HomeController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index(): Factory|View
    {
        return view('pages.home');
    }
}
