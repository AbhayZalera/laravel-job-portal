@extends('frontend.layouts.master')

@section('contents')
    <section class="section-box mt-75">
        <div class="breacrumb-cover">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <h2 class="mb-20">Applications</h2>
                        <ul class="breadcrumbs">
                            <li><a class="home-icon" href="index.html">Home</a></li>
                            <li>Applications</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-box mt-120">
        <div class="container">
            <div class="row">
                @include('frontend.company-dashboard.sidebar')
                <div class="col-lg-9 col-md-8 col-sm-12 col-12 mb-50">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $jobTitle?->title }}</h4>

                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Details</th>
                                        <th>Experience</th>
                                        <th>Approve</th>
                                        <th style="width: 20%">Action</th>
                                    </tr>
                                    {{-- {{ dd($applications) }} --}}
                                    <tbody>
                                        @forelse ($applications as $application)
                                            <tr>
                                                <td>
                                                    <div class="d-flex">

                                                        <img style="width: 50px; height: 50px;; object-fit:cover;"
                                                            src="{{ asset($application?->candidate?->image) }}"
                                                            alt="">
                                                        <br>
                                                        <div style="margin-left: 10px">
                                                            <span>{{ $application?->candidate?->full_name }}</span>
                                                            <br>
                                                            <span>{{ $application?->candidate?->professions->name }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $application->candidate?->experience->name }}
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label class="custom-switch mt-2">
                                                            <input @checked($application->a_status === 'active') type="checkbox"
                                                                data-id="{{ $application->id }}"
                                                                name="custom-switch-checkbox"
                                                                class="custom-switch-input a_status">
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('candidates.show', $application?->candidate?->slug) }}"
                                                        class="btn btn-primary">View Profile</a>
                                                    <a href="mailto:{{ $application->candidate->email }}"
                                                        class="btn btn-primary">Send
                                                        Mail</a>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">No result found!</td>
                                            </tr>
                                        @endforelse

                                    </tbody>

                                </table>
                            </div>
                        </div>

                        <div class="paginations">
                            <ul class="pager">
                                @if ($applications->hasPages())
                                    {{ $applications->withQueryString()->links() }}
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('.a_status').on('change', function() {
                let id = $(this).data('id');

                $.ajax({
                    method: 'POST',
                    url: '{{ route('company.approve.update', ':id') }}'.replace(":id", id),
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.message == 'success') {
                            window.location.reload();
                        }
                    },
                    error: function(xhr, status, error) {

                    }
                });
            })
        })
    </script>
@endpush
