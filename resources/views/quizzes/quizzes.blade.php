@extends('layouts.master')
@section("content")
<div class="home-page">
    <h1 class="heading-primary">
        {{__('Quizzes')}}
    </h1>
{{--    <h2 class="heading-secondary"> @php echo __('general.lessons_h1') @endphp </h2>--}}
    <h3> {{ __('Select a quiz to get started.') }}</h3>


    <all-quizzes-component :quizzes="{{ $quizzes }}"></all-quizzes-component>

    <div type="button" data-toggle="tooltip" data-placement="top" title="Sed commodo pellentesque tortor quis pretium. Mauris tristique porta mauris eu condimentum. Quisque sed justo in massa blandit porta sit amet nec metus. Sed dolor tortor, tincidunt id volutpat mollis, viverra quis nisl. Sed egestas diam at sapien placerat, eget tincidunt massa sagittis." class="help">

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
