@extends('adminlte::layouts.app')
@section('title', 'Kullanıcı Düzenle')

@push('scripts')
    <!--Custom Scripts -->
    <!-- Select2 -->
    <script src="{{ asset('vendor/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>


    <!-- Bootstrap Switch -->
    <script src="{{ asset('vendor/adminlte/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script>
        $("input[data-bootstrap-switch]").each(function () {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

        $('input#tmd_auth').on('switchChange.bootstrapSwitch', function (event, state) {
            $(this).val(state === true ? 1 : 0);
        });

        $('input#status').on('switchChange.bootstrapSwitch', function (event, state) {
            $(this).val(state === true ? 1 : 0);
        });
    </script>

@endpush
@push('styles')
    <!--Custom Styles -->

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">


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
                <h3 class="card-title">{{$user->name}}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <form class="form-horizontal ajax" action="{{route('users.update',[$user->id])}}" method="post">
                @method('PUT')
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">İsim Soyisim</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">E-Posta</label>
                        <div class="col-sm-4">
                            <input type="email" class="form-control" id="email" name="email"
                                   value="{{$user->email}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Yeni Şifre</label>
                        <div class="col-sm-4">
                            <input type="text" autocomplete="off" class="form-control" id="password"
                                   name="password">
                            <small id="emailHelp" class="form-text text-muted">Mevcut şifreyi değiştirmek isterseniz
                                doldurun.</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Roller</label>
                        <div class="col-sm-4">
                            <select class="select2bs4" multiple="multiple" data-placeholder="Rol seçiniz."
                                    style="width: 100%;" name="roles[]" id="roles">
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}" {{$user->hasRole($role->id) ? 'selected="selected"' : ''}}>{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Yetkiler</label>
                        <div class="col-sm-4">
                            <select class="select2bs4" multiple="multiple" data-placeholder="Yetki seçiniz."
                                    style="width: 100%;" name="permissions[]" id="permissions">
                                @php
                                    $directPermisssions = $user->getDirectPermissions();
                                @endphp

                                @endphp
                                @foreach($permissions as $permission)
                                    <option value="{{$permission->id}}"  {{$directPermisssions->contains($permission) ? 'selected="selected"' : ''}}>{{$permission->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tmd_auth" class="col-sm-3 col-form-label">Tmd Auth</label>
                        <div class="col-sm-4 pt-2">
                            <input type="checkbox" name="tmd_auth"
                                   {{$user->is_tmd_auth == 1 ? 'checked' :''}} data-bootstrap-switch
                                   data-off-color="danger" data-on-color="success" data-on-text="Açık"
                                   data-off-text="Kapalı" id="tmd_auth" value="{{$user->is_tmd_auth}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-sm-3 col-form-label">Durumu</label>
                        <div class="col-sm-4 pt-2">
                            <input type="checkbox" name="status"
                                   {{$user->status == 1 ? 'checked' :''}} data-bootstrap-switch
                                   data-off-color="danger" data-on-color="success" data-on-text="Aktif"
                                   data-off-text="Pasif" id="status" value="{{$user->status}}">
                            <small id="emailHelp" class="form-text text-muted">Pasif kullanıcılar sisteme giriş
                                yapamaz.</small>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="form-group row mb-0">
                        <label for="buttons" class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-dark ajax_btn">Güncelle</button>
                            <a href="{{route('users.index')}}" class="btn btn-default">İptal Et</a>
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
