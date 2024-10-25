<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>SISGA LOGIN</title>
    <style type="text/css">
        body {
            font-family: 'Overpass', sans-serif;
            font-weight: normal;
            font-size: 100%;
            color: rgb(190, 0, 0);
            margin: 20;
            background-image: url("vendor/adminlte/dist/img/almacen4.jpg");
            background-position: center;
            background-size: cover;
        }

        #f1 {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 5px;
            padding: 5px;
            min-width: 100vw;
            min-height: 100vh;
            width: 100%;
            height: 100%;
        }

        #contenedorcentrado {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: row;
            min-width: 380px;
            max-width: 900px;
            width: 90%;
            opacity: 0.90;
            background-color: #719192;
            border-radius: 10px 10px 10px 10px;
            padding: 30px;
            box-sizing: border-box;
            border-style: dotted;
        }

        /* formulario de login */
        #login {
            width: 100%;
            max-width: 320px;
            min-width: 320px;
            padding: 30px 30px 50px 30px;
            background-color: #719192;
            border-style: dotted;
            -webkit-box-shadow: 0px 0px 5px 5px rgba(0, 0, 0, 0.15);
            -moz-box-shadow: 0px 0px 5px 5px rgba(0, 0, 0, 0.15);
            box-shadow: 0px 0px 5px 5px rgba(0, 0, 0, 0.15);
            border-radius: 3px 3px 3px 3px;
            -moz-border-radius: 3px 3px 3px 3px;
            -webkit-border-radius: 3px 3px 3px 3px;
            box-sizing: border-box;
            opacity: 1;
            filter: alpha(opacity=1);
        }

        #login label {
            display: block;
            font-family: 'Overpass', sans-serif;
            font-size: 120%;
            color: black;
            margin-top: 15px;
        }

        #login input {
            font-family: 'Overpass', sans-serif;
            font-size: 110%;
            color: black;
            display: block;
            width: 100%;
            height: 40px;
            margin-bottom: 10px;
            padding: 5px 5px 5px 10px;
            box-sizing: border-box;
            border: none;
            border-radius: 3px 3px 3px 3px;
            -moz-border-radius: 3px 3px 3px 3px;
            -webkit-border-radius: 3px 3px 3px 3px;
        }

        #login input::placeholder {
            font-family: 'Overpass', sans-serif;
            color: black;
        }

        #login button {
            font-family: 'Overpass', sans-serif;
            font-size: 110%;
            color: black;
            width: 100%;
            height: 40px;
            border: none;
            border-radius: 3px 3px 3px 3px;
            -moz-border-radius: 3px 3px 3px 3px;
            -webkit-border-radius: 3px 3px 3px 3px;
            background-color: #dfcdc3;
            margin-top: 10px;
        }

        #login button:hover {
            background-color: #3c4245;
            color: white;
        }

        #derecho {
            text-align: center;
            width: 100%;
            opacity: 0.70;
            filter: alpha(opacity=70);
            padding: 20px 20px 20px 50px;
            box-sizing: border-box;
        }

        .titulo {
            font-size: 300%;
            color: black;
        }

        hr {
            border-top: 1px solid #8c8b8b;
            border-bottom: 1px solid #dfcdc3;
        }

        .pie-form {
            font-size: 90%;
            text-align: center;
            margin-top: 15px;
        }

        .pie-form a {
            display: block;
            text-decoration: none;
            color: black;
            margin-bottom: 3px;
        }

        .pie-form a:hover {
            color: black;
        }

        @media all and (max-width: 775px) {
            #contenedorcentrado {
                flex-direction: column-reverse;
                min-width: 380px;
                max-width: 900px;
                width: 90%;
                background-color: black;
                border-radius: 10px 10px 10px 10px;
                -moz-border-radius: 10px 10px 10px 10px;
                -webkit-border-radius: 10px 10px 10px 10px;
                -webkit-box-shadow: 0px 0px 5px 5px rgba(0, 0, 0, 0.15);
                -moz-box-shadow: 0px 0px 5px 5px rgba(0, 0, 0, 0.15);
                box-shadow: 0px 0px 5px 5px rgba(0, 0, 0, 0.15);
                padding: 30px;
                box-sizing: border-box;
            }

            #login {
                margin: 0 auto;
            }

            #derecho {
                padding: 20px 20px 20px 20px;
            }

            #login label {
                text-align: left;
            }
        }
    </style>
</head>

<body>
    <div id="f1">
        <div id="contenedorcentrado">
            <div id="login">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <label for="email">Correo Electrónico</label>
                    <input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

                    <label for="password">Contraseña</label>
                    <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    <button type="submit">{{ __('Ingresar') }}</button>
                </form>
            </div>
            <div id="derecho">
                <div class="titulo">
                    Bienvenido al sistema web SISGA
                    <a><img src="vendor/adminlte/dist/img/logo.png" width="176" height="176"></a>
                </div>
                <hr>
                <div class="pie-form">
                    <a>Sigamos triunfando</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
