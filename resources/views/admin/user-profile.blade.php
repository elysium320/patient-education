@extends('layouts.master')
@section("content")
<div class="admin-components">
    <profile-component id="{{ auth()->id() }}" email="{{ auth()->user()->email }}"></profile-component>
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