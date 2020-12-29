
@push('scripts')
    <!-- Croppie -->
    <script src="{{ asset('vendor/croppie/croppie.js') }}"></script>
    <script src="{{ asset('vendor/croppie/exif-js.js') }}"></script>
    <script src="{{ asset('js/croppie.js') }}"></script>
    <script>

        Croppie.crop(@json($params),"{{$params['targetModal']}}_croppie_path");

        $(document).ready(function () {

            var targetPath = "{{$params['targetPath']}}";
            $('.{{$params['targetModal']}}').click(function (e) {
                $("#{{$params['targetModal']}}").modal();
            });
            $('.upload_btn_'+"{{$params['targetModal']}}").click(function (e) {

                e.preventDefault();
                var formData = new FormData($('#{{$params['targetModal']}}_form')[0]);

                $.ajax({
                    type: 'POST',
                    url: "{!! URL::signedRoute('croppie.upload', $params) !!}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $('div.upload_error').addClass('d-none');
                        $('div.upload_error .alert').html('');

                        $('input#'+targetPath).val(data.imageBaseUrl)
                        $('img#'+targetPath).attr('src',data.imageFullUrl);
                        $("#{{$params['targetModal']}}").modal('hide')

                    },
                    error: function (data) {
                        $.each(data.responseJSON.errors, function (err_key, err_desc) {
                            $('div.upload_error').removeClass('d-none');
                            $('div.upload_error .alert').html(err_desc);
                        })
                    }
                });

            });
        });
    </script>


@endpush
@push('styles')

    <!-- Croppie -->
    <link rel="stylesheet" href="{{ asset('vendor/croppie/croppie.css') }}"/>
    <style>
        .croppie-image .croppie-image-wrap,
        .croppie-image .upload-result,
        .croppie-image.ready .upload-msg {
            display: none;
        }

        .croppie-image.ready .croppie-image-wrap {
            display: block;
            margin-bottom: 1rem;
            margin-top: 1rem;
        }

        .croppie-image.ready .upload-result {
            display: inline-block;
        }
        .cr-boundary{
            overflow: auto !important;

        }

    </style>

@endpush

<div class="modal fade" id="{{$params['targetModal']}}">
    <form method="post" id="{{$params['targetModal']}}_form" name="{{$params['targetModal']}}_form">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Resim Yükle [{{$params['title']}}]</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row croppie-image">
                        <div class="col-sm-12">
                            <div class="callout callout-warning">
                                <ol class="mb-0">
                                    <li>Resim Boyutu <strong>{{$params['width']}}px X {{$params['height']}}px</strong>
                                        boyutlarında olmalıdır.
                                    </li>

                                    <li>Resim <strong>{{$params['output']}}</strong> formatlarından birisi
                                        olmalıdır.
                                    </li>
                                    <li>Resim boyutu maksimum <strong>{{$params['max_size_kb'] / 1024}}MB</strong>
                                        olmalıdır.
                                    </li>
                                </ol>
                            </div>

                        </div>

                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="upload">

                                    <input type="hidden" id="croppie_image_url" name="croppie_image_url">
                                    <input type="hidden" id="croppie_image_extension" name="croppie_image_extension">
                                    <label class="custom-file-label" for="exampleInputFile">Resim Seçiniz</label>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12">
                            <div class="croppie-image-wrap" style="overflow: auto">
                                <div id="{{$params['targetModal']}}_croppie_path"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3 upload_error d-none">
                            <div class="alert alert-danger alert-dismissible mb-0"></div>
                        </div>

                    </div>


                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                    <button type="button" class="btn btn-dark upload_btn_{{$params['targetModal']}}">Resmi Yükle</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </form>
</div>


