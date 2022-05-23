@extends('layouts.master')
@section("content")
<div class="home-page">
    <div class="page-holder">

        <edit-lesson-component :lessons="{{ $lessons }}"></edit-lesson-component>


        <a style="width: fit-content;" href="{{ route('admin/create-lesson', app()->getLocale()) }}" class="white-btn mb-5 pull-right"> + Create New
            Lesson</a>

    </div>
    <div type="button" data-toggle="tooltip" data-placement="top" title="{{__('Select a lesson. Watch a video. Take the quiz.')}}" class="help">
        <div class="help-icon">
            <i class="fa fa-question-circle" aria-hidden="true"></i>
        </div>
        <span>HELP</span>

        <div id="toTop" class="back-top">
            <div class="back">
                <i class="fas fa-angle-double-up"></i>
            </div>
            <span>BACK TO TOP</span>
        </div>
    </div>
</div>

@endsection
<script>

</script>
