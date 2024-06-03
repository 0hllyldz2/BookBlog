@extends('back.layouts.master')
@section('title', 'Silinen Tüm Sayfalar')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <span>{{ $pages->count() }} makale bulundu.</span>
                <a href="{{ route('admin.page.index') }}" class="float-right btn btn-info btn-sm"> Aktif Sayfalar
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Fotoğraf</th>
                            <th>Sayfa Başlığı</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $page)
                            <tr>
                                <td>
                                    <img src="{{ asset($page->image) }}" width="150">
                                </td>
                                <td>{{ $page->title }}</td>
                                <td>
                                    <a href="{{ route('admin.page.recover', $page->id) }}" title="Kurtar"
                                        class="btn btn-sm btn-primary "><i class="fa fa-recycle"></i></a>
                                    <a href="{{ route('admin.page.hard.delete', $page->id) }}" title="Sil" class="btn btn-sm btn-danger "><i
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
