@extends('back.layouts.master')
@section('title', 'Tüm Sayfalar')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <span>{{ $pages->count() }} sayfa bulundu.</span>
                <a href="{{ route('admin.page.trashed') }}" class="float-right btn btn-warning btn-sm">
                    <i class="fa fa-trash"></i> Silinen Sayfalar
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div id="orderSuccess" class="alert alert-success" style="display: none">Sıralama başarıyla güncellendi!</div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sıralama</th>
                            <th>Fotoğraf</th>
                            <th>Sayfa Başlığı</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody id="orders">
                        @foreach ($pages as $page)
                            <tr id="page_{{ $page->id }}">
                                <td class="text-center" style="width: 5px">
                                    <i class="fa fa-arrows-alt-v fa-3x handle" style="cursor: move"></i>
                                </td>
                                <td>
                                    <img src="{{ asset($page->image) }}" width="150">
                                </td>
                                <td>{{ $page->title }}</td>
                                <td>
                                    <input class="switch" page-id="{{ $page->id }}" type="checkbox" data-on="Aktif"
                                        data-off="Pasif" data-onstyle="success" data-offstyle="danger"
                                        @if ($page->status == 1) checked @endif data-toggle="toggle">
                                </td>
                                <td>
                                    <a target="_blank" href="{{ route('page', $page->slug) }}" title="Görüntüle"
                                        class="btn btn-sm btn-success "><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('admin.page.edit', $page->id) }}" title="Düzenle"
                                        class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <a href="{{ route('admin.page.delete', $page->id) }}" title="Sil"
                                        class="btn btn-sm btn-danger "><i class="fa fa-times"></i></a>
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
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#orders').sortable({
                handle: '.handle',
                update: function(event, ui) {
                    var siralama = $('#orders').sortable('serialize');
                    $.get("{{ route('admin.page.orders') }}?" + siralama, function(data, status) {
                        console.log(data);
                        $("#orderSuccess").show();
                        setTimeout(function() {
                            $("#orderSuccess").hide();
                        }, 1000);
                    });
                }
            });
        });
    </script>
    <script>
        $(function() {
            $('.switch').change(function() {
                var id = $(this).attr('page-id');
                var statu = $(this).prop('checked');

                $.ajax({
                    url: "{{ route('admin.page.switch') }}",
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
