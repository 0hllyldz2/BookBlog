@extends('front.layouts.master')
@section('title', $article->title)
@section('bg', $article->image)
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                <article>
                    <div>
                        {!! $article->content !!}
                    </div>
                    <br>
                    <span class="text-danger">Okunma Sayısı: <b>{{ $article->hit }}</b></span>
                </article>
            </div>
            <!-- Sidebar Widgets-->
            <div class="col-md-10 col-lg-4 col-xl-3 mx-auto">
                <div>
                    @include('front.widgets.categoryWidgets')
                </div>
            </div>
        </div>
    </div>
@endsection

