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
                        @if (!empty($salaryType->id))
                            <h4>Update SalaryType</h4>
                        @else
                            <h4>Create New SalaryType</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($salaryType) ? route('admin.salary-type.update', $salaryType->id) : route('admin.salary-type.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($salaryType))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="">Name</label>
                                <input class="form-control {{ hasError($errors, 'name') }}"
                                    value="{{ old('name', $salaryType->name ?? '') }}" type="text" name="name">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (!empty($salaryType->id))
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
