<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('estoque-pronto.png') }}" alt="Logo" class="img-fluid" style="max-width: 50px;">
        </a>

        <div class="d-flex ms-auto">
            <div class="dropdown">
                <button class="btn btn-link dropdown-toggle d-flex align-items-center text-dark" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('profile.jpeg') }}" alt="Avatar" class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;">
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li class="px-3 py-2">
                        <strong>{{ Auth::user()->name}}</strong><br>
                        <small class="text-muted">{{ Auth::user()->email}}</small>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
