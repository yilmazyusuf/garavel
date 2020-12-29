@extends('adminlte::layouts.app')
@section('title', 'Ayarlar')

@push('scripts')
    <!--Custom Scripts -->

    <!-- DataTables -->
    <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/data_table.js') }}"></script>
    <script>

        DataTable.getSettings = function (ajaxUrl) {
            var role_table = $("#settings_data_table").DataTable({
                "oLanguage": {
                    "sUrl": this.getLanguageFileUrl()
                },
                responsive: true,
                bAutoWidth: false,
                "dom": 'frtip',
                "pageLength": 30,
                "searchDelay": 1500,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": ajaxUrl,
                    data: function (d) {
                    },
                    dataSrc: function (json) {
                        if (!json.recordsTotal) {
                            return false;
                        }
                        return json.data;
                    }
                },
                "order": [],
                "columns": [
                    {"data": "title", "orderable": false,},
                    {"data": "description", "orderable": false,},
                    {"data": "key", "orderable": true},
                    {"data": "value", "orderable": false, "searchable": false},
                    {"data": "action", "orderable": false, "searchable": false},
                ],
                "initComplete": function (settings, json) {
                }
            });
        },
            SweetAlert.deleteSetting = function (ajaxUrl) {
                Swal.fire({
                    title: 'Ayar silinecek ve  kullanıcılardan kaldırılacaktır',
                    text: "Onaylıyormusunuz?",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet',
                    cancelButtonText: 'Hayır'
                }).then((result) => {
                    if (result.value) {
                        laravel.ajax.send({
                            url: ajaxUrl,
                            type: 'DELETE',
                            success: laravel.ajax.successHandler,
                            error: laravel.ajax.errorHandler
                        })
                    }
                })
            },
            DataTable.getSettings('{{route('settings.index.data_table')}}');
    </script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('vendor/adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>


@endpush
@push('styles')
    <!--Custom Styles -->
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ayarlar</h3>

                        <div class="card-tools">
                            <a href="{{route('settings.create')}}" class="btn btn-dark btn-sm">
                                <i class="fas fa-plus"></i> Ayar Ekle
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="settings_data_table"
                               class="table table-bordered table-striped table-hover  table-head-fixed text-nowrap">
                            <thead>
                            <tr>
                                <th width="">Başlık</th>
                                <th width="">Açıklama</th>
                                <th width="">Ayar Adı</th>
                                <th width="">Ayar Değeri</th>
                                <th width="10%">#</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>


    </section>
    <!-- /.content -->
@endsection
