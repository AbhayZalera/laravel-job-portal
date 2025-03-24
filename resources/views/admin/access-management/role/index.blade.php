@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Roles</h1>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>All Roles</h4>
                        <div class="card-header-form">
                            <form action="{{ route('admin.role.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search"
                                        value="{{ request('search') }}" placeholder="Search">
                                    <div class="input-group-btn">
                                        <button style="height: 40px" class="btn btn-primary"><i
                                                class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <a href="{{ route('admin.role.create') }}" class="btn btn-primary"><i
                                class="fas fa-plus-circle"></i> Create new</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>Name</th>
                                    <th>Permissions</th>
                                    <th style="width: 20%">Actions</th>
                                </tr>
                                <tbody>
                                    @forelse ($roles as $role)
                                        <tr>
                                            <td>{{ $role->name }}</td>
                                            <td style="width:70%;">
                                                @foreach ($role->permissions as $permission)
                                                    <span
                                                        class="badge bg-primary text-light m-1">{{ $permission->name }}</span>
                                                @endforeach
                                            </td>
                                            {{-- @if ($role->name !== 'Super Admin') --}}
                                            <td><a href="{{ route('admin.role.edit', $role->id) }}"
                                                    class="btn btn-small btn-primary"><i class="fas fa-edit"></i></a>
                                                <a href="{{ route('admin.role.destroy', $role->id) }}"
                                                    class="btn btn-small btn-danger delete-item"><i
                                                        class="fas fa-trash-alt"></i></a>
                                            </td>
                                            {{-- @endif --}}

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No result found! </td>
                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <nav class="d-inline-block">
                            {{-- @if ($roles->hasPages())
                                {{ $roles->withQueryString()->links() }}
                            @endif --}}
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
