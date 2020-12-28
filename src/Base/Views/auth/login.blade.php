@extends('adminlte::layouts.login')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="/"><b>{{config('app.name')}}</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">

                <form action="{{route('login')}}" method="post" class="{{settings('captcha.isActive') == 1 ? 'captcha' :'ajax'}}">
                    @if(settings('captcha.isActive') == 1)
                        @csrf
                        {!! app('captcha')->render('tr') !!}
                    @endif
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="E-Posta Adresiniz" name="email" id="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Şifreniz" name="password" id="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember" value="1">
                                <label for="remember">Beni Hatırla</label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-block btn-info btn-flat ajax_btn">Giriş Yap</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div id="alerts">@yield('alerts')</div>
                </form>
                <hr>
                <p class="text-center mt-3">
                    <img src="{{ asset('images/logo.png') }}" alt="{{config('app.name')}}" width="250">
                </p>
                <p class="mt-3 login-box-msg">©{{date('Y')}} {{config('app.name')}}</p>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>

    @if(settings('captcha.isActive') == 1)
        @captchaScripts
            <script>
                _submitEvent = function() {
                    laravel.ajax.send({
                        url: "{{ route('login') }}",
                        type: 'POST',
                        data: {
                            "email": $("#email").val(),
                            "password": $("#password").val(),
                            "g-recaptcha-response": $("#g-recaptcha-response").val()
                        },
                        success: laravel.ajax.successHandler,
                        error:laravel.ajax.errorHandler
                    });
                };
            </script>
        @captchaScripts('tr')
    @endif
@endsection
