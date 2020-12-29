@extends('adminlte::layouts.app')
@section('title', 'Menü Yönetimi')

@push('scripts')

    <script type="text/javascript"
            src="/vendor/menu-editor/bootstrap-iconpicker/js/iconset/fontawesome5-3-1.min.js"></script>
    <script type="text/javascript"
            src="/vendor/menu-editor/bootstrap-iconpicker/js/bootstrap-iconpicker.min.js"></script>
    <script type="text/javascript" src="/vendor/menu-editor/jquery-menu-editor.js"></script>

    <script>
        // icon picker options
        var iconPickerOptions = {searchText: "İkon", labelHeader: "{0}/{1}", icon: "far fa-circle"};
        // sortable list o  ptions
        var sortableListOptions = {
            placeholderCss: {'background-color': "#cccccc"}
        };
        var editor = new MenuEditor('menu_list', {listOptions: sortableListOptions, iconPicker: iconPickerOptions});
        editor.setForm($('#frmEdit'));
        editor.setUpdateButton($('#btnUpdate'));
        //Calling the update method
        $("#btnUpdate").click(function () {
            editor.update();
        });
        // Calling the add method
        $('#btnAdd').click(function () {
            editor.add();
        });

        var arrayJson = @json($menus);
        editor.setData(arrayJson);

        var str = editor.getString();
        //$("#myTextarea").text(str);

        $('#btnSave').click(function () {
            var str = editor.getString();
            laravel.ajax.send({
                url: '{{route('menus.store')}}',
                type: 'POST',
                data: str,
                contentType: "json",
                processData: false,
                success: laravel.ajax.successHandler,
                error: laravel.ajax.errorHandler
            })
        });


    </script>


@endpush
@push('styles')
    <link rel="stylesheet" href="/vendor/menu-editor/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css">
    <style type="text/css">
        #menu_list > li {
            padding-right: 20px !important;
        }
    </style>
@endpush
@section('content')

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

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Menüler</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <ul id="menu_list" class="sortableLists list-group">
                        </ul>
                    </div>

                    <div class="card-footer">
                        <button type="button" id="btnSave" class="btn btn-success"><i class="fas fa-save"></i> Kaydet
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Menü Ekle & Düzenle</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <ul id="menu_list" class="sortableLists list-group">
                        </ul>
                        <form id="frmEdit" class="form-horizontal">
                            <div class="form-group">
                                <label for="text">Başlık</label>
                                <div class="input-group">
                                    <input type="text" class="form-control item-menu" name="text" id="text"
                                           placeholder="Text">
                                    <div class="input-group-append">
                                        <button type="button" id="menu_list_icon"
                                                class="btn btn-outline-secondary"></button>
                                    </div>
                                </div>
                                <input type="hidden" name="icon" class="item-menu">
                            </div>
                            <div class="form-group">
                                <label for="href">Adress</label>
                                <select name="href" id="href" class="form-control item-menu">
                                    <option value="#">#</option>
                                    @foreach($routes as $route)
                                        <option value="{{$route}}">{{$route}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="href">Rol</label>
                                <select name="role_id" id="role_id" class="form-control item-menu">
                                    <option value="">Seçiniz</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="href">Yetki</label>
                                <select name="permission_id" id="permission_id" class="form-control item-menu">
                                    <option value="">Seçiniz</option>
                                    @foreach($permissions as $permission)
                                        <option value="{{$permission->id}}">{{$permission->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </form>


                    </div>

                    <div class="card-footer">
                        <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i
                                class="fas fa-sync-alt"></i> Güncelle
                        </button>
                        <button type="button" id="btnAdd" class="btn btn-dark"><i class="fas fa-plus"></i> Ekle</button>
                    </div>
                </div>
            </div>


        </div>


    </section>
    <!-- /.content -->
@endsection
