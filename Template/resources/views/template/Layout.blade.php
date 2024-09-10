
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet" />
    <title>{{ $title }}</title>

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
      .pagination {
    display: flex;
    list-style: none;
    padding: 0;
}

.pagination li {
    margin-right: 5px;
}

.pagination li a {
    padding: 5px 10px;
    border: 1px solid #ccc;
    color: #333;
    text-decoration: none;
}

.pagination li.active a {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
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


    <div>
      <!-- #Left Sidebar ==================== -->
      <div class="sidebar">
        <div class="sidebar-inner">
          <!-- ### $Sidebar Header ### -->
          @include("template.sidebar.Logo")
          <!-- ### $Sidebar Menu ### -->
          @include("template.sidebar.Menu")
        </div>
      </div>

      <!-- #Main ============================ -->
      <div class="page-container">
        <!-- ### $Topbar ### -->
        @include("template.header.Header")
        <!-- ### $App Screen Content ### -->
        <main class="main-content bgc-grey-100">
          <div id="mainContent">
                @include($page)
            </div>
          </div>
        </main>

        <!-- ### $App Screen Footer ### -->
       @include("template.footer.Footer")
      </div>
    </div>
  </body>
</html>
