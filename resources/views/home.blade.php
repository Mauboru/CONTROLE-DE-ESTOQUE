@extends('index')

@section('conteudo')
<div class="text-center my-4">
    <span class="fs-4 fw-bold text-dark">
        Seja bem-vindo(a)
        <span class="text-primary">Visitante</span>
        <br>
        ao Sistema Controle de Estoque!
    </span>
</div>

<!-- Cards Section -->
<div class="container my-4">
    <div class="row justify-content-center">

        <!-- Card 1 -->
        <div class="col-md-4">
            <a href="{{ route('clientes.index') }}" class="text-decoration-none">
                <div class="card card-hover">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRmN0sYhMXV6OCpe_vgSIY1Fwm8rJepE6F0-w&s" class="card-img-top custom-img" alt="Smart-Harpia">
                    <div class="card-body text-center">
                        <h5 class="card-title custom-title">Clientes</h5>
                        <p class="card-text custom-description">Área para gerenciar seus clientes!</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4">
            <a href="{{ route('categorias.index') }}" class="text-decoration-none">
                <div class="card card-hover">
                    <img src="https://static6.depositphotos.com/1112859/621/i/450/depositphotos_6219942-stock-photo-search-of-data-isolated-3d.jpg" class="card-img-top custom-img" alt="Smart-Harpia">
                    <div class="card-body text-center">
                        <h5 class="card-title custom-title">Categorias</h5>
                        <p class="card-text custom-description">Área para gereciar suas categorias!</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4">
            <a href="{{ route('unidades.index') }}" class="text-decoration-none">
                <div class="card card-hover">
                    <img src="https://media.istockphoto.com/id/1222200861/pt/foto/house-renovation-unrecognizable-repairman-holding-tape-measure-on-blue-background-closeup.jpg?s=612x612&w=0&k=20&c=clXGXowqnZZdGGYU1yqX7sM9b5rgkAl_WSSHF9w51JA=" class="card-img-top custom-img" alt="Smart-Harpia">
                    <div class="card-body text-center">
                        <h5 class="card-title custom-title">Unidade de Medida</h5>
                        <p class="card-text custom-description">Área para gereciar suas unidades de medidas!</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- STYLE -->
<style>
    .custom-img {
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .custom-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 10px;
    }

    .custom-description {
        font-size: 1rem;
        color: #555;
    }

    .card-hover {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        border-radius: 8px;
        overflow: hidden;
    }

    .card-hover:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
</style>

@endsection
