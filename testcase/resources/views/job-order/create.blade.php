@extends('layouts.main')
@section('content')
<div class="container mt-4 mb-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h4 class="mb-0">Create Job Order</h4>
        </div>
        <div class="card-body p-4">
            <form id="jobOrderForm" action="{{ route('job-orders.store') }}" method="POST">
                @csrf

                {{-- SECTION 1: Asal & Tujuan --}}
                <h5 class="fw-bold mb-3 text-primary">Data Pengiriman</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            <h6 class="text-secondary mb-3">Asal (Origin)</h6>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Provinsi</label>
                                <select id="origin_province" class="form-select">
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $prov)
                                        <option value="{{ $prov['id'] }}">{{ $prov['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kota</label>
                                <select name="origin_city_id" id="origin_city" class="form-select" required></select>
                                <input type="hidden" name="origin_city_name" id="origin_city_name">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            <h6 class="text-secondary mb-3">Tujuan (Destination)</h6>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Provinsi</label>
                                <select id="destination_province" class="form-select">
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $prov)
                                        <option value="{{ $prov['id'] }}">{{ $prov['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kota</label>
                                <select name="destination_city_id" id="destination_city" class="form-select" required></select>
                                <input type="hidden" name="destination_city_name" id="destination_city_name">
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- SECTION 2: Detail Pengiriman --}}
                <h5 class="fw-bold mb-3 text-primary">Detail Pengiriman</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Berat (gram)</label>
                        <input type="number" id="weight" name="weight" class="form-control" placeholder="Contoh: 1000" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kurir</label>
                        <select name="courier" id="courier" class="form-select" required>
                            <option value="">Pilih Kurir</option>
                            <option value="jne">JNE</option>
                            <option value="tiki">TIKI</option>
                            <option value="pos">POS</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="button" id="checkCostBtn" class="btn btn-outline-primary w-100">
                            Hitung Ongkir
                        </button>
                    </div>
                </div>

                {{-- Hasil Perhitungan --}}
                <div id="costResult" class="mt-4" style="display:none;">
                    <label class="form-label fw-semibold">Pilih Layanan</label>
                    <select id="service" name="service" class="form-select" required></select>
                    <input type="hidden" id="cost" name="cost">
                    <input type="hidden" id="etd" name="etd">
                </div>

                <hr class="my-4">

                {{-- SECTION 3: Data Sopir --}}
                <h5 class="fw-bold mb-3 text-primary">Data Sopir & Kendaraan</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Sopir</label>
                        <input type="text" name="driver_name" class="form-control" placeholder="Contoh: Budi Santoso">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nomor Kendaraan</label>
                        <input type="text" name="vehicle_number" class="form-control" placeholder="Contoh: B 1234 CD">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jenis Kendaraan</label>
                        <input type="text" name="vehicle_type" class="form-control" placeholder="Contoh: Truk Box">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nomor Kontak</label>
                        <input type="text" name="contact_number" class="form-control" placeholder="Contoh: 0812xxxxxxx">
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-4 py-2">
                        Simpan Job Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
    // Ambil Kota berdasarkan Provinsi
    function fetchCities(provinceId, citySelect, nameInput) {
        if (!provinceId) return;
        fetch(`/job-orders/cities/${provinceId}`)
        .then(res => res.json())
        .then(data => {
            citySelect.innerHTML = '<option value="">Pilih Kota</option>';
            data.forEach(city => {
                const opt = document.createElement('option');
                opt.value = city.id;
                opt.dataset.name = city.name;
                opt.textContent = city.name;
                citySelect.appendChild(opt);
            });
            citySelect.addEventListener('change', () => {
                nameInput.value = citySelect.selectedOptions[0]?.dataset.name || '';
            });
        });
    }

    const originProvince = document.getElementById('origin_province');
    const originCity = document.getElementById('origin_city');
    const originName = document.getElementById('origin_city_name');
    originProvince.addEventListener('change', () => fetchCities(originProvince.value, originCity, originName));

    const destProvince = document.getElementById('destination_province');
    const destCity = document.getElementById('destination_city');
    const destName = document.getElementById('destination_city_name');
    destProvince.addEventListener('change', () => fetchCities(destProvince.value, destCity, destName));

    // Hitung Ongkir
    const checkBtn = document.getElementById('checkCostBtn');
    const costResult = document.getElementById('costResult');
    const serviceSelect = document.getElementById('service');
    const costInput = document.getElementById('cost');
    const etdInput = document.getElementById('etd');

    checkBtn.addEventListener('click', async () => {
        const origin = originCity.value;
        const destination = destCity.value;
        const weight = document.getElementById('weight').value;
        const courier = document.getElementById('courier').value;

        if (!origin || !destination || !weight || !courier) {
            alert('⚠️ Lengkapi data pengiriman terlebih dahulu!');
            return;
        }

        const res = await fetch('/job-orders/get-cost', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ origin, destination, weight, courier })
        });

        const result = await res.json();

        if (result.meta?.status === 'success') {
            serviceSelect.innerHTML = '';
            result.data.forEach(service => {
                const opt = document.createElement('option');
                opt.value = service.service;
                opt.dataset.cost = service.cost;
                opt.dataset.etd = service.etd;
                opt.textContent = `${service.service} - Rp${service.cost.toLocaleString()} (${service.etd})`;
                serviceSelect.appendChild(opt);
            });

            costResult.style.display = 'block';

            serviceSelect.addEventListener('change', () => {
                const selected = serviceSelect.selectedOptions[0];
                costInput.value = selected.dataset.cost;
                etdInput.value = selected.dataset.etd;
            });

            // Auto isi default pertama
            const first = serviceSelect.options[0];
            if (first) {
                costInput.value = first.dataset.cost;
                etdInput.value = first.dataset.etd;
            }
        } else {
            alert('Gagal menghitung ongkir!');
        }
    });
</script>
@endsection
