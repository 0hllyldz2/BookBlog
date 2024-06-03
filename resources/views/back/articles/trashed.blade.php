@extends('back.layouts.master')
@section('title', 'Silinen Tüm Metinler')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <span>{{ $articles->count() }} makale bulundu.</span>
                <a href="{{ route('admin.metinler.index') }}" class="float-right btn btn-info btn-sm"> Aktif Metinler
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
                                    <a href="{{ route('admin.recover.article', $article->id) }}" title="Kurtar"
                                        class="btn btn-sm btn-primary "><i class="fa fa-recycle"></i></a>
                                    <a href="{{ route('admin.hard.delete.article', $article->id) }}" title="Sil" class="btn btn-sm btn-danger "><i
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
