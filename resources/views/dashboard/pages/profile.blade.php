@extends('dashboard.layouts.app')
@section('main')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.update', $admin->id) }}" method="post">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label for="edit_admins_name">Name</label>
                            <input type="text" name="name" value="{{ $admin->name }}" id="edit_admins_name" class="form-control" required="true"  />
                             @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="edit_admins_email">Email</label>
                            <input type="text" name="email" value="{{ $admin->email }}" id="edit_admins_email"
                                class="form-control" required="true" />
                            @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="edit_admins_password">Password Baru</label>
                            <input type="password" name="password" value="{{ old('password') }}" id="edit_admins_password"
                                class="form-control"/>
                            @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="edit_admins_password">Ketik Ulang Password Baru</label>
                            <input type="password" name="password_confirmation" value="{{ old('password') }}"
                                id="edit_admins_password" class="form-control"/>
                            @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit">
                            Ubah
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>

@endsection
@push('js')

@endpush
