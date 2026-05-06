<?php

namespace App\Controllers;


class Matiere extends BaseController
{
    public function index(): string
    {
        return view('index');
    }

    public function create(): string
    {
        return view('create');
    }

    public function ajouter(): string
    {
        return view('ajouter');
    }


}