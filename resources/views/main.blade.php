<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONTROLE DE ESTOQUE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid vh-100 d-flex flex-column justify-content-center align-items-center text-center">
        <nav class="navbar bg-white rounded p-3 w-100">
            <div class="container-fluid d-flex flex-column align-items-center">
                <a class="navbar-brand d-flex flex-column align-items-center" href="{{ route('home') }}">
                    <img src="{{ asset('estoque-pronto.png') }}" alt="Logo" class="img-fluid mb-3" style="max-width: 220px; height: auto;">
                    <span class="fs-2 fs-md-1 fw-semibold text-secondary">CONTROLE DE ESTOQUE</span>
                </a>
            </div>
        </nav>
    </div>
</body>
</html>