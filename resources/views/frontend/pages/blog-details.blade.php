@extends('frontend.layouts.master')

@section('contents')
    <section class="section-box mt-75">
        <div class="breacrumb-cover">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <h2 class="mb-20">Blog Details</h2>
                        <ul class="breadcrumbs">
                            <li><a class="home-icon" href="{{ url('/') }}">Home</a></li>
                            <li>Blog Details</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-box">
        <div class="archive-header pt-40">
            <div class="container">
                <div class="box-white">
                    <!-- <div class="max-width-single"><a class="btn btn-tag" href="#">Job Tips</a> -->
                    <h2 class="mb-30 mt-20">{{ $blog->title }}</h2>
                    <div class="post-meta text-muted d-flex mx-auto">
                        <div class="author d-flex mr-30"><span>{{ $blog->author->name }}</span></div>
                        <div class="date"><span class="font-xs color-text-paragraph-2 mr-20 d-inline-block"><img
                                    class="img-middle mr-5"
                                    src="{{ asset('frontend/assets/imgs/page/blog/calendar.svg') }}">
                                {{ formatDate($blog->created_at) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <div class="post-loop-grid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="single-body">
                        <figure><img style="height: 400px; width:100%; object-fit:cover;" src="{{ $blog->image }}">
                        </figure>
                        <div class="">
                            <div class="content-single">
                                <p>{!! $blog->description !!}</p>
                            </div>
                            <div class="single-apply-jobs mt-20">
                                <div class="row">
                                    <div style="text-align: left !important;" class="col-md-5 text-lg-end social-share">
                                        <h6 class="color-text-paragraph-2 d-inline-block d-baseline mr-20 mt-10">Share</h6>
                                        <a data-social="facebook" class="mr-5 d-inline-block d-middle" href="#"><img
                                                alt="joblist"
                                                src="{{ asset('frontend/assets/imgs/template/icons/share-fb.svg') }}"></a>
                                        <a data-social="twitter" class="mr-5 d-inline-block d-middle" href="#"><img
                                                alt="joblist"
                                                src="{{ asset('frontend/assets/imgs/template/icons/share-tw.svg') }}"></a>
                                        <a data-social="reddit" class="mr-5 d-inline-block d-middle" href="#"><img
                                                alt="joblist"
                                                src="{{ asset('frontend/assets/imgs/template/icons/share-red.svg') }}"></a>
                                        <a data-social="linkedin" class="d-inline-block d-middle" href="#"><img
                                                alt="joblist"
                                                src="{{ asset('frontend/assets/imgs/template/icons/linkedin.svg') }}"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
