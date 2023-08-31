@extends('dashboard.template.header')
@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <h3 class="title-5 m-b-35">Data Users</h3>
                        @if (session('success'))
                            <div id="successAlert" class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div id="successAlert2" class="alert alert-success" role="alert" style="display: none;">
                            Role Berhasil dirubah
                        </div>
                        @error('password')
                            <div id="successAlert" class="alert alert-success" role="alert">
                                <li>{{ $message }}</li>
                            </div>
                        @enderror
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
                                                <div class="rs-select2--trans rs-select2--sm">
                                                    <form action="{{ route('ubahRole', ['id' => $u->id]) }}" method="post"
                                                        id="roleForm{{ $u->id }}">
                                                        @csrf
                                                        @method('PUT') <!-- Tambahkan metode PUT di sini -->

                                                        <select class="form-control" name="role{{ $u->id }}"
                                                            id="role{{ $u->id }}"
                                                            data-current-role="{{ $u->RoleId }}"
                                                            onchange="confirmRoleChange(this, {{ $u->id }})">
                                                            <option value="1" {{ $u->RoleId == 1 ? 'selected' : '' }}>
                                                                Admin</option>
                                                            <option value="2" {{ $u->RoleId == 2 ? 'selected' : '' }}>
                                                                Operator</option>
                                                            <option value="3" {{ $u->RoleId == 3 ? 'selected' : '' }}>
                                                                Guest</option>
                                                        </select>
                                                    </form>
                                                    <div class="dropDownSelect2"></div>
                                                </div>
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
                                        <script>
                                            function confirmRoleChange(selectElement, userId) {
                                                const confirmed = confirm(
                                                    "Apakah Anda yakin ingin mengubah role dengan nama {{ $u->name }} ke : " +
                                                    selectElement.options[selectElement.selectedIndex].text);
                                                if (confirmed) {
                                                    const selectedOption = selectElement.options[selectElement.selectedIndex].text;
                                                    selectElement.setAttribute('data-current-role', selectedOption);
                                                    const formData = {
                                                        _method: 'PUT',
                                                        userId: userId,
                                                        newRole: selectedOption,
                                                    };

                                                    $.ajax({
                                                        type: 'POST',
                                                        url: $('#roleForm' + userId).attr('action'),
                                                        data: $('#roleForm' + userId).serialize(),
                                                        success: function(response) {

                                                            // Update tampilan peran pengguna sesuai dengan perubahan
                                                            const userRoleElement = document.getElementById('userRole' + userId);
                                                            userRoleElement.textContent = selectedOption;
                                                        },
                                                        error: function(error) {
                                                            console.error(error);
                                                        }
                                                    });
                                                } else {
                                                    // Kembalikan elemen select ke peran yang sebelumnya terpilih
                                                    const currentRole = selectElement.getAttribute('data-current-role');
                                                    selectElement.value = currentRole;
                                                }
                                            }
                                        </script>
                                    @endforeach
                                    <script></script>
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
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
                                            id="password{{ $up->id }}" name="password{{ $up->id }}"
                                            value="{{ old('password' . $up->id) }}">

                                        <span id="showPasswordIcon{{ $up->id }}" class="input-group-text"><i
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
                                        id="repassword{{ $up->id }}" name="repassword{{ $up->id }}"
                                        value="{{ old('password' . $up->id) }}">

                                    <span id="showrePasswordIcon{{ $up->id }}" class="input-group-text"><i
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
            const passwordInput{{ $up->id }} = document.getElementById('password{{ $up->id }}');
            const showPasswordIcon{{ $up->id }} = document.getElementById('showPasswordIcon{{ $up->id }}');

            showPasswordIcon{{ $up->id }}.addEventListener('click', function() {
                if (passwordInput{{ $up->id }}.type === 'password') {
                    passwordInput{{ $up->id }}.type = 'text';
                    showPasswordIcon{{ $up->id }}.innerHTML = '<i class="fas fa-eye"></i>'; // Ikon mata tertutup
                } else {
                    passwordInput{{ $up->id }}.type = 'password';
                    showPasswordIcon{{ $up->id }}.innerHTML =
                        '<i class="fas fa-eye-slash"></i>'; // Ikon mata terbuka
                }
            });

            const repasswordInput{{ $up->id }} = document.getElementById('repassword{{ $up->id }}');
            const showrePasswordIcon{{ $up->id }} = document.getElementById('showrePasswordIcon{{ $up->id }}');

            showrePasswordIcon{{ $up->id }}.addEventListener('click', function() {
                if (repasswordInput{{ $up->id }}.type === 'password') {
                    repasswordInput{{ $up->id }}.type = 'text';
                    showrePasswordIcon{{ $up->id }}.innerHTML =
                        '<i class="fas fa-eye"></i>'; // Ikon mata tertutup
                } else {
                    repasswordInput{{ $up->id }}.type = 'password';
                    showrePasswordIcon{{ $up->id }}.innerHTML =
                        '<i class="fas fa-eye-slash"></i>'; // Ikon mata terbuka
                }
            });

            var successElement = document.getElementById('successAlert');
            var dangerElement = document.getElementById('dangerAlert');
            setTimeout(function() {
                successElement.style.display = 'none';
            }, 5000);

            setTimeout(function() {
                dangerElement.style.display = 'none';
            }, 5000);
        </script>
    @endforeach
@endsection
