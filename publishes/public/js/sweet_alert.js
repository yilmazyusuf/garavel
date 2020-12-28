let SweetAlert = {
    deleteUser: function (ajaxUrl) {
        Swal.fire({
            title: 'Kullanıcı silinecektir!',
            text: "Onaylıyormusunuz?",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet',
            cancelButtonText:'Hayır'
        }).then((result) => {
            if (result.value) {
                laravel.ajax.send({
                    url: ajaxUrl,
                    type: 'DELETE',
                    success: laravel.ajax.successHandler,
                    error:laravel.ajax.errorHandler
                })
            }
        })
    },

    deletePermission : function (ajaxUrl) {
        Swal.fire({
            title: 'Yetki tüm rollerden ve kullanıcılardan silinecektir!',
            text: "Onaylıyormusunuz?",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet',
            cancelButtonText:'Hayır'
        }).then((result) => {
            if (result.value) {
                laravel.ajax.send({
                    url: ajaxUrl,
                    type: 'DELETE',
                    success: laravel.ajax.successHandler,
                    error:laravel.ajax.errorHandler
                })
            }
        })
    },
    deleteRole : function (ajaxUrl) {
        Swal.fire({
            title: 'Rol silinecek ve  kullanıcılardan kaldırılacaktır',
            text: "Onaylıyormusunuz?",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet',
            cancelButtonText:'Hayır'
        }).then((result) => {
            if (result.value) {
                laravel.ajax.send({
                    url: ajaxUrl,
                    type: 'DELETE',
                    success: laravel.ajax.successHandler,
                    error:laravel.ajax.errorHandler
                })
            }
        })
    }


};
