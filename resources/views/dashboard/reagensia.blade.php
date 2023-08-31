@extends('dashboard.template.header')
@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="title-5 m-b-35">Data Inventaris Reagensia</h3>
                        @if (session('success'))
                            <div id="successAlert" class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div id="dangerAlert" hidden class="alert alert-danger" role="alert">
                            A simple success alert—check it out!
                        </div>
                        <div class="table-data__tool">
                            <div class="table-data__tool-left">
                            </div>
                            <div class="table-data__tool-right">
                                @if (auth()->user()->RoleId != 3)
                                    <button class="au-btn au-btn-icon au-btn--green au-btn--small" data-bs-toggle="modal"
                                        data-bs-target="#tambahModal">
                                        <i class="zmdi zmdi-plus"></i>add item</button>
                                @endif
                                <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
                                    <a class="au-btn-filter" href="/reagensia/export" target="_blank">Export Excel</a>
                                    <div class="dropDownSelect2"></div>
                                </div>
                            </div>
                        </div>
                        <div id="item-table">
                            <div class="table-responsive table--no-card m-b-40">
                                <table class="table table-borderless table-striped table-earning">
                                    <thead>
                                        <tr>
                                            <th class="pl-4">No</th>
                                            <th class="pl-1">Nama Reagensia</th>
                                            <th class="pl-1">Stok</th>
                                            <th class="pl-1">Tanggal Kadaluarsa</th>
                                            <th class="pl-1">Keterangan</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reagensia as $p)
                                            <tr>
                                                <td class="pl-4">
                                                    {{ ($reagensia->currentPage() - 1) * $reagensia->perPage() + $loop->iteration }}
                                                </td>
                                                <td class="pl-1">{{ $p->nama_reagensia }}</td>
                                                <td class="pl-1">{{ $p->stok }}</td>
                                                <td class="pl-1">{{ $p->tanggal_kadaluarsa }}</td>
                                                <td class="pl-1">{{ $p->keterangan }}</td>
                                                <td class="pl-4">
                                                    <div class="table-data-feature">
                                                        @if (auth()->user()->RoleId != 3)
                                                            <button class="item" data-toggle="tooltip"
                                                                data-placement="top" title="More" data-bs-toggle="modal"
                                                                data-bs-target="#moreModal{{ $p->id }}">
                                                                <i class="zmdi zmdi-more"></i>
                                                            </button>
                                                            <form action="/reagensia/hapusreagensia/{{ $p->id }}"
                                                                method="POST" class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button class="item" type="submit" data-toggle="tooltip"
                                                                    onclick="return confirm('Anda yakin ingin menghapus data ini?')"
                                                                    data-placement="top" title="Delete">
                                                                    <i class="zmdi zmdi-delete"></i>
                                                                </button>
                                                            </form>
                                                        @endif

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="pagination-links">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $reagensia->url(1) }}" aria-label="First">
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
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('tambahreagensia') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h3 class="title-5 fs-5">Add Item</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Reagensia</label>
                            <input type="text" class="form-control @error('nama_reagensia') is-invalid @enderror"
                                id="nama_reagensia" name="nama_reagensia" value="{{ old('nama_reagensia') }}">
                            @error('nama_reagensia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Satuan</label>
                            <input type="text" class="form-control @error('satuan') is-invalid @enderror"
                                id="satuan" name="satuan" value="{{ old('satuan') }}">
                            @error('satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label">Tanggal Masuk</label>
                                <input type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                    name="tanggal_masuk" id="tanggal_masuk" value="{{ old('tanggal_masuk') }}">
                                @error('tanggal_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jumlah</label>
                                <input type="text" class="form-control @error('jumlah_masuk') is-invalid @enderror"
                                    id="jumlah_masuk" name="jumlah_masuk" value="{{ old('jumlah_masuk') }}">
                                @error('jumlah_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label">Tanggal Keluar </label>
                                <input type="date" class="form-control @error('tanggal_keluar') is-invalid @enderror"
                                    id="tanggal_keluar" name="tanggal_keluar" value="{{ old('tanggal_keluar') }}">
                                @error('tanggal_keluar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jumlah</label>
                                <input type="text" class="form-control @error('jumlah_keluar') is-invalid @enderror"
                                    id="jumlah_keluar" name="jumlah_keluar" value="{{ old('jumlah_keluar') }}">
                                <input type="text" class="form-control" id="stok" name="stok"
                                    value="{{ old('stok') }}" hidden>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Tanggal Kadaluarsa</label>
                            <input type="date" class="form-control @error('tanggal_kadaluarsa') is-invalid @enderror"
                                id="tanggal_kadaluarsa" name="tanggal_kadaluarsa"
                                value="{{ old('tanggal_kadaluarsa') }}">
                            @error('tanggal_kadaluarsa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Keterangan</label>
                            <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                id="keterangan" name="keterangan" value="{{ old('keterangan') }}">
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach ($reagensia as $re)
        <div class="modal fade" id="moreModal{{ $re->id }}" tabindex="-1"
            aria-labelledby="moreModalLabel{{ $re->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 id="moreModalLabel{{ $re->id }}">{{ $re->nama_reagensia }}</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama &nbsp : {{ $re->nama_reagensia }}
                            </label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Satuan &nbsp : {{ $re->satuan }}</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Masuk &nbsp : {{ $re->tanggal_masuk }}
                                ({{ $re->jumlah_masuk }})
                            </label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Keluar &nbsp : @if ($re->tanggal_keluar != null)
                                    {{ $re->tanggal_keluar }} ({{ $re->jumlah_keluar }})
                                @else
                                    -
                                @endif
                            </label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stok &nbsp : {{ $re->stok }}
                            </label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Kadaluarsa &nbsp : {{ $re->tanggal_kadaluarsa }}
                            </label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan &nbsp : {{ $re->keterangan }}
                            </label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Input &nbsp : {{ $re->created_at }}
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const tanggalMasukInput = document.getElementById('tanggal_masuk');
        const tanggalKeluarInput = document.getElementById('tanggal_keluar');

        tanggalMasukInput.addEventListener('input', function() {
            tanggalKeluarInput.setAttribute('min', this.value);
        });

        tanggalKeluarInput.addEventListener('input', function() {
            tanggalMasukInput.setAttribute('max', this.value);
        });
        var today = new Date().toISOString().split('T')[0];
        document.getElementById('tanggal_kadaluarsa').setAttribute('min', today);

        // Alert
        var successElement = document.getElementById('successAlert');
        var dangerElement = document.getElementById('dangerAlert');
        setTimeout(function() {
            successElement.style.display = 'none';
        }, 5000);

        setTimeout(function() {
            dangerElement.style.display = 'none';
        }, 5000);

        const namaReagensiaInput = document.getElementById('nama_reagensia');
        namaReagensiaInput.addEventListener('change', () => {
            const namaReagensia = namaReagensiaInput.value;

            // Mengambil data dari server berdasarkan nama reagensia
            fetch(`/api/reagensia/${namaReagensia}`)
                .then(response => response.json())
                .then(data => {
                    // Mengisi field-field pada formulir dengan data yang diterima
                    document.getElementById('satuan').value = data.satuan;
                    document.getElementById('stok').value = data.stok;
                })
            console.log(data.satuan)
                .catch(error => {
                    console.error('Error:', error);
                });
        });

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
@endsection
