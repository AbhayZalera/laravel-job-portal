@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Payment Gateway Setting</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>All Gateway Settings</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-2">
                                <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">

                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab4" data-toggle="tab" href="#home4"
                                            role="tab" aria-controls="home" aria-selected="true">Paypal</a>
                                    </li>


                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#profile4"
                                            role="tab" aria-controls="profile" aria-selected="false">Stripe</a>
                                    </li>


                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#contact4"
                                            role="tab" aria-controls="contact" aria-selected="false">RazorPay</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="phonepe-tab4" data-toggle="tab" href="#phonepe4"
                                            role="tab" aria-controls="phonepe" aria-selected="false">PhonePe</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-10">
                                <div class="tab-content no-padding" id="myTab2Content">

                                    <div class="tab-pane fade show active" id="home4" role="tabpanel"
                                        aria-labelledby="home-tab4">

                                        {{-- Paypal Settings --}}
                                        @include('admin.payment-setting.sections.paypal-section')
                                    </div>

                                    <div class="tab-pane fade" id="profile4" role="tabpanel"
                                        aria-labelledby="profile-tab4">

                                        {{-- Stripe Settings --}}
                                        @include('admin.payment-setting.sections.stripe-section')
                                    </div>

                                    <div class="tab-pane fade" id="contact4" role="tabpanel"
                                        aria-labelledby="contact-tab4">
                                        {{-- RazorPay Settings --}}
                                        @include('admin.payment-setting.sections.razorpay-section')
                                    </div>

                                    <div class="tab-pane fade" id="phonepe4" role="tabpanel"
                                        aria-labelledby="phonepe-tab4">
                                        @include('admin.payment-setting.sections.phonepe-section')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
