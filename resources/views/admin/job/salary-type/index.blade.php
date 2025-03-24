@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Salary Types</h1>
        </div>
        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>All Salary Types</h4>
                        <div class="card-header-form">
                            <form action="{{ route('admin.salary-type.index') }}" method="GET">
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
                        <a href="{{ route('admin.salary-type.create') }}" class="btn btn-primary"><i
                                class="fas fa-plus-circle"></i> Create new</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th style="width: 20%">Actions</th>
                                </tr>
                                <tbody>
                                    @forelse ($salaryTypes as $salaryType)
                                        <tr>
                                            <td>{{ $salaryType->name }}</td>
                                            <td>{{ $salaryType->slug }}</td>
                                            <td><a href="{{ route('admin.salary-type.edit', $salaryType->id) }}"
                                                    class="btn btn-small btn-primary"><i class="fas fa-edit"></i></a>
                                                <a href="{{ route('admin.salary-type.destroy', $salaryType->id) }}"
                                                    class="btn btn-small btn-danger delete-item"><i
                                                        class="fas fa-trash-alt"></i></a>
                                            </td>
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
                            @if ($salaryTypes->hasPages())
                                {{ $salaryTypes->withQueryString()->links() }}
                            @endif
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
