@extends('layouts.master')
@section("content")
<div class="home-page">
    <div class="lesson-start-container" style="margin-bottom: 9.875rem;">
        <h1 style="cursor:pointer" onclick="window.location='/modules/{{$module->id}}'" class="heading-primary">
            {{ $module->title }}
        </h1>
        {{-- {{ dd($lesson) }}--}}
        <h2 class="heading-secondary">{{ __('Watch the full video and then press “Take Quiz” to test your knowledge on what you have just seen.') }}</h2>
        {{-- <div class="video">--}}
        {{-- <img src="{{ $lesson->getCover() }}" alt="">--}}
        {{-- </div>--}}
        <div class="video">
            @if($lesson->videos && isset($lesson->videos[0]) && $lesson->videos[0]->external_url)
            {!! $lesson->videos[0]->external_url !!}
            @else
            <video controls controlsList="nodownload">
                <source src="{{ $lesson->getFirstVideo() }}" type="video/mp4">
            </video>
            @endif


        </div>
        <div class="d-flex justify-space-between align-center mar-bottom action-btns">
            <div class=" lesson-information">
                <h1>{{ $lesson->title }}</h1>
                <span>{{ $lesson->description }}</span>
            </div>
            <!-- <a href="/lessons" class="white-btn">Return to Modules</a> -->
            <a href="/quizzes/{{ $lesson->getQuiz() }}" class="default-btn">{{__('Take quiz')}}</a>
        </div>
    </div>
    @if($module)
    <div class="lesson-navigation">
        <!-- <h2 class="slider-title">Now Playing...</h2> -->
        <slider-component :lessons="{{$module->lessons}}"></slider-component>
    </div>
    @else
    <h2 class="slider-title">This lesson doesn't belong to any module</h2>
    @endif

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
<style>

</style>
