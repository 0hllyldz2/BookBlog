@extends('front.layouts.master')
@section('title', $page->title)
@section('bg', $page->image)
@section('content')

    <div class="col-md-10 col-lg-8 col-xl-7 mx-auto text-center">
        {!! $page->content !!}
    </div>

@endsection
