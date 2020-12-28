@extends('adminlte::layouts.app')
@section('title', 'Yetki Düzenle')

@push('scripts')
@endpush
@push('styles')
    <!--Custom Styles -->
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
                <h3 class="card-title">Yetki Düzenle</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <form class="form-horizontal ajax" action="{{route('permissions.update',[$permission->id])}}" method="post">
                @method('PUT')
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Yetki Adı</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="name" name="name" value="{{$permission->name}}">
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="form-group row mb-0">
                        <label for="buttons" class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-info ajax_btn">Güncelle</button>
                            <a href="{{route('permissions.index')}}" class="btn btn-default">İptal Et</a>
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
