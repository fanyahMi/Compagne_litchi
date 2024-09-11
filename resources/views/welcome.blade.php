<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/plugins/bootstrap.min.css">
    <title>Sign In</title>
    <style>
      #loader {
        transition: all 0.3s ease-in-out;
        opacity: 1;
        visibility: visible;
        position: fixed;
        height: 100vh;
        width: 100%;
        background: #fff;
        z-index: 90000;
      }

      #loader.fadeOut {
        opacity: 0;
        visibility: hidden;
      }

      .spinner {
        width: 40px;
        height: 40px;
        position: absolute;
        top: calc(50% - 20px);
        left: calc(50% - 20px);
        background-color: #333;
        border-radius: 100%;
        -webkit-animation: sk-scaleout 1.0s infinite ease-in-out;
        animation: sk-scaleout 1.0s infinite ease-in-out;
      }


        .error-message {
            color: red;
            margin-top: 5px;
        }


        .c-dark-green {
            color: #2e7d32; /* Vert foncé */
        }

        .form-control {
            border: 1px solid #2e7d32; /* Bordure verte */
            border-radius: 5px; /* Coins arrondis */
        }

        .form-control:focus {
            border-color: #1b5e20; /* Bordure verte plus foncée au focus */
            box-shadow: 0 0 5px rgba(30, 130, 76, 0.5); /* Ombre au focus */
        }

        .error-message {
            margin-top: 10px;
            font-size: 14px;
        }

        #titre {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            text-transform: uppercase;
            font-family: 'Georgia', serif;
            font-size: xx-large;
        }

        .bouton{
            background: linear-gradient(to right, #4caf50, #388e3c);
            border: none;
            display: inline-block;
        }
        .bouton:hover{
            transform: translateY(2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

    </style>
</head>
  <body class="app" style="background-color: #2c3e50">
    <div id="loader">
      <div class="spinner"></div>
    </div>

    <script>
      window.addEventListener('load', function load() {
        const loader = document.getElementById('loader');
        setTimeout(function() {
          loader.classList.add('fadeOut');
        }, 300);
      });
    </script>
        <div class="container" style="padding: 5%;">
            <div class="row" style="box-shadow: 0 4px 20px rgba(222, 219, 219, 0.127);border-radius: 10px;background-size: contain;background-repeat: no-repeat; padding:5% ;justify-content: space-around;background-color: whitesmoke">
                <div class="col-md-7" style='background-image: url("assets/images/Logo_vectoriel_etk4ek.png");background-size: contain;background-repeat: no-repeat;background-position: center'>
                </div>
                <div class="col-12 col-md-4 " style="min-width: 320px;">
                    <h4 class="fw-300 c-dark-green mB-40" id="titre" >Connectez-vous</h4>
                    <form action="{{ url('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="text-normal text-dark form-label">Nº matricule</label>
                            <input type="text" class="form-control" name="matricule" value="m@m" required>
                        </div>
                        <div class="mb-3">
                            <label class="text-normal text-dark form-label">Mot de passe</label>
                            <input type="password" class="form-control" name="password" required value="m">
                        </div>
                        @if ($errors->any())
                            <div class="error-message text-danger">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class="">
                            <div class="peers ai-c jc-sb fxw-nw">
                                <div class="peer">
                                    <div class="checkbox checkbox-circle checkbox-info peers ai-c">
                                        <input type="checkbox" id="inputCall1" name="inputCheckboxesCall" class="peer">
                                        <label for="inputCall1" class="peers peer-greed js-sb ai-c form-label">
                                            <span class="peer peer-greed">Remember Me</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="peer">
                                    <button class="btn btn-color bouton">Login</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
  </body>
</html>
