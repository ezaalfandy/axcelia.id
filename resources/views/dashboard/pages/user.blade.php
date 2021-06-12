@extends('dashboard.layouts.app')
@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar {{ Str::ucfirst(Request::segment(1)) }}</h4>
                </div>
                <div class="card-body">

                    <table class="table table-striped" id="tableUsers">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Name</td>
                                <td>Email</td>
                                <td>Phone Number</td>
                                <td>Province</td>
                                <td>City</td>
                                <td>Zip Code</td>
                                <td>Address</td>
                                <td>Status</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td></td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>{{ $user->province }}</td>
                                    <td>{{ $user->city }}</td>
                                    <td>{{ $user->zip_code }}</td>
                                    <td>{{ $user->address }}</td>
                                    <td>{{ $user->status }}</td>
                                    <td>
                                        @if ($user->status == 'approved')
                                            <form class="d-inline-block" action="{{ route('user.change-status', $user->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="waiting">
                                                <button type="button"
                                                    class="btn btn-sm btn-warning btn-change-status-user">Non Aktifkan User</button>
                                            </form>
                                        @else
                                            <form class="d-inline-block" action="{{ route('user.change-status', $user->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="button"
                                                    class="btn btn-sm btn-success btn-change-status-user">Aktifkan User</button>
                                            </form>
                                        @endif
                                        <a class="btn btn-info btn-sm" href="{{ route('user.edit', $user->id)}}">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
                <div class="card-footer text-muted">
                    Footer
                </div>
            </div>
        </div>
    </div>


@endsection
@push('js')

    <script>
        $(document).ready(function() {
            var tableUsers = $('#tableUsers').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "columnDefs": [{
                        "width": "15%",
                        "targets": -1
                    },
                    {
                        "width": "5%",
                        "targets": 0
                    }
                ],
                responsive: true,
                autoWidth: false
            });

            tableUsers.on('order.dt search.dt', function() {
                tableUsers.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });


        $('.btn-change-status-user').on('click', function(e) {
            e.preventDefault();
            var form = $(this).parents('form');
            swal({
                title: 'Apakah Anda Yakin ?',
                text: "Data user akan diubah !",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-info',
                cancelButtonClass: 'btn btn-default btn-link',
                confirmButtonText: 'Ya, Ubah',
                buttonsStyling: false
            }).then(function(result) {
                if (result.value === true) {
                    $(form).submit();
                }
            })
        });


        app.setFormValidation('#formInsertUser');

        app.setFormValidation('#formEditUser');

        function openModalEditUser($getUrl, $updateUrl) {
            $.getJSON($getUrl,
                function(data, textStatus, jqXHR) {
                    $('#formEditUser .form-group').addClass('is-filled');
                    $('#formEditUser [name="id"]').val(data.id);
                    $('#formEditUser [name="name"]').val(data.name);
                    $('#formEditUser [name="email"]').val(data.email);
                    $('#formEditUser [name="password"]').val(data.password);
                    $('#formEditUser [name="phone_number"]').val(data.phone_number);
                    $('#formEditUser [name="province"]').val(data.province);
                    $('#formEditUser [name="city"]').val(data.city);
                    $('#formEditUser [name="zip_code"]').val(data.zip_code);
                    $('#formEditUser [name="address"]').val(data.address);
                    $('#formEditUser [name="status"]').selectpicker('val', data.status);
                    $('#formEditUser [name="remember_token"]').val(data.remember_token);
                    $('#formEditUser').attr('action', $updateUrl);
                    $('#modalEditUser').modal('show');
                }
            );
        }

    </script>

@endpush
