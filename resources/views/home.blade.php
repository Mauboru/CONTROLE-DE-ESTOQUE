@extends('index')

@section('conteudo')
<div class="text-center my-4">
    <span class="fs-4 fw-bold text-dark">
        Seja bem-vindo(a)
        <span class="text-primary">{{ Auth::user()->name}}</span>
        <br>
        ao Sistema Controle de Estoque!
    </span>
</div>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-2">
            <a href="{{ route('clientes.index') }}" class="text-decoration-none">
                <div class="card card-hover">
                    <img src="https://cdn-icons-png.flaticon.com/512/3649/3649789.png" class="card-img-top custom-img">
                    <h4 class="custom-title">Clientes</h4>
                </div>
            </a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('categorias.index') }}" class="text-decoration-none">
                <div class="card card-hover">
                    <img src="https://cdn-icons-png.flaticon.com/512/17776/17776149.png" class="card-img-top custom-img">
                    <h4 class="custom-title">Categorias</h4>
                </div>
            </a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('unidades.index') }}" class="text-decoration-none">
                <div class="card card-hover">
                    <img src="   https://cdn-icons-png.flaticon.com/512/2738/2738624.png " class="card-img-top custom-img">
                    <h4 class="custom-title">Unidades</h4>
                </div>
            </a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('produtos.index') }}" class="text-decoration-none">
                <div class="card card-hover">
                    <img src="https://cdn-icons-png.flaticon.com/512/10951/10951869.png" class="card-img-top custom-img">
                    <h4 class="custom-title">Produtos</h4>
                </div>
            </a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('vendas.index') }}" class="text-decoration-none">
                <div class="card card-hover">
                    <img src="https://cdn-icons-png.flaticon.com/512/1374/1374072.png" class="card-img-top custom-img">
                    <h4 class="custom-title">Vendas</h4>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    .card-hover {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        border-radius: 8px;
        overflow: hidden;
    }

    .custom-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 10px;
        text-align: center;
    }

    .card-hover:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
</style>

@endsection
