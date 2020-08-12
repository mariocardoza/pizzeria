<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function masas()
    {
    	return view('administrador.masas');
    }

    public function ingredient()
    {
    	return view('administrador.ingredients');
    }

    public function basics()
    {
    	return view('administrador.basics');
    }

    public function specialities()
    {
        return view('administrador.specialities');
    }
}
