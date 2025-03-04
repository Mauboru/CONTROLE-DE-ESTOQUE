<nav class="navbar navbar-expand-lg navbar-light shadow-sm">
    <div class="container-fluid">
    <a class="navbar-brand" href="javascript:history.back();">
        @if (!Route::is('home'))
            <img src="{{ asset('arrow-back.png') }}" alt="Voltar" class="img-fluid" style="max-width: 50px;">
        @endif
    </a>
        <div class="d-flex ms-auto">
            <div class="dropdown">
                @php
                $userId = auth()->user()->id;
                $imageId = (($userId - 1) % 10) + 1;
                $imagePath = asset("profiles/image{$imageId}.png");
                @endphp

                <button class="btn btn-link dropdown-toggle d-flex align-items-center text-dark" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ $imagePath }}" alt="Avatar" class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;">
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
