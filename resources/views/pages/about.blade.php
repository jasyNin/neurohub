@extends('layouts.app')

@section('title', 'О нас')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">О НейроХабе</div>

                <div class="card-body">
                    <h2 class="mb-4">Добро пожаловать в НейроХаб!</h2>
                    
                    <p class="lead">НейроХаб - это современная платформа для обмена знаниями и опытом в области нейротехнологий, искусственного интеллекта и когнитивных наук.</p>
                    
                    <h3 class="mt-4">Наша миссия</h3>
                    <p>Мы стремимся создать сообщество, где эксперты и энтузиасты могут делиться своими знаниями, задавать вопросы и находить ответы на сложные вопросы в области нейротехнологий.</p>
                    
                    <h3 class="mt-4">Что мы предлагаем</h3>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Платформу для обмена знаниями</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Сообщество единомышленников</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Возможность задавать вопросы и получать ответы</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Доступ к актуальной информации в области нейротехнологий</li>
                    </ul>
                    
                    <h3 class="mt-4">Присоединяйтесь к нам</h3>
                    <p>Станьте частью нашего растущего сообщества и внесите свой вклад в развитие нейротехнологий!</p>
                    <a href="{{ route('register') }}" class="btn btn-primary">Зарегистрироваться</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 