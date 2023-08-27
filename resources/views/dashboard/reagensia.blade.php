@extends('dashboard.template.header')
@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <h3 class="title-5 m-b-35">data table</h3>
                        <div id="successAlert" class="alert alert-success" role="alert">
                            A simple success alert—check it out!
                        </div>
                        <div id="dangerAlert" class="alert alert-danger" role="alert">
                            A simple success alert—check it out!
                        </div>
                        <div class="table-data__tool">
                            <div class="table-data__tool-left">
                                <div class="rs-select2--light rs-select2--md">
                                    <select class="js-select2" name="property">
                                        <option selected="selected">All Properties</option>
                                        <option value="">Option 1</option>
                                        <option value="">Option 2</option>
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                                <a href="/reagensia/export" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a>
                                <div class="rs-select2--light rs-select2--sm">
                                    <select class="js-select2" name="time">
                                        <option selected="selected">Today</option>
                                        <option value="">3 Days</option>
                                        <option value="">1 Week</option>
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                                <button class="au-btn-filter">
                                    <i class="zmdi zmdi-filter-list"></i>filters</button>
                            </div>
                            <div class="table-data__tool-right">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small" data-bs-toggle="modal"
                                    data-bs-target="#tambahModal">
                                    <i class="zmdi zmdi-plus"></i>add item</button>
                                <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
                                    <select class="js-select2" name="type">
                                        <option selected="selected">Export</option>
                                        <option value="">Option 1</option>
                                        <option value="">Option 2</option>
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive table--no-card m-b-40">
                            <table class="table table-borderless table-striped table-earning">
                                <thead>
                                    <tr>
                                        <th class="pl-4">No</th>
                                        <th class="pl-1">Nama Reagensia</th>
                                        <th class="pl-1">Saldo</th>
                                        <th class="pl-1">Tanggal Kadaluarsa</th>
                                        <th class="pl-1">Keterangan</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reagensia as $p)
                                        <tr>
                                            <td class="pl-4">1</td>
                                            <td class="pl-1">{{ $p->nama_reagensia }}</td>
                                            <td class="pl-1">{{ $p->saldo }}</td>
                                            <td class="pl-1">{{ $p->tanggal_kadaluarsa }}</td>
                                            <td class="pl-1">{{ $p->keterangan }}</td>
                                            <td>
                                                <div class="table-data-feature">
                                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="Edit">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </button>
                                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="More">
                                                        <i class="zmdi zmdi-more"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="copyright">
                            <p>Copyright © 2018 Colorlib. All rights reserved. Template by <a
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
                                @error('jumlah_keluar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
    </script>
@endsection
