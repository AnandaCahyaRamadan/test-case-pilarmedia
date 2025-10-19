<?php

namespace App\Http\Controllers;

use App\Models\JobOrder;
use Illuminate\Http\Request;

class JobOrderController extends Controller
{
    public function index()
    {
        $jobOrders = JobOrder::all();
        return view('job-order.index', compact('jobOrders'));
    }
    public function show($id)
    {
        $order = JobOrder::findOrFail($id);
        return view('job-order.show', compact('order'));
    }
}
