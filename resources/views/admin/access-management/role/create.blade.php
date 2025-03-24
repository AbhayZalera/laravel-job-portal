@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Roles and Permissions</h1>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (!empty($role))
                            <h4>Update New Role</h4>
                        @else
                            <h4>Create New Role</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($role->id) ? route('admin.role.update', $role->id) : route('admin.role.store') }}"
                            method="POST">
                            @csrf
                            @if (!empty($role->id))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="">Name</label>
                                <input class="form-control {{ hasError($errors, 'name') }}"
                                    value="{{ old('name', $role->name ?? '') }}" type="text" name="name">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            @foreach ($permissions as $groupname => $permission)
                                <div class="form-group">
                                    <h5 class="">{{ $groupname }}</h5>
                                    <div class="row">
                                        @foreach ($permission as $item)
                                            <div class="col-md-2">
                                                <label class="custom-switch mt-2">
                                                    <input
                                                        @if (!empty($role)) {{ in_array($item->name, $rolePermission) ? 'checked' : '' }} @endif
                                                        type="checkbox" name="permissions[]" class="custom-switch-input"
                                                        value="{{ $item->name }}">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">{{ $item->name }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (!empty($role->id))
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
