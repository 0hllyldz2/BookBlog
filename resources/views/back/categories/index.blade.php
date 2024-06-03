@extends('back.layouts.master')
@section('title', 'Tüm Kategoriler')
@section('content')

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Yeni Kategori Oluştur</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.category.create') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Kategori Adı</label>
                            <input type="text" name="category" class="form-control" required></input>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Kategori Oluştur</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Kategori Adı</th>
                                    <th>Metin Sayısı</th>
                                    <th>Durum</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->articleCount() }}</td>
                                        <td>
                                            <input class="switch" category-id="{{ $category->id }}" type="checkbox"
                                                data-on="Aktif" data-off="Pasif" data-onstyle="success"
                                                data-offstyle="danger" @if ($category->status == 1) checked @endif
                                                data-toggle="toggle">
                                        </td>
                                        <td>
                                            <a title="Düzenle" category-id="{{ $category->id }}"
                                                class="btn btn-sm btn-primary edit-click"><i class="fa fa-edit"></i>
                                            </a>
                                            <a title="Sil" category-id="{{ $category->id }}" category-name="{{ $category->name }}"
                                                category-count="{{ $category->articleCount() }}"
                                                class="btn btn-sm btn-danger remove-click"><i class="fa fa-times"></i></a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal1 -->
    <div class="modal" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Kategori Düzenle</h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.category.update') }}">
                        @csrf
                        <div class="form-group">
                            <label>Kategori Adı</label>
                            <input id="category" type="text" class="form-control" name="category">
                            <input id="category_id" type="hidden" name="category_id">
                        </div>
                        <div class="form-group">
                            <label>Kategori Slug</label>
                            <input id="slug" type="text" class="form-control" name="slug">
                        </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Kaydet</button>
                    <button type="button" class="btn btn-danger" onclick="$('#editModal').modal('hide')">Kapat</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- The Modal2 -->
    <div class="modal" id="removeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Kategori Sil</h4>
                </div>
                <div id="body" class="modal-body">
                    <div class="alert alert-danger" id="articleAlert"></div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <form method="POST" action="{{ route('admin.category.delete') }}">
                        @csrf
                        <input id="deleteid" type="hidden" name="id">
                        <button id="deleteButton" type="submit" class="btn btn-danger">Sil</button>
                        <button type="button" class="btn btn-success"
                            onclick="$('#removeModal').modal('hide')">Kapat</button>
                </div>
                </form>
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
        $(document).ready(function() {
            $('.remove-click').click(function() {
                var id = $(this).attr('category-id');
                var count = $(this).attr('category-count');
                var name = $(this).attr('category-name');
                if (id == 1) {
                    $('#articleAlert').html(
                        name + ' kategorisi sabit bir kategoridir. Silinen diğer kategorilere ait metinler bu kategoriye eklenecektir'
                        );
                    $('#body').show();
                    $('#deleteButton').hide();
                    $('#removeModal').modal();
                    return;
                }
                $('#deleteButton').show();
                console.log("Category ID: ", id);
                console.log("Category Count: ", count);
                console.log("Category Name: ", name);
                $('#articleAlert').html('');
                $('#body').hide();
                if (count > 0) {
                    $('#articleAlert').html('Bu kategoriye ait ' + count +
                        ' metin bulunmaktadır. Silmek istediğinize emin misiniz?');
                    $('#body').show();
                }
                $('#deleteid').val(id); // Burada id değerini atıyoruz
                $('#removeModal').modal();
            });

            $('.edit-click').click(function() {
                var id = $(this).attr('category-id');
                $.ajax({
                    url: "{{ route('admin.category.getdata') }}",
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        console.log(data);
                        $('#category').val(data.name);
                        $('#slug').val(data.slug);
                        $('#category_id').val(data.id);
                        $('#editModal').modal();
                    }
                });
            });

            $('.switch').change(function() {
                var id = $(this).attr('category-id');
                var statu = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    url: "{{ route('admin.category.switch') }}",
                    type: 'GET',
                    data: {
                        id: id,
                        statu: statu,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        if (data.success) {
                            console.log(data.message);
                        } else {
                            console.log('Bir hata oluştu.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
