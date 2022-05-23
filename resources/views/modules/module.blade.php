@extends('layouts.master')
@section("content")
<div class="home-page">
    <h1 class="heading-primary">
        <a href="/modules">{{ $module->title }}</a>
    </h1>
    <h2 class="heading-secondary">{{ $module->description }}</h2>
    @if (count($module->lessons))
    <div onclick="window.location='/modules/{{$module->id}}/lessons/{{$module->lessons[0]->id}}'" class="white-btn start-btn">{{ __('START') }}</div>

    @endif

    @php
    $items = [1, 3, 4];
    @endphp
    @foreach( $module->lessons as $key => $item)
    <div class="lesson-container d-sm-flex">
        <div class="video">
            <p class="num {{ $key === (count($items) - 1) ? 'last-pseudo' : ' ' }}">
                <span>{{ $key+1 }}</span>
            </p>
            @if($module->videos && isset($module->videos[0]) && $module->videos[0]->external_url)
            {!! $module->videos[0]->external_url !!}
            @else
            <img style="width:100%;border:1px solid black;" src="{{ $item->cover_image }}" />
            @endif
        </div>
        <div class="lesson-info">
            <div class="d-sm-flex align-center">
                <h2 class="title">
                    {{ $item->title }}
                </h2>

            </div>
            <div class="description">{{ $item->description }}</div>
            <button onclick="window.location = '/modules/{{$module->id}}/lessons/{{$item->id}}'" class="begin-lesson">
                {{ __('Begin Lesson') }}
            </button>
        </div>
    </div>
    @endforeach

    <!-- <div class="d-flex justify-center action-btns">
        <a href="/lessons" class="white-btn">Return to Modules</a>
    </div> -->
    <div class="d-flex justify-center action-btns">
        <a onclick="window.location='/modules/{{$module->id}}/lessons/{{$module->lessons[0]->id}}'" class="white-btn">{{ __('START') }}</a>
    </div>
    <div type="button" data-toggle="tooltip" data-placement="top" title="{{__('Select a lesson. Watch a video. Take the quiz.')}}" class="help">
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
