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
                <a href="#" class="text-decoration-none">
                    <div class="card card-hover">
                        <img src="https://png.pngtree.com/thumb_back/fh260/background/20220217/pngtree-organic-poultry-freerange-chickens-on-a-farm-in-germany-photo-image_35385422.jpg" class="card-img-top custom-img" alt="Smart-Harpia">
                        <div class="card-body text-center">
                            <h5 class="card-title custom-title">SMART ANILHAS</h5>
                            <p class="card-text custom-description">Sistema desenvolvido com objetivo de monitorar as aves!</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 2 -->
            <div class="col-md-4">
                <a href="#" class="text-decoration-none">
                    <div class="card card-hover">
                        <img src="https://s2.glbimg.com/r42vuL4vV9D55oBLl0CmO5Ht9VY=/512x320/smart/e.glbimg.com/og/ed/f/original/2022/01/18/tudo-o-que-voce-precisa-saber-para-ter-uma-horta-sustentavel-em-casa_3.jpg" class="card-img-top custom-img" alt="Smart-Harpia">
                        <div class="card-body text-center">
                            <h5 class="card-title custom-title">SMART HORTA</h5>
                            <p class="card-text custom-description">Sistema desenvolvido com objetivo de cuidar e monitorar as plantas!</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 3 -->
            <div class="col-md-4">
                <a href="#" class="text-decoration-none">
                    <div class="card card-hover">
                        <img src="https://www.fao.org/images/nationalforestmonitoringlibraries/default-album/fao_25023_0034.jpg?sfvrsn=7fcb66fb_11" class="card-img-top custom-img" alt="Smart-Harpia">
                        <div class="card-body text-center">
                            <h5 class="card-title custom-title">MAC ADDRESS</h5>
                            <p class="card-text custom-description">Tem como objetivo a monitoração de entradas não autorizadas em regiões ambientais preservadas!</p>
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