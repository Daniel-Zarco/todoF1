<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Constructor para aplicar el middleware auth.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la página principal.
     */
    public function index()
    {
        return view('pageprincipal');
    }
}
