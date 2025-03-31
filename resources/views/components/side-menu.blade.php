<div class="col-md-2 ps-0">
    <div class="side-menu">
        <div class="menu-section mb-4">
            <div class="menu-item {{ Route::is('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Главная
                </a>
            </div>
            <div class="menu-item {{ Route::is('users.rating') ? 'active' : '' }}">
                <a href="{{ route('users.rating') }}" class="d-flex align-items-center text-decoration-none">
                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13M16 3.13C16.8604 3.3503 17.623 3.8507 18.1676 4.55231C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89317 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88M13 7C13 9.20914 11.2091 11 9 11C6.79086 11 5 9.20914 5 7C5 4.79086 6.79086 3 9 3C11.2091 3 13 4.79086 13 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Рейтинг
                </a>
            </div>
            <div class="menu-item {{ Route::is('tags.*') ? 'active' : '' }}">
                <a href="{{ route('tags.index') }}" class="d-flex align-items-center text-decoration-none">
                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M9.5 3L4 8.5V15.5L9.5 21L16.5 15.5L22 10L16.5 4.5L9.5 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Теги
                </a>
            </div>
            <div class="menu-item {{ Route::is('answers.*') ? 'active' : '' }}">
                <a href="{{ route('answers.index') }}" class="d-flex align-items-center text-decoration-none">
                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M21 15C21 15.5304 20.7893 16.0391 20.4142 16.4142C20.0391 16.7893 19.5304 17 19 17H7L3 21V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Ответы
                </a>
            </div>
            @auth
            <div class="menu-item {{ Route::is('bookmarks.*') ? 'active' : '' }}">
                <a href="{{ route('bookmarks.index') }}" class="d-flex align-items-center text-decoration-none">
                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M19 21L12 16L5 21V5C5 4.46957 5.21071 3.96086 5.58579 3.58579C5.96086 3.21071 6.46957 3 7 3H17C17.5304 3 18.0391 3.21071 18.4142 3.58579C18.7893 3.96086 19 4.46957 19 5V21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Закладки
                </a>
            </div>
            <div class="menu-item {{ Route::is('drafts.*') ? 'active' : '' }}">
                <a href="{{ route('drafts.index') }}" class="d-flex align-items-center text-decoration-none">
                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13M18.5 2.50001C18.8978 2.10219 19.4374 1.87869 20 1.87869C20.5626 1.87869 21.1022 2.10219 21.5 2.50001C21.8978 2.89784 22.1213 3.43739 22.1213 4.00001C22.1213 4.56262 21.8978 5.10219 21.5 5.50001L12 15L8 16L9 12L18.5 2.50001Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Черновики
                </a>
            </div>
            @endauth
        </div>

        <div class="menu-section mt-auto">
            <div class="menu-item {{ Route::is('rules') ? 'active' : '' }}">
                <a href="{{ route('rules') }}" class="d-flex align-items-center text-decoration-none">
                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Правила
                </a>
            </div>
            <div class="menu-item {{ Route::is('help') ? 'active' : '' }}">
                <a href="{{ route('help') }}" class="d-flex align-items-center text-decoration-none">
                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9.09 9.00002C9.3251 8.33169 9.78915 7.76813 10.4 7.40915C11.0108 7.05018 11.7289 6.91895 12.4272 7.03872C13.1255 7.15849 13.7588 7.52153 14.2151 8.06353C14.6713 8.60554 14.9211 9.29153 14.92 10C14.92 12 11.92 13 11.92 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 17H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Помощь
                </a>
            </div>
            <div class="menu-item {{ Route::is('about') ? 'active' : '' }}">
                <a href="{{ route('about') }}" class="d-flex align-items-center text-decoration-none">
                    <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 16V12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 8H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    О нас
                </a>
            </div>
        </div>
    </div>
</div> 