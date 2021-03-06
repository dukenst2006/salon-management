<?php

namespace App\Http\Controllers;

use App\TechnicianBook;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Technician;
use App\TechnicianSale;
use Validator;
use App\PayPeriod;

class TechnicianSaleController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }


    public function index(){



    }


    /**
     * Route: /technician-sale/create
     *
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){

        return view('technicians.create-sales');

    }
    public function storeSale(Request $request){

       $validator =  Validator::make($request->all(),[
            'sale-date' =>'required|date',
            'sale' => 'required|numeric',
            'additional-sale' => 'numeric'
        ]);

        $technician = Technician::find($request->input('technicianID'));

        $saleDate = $request->input('sale-date');

        if($validator->fails()){
            return redirect('/technician-sale/date/'.$saleDate .'/technician/'.$technician->first_name)->withErrors($validator);
        }

        $sale = TechnicianSale::create(['technician_id' => $request->input('technicianID'),'sale_date' => $saleDate,
            'sales' => $request->input('sale') ,'additional_sales' => $request->input('additional-sale')]);

        $request->session()->flash('confirm-sale', $technician->first_name.'\' sales has been added for ' . $sale->sale_date_mdy);
        return redirect('/technician-sale/date/'.$saleDate .'/technician/'.$technician->first_name);

    }

    public function quickSaleEntry(){
        return view('technicians.quick-sale-entry',['pageTitle' => 'Quick Sale Entry']);
    }

}
