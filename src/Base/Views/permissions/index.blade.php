@extends('adminlte::layouts.app')
@section('title', 'Yetkiler')

@push('scripts')
    <!--Custom Scripts -->

    <!-- DataTables -->
    <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/data_table.js') }}"></script>
    <script>
        DataTable.getPermissions('{{route('permissions.index.data_table')}}');
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
                        <h3 class="card-title">Yetkiler</h3>

                        <div class="card-tools">
                            <a href="{{route('permissions.create')}}" class="btn btn-dark btn-sm">
                                <i class="fas fa-plus"></i> Yetki Ekle
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="permissions_data_table"
                               class="table table-bordered table-striped table-hover  table-head-fixed text-nowrap">
                            <thead>
                            <tr>
                                <th width="10%">Yetki No</th>
                                <th width="80%">Yetki Adı</th>
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
