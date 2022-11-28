<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login sgc</title>
    <meta name='generator' content='CRUDBooster' />
    <meta name='robots' content='noindex,nofollow' />
    <link rel="shortcut icon" href="http://localhost/sgc/public/uploads/2022-02/843b226609930b014693758ec14e5875.png">

    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link rel="stylesheet" href="{{ asset('css/crudbooster/bootstrap.min.css') }}">

    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
        type="text/css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/crudbooster/AdminLTE.min.css') }}">
    <!-- support rtl-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="{{ asset('css/crudbooster/main.css') }}">


    <style>
        .login-page,
        .register-page {

            color: #ffffff !important;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;

        }

        .login-box,
        .register-box {
            align-content: center
        }

        .login-box-body {

            background: rgba(255, 255, 255, 0);
            width: 400px;
            height: 320px;
            align-content: center
        }

        .register-box {
            margin-left: 30px;
            align-content: center
        }

        html,
        body {
            overflow: hidden;
            align-content: center
        }

        .login {
            margin-left: 450px;
            align-content: center
        }

        .content {
            width: 400px;
        }

        .log {


            width: 400px;
            align
        }

        .abs-center {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;

        }

    </style>
</head>

<body>

    <div class="abs-center">
        <div class="log">

            <div class="login-box">
                <div class="login-logo">
                    <a href="http://localhost/sgc/public">

                    </a>
                </div><!-- /.login-logo -->

            </div>

            <div>



            </div class="content">


            <form autocomplete='off' method="POST" action="{{ route('login') }}">
                @csrf

                <div class="login-box-body">

                    <h1 ALIGN="CENTER">LOGIN </h1>
                    <div class="form-group has-feedback">                    

                        <input autocomplete='off' id="email" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Email">

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    {{-- <span class="glyphicon glyphicon-user form-control-feedback"></span> --}}
                </div>
                    <div class="form-group has-feedback">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        {{-- <span class="glyphicon glyphicon-lock form-control-feedback"></span> --}}
                    </div>
                    <div style="margin-bottom:10px" class='row'>
                        <div class='col-xs-12'>
                            <button type="submit" class="btn btn-primary btn-block btn-flat" ></i> Ingresar</button>
                        </div>

                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Olvido su password?') }}
                        </a>
                    @endif

                    </div>

                    <div class='row'>

                    </div>
                </div>
            </form>

            <br />
            <!--a href="#">I forgot my password</a-->
        </div>
    </div><!-- /.login-box-body -->
    <div>
    </div><!-- /.login-box -->



    <!-- jQuery 2.2.3 -->
    {{-- <script src="http://localhost/sgc/public/vendor/crudbooster/assets/adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script> --}}
    <!-- Bootstrap 3.4.1 JS -->
    {{-- j</body>
</html>
