<?php

namespace Single\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Frontier\Controllers\AdminController as Controller;

class AdminController extends Controller
{
    /**
     * Displays the root page.
     *
     * @param  Request $request
     * @return Illuminate\View\View
     */
    public function getRootPage(Request $request)
    {
        return view("Single::layouts.master");
    }

    /**
     * Displays the unsupported browser message.
     *
     * @param  Request $request
     * @return Illuminate\View\View
     */
    public function getUnsupportedBrowserPage(Request $request)
    {
        return view("Single::errors.unsupported");
    }
}