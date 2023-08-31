@extends('dashboard.template.header')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Dashboard</h2>
                        </div>
                    </div>
                </div>
                <div class="row m-t-25">
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c1">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="text mb-4">
                                        <h2>
                                            {{ number_format($users, 0, ',', '.') }} Users
                                        </h2>
                                        <span>Total Users</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c2">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="text mb-4">
                                        @php
                                            $totalStok = 0;
                                            $reagensiagroup = $reagensiastok->groupBy('nama_reagensia');
                                        @endphp
                                        @foreach ($reagensiagroup as $nama => $group)
                                            @php
                                                $latestReagensia = $group->sortByDesc('created_at')->first();
                                                $totalStok += $latestReagensia->stok;
                                            @endphp
                                        @endforeach
                                        <h2>{{ number_format($totalStok, 0, ',', '.') }}</h2>
                                        <span>Seluruh Stok</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c3">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="text  mb-4">
                                        @php
                                            $currentMonth = date('n');
                                            $currentYear = date('Y');
                                            $totalMasukBulanIni = 0;
                                            $totalKeluarBulanIni = 0;
                                        @endphp
                                        @foreach ($reagensiagroup as $nama => $group)
                                            @foreach ($group as $reagensiaJM)
                                                @php
                                                    $tanggalMasuk = $reagensiaJM->tanggal_masuk;
                                                    $tanggalKeluar = $reagensiaJM->tanggal_keluar;
                                                    
                                                    $tanggalMasukMonth = date('n', strtotime($tanggalMasuk));
                                                    $tanggalMasukYear = date('Y', strtotime($tanggalMasuk));
                                                    
                                                    $tanggalKeluarMonth = date('n', strtotime($tanggalKeluar));
                                                    $tanggalKeluarYear = date('Y', strtotime($tanggalKeluar));
                                                @endphp
                                                @if ($tanggalMasukMonth == $currentMonth && $tanggalMasukYear == $currentYear)
                                                    @php
                                                        $totalMasukBulanIni += $reagensiaJM->jumlah_masuk;
                                                    @endphp
                                                @endif
                                                @if ($tanggalKeluarMonth == $currentMonth && $tanggalKeluarYear == $currentYear)
                                                    @php
                                                        $totalKeluarBulanIni += $reagensiaJM->jumlah_keluar;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endforeach
                                        <h2>{{ number_format($totalMasukBulanIni, 0, ',', '.') }}</h2>
                                        <span style="font-size: 100%">Jumlah Masuk Bulan ini</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="overview-item overview-item--c4">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="text mb-4">

                                        <h2>{{ number_format($totalKeluarBulanIni, 0, ',', '.') }}</h2>
                                        <span style="font-size: 100%">Jumlah Keluar Bulan ini</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <h2 class="title-1 m-b-25">Data Reagensia</h2>
                    <div class="table-responsive table--no-card m-b-40">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Reagensia</th>
                                    <th>Satuan</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Tanggal Keluar</th>
                                    <th>Saldo</th>
                                    <th>Tanggal Kadaluarsa</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reagensia as $r)
                                    <tr>
                                        <td class="pl-4">
                                            {{ ($reagensia->currentPage() - 1) * $reagensia->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="pl-1">{{ $r->nama_reagensia }}</td>
                                        <td class="pl-1">{{ $r->satuan }}</td>
                                        <td class="pl-1">{{ $r->tanggal_masuk }}</td>
                                        <td class="pl-1">{{ $r->tanggal_keluar }}</td>
                                        <td class="pl-1">{{ $r->saldo }}</td>
                                        <td class="pl-1">
                                            <div
                                                class="{{ strtotime($r->tanggal_kadaluarsa) < strtotime(date('Y-m-d')) ? 'text-danger' : '' }}">
                                                {{ $r->tanggal_kadaluarsa }}
                                            </div>
                                        </td>
                                        <td class="pl-1">{{ $r->keterangan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="pagination-links" style="margin-top: -30px">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="{{ $reagensia->url(1) }}" aria-label="First"
                                        data-page="{{ $reagensia->url(1) }}">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">First</span>
                                    </a>
                                </li>
                                @php
                                    $startPage = max(1, $reagensia->currentPage() - 1);
                                    $endPage = min($reagensia->lastPage(), $reagensia->currentPage() + 1);
                                    if ($reagensia->currentPage() === 1) {
                                        $endPage = min($reagensia->lastPage(), 3);
                                    } elseif ($reagensia->currentPage() === 2) {
                                        $startPage = 1;
                                        $endPage = min($reagensia->lastPage(), 3);
                                    } elseif ($reagensia->currentPage() === $reagensia->lastPage()) {
                                        $startPage = max(1, $reagensia->lastPage() - 2);
                                        $endPage = $reagensia->lastPage();
                                    }
                                @endphp
                                @for ($i = $startPage; $i <= $endPage; $i++)
                                    <li class="page-item {{ $reagensia->currentPage() === $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $reagensia->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item">
                                    <a class="page-link" href="{{ $reagensia->url($reagensia->lastPage()) }}"
                                        aria-label="Last">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Last</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-8">
                        <!-- USER DATA-->
                        <div class="user-data">
                            <h3 class="title-3 m-b-30">
                                <i class="zmdi zmdi-account-calendar"></i>user data
                            </h3>
                            <div class="table-responsive table-data">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <td>Nama</td>
                                            <td>Username</td>
                                            <td>Role</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user as $u)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    <div class="table-data__info">
                                                        <h6>{{ $u->name }}</h6>
                                                        <span>
                                                            <a href="#">{{ $u->email }}</a>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $u->username }}
                                                </td>
                                                <td>
                                                    @if ($u->RoleId == 1)
                                                        <span class="btn btn-danger">Admin</span>
                                                    @elseif ($u->RoleId == 2)
                                                        <span class="btn btn-warning">Operator</span>
                                                    @else
                                                        <span class="btn btn-success">User</span>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END USER DATA-->
                    </div>
                    <div class="col-lg-4">
                        <!-- TOP CAMPAIGN-->
                        <div class="top-campaign">
                            <h3 class="title-3 m-b-30">Jumlah Stok Reagensia</h3>
                            <div class="table-responsive">
                                <table class="table table-top-campaign">
                                    <tbody>
                                        @php
                                            $reagensiagroup = $reagensiastok->groupBy('nama_reagensia');
                                        @endphp
                                        @foreach ($reagensiagroup as $nama => $group)
                                            @php
                                                $latestReagensia = $group->sortByDesc('created_at')->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $nama }}</td>
                                                <td>{{ $latestReagensia->stok }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--  END TOP CAMPAIGN-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="copyright">
                            <p>Copyright © 2023 Colorlib. All rights reserved. Template by <a
                                    href="https://colorlib.com">Colorlib</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            const table = $('#item-table');
            const paginationLinks = $('#pagination-links');

            paginationLinks.on('click', '.page-link', function(event) {
                event.preventDefault();
                const url = $(this).attr('href');

                $.ajax({
                    url: url,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(data) {
                        table.html($(data).find('#item-table').html());
                        paginationLinks.html($(data).find('#pagination-links').html());
                        scrollToTop();
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });

            function scrollToTop() {
                table[0].scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
