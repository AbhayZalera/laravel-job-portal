@extends('frontend.layouts.master')

@section('contents')
    <section class="section-box mt-75">
        <div class="breacrumb-cover">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <h2 class="mb-20">Contact</h2>
                        <ul class="breadcrumbs">
                            <li><a class="home-icon" href="{{ url('/') }}">Home</a></li>
                            <li>Contact</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-box mt-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 text-center d-none d-lg-block">
                    <img src="{{ asset('frontend/assets/imgs/page/contact/img.png') }}" alt="joxBox">
                </div>
                <div class="col-lg-8 mb-40"><span class="font-md color-brand-2 d-inline-block">Contact us</span>
                    <h2 class="mt-5 mb-10">Get in touch</h2>
                    <p class="font-md color-text-paragraph-2">The right move at the right time saves your investment.
                        live<br class="d-none d-lg-block"> the dream of expanding your business.</p>
                    <form class="contact-form-style mt-30" id="contact-form" action="" method="post">
                        @csrf
                        <div class="row wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                            <div class="col-lg-6 col-md-6">
                                <div class="input-style mb-20">
                                    <input class="font-sm color-text-paragraph-2" name="name"
                                        placeholder="Enter your name" type="text">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="input-style mb-20">
                                    <input class="font-sm color-text-paragraph-2" name="email"
                                        placeholder="Enter your email" type="text">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="input-style mb-20">
                                    <input class="font-sm color-text-paragraph-2" name="subject" placeholder="Your subject"
                                        type="text">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="textarea-style mb-30">
                                    <textarea class="font-sm color-text-paragraph-2" name="message" placeholder="Message"></textarea>
                                </div>
                                <button class="submit btn btn-send-message" type="submit">Send message</button>
                            </div>
                        </div>
                    </form>
                    <p class="form-messege"></p>
                </div>
            </div>
        </div>
    </section>

    <section class="contact_map mt-80">
        <div class="container">
            <div class="row">
                @if (config('settings.site_map'))
                    {!! config('settings.site_map') !!}
                @endif
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $("#contact-form").on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                let button = $('.submit');

                $.ajax({
                    method: 'POST',
                    url: '{{ route('send-mail') }}',
                    data: formData,
                    beforeSend: function() {
                        button.text("Sending...");
                        button.prop('disabled', true);
                    },
                    success: function(response) {
                        button.text("Send message")
                        button.prop('disabled', false);
                        $("#contact-form").trigger('reset');
                        notyf.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        let erorrs = xhr.responseJSON.errors;
                        console.log(xhr)
                        $.each(erorrs, function(index, value) {
                            notyf.error(value[0]);
                        });
                        button.text("Send message");
                        button.prop('disabled', false);

                    }
                })
            });
        })
    </script>
@endpush
