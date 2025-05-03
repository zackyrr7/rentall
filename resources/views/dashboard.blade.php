@extends('layouts.app', ['pageSlug' => 'dashboard'])

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">


                    @php
                        $bulan = date('m');
                        $total = DB::select("SELECT COUNT(id_sewa) as total from sewa where status = '0'");

                    @endphp
                    <h5 class="card-category">Total Mobil Yang di boking</h5>
                    <h3 class="card-title"><i class="tim-icons icon-basket-simple text-primary"></i> {{ $total[0]->total }}
                    </h3>
                </div>


            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    @php

                        $total = DB::select("SELECT COUNT(id_sewa) as total from sewa where status = '1'");

                    @endphp

                    <h5 class="card-category">Total Mobil yang berlangsung</h5>
                    <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i> {{ $total[0]->total }}
                    </h3>
                </div>

            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">

                    @php

                        $total = DB::select("SELECT COUNT(id_sewa) as total from sewa where status = '2'");

                    @endphp

                    <h5 class="card-category">Total Penyewa Selesai</h5>
                    <h3 class="card-title"><i class="tim-icons icon-send text-success"></i> {{ $total[0]->total }}</h3>
                </div>

            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-12 col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-title">Daftar Boking Terdekat</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter" id="">
                            <thead class=" text-primary">
                                <tr>

                                    <th>
                                        Plat Nomor
                                    </th>
                                    <th>
                                        Tanggal Ambil
                                    </th>
                                    <th>
                                        Tanggal Pulang
                                    </th>
                                    <th class="text-center">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $data = DB::select("SELECT 
                                                c.merk,
                                                c.plat_nomor,
                                                b.tgl_ambil,
                                                b.tgl_pulang,
                                                b.total
                                            FROM
                                                sewa a
                                            LEFT JOIN dsewa b ON a.id_sewa = b.id_sewa
                                            LEFT JOIN mobil c ON a.id_mobil = c.id_mobil
                                            WHERE 
                                                a.status = 0
                                            ORDER BY 
                                                b.tgl_ambil DESC
                                            LIMIT 5;
                                            ");

                                @endphp
                                @foreach ($data as $item)
                                    <tr>

                                        <td>
                                            {{ $item->plat_nomor }}
                                        </td>
                                        <td>
                                            {{ tgl($item->tgl_ambil) }}
                                        </td>
                                        <td>
                                            {{ tgl($item->tgl_pulang) }}
                                        </td>
                                        <td class="text-center">
                                            {{ rupiah($item->total) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @push('js')
    <script src="{{ asset('black') }}/js/plugins/chartjs.min.js"></script>
    <script>
        $(document).ready(function() {
            demo.initDashboardPageCharts();
        });
    </script>
@endpush --}}
