<!-- Barra de Navegação -->
<nav class="nav-links">
    <a href="{{ route('home') }}" class="nav-link active">Home</a>

    <!-- Dropdown do Usuário -->
    <div class="dropdown">
        <button class="btn btn-link dropdown-toggle d-flex align-items-center text-decoration-none text-dark" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <!-- Exibir imagem de perfil e nome do usuário -->
          
        </button>

        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
            <li>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user me-2"></i> Perfil
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}" class="dropdown-item">
                    @csrf
                    <button type="submit" class="btn btn-link text-decoration-none p-0 w-100 text-start">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>
