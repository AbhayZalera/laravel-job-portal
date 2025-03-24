@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Role User</h1>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (!empty($admin))
                            <h4>Update User</h4>
                        @else
                            <h4>Create User</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($admin->id) ? route('admin.role-user.update', $admin->id) : route('admin.role-user.store') }}"
                            method="POST">
                            @csrf
                            @if (!empty($admin->id))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="">Name</label>
                                <input class="form-control {{ hasError($errors, 'name') }}"
                                    value="{{ old('name', $admin->name ?? '') }}" type="text" name="name">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Email</label>
                                <input class="form-control {{ hasError($errors, 'email') }}"
                                    value="{{ old('email', $admin->email ?? '') }}" type="text" name="email">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Password</label>
                                <input class="form-control {{ hasError($errors, 'password') }}"
                                    value="{{ old('password') }}" type="text" name="password">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Confirm Password</label>
                                <input class="form-control {{ hasError($errors, 'password_confirmation') }}"
                                    value="{{ old('password_confirmation') }}" type="text" name="password_confirmation">
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Role</label>
                                <select class="form-control" name="role" id="">
                                    <option value="">Select</option>
                                    @foreach ($roles as $r)
                                        <option @if (!empty($admin)) @selected($r->name == $admin->getRoleNames()->first()) @endif
                                            value="{{ $r->name }}">
                                            {{ $r->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>


                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (!empty($admin->id))
                                        Update
                                    @else
                                        Create
                                    @endif
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
