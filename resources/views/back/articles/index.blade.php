@extends('back.layouts.master')
@section('title', 'Tüm Metinler')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <span>{{ $articles->count() }} makale bulundu.</span>
                <a href="{{ route('admin.trashed.article') }}" class="float-right btn btn-warning btn-sm">
                    <i class="fa fa-trash"></i> Silinen Metinler
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Fotoğraf</th>
                            <th>Metin Başlığı</th>
                            <th>Kategori</th>
                            <th>Hit</th>
                            <th>Oluşturulma Tarihi</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articles as $article)
                            <tr>
                                <td>
                                    <img src="{{ asset($article->image) }}" width="150">
                                </td>
                                <td>{{ $article->title }}</td>
                                <td>{{ $article->getCategory->name }}</td>
                                <td>{{ $article->hit }}</td>
                                <td>{{ $article->created_at->diffForHumans() }}</td>
                                <td>
                                    <input class="switch" article-id="{{ $article->id }}" type="checkbox" data-on="Aktif"
                                        data-off="Pasif" data-onstyle="success" data-offstyle="danger"
                                        @if ($article->status == 1) checked @endif data-toggle="toggle">
                                </td>
                                <td>
                                    <a target="_blank" href="{{ route('single', [$article->getCategory->slug, $article->slug]) }}" title="Görüntüle"
                                        class="btn btn-sm btn-success "><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('admin.metinler.edit', $article->id) }}" title="Düzenle"
                                        class="btn btn-sm btn-primary "><i class="fa fa-edit"></i></a>
                                    <a href="{{ route('admin.delete.article', $article->id) }}" title="Sil" class="btn btn-sm btn-danger "><i
                                            class="fa fa-times"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

@section('js')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
        $(function() {
            $('.switch').change(function() {
                var id = $(this).attr('article-id');
                var statu = $(this).prop('checked');

                $.ajax({
                    url: "{{ route('admin.switch') }}",
                    type: 'GET',
                    data: {
                        id: id,
                        statu: statu,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        console.log(data);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
