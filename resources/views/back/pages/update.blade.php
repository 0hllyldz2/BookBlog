@extends('back.layouts.master')
@section('title', $page->title.' sayfasını güncelle')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.page.update', $page->id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label>Sayfa Başlığı</label>
                    <input type="text" name="title" class="form-control" value="{{ $page->title }}" required></input>
                </div>
                <div class="form-group">
                    <label>Sayfa Fotoğrafı</label> <br>
                    <img src="{{ asset($page->image) }}" class="img-thumbnail rounded" width="300"> <br>
                    <input type="file" name="image" class="form-control"></input>
                </div>
                <div class="form-group">
                    <label>Sayfa İçeriği</label>
                    <textarea id="summernote" name="content" class="form-control" rows="4" required>{!! $page->content !!}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Sayfayı Güncelle</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                'height': 300
            });
        });
    </script>
@endsection
