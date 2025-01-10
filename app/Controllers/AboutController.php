<?php

export('Controllers/Controller');

class AboutController extends Controller
{
    public function index()
    {
        return $this->render('about');
    }
}
