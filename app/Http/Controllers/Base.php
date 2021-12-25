<?php


namespace Boykioyb\Notify\Http\Controllers;


use Illuminate\Routing\Controller;


/**
 * Class Base
 * @package Boykioyb\Notify\Http\Controllers
 */
class Base extends Controller
{
    /**
     * Base constructor.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            return $next($request);
        });

        view()->addLocation($this->getViewPath());
    }

    /**
     * @return string
     */
    private function getViewPath()
    {
        return base_path('vendor/Boykioyb/notify/resources/views');
    }
}
