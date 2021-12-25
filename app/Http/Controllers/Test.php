<?php

namespace Boykioyb\Notify\Http\Controllers;


/**
 * Class Test
 * @package Boykioyb\Notify\Http\Controllers
 */
class Test extends Base
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('test');
    }
}
