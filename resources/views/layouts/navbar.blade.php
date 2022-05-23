<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="/">Patient Education 101</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">

        <ul class="navbar-nav">
            @if(auth()->check())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin', app()->getLocale()) }}">{{ __('Admin') }}<span class="sr-only">(current)</span></a>
            </li>
            @endif

            <li class="nav-item active">

                <a class="nav-link" href="{{ route('home', app()->getLocale()) }}">{{ __('Home') }} <span class="sr-only">(current)</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('modules', app()->getLocale()) }}">{{__('Modules')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('lessons', app()->getLocale()) }}">{{__('Lessons')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('quizzes', app()->getLocale()) }}">{{__('Quizzes')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Demo</a>
            </li>
            <li class="nav-item pr-0">
{{--                <a href="{{ route(Route::currentRouteName(), 'en') }}" class="nav-link">EN</a>--}}
                <a href="/en" class="nav-link">EN</a>
            </li>
            <span class=" b-right"></span>
            <li class="nav-item">
{{--                <a href="{{ route(Route::currentRouteName(), 'es') }}" class="nav-link">ES</a>--}}
                <a href="/es" class="nav-link">ES</a>
            </li>

            @if(auth()->check())
            <li class="nav-item" style=" padding-right: 10px;">
                <a class="user-profile" href="/admin/profile">
                    <img src="/img/male-placeholder.png" alt="">
                    Account
                </a>
            </li>
            <li class="nav-item">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="/admin/modules">Modules/Lessons</a>
                        <a class="dropdown-item" href="admin/analytics">Analytics</a>
                        <form method="POST" action="/logout">
                            @csrf
                            <button class="drop-links" type="submit" class="nav-link">Logout</button>
                        </form>

                    </div>
                </div>

            </li>

            @endif

        </ul>
        
        <div class="modal fade" id="practice_modal">
            <div class="modal-dialog">
                <form id="companydata">
                    <div class="modal-content">
                    <input type="hidden" id="color_id" name="color_id" value="">
                    <div class="modal-body">
                        <input type="text" name="name" id="name" value="" class="form-control">
                    </div>
                    <input type="submit" value="Submit" id="submit" class="btn btn-sm btn-outline-danger py-0" style="font-size: 0.8em;">
                </div>
                </form>
            </div>
        </div>
    </div>
</nav>