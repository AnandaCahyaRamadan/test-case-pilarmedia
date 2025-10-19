<?php

namespace App\Http\Controllers;

use App\Models\JobOrder;
use Illuminate\Http\Request;

class JobOrderController extends Controller
{
    public function dashboard()
    {
        $jobOrders = JobOrder::all();
        return view('dashboard', compact('jobOrders'));
    }
    public function show($id)
    {
        $order = JobOrder::findOrFail($id);
        return view('detail', compact('order'));
    }
}
