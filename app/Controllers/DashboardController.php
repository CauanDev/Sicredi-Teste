<?php
export('Controllers/Controller');
session_start();
class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct(true);
    }

    public function index()
    {
        return $this->render('dashboard');
    }
}
