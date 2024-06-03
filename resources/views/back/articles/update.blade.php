@extends('back.layouts.master')
@section('title', $article->title.' makalesini güncelle')
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
            <form method="POST" action="{{ route('admin.metinler.update', $article->id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label>Metin Başlığı</label>
                    <input type="text" name="title" class="form-control" value="{{ $article->title }}" required></input>
                </div>
                <div class="form-group">
                    <label>Metin Kategori</label>
                    <select name="category" class="form-control" required>
                        <option value="">Seçim Yapınız</option>
                        @foreach ($categories as $category)
                            <option @if ($article->category_id==$category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Metin Fotoğrafı</label> <br>
                    <img src="{{ asset($article->image) }}" class="img-thumbnail rounded" width="300"> <br>
                    <input type="file" name="image" class="form-control"></input>
                </div>
                <div class="form-group">
                    <label>Metin İçeriği</label>
                    <textarea id="summernote" name="content" class="form-control" rows="4" required>{!! $article->content !!}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Metni Güncelle</button>
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