@extends('front.layouts.master')
@section('title', 'BookBlog')
@section('content')
    <div class="container">
        <div class="row">
            <!-- Main Content-->
            <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                @include('front.widgets.articleList')
            </div>
            <!-- Sidebar Widgets-->
            <div class="col-md-10 col-lg-4 col-xl-3 mx-auto">
                @include('front.widgets.categoryWidgets')
            </div>
        </div>
    </div>
@endsection
