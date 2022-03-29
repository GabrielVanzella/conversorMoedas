<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .container{
            width: 100%;
        }
    </style>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
    <title>Cotações</title>
  </head>
  <body>
        <main class="py-4">
            <div class="container">
                <h1>Cotações</h1>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="/">Inicio</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="container">
                @yield('content')
            </div>
        </main>
    
  </body>
</html>