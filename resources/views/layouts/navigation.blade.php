<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu e Navegação</title>

    <!-- Estilos e Fontes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        .custom-color {
            color: #1E90FF;
        }

        .nav-links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .nav-link {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            color: #007bff;
            transition: background-color 0.2s, color 0.2s;
        }

        .nav-link:hover {
            background-color: #e9ecef;
            color: #0056b3;
        }

        .nav-link.active {
            background-color: #007bff;
            color: #fff;
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>

    <!-- Barra de Navegação -->
    <nav class="nav-links">
        <a href="{{ route('main') }}" class="nav-link active">Home</a>    

        <!-- Dropdown do Usuário -->
        <div class="dropdown">
            <button class="btn btn-link dropdown-toggle d-flex align-items-center text-decoration-none text-dark" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('profile.jpeg') }}" alt="Avatar" class="profile-avatar me-2">
                <span>Visitante</span>
            </button>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <li>
                    <form method="POST" action="{{ route('home') }}" class="dropdown-item">
                        @csrf
                        <button type="submit" class="btn btn-link text-decoration-none">home</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
