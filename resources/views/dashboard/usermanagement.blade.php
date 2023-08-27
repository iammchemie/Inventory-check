@extends('dashboard.template.header')
@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <h3 class="title-5 m-b-35">data table</h3>
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
                        </div>
                        <div class="table-responsive table--no-card m-b-40">
                            <table class="table table-borderless table-striped table-earning">
                                <thead>
                                    <tr>
                                        <th class="pl-4">No</th>
                                        <th class="pl-1">Nama</th>
                                        <th class="pl-1">Email</th>
                                        <th class="pl-1">Role</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $u)
                                        <tr>
                                            <td class="pl-4">{{ $loop->iteration }}</td>
                                            <td class="pl-1">{{ $u->name }}</td>
                                            <td class="pl-1">{{ $u->email }}</td>
                                            <td class="pl-1">
                                                @if ($u->RoleId == 1)
                                                    Admin
                                                @elseif ($u->RoleId == 2)
                                                    Operator
                                                @else
                                                    Guest
                                                @endif
                                            </td>
                                            <td>
                                                <div class="table-data-feature">
                                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="Ubah Kata Sandi" data-bs-toggle="modal"
                                                        data-bs-target="#ubahpasswordModal{{ $u->id }}">
                                                        <i class="zmdi zmdi-edit"></i>
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
    @foreach ($users as $up)
        <div class="modal fade" id="ubahpasswordModal{{ $up->id }}" tabindex="-1"
            aria-labelledby="ubahpasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('ubahpassword', ['id' => $up->id]) }}" method="post">
                        @csrf
                        <div class="modal-header">
                            <h3 class="title-5 fs-5">Ubah Password {{ $up->name }}</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <div class="password-input-container">
                                    <label class="form-label">Kata Sandi Baru</label>
                                    <div class="input-group-append">
                                        <input type="password"
                                            class="form-control @error('password' . $up->id) is-invalid @enderror"
                                            id="password" name="password{{ $up->id }}"
                                            value="{{ old('password' . $up->id) }}">

                                        <span id="showPasswordIcon" class="input-group-text"><i
                                                class="fas fa-eye-slash"></i></span>
                                    </div>
                                    @error('password' . $up->id)
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Kata Sandi Baru</label>
                                <div class="input-group-append">
                                    <input type="password"
                                        class="form-control @error('repassword' . $up->id) is-invalid @enderror"
                                        id="repassword" name="repassword{{ $up->id }}"
                                        value="{{ old('password' . $up->id) }}">

                                    <span id="showrePasswordIcon" class="input-group-text"><i
                                            class="fas fa-eye-slash"></i></span>
                                </div>
                                @error('repassword' . $up->id)
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"
                                onclick="return confirm('Anda yakin ingin mengubah password?')">Save
                                changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            const passwordInput = document.getElementById('password');
            const showPasswordIcon = document.getElementById('showPasswordIcon');

            showPasswordIcon.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    showPasswordIcon.innerHTML = '<i class="fas fa-eye"></i>'; // Ikon mata tertutup
                } else {
                    passwordInput.type = 'password';
                    showPasswordIcon.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Ikon mata terbuka
                }
            });

            const repasswordInput = document.getElementById('repassword');
            const showrePasswordIcon = document.getElementById('showrePasswordIcon');

            showrePasswordIcon.addEventListener('click', function() {
                if (repasswordInput.type === 'password') {
                    repasswordInput.type = 'text';
                    showrePasswordIcon.innerHTML = '<i class="fas fa-eye"></i>'; // Ikon mata tertutup
                } else {
                    repasswordInput.type = 'password';
                    showrePasswordIcon.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Ikon mata terbuka
                }
            });
        </script>
    @endforeach
@endsection
