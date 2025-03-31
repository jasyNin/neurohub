@extends('layouts.app')

@section('title', 'Помощь')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Помощь</h2>
                </div>
                <div class="card-body">
                    <h3>Часто задаваемые вопросы</h3>
                    
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Как создать пост?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Чтобы создать пост:</p>
                                    <ol>
                                        <li>Войдите в свой аккаунт</li>
                                        <li>Нажмите кнопку "Создать пост" на главной странице</li>
                                        <li>Заполните заголовок и содержание</li>
                                        <li>Выберите тип (запись или вопрос)</li>
                                        <li>Добавьте теги (необязательно)</li>
                                        <li>Нажмите "Опубликовать"</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Как добавить теги к посту?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>При создании или редактировании поста:</p>
                                    <ol>
                                        <li>В поле "Теги" введите теги через запятую</li>
                                        <li>Например: "программирование, php, laravel"</li>
                                        <li>Теги будут автоматически созданы при публикации поста</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Как редактировать свой профиль?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Чтобы отредактировать профиль:</p>
                                    <ol>
                                        <li>Перейдите в свой профиль</li>
                                        <li>Нажмите кнопку "Редактировать профиль"</li>
                                        <li>Измените нужные поля</li>
                                        <li>Нажмите "Сохранить"</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    Как использовать закладки?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Чтобы добавить пост в закладки:</p>
                                    <ol>
                                        <li>Откройте пост, который хотите сохранить</li>
                                        <li>Нажмите кнопку "В закладки"</li>
                                        <li>Чтобы просмотреть закладки, перейдите в раздел "Мои закладки"</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="mt-4">Нужна дополнительная помощь?</h3>
                    <p>Если у вас остались вопросы, вы можете:</p>
                    <ul>
                        <li>Обратиться к <a href="{{ route('contact') }}">службе поддержки</a></li>
                        <li>Ознакомиться с <a href="{{ route('rules') }}">правилами сайта</a></li>
                        <li>Написать администратору через форму обратной связи</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 