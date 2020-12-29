@extends('adminlte::layouts.app')
@section('title', 'Ayar Düzenle')

@push('scripts')
    <!-- Select2 -->
    <script src="{{ asset('vendor/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endpush
@push('styles')
    <!--Custom Styles -->
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <style>
        @media (min-width: 768px) {
            .form-horizontal .form-group > label {
                text-align: right;
            }
        }

    </style>
@endpush
@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@yield('title')</h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ayar Düzenle</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <form class="form-horizontal ajax" action="{{route('settings.update',[$setting->id])}}" method="post">
                @method('PUT')
                <div class="card-body">
                    <div class="form-group row">
                        <label for="title" class="col-sm-3 col-form-label">Başlık</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="title" name="title" value="{{$setting->title}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-sm-3 col-form-label">Açıklama</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="description" name="description" value="{{$setting->description}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="key" class="col-sm-3 col-form-label">Ayar Adı</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="key" name="key" value="{{$setting->key}}" {{$setting->is_changeable == 0 ? 'readonly' : ''}}>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="value" class="col-sm-3 col-form-label">Değer</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="value" name="value" value="{{$setting->value}}">
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="form-group row mb-0">
                        <label for="buttons" class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-dark ajax_btn">Güncelle</button>
                            <a href="{{route('settings.index')}}" class="btn btn-default">İptal Et</a>
                        </div>
                    </div>


                </div>
                <!-- /.card-footer -->
            </form>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->

@endsection
