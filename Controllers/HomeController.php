<?php

namespace App\Controllers;

class HomeController extends BaseController{

public function dashboard()
{
    if (auth()->user()->inGroup('admin')) {
        return redirect()->to('/admin/dashboard');
    }

    return redirect()->to('/santri/dashboard');
}
}