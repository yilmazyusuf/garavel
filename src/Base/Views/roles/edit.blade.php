@extends('adminlte::layouts.app')
@section('title', 'Rol Düzenle')

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
                <h3 class="card-title">Rol Düzenle</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <form class="form-horizontal ajax" action="{{route('roles.update',[$role->id])}}" method="post">
                @method('PUT')
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Rol Adı</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="name" name="name" value="{{$role->name}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Yetkiler</label>
                        <div class="col-sm-4">
                            <select class="select2bs4" multiple="multiple" data-placeholder="Yetki seçiniz."
                                    style="width: 100%;" name="permissions[]" id="permissions">
                                @foreach($permissions as $permission)
                                    <option value="{{$permission->id}}" {{!is_null($role->permissions()->find($permission->id)) ? 'selected="selected"' :''}}>{{$permission->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="form-group row mb-0">
                        <label for="buttons" class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-info ajax_btn">Güncelle</button>
                            <a href="{{route('roles.index')}}" class="btn btn-default">İptal Et</a>
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
