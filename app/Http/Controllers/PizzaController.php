<?php

namespace App\Http\Controllers;
class PizzaController extends Controller{
    public function customer(){

        return view("customer");
    }
    
    public function admin(){
    return view("admin");
    }
}