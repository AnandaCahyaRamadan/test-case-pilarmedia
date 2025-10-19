<?php

namespace App\Http\Controllers;

use App\Models\JobOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JobOrderController extends Controller
{
    private $apiBase;
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('RAJAONGKIR_API_KEY');
        $this->apiBase = 'https://rajaongkir.komerce.id/api/v1';
    } 

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

    public function create()
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey,
        ])->get($this->apiBase.'/destination/province');

        $data = $response->json();
        $provinces = $data['data'] ?? [];
        return view('job-order.create', compact('provinces'));
    }

    public function getCities($provinceId)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey,
        ])->get($this->apiBase."/destination/city/{$provinceId}");

        $data = $response->json();
        $cities = $data['data'] ?? [];

        return response()->json($cities);
    }

    public function getCost(Request $request)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey,
            'Accept' => 'application/json',
        ])->asForm()->post($this->apiBase.'/calculate/domestic-cost', [
            'origin' => $request->origin,
            'destination' => $request->destination,
            'weight' => $request->weight,
            'courier' => $request->courier,
        ]);

        return $response->json();
    }

    public function store(Request $request)
    {
        $request->validate([
            'origin_city_id' => 'required',
            'origin_city_name' => 'required',
            'destination_city_id' => 'required',
            'destination_city_name' => 'required',
            'weight' => 'required|numeric',
            'courier' => 'required|string',
            'service' => 'required|string',
            'cost' => 'required|numeric',
            'etd' => 'nullable|string',
        ]);

        $jobOrder = JobOrder::create([
            'order_number' => 'JO'.time(),
            'origin_city_id' => $request->origin_city_id,
            'origin_city_name' => $request->origin_city_name,
            'destination_city_id' => $request->destination_city_id,
            'destination_city_name' => $request->destination_city_name,
            'courier' => $request->courier,
            'service' => $request->service,
            'cost' => $request->cost,
            'estimate' => $request->etd,
            'driver_name' => $request->driver_name,
            'vehicle_number' => $request->vehicle_number,
            'vehicle_type' => $request->vehicle_type,
            'contact_number' => $request->contact_number,
        ]);

        return redirect()->route('job-orders.show', $jobOrder->id)
                        ->with('success', 'Job Order berhasil dibuat!');
    }

}
