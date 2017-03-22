<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProviderController extends Controller
{

    public function index()
    {
        return view('admin.provider.index');
    }

    public function getData()
    {

    }
}
