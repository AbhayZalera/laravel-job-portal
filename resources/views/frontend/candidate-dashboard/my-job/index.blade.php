@extends('frontend.layouts.master')

@section('contents')
    <section class="section-box mt-75">
        <div class="breacrumb-cover">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <h2 class="mb-20">Applied Jobs</h2>
                        <ul class="breadcrumbs">
                            <li><a class="home-icon" href={{ url('/') }}>Home</a></li>
                            <li>Applied Jobs</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-box mt-120">
        <div class="container">
            <div class="row">
                {{-- sidebar --}}
                @include('frontend.candidate-dashboard.sidebar')

                <div class="col-lg-9 col-md-8 col-sm-12 col-12 mb-50">

                    <div class="mb-3">
                        <h4>Applied Jobs ({{ count($appliedJobs) }})</h4>
                    </div>
                    <table class="table table-striped table-hover">

                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Salary</th>
                                <th>Date</th>
                                <th>Job Status</th>
                                <th>Status</th>
                                <th style="width: 15%">Action</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            @forelse ($appliedJobs as $appliedJob)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <img style="width: 50px; height:50px; object-fit:cover;"
                                                src="{{ asset($appliedJob->job?->company?->logo) }} ">
                                            <div>
                                                <h6 style="padding-left: 15px">{{ $appliedJob->job?->company?->name }}</h6>
                                                <b
                                                    style="padding-left: 15px">{{ $appliedJob->job?->company?->countries->name }}</b>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($appliedJob->job?->salary_mode === 'range')
                                            {{ $appliedJob->job?->min_salary }} - {{ $appliedJob->job?->max_salary }}
                                            {{ config('settings.site_default_currency') }}
                                        @else
                                            {{ $appliedJob->job?->custom_salary }}
                                        @endif
                                    </td>
                                    <td>{{ formatDate($appliedJob?->created_at) }}</td>
                                    <td>
                                        @if ($appliedJob->job?->deadline < date('Y-m-d'))
                                            <span class='badge bg-danger'>Expired</span>
                                        @else
                                            <span class='badge bg-success'>Active</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($appliedJob->a_status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @else
                                            <span class="badge bg-success">Aprove</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href={{ route('jobs.show', $appliedJob->job?->slug) }}
                                            class="btn-sm btn btn-primary "><i class="fas fa-eye"></i></a>
                                    </td>

                                </tr>
                            @empty
                                <td colspan="5" class="text-center">No Data Found</td>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
