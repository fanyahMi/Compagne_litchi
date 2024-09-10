<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <title>Sign Up</title>
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
        font-weight: bold;
    }
      @-webkit-keyframes sk-scaleout {
        0% { -webkit-transform: scale(0) }
        100% {
          -webkit-transform: scale(1.0);
          opacity: 0;
        }
      }

      @keyframes sk-scaleout {
        0% {
          -webkit-transform: scale(0);
          transform: scale(0);
        } 100% {
          -webkit-transform: scale(1.0);
          transform: scale(1.0);
          opacity: 0;
        }
      }
    </style>
 <script defer="defer" src="{{ asset('main.js') }} "></script></head>
 <body class="app">
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
    <div class="peers ai-s fxw-nw h-100vh">
      <div class="peer peer-greed h-100 pos-r bgr-n bgpX-c bgpY-c bgsz-cv" style='background-image: url("assets/static/images/login.jpg")'>
        <div class="pos-a centerXY">
          <div class="bgc-white bdrs-50p pos-r" style="width: 120px; height: 120px;">
            <img class="pos-a centerXY" src="assets/static/images/logo.png" alt="">
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4 peer pX-40 pY-80 h-100 bgc-white scrollable pos-r" style="min-width: 320px;">
        <h4 class="fw-300 c-grey-900 mB-40">Register</h4>
        <form action="{{ url('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label" class="text-normal text-dark">Name</label>
                <input type="text" class="form-control" name="name" placeholder="John">
                @error('name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" class="text-normal text-dark">First names</label>
                <input type="text" class="form-control" name="first_names" placeholder=" Doe">
                @error('first_names')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" class="text-normal text-dark">Date of birth</label>
                <input type="date" name="date_birth" class="form-control">
                @error('date_birth')
                    <p class="error-message">{!! $message !!}</p>
                @enderror

            </div>
            <div class="mb-3">
                <label class="form-label" class="text-normal text-dark">Email Address</label>
                <input type="email" class="form-control" name="email" placeholder="name@email.com">
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" class="text-normal text-dark">Password</label>
                <input type="password" class="form-control" name="passwords" placeholder="Password">
                @error('passwords')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" class="text-normal text-dark">Confirm Password</label>
                <input type="password" class="form-control" name="passwords2" placeholder="Password">
                @error('passwords2')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <button class="btn btn-primary btn-color">Register</button>
            </div>
        </form>
              </div>
    </div>

  </body>
</html>
