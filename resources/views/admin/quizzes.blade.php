@extends('layouts.master')
@section("content")

<div class="home-page">
    <h1 class="heading-primary mb-5">
        Quizzes
    </h1>
    <div class="page-holder">
        <quizzes-component></quizzes-component>
    </div>
    <div type="button" data-toggle="tooltip" data-placement="top" title="Sed commodo pellentesque tortor quis pretium. Mauris tristique porta mauris eu condimentum. Quisque sed justo in massa blandit porta sit amet nec metus. Sed dolor tortor, tincidunt id volutpat mollis, viverra quis nisl. Sed egestas diam at sapien placerat, eget tincidunt massa sagittis." class="help">
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