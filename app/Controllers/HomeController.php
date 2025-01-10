<?php

export('Controllers/Controller');

class HomeController extends Controller
{
    public function index()
    {
        return $this->render('home');
    }
}
