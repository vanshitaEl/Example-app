@extends('layout')
@section('content')

    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
            }

            form {
                border: 3px solid #f1f1f1;
            }

            input[type=text],
            input[type=password] {
                width: 100%;
                padding: 12px 20px;
                margin: 8px 0;
                display: inline-block;
                border: 1px solid #ccc;
                box-sizing: border-box;
            }

            button {
                background-color: #04AA6D;
                color: white;
                padding: 14px 20px;
                margin: 8px 0;
                border: none;
                cursor: pointer;
                width: 100%;
            }

            button:hover {
                opacity: 0.8;
            }

            .cancelbtn {
                width: auto;
                padding: 10px 18px;
                background-color: #f44336;
            }

            .imgcontainer {
                text-align: center;
                margin: 24px 0 12px 0;
            }

            img.avatar {
                width: 40%;
                border-radius: 50%;
            }

            .container {
                padding: 16px;
            }

            span.psw {
                float: right;
                padding-top: 16px;
            }

            /* Change styles for span and cancel button on extra small screens */
            @media screen and (max-width: 300px) {
                span.psw {
                    display: block;
                    float: none;
                }

                .cancelbtn {
                    width: 100%;
                }
            }

            .dropbtn {
                background-color: #04AA6D;

                color: white;
                padding: 10px;
                font-size: 16px;
                border: none;
            }

            .dropdown {
                position: relative;
                display: inline-block;
            }

            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f1f1f1;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
                z-index: 1;
            }

            .dropdown-content a {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
            }

            .dropdown-content a:hover {
                background-color: #ddd;
            }

            .dropdown:hover .dropdown-content {
                display: block;
            }

            .dropdown:hover .dropbtn {
                background-color: #3e8e41;
            }
        </style>
    </head>

    <body>

        <br>
        <center>
            <div class="dropdown">
                <button class="dropbtn">Language</button>

                <div class="dropdown-content">

                    <a href="{{ route(Route::currentRouteName(), ['lang' => 'en']) }}">English</a>
                    <a href="{{ route(Route::currentRouteName(), ['lang' => 'hi']) }}">hindi</a>
                    <a href="{{ route(Route::currentRouteName(), ['lang' => 'ta']) }}">Tamil</a>

                </div>
            </div>
        </center>
        <hr>

        <h2>{{ __('lang.login_form') }}</h2>

        <form action="{{ route('doctor.check', ['lang' => app()->getLocale()]) }}">

            @if (Session::get('fail'))
                <div class="alert alert-danger">
                    {{ Session::get('fail') }}
                </div>
            @endif

            @if (Session::get('info'))
                <div class="alert alert-info">
                    {{ Session::get('info') }}
                </div>
            @endif
            @csrf

            <div class="container">
                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" id="email" value=" {{ Session::get('status') ? Session::get('status') : old('email') }}">
                <span class="text-danger">
                    @error('email')
                        {{ $message }}
                    @enderror
                </span><br><br>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" value="{{ old('password') }}">
                <span class="text-danger">
                    @error('password')
                        {{ $message }}
                    @enderror
                </span><br><br>

                <button type="submit">Login</button>

            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" class="cancelbtn">Cancel</button>
                <a href="{{ route('doctor.register', ['lang' => app()->getLocale()]) }}">I have don't accont,create new</a>
            </div>


            <hr>
            <center>
                <div class="flex items-center justify-end mt-4">
                    <a href="{{ url('login/google') }}">
                        <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png">
                    </a>
                </div>
            </center>

        </form>

    </body>

    </html>
