<?php

namespace App\Http\Controllers;
use App\Technician;
use App\User;
use Illuminate\Http\Request;
use Auth;

class TechnicianHomeController extends Controller
{



    public function home(){

        return view('technicians.home');

    }

    public function homeApp(){

        $user = User::find(Auth::id());
        $technician = Technician::find($user->technician_id);
        return response()->json($technician->first_name,200);
    }

    public function sale(){
        return view('technicians.sales');
    }

    public function saleApp(){

    }
}
