<?php

namespace App\Http\Controllers;

use App\Models\ShoppingList;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class UserController extends Controller
{
    

    public function generatepdf(){
        $data = ShoppingList::all();
        $pdf = PDF::loadView('pages.list',['data' => $data]);

        return $pdf->download('Lists.pdf');
    }
}
