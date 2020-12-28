let DataTable = {
    getLanguageFileUrl: function () {
        return "/vendor/adminlte/plugins/datatables-i18n/Turkish.json";
    },
    getUsers: function (ajaxUrl) {
        var user_table = $("#users_data_table").DataTable({
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
                {"data": "name", "orderable": true,},
                {"data": "email", "orderable": true},
                {"data": "is_tmd_auth", "orderable": true,"searchable": false},
                {"data": "status", "orderable": true,"searchable": false},
                {"data": "roles", "orderable": false,"searchable": false},
                {"data": "permissions", "orderable": false,"searchable": false},
                {"data": "action", "orderable": false,"searchable": false},
            ],
            "initComplete": function (settings, json) {
            }
        });
    },
    getPermissions: function (ajaxUrl) {
        var user_table = $("#permissions_data_table").DataTable({
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
                {"data": "id", "orderable": true,},
                {"data": "name", "orderable": true},
                {"data": "action", "orderable": false,"searchable": false},
            ],
            "initComplete": function (settings, json) {
            }
        });
    },
    getRoles: function (ajaxUrl) {
        var role_table = $("#roles_data_table").DataTable({
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
                {"data": "id", "orderable": true,},
                {"data": "name", "orderable": true},
                {"data": "permissions", "orderable": false,"searchable": false},
                {"data": "action", "orderable": false,"searchable": false},
            ],
            "initComplete": function (settings, json) {
            }
        });
    },


};
