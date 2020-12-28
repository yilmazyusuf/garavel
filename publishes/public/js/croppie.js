var Croppie = {
    crop: function (params,target) {

        var enableExif = params.enableExif == 0 ? false : true
        var enableResize = params.enableResize == 0 ? false : true
        var $uploadCrop;
        $uploadCrop = $('#'+target).croppie({
            viewport: {
                width: params.width,
                height: params.height,
                type: params.type
            },
            boundary: {
                width: params.width * 1.2,
                height: params.height * 1.2
            },

            enableExif: enableExif,
            enableResize: enableResize,

            quality: params.quality,
            format: params.output, //'jpeg'|'png'|'webp'
        });

        $('#upload').on('change', function () {
            return Croppie.readFile(this, $uploadCrop, params);
        });
        $('#'+target).on('update.croppie', function (ev, cropData) {
            $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
                $('#croppie_image_url').val(resp);
                $('div.upload_error').addClass('d-none');
                $('div.upload_error .alert').html('');
            });
        });

    },
    readFile: function readFile(input, uploadCrop, params) {
        if (input.files && input.files[0]) {

            let file = input.files[0];
            var extension = file.name.split('.').pop().toLowerCase();

            if (params.output.search(extension) == -1) {


                var err = 'Sadece ' + params.output + ' uzantılı resim yükleyebilirsiniz.';
                $('div.upload_error').removeClass('d-none');
                $('div.upload_error .alert').html(err);
                return false;
            }

            if ((file.size / 1024) > params.max_size_kb) {
                var err = 'En fazla ' + (params.max_size_kb / 1024) + 'MB resim yükleyebilirsiniz.';
                $('div.upload_error').removeClass('d-none');
                $('div.upload_error .alert').html(err);
                return false;
            }

            var reader = new FileReader();
            reader.onload = function (e) {

                $('.croppie-image').addClass('ready');
                uploadCrop.croppie('bind', {
                    url: e.target.result
                }).then(function () {
                    $('#croppie_image_extension').val(extension);
                    //console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(file);
        } else {
            alert("Sorry - you're browser doesn't support the FileReader API");
        }
    }
}
