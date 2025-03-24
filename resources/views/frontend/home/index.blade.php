@extends('frontend.layouts.master')

@section('contents')
    <div class="bg-homepage1"></div>

    {{-- Hero section --}}
    @include('frontend.home.sections.hero-section')


    <div class="mt-100"></div>

    {{-- Category section --}}
    @include('frontend.home.sections.category-section')

    {{-- Featured Job Section --}}
    @include('frontend.home.sections.featured-job-section')

    {{-- Why choose us section --}}
    @include('frontend.home.sections.why-choose-us-section')

    {{-- Learn More section --}}
    @include('frontend.home.sections.learn-more-section')

    {{-- counter section --}}
    @include('frontend.home.sections.counter-section')

    {{-- Recruiters section --}}
    @include('frontend.home.sections.top-recruiters-section')

    {{-- price plane section --}}
    @if (auth()->user()?->role != 'candidate')
        @include('frontend.home.sections.price-plane-section')
    @endif

    {{-- job by location section --}}
    @include('frontend.home.sections.job-by-location-section')

    {{-- review section --}}
    @include('frontend.home.sections.review-section')

    {{-- blog section --}}
    @include('frontend.home.sections.blog-section')
@endsection
