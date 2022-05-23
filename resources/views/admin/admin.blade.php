@extends('layouts.master')
@section("content")
<div class="home-page">
    <h1 class="heading-primary">
        Administrator Home
    </h1>
    <h2 class="heading-secondary">Welcome to Admin Panel</h2>
    <div class="modules mt">
        <div class="d-grid-content">

            <a href="{{ route('admin/lessons', app()->getLocale()) }}" class="module">
                <img src="/img/modules.png" alt="" />
                <div class="module-border">
                    <span class="heading-ternary ">Lessons</span>
                </div>

            </a>
            <a href="{{ route('admin/analytics', app()->getLocale()) }}" class="module">
                <img src="/img/analytics.png" alt="" />
                <div class="module-border">
                    <span class="heading-ternary ">Data & Analytics</span>
                </div>
            </a>

            <a class="module" href="{{ route('admin/profile', app()->getLocale()) }}">
                <img src="/img/account.png" alt="" />
                <div class="module-border">
                    <span class="heading-ternary">Account</span>
                </div>
            </a>
            <a class="module" href="{{ route('admin/modules', app()->getLocale()) }}">
                <img src="/img/account.png" alt="" />
                <div class="module-border">
                    <span class="heading-ternary">Modules</span>
                </div>
            </a>
            <a class="module" href="{{ route('admin/quizzes', app()->getLocale()) }}">
                <img src="/img/account.png" alt="" />
                <div class="module-border">
                    <span class="heading-ternary">Quizzes</span>
                </div>
            </a>

        </div>
    </div>
    <div type="button" data-toggle="tooltip" data-placement="top"
        title="Sed commodo pellentesque tortor quis pretium. Mauris tristique porta mauris eu condimentum. Quisque sed justo in massa blandit porta sit amet nec metus. Sed dolor tortor, tincidunt id volutpat mollis, viverra quis nisl. Sed egestas diam at sapien placerat, eget tincidunt massa sagittis."
        class="help">
        <div class="help-icon">
            <i class="fa fa-question-circle" aria-hidden="true"></i>
        </div>
        <span>HELP</span>
    </div>
    <div id="toTop" class="back-top">
        <div class="back">
            <i class="fas fa-angle-double-up"></i>
        </div>
        <span>BACK TO TOP</span>
    </div>

</div>

@endsection
<script>
window.addEventListener('load', function() {
    $('[data-toggle="tooltip"]').tooltip();

    $(window).scroll(function() {
        if ($(this).scrollTop()) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });

    $("#toTop").click(function() {

        $("html, body").animate({
            scrollTop: 0
        }, 1000);
    });

});
</script>
