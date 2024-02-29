@extends('layout')
@section('content')

    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
                background-color: white;
            }

            * {
                box-sizing: border-box;
            }

            /* Add padding to containers */
            .container {
                padding: 16px;
                background-color: white;
            }

            /* Full-width input fields */
            input[type=text],
            input[type=password] {
                width: 100%;
                padding: 15px;
                margin: 5px 0 22px 0;
                display: inline-block;
                border: none;
                background: #f1f1f1;
            }

            input[type=text]:focus,
            input[type=password]:focus {
                background-color: #ddd;
                outline: none;
            }

            /* Overwrite default styles of hr */
            hr {
                border: 1px solid #f1f1f1;
                margin-bottom: 25px;
            }

            /* Set a style for the submit button */
            .registerbtn {
                background-color: #04AA6D;
                color: white;
                padding: 16px 20px;
                margin: 8px 0;
                border: none;
                cursor: pointer;
                width: 100%;
                opacity: 0.9;
            }

            .registerbtn:hover {
                opacity: 1;
            }

            /* Add a blue text color to links */
            a {
                color: dodgerblue;
            }

            /* Set a grey background color and center the text of the "sign in" section */
            .signin {
                background-color: #f1f1f1;
                text-align: center;
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

        <form action="{{ route('doctor.save', ['lang' => app()->getLocale()]) }}">

            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif

            @if (Session::get('fail'))
                <div class="alert alert-danger">
                    {{ Session::get('fail') }}
                </div>
            @endif

            @csrf
            <div class="container">
                <h1> {{ __('lang.Register') }}</h1>
                {{-- <p>Please fill in this form to create an account.</p> --}}
                {{-- <p>@lang('lang.test')</p> --}}
                <p> {{ __('lang.tests') }}</p>
                <hr>



                <br><br>
                <label for="email"><b>{{ __('lang.name') }}</b></label>
                <input type="text" placeholder=" {{ __('lang.entername') }}" name="name" id="name" value="{{ old('name') }}">
                <span class="text-danger">
                    @error('name')
                        {{ $message }}
                    @enderror
                </span><br><br>

                <label for="email"><b>{{ __('lang.email') }}</b></label>
                <input type="text" placeholder="{{ __('lang.enteremail') }}" name="email" id="email" value="{{ old('email') }}">
                <span class="text-danger">
                    @error('email')
                        {{ $message }}
                    @enderror
                </span><br><br>

                <label for="psw"><b>{{ __('lang.password') }}</b></label>
                <input type="password" placeholder="{{ __('lang.enterpassword') }}" name="psw" id="psw" value="{{ old('psw') }}">
                <span class="text-danger">
                    @error('psw')
                        {{ $message }}
                    @enderror
                </span><br><br>

                <hr>

                {{-- <button type="submit" href="{{ route('doctor.messages',['lang' => app()->getLocale()] ) }}">register</button>  --}}
                <button type="submit" class="registerbtn">{{ __('lang.Register') }}</button>
                <a href="{{ route('doctor.login', ['lang' => app()->getLocale()]) }}">{{ __('lang.already email') }} </a>
            </div>
            <center>

                @foreach ($quotes as $item)
                    <p>{{ $loop->index + 1 }}. {{ $item['id'] }}

                        {{ $item['quote'] }}
                        {{ $item['author'] }} </p>
                @endforeach
                @for ($i = 1; $i <= $totalPage; $i++)
                    <a href="{{ route('doctor.register', ['lang' => app()->getLocale(), 'page' => $i]) }}">{{ $i }}</a>
                @endfor
                {{-- {{ $quotes->links() }} --}}


            </center>



        </form>

    </body>

    </html>
