@extends('frontend.layouts.master')

@section('contents')
    <section class="section-box mt-75">
        <div class="breacrumb-cover">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <h2 class="mb-20">My Profile</h2>
                        <ul class="breadcrumbs">
                            <li><a class="home-icon" href="{{ url('/') }}">Home</a></li>
                            <li>My Profile</li>
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

                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">Basic</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                aria-selected="false">Profile</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-experience-education-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-experience-education" type="button" role="tab"
                                aria-controls="pills-experience-education" aria-selected="false">Experience &
                                Education</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                                aria-selected="false">Account Settings</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            @include('frontend.candidate-dashboard.profile.sections.basic-section')
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            @include('frontend.candidate-dashboard.profile.sections.profile-section')
                        </div>
                        <div class="tab-pane fade" id="pills-experience-education" role="tabpanel"
                            aria-labelledby="pills-experience-education-tab">
                            @include('frontend.candidate-dashboard.profile.sections.experience-section')
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                            @include('frontend.candidate-dashboard.profile.sections.account-settings-section')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Experience Modal -->
    <div class="modal fade" id="experienceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        {{-- aria-hidden="true" --}}
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Experience</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="ExperienceForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Company *</label>
                                    <input type="text" class="from-control" required="" name="company"
                                        id="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Depertment *</label>
                                    <input type="text" class="from-control" required="" name="department"
                                        id="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Designation *</label>
                                    <input type="text" class="from-control" required="" name="designation"
                                        id="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Start Date *</label>
                                    <input type="text" class="from-control datepicker" required="" name="start"
                                        id="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">End Date *</label>
                                    <input type="text" class="from-control datepicker" required="" name="end"
                                        id="">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-check form-group form-check-inline">
                                    <input class="form-check-input" style="margin-right: 10px" value="1"
                                        type="checkbox" name="currently_working">
                                    <label class="form-check-label" for="typeCandidate"> I am currently working</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Responsibilities</label>
                                    <textarea name="responsibilities" maxlength="500" id="" class="from-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary save_changes">Save Experience</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Education Modal -->
    <div class="modal fade" id="educationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Education</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="EducationForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Level *</label>
                                    <input type="text" class="from-control" required="" name="level"
                                        id="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Degree *</label>
                                    <input type="text" class="from-control" required="" name="degree"
                                        id="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Year *</label>
                                    <input type="text" class="from-control yearpicker" required="" name="year"
                                        id="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Note</label>
                                    <textarea name="note" maxlength="500" id="" class="from-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Eduction</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        var editID = '';

        //fetch experience data
        function fetchExperience() {
            $.ajax({
                method: 'GET',
                url: "{{ route('candidate.experience.index') }}",
                data: {},
                success: function(response) {
                    $('.experience-tbody').html(response);
                },
                error: function(xhr, status, error) {}
            })
        }
        fetchExperience();
        // var editMode = false;
        //insert and update Experience
        $('#ExperienceForm').on('submit', function(event) {
            event.preventDefault();
            const formData = $(this).serialize();
            // console.log(formData);
            if (editID) {
                method = 'PUT';
                url = "{{ route('candidate.experience.update', ':id') }}".replace(':id',
                    editID);
            } else {
                method = 'POST';
                url = "{{ route('candidate.experience.store') }}";
            }
            $.ajax({
                method: method,
                url: url,
                data: formData,
                success: function(response) {
                    fetchExperience();
                    $('#ExperienceForm').trigger('reset');
                    $('#experienceModal').modal('hide');
                    editID = '';
                    notyf.success(response.message);
                },
                error: function(xhr, status, error) {}
            })
        });

        //edit experience
        $('body').on('click', '.edit-experience', function() {
            $('#ExperienceForm').trigger('reset');
            let url = $(this).attr('href');
            // console.log(url);
            $.ajax({
                type: "GET",
                url: url,
                data: {},
                // beforeSend: function(response) {
                //     showLoader();
                // }
                success: function(response) {
                    editID = response.id;
                    // editMode = true;
                    $.each(response, function(index, value) {
                        $(`input[name="${index}"]:text`).val(value);
                        if (index === 'currently_working' && value === 1) {
                            $(`input[name="${index}"]:checkbox`).prop(
                                'checked', true);
                        }
                        if (index === 'responsibilities') {
                            $(`textarea[name="${index}"]`).val(value);
                        }
                    });
                    hideLoader();
                },
                error: function(xhr, status, error) {}
            })
        });

        //delete exeperience
        $("body").on('click', '.delete-experience', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            console.log(url);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "DELETE",
                        url: url,
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            fetchExperience();
                            // window.location.reload();
                            notyf.success(response.message);
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                            swal(xhr.responseJSON.message, {
                                icon: 'error',
                            });
                        }
                    });
                }
            });
        });



        //=========================================================================

        // fetch education data
        function fetchEducation() {
            $.ajax({
                method: 'GET',
                url: "{{ route('candidate.education.index') }}",
                data: {},
                success: function(response) {
                    $('.education-tbody').html(response);
                },
                error: function(xhr, status, error) {}
            })
        }

        fetchEducation()

        // var editMode = false;
        // insert and update education
        $('#EducationForm').on('submit', function(event) {
            event.preventDefault();
            const formData = $(this).serialize();
            // console.log(formData);
            if (editID) {
                method = 'PUT';
                url = "{{ route('candidate.education.update', ':id') }}".replace(':id',
                    editID);
            } else {
                method = 'POST';
                url = "{{ route('candidate.education.store') }}";
            }
            $.ajax({
                method: method,
                url: url,
                data: formData,
                // beforeSend: function() {
                //     showLoader();
                // },
                success: function(response) {
                    fetchEducation();
                    $('#EducationForm').trigger('reset');
                    $('#educationModal').modal('hide');
                    editID = '';
                    // hideLoader();
                    notyf.success(response.message);
                },
                error: function(xhr, status, error) {}
            })
            // if (editID) {
            //     // console.log(editId);
            //     $.ajax({
            //         method: 'PUT',
            //         url: "{{ route('candidate.experience.update', ':id') }}".replace(':id',
            //             editID),
            //         data: formData,
            //         success: function(response) {
            //             $('#ExperienceForm').trigger('reset');
            //             $('#experienceModal').modal('hide');
            //             // editID = '';
            //             notyf.success(response.message);
            //         },
            //         error: function(xhr, status, error) {}
            //     })
            // } else {
            //     $.ajax({
            //         method: 'POST',
            //         url: "{{ route('candidate.experience.store') }}",
            //         data: formData,
            //         success: function(response) {
            //             $('#ExperienceForm').trigger('reset');
            //             $('#experienceModal').modal('hide');
            //             notyf.success(response.message);
            //         },
            //         error: function(xhr, status, error) {}
            //     })
            // }

        });

        // edit education
        $('body').on('click', '.edit-education', function() {
            $('#EducationForm').trigger('reset');
            let url = $(this).attr('href');
            // console.log(url);
            $.ajax({
                type: "GET",
                url: url,
                data: {},
                // beforeSend: function(response) {
                //     showLoader();
                // }
                success: function(response) {
                    editID = response.id;
                    // editMode = true;
                    $.each(response, function(index, value) {
                        $(`input[name="${index}"]:text`).val(value);

                        if (index === 'note') {
                            $(`textarea[name="${index}"]`).val(value);
                        }
                    });
                    hideLoader();
                },
                error: function(xhr, status, error) {}
            })
        });

        // delete education
        $("body").on('click', '.delete-education', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            console.log(url);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "DELETE",
                        url: url,
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            fetchEducation();
                            // window.location.reload();
                            notyf.success(response.message);
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                            swal(xhr.responseJSON.message, {
                                icon: 'error',
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
