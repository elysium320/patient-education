@extends('layouts.master')
@section("content")
<div class="home-page main-page">
    <h1 class="heading-primary">

        {{ __('Welcome to Patient Education 101') }}
    </h1>
    {{-- <h2 class="heading-secondary">Providing education to everyone.</h2>--}}
    <div class="home-grid">
        <div class="image">
            <img src="/img/homepage.png" alt="">
        </div>
        <div class="description">
            {{-- <div class="input-group">--}}
            {{-- <span class="input-group-prepend">--}}
            {{-- <div class="input-group-text bg-transparent border-right-0">--}}
            {{-- <i class="fa fa-search"></i>--}}
            {{-- </div>--}}
            {{-- </span>--}}
            {{-- <input  class="form-control py-2 border-left-0 border" type="search"--}}
            {{-- placeholder="Search" id="example-search-input" />--}}
            {{-- </div>--}}
            <hr class="green-line">
            <p> {{__('We aim to improve health literacy for all patients.')}}
                <a href="{{ route('modules', app()->getLocale()) }}" class="default-btn default-btn-center">{{__('Get Started')}}</a>
            </p>
        </div>
    </div>
    <div class="modules">
        <h3>{{ __('Make a selection to get started')}}</h3>
        <div class="d-grid-content">
            <a href="{{ route('modules', app()->getLocale()) }}" class="module">
                <img src="/img/modules.png" alt="" />
                <span class="heading-ternary">{{ __('Modules')}}</span>
            </a>
            <a href="{{ route('lessons', app()->getLocale()) }}" class="module">
                <img src="/img/analytics.png" alt="" />
                <span class="heading-ternary">{{ __('Lessons')}}</span>
            </a>
            <a href="{{ route('quizzes', app()->getLocale()) }}" class="module">
                <img src="/img/account.png" alt="" />
                <span class="heading-ternary">{{ __('Quizzes')}}</span>
            </a>

        </div>
    </div>
    <button id="open-modal" class="triger-modal" data-triger="modal-demo">Open Modal</button>
    <div class="modal-wrap" id="modal-demo">
        <div class="modal-container">
            <div class="modal-header">
            <h2 class="modal-title">Modal Title</h2>
            <button class="close-modal">&times;</button>
            </div>
            <div class="modal-content">
            <h3>Modal inner heading tag H3</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestiae itaque quaerat animi praesentium accusamus
                expedita rerum unde ipsum nihil est officia, quisquam sunt reiciendis, omnis placeat distinctio similique
                illum minus.</p>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestiae itaque quaerat animi praesentium accusamus
                expedita rerum unde ipsum nihil est officia, quisquam sunt reiciendis, omnis placeat distinctio similique
                illum minus.</p>
            </div>
            <div class="modal-footer">
            <p>Modal footer</p>
            </div>
        </div>
    </div>

</div>
<footer>
    <div>
        <div class="logo">
            {{-- <img src="/img/logo.png" alt="">--}}
            <!-- <p>Patient Education That Stands <br> Above The Rest.</p> -->
        </div>
        <div class="follow-contact">
            <h3>Follow</h3>
            <div class="d-flex">
                <i class="fab fa-facebook"></i>
                <i class="fab fa-instagram"></i>
            </div>
            <h3 class="contact">Contact</h3>
            <a href="mailto:patienteducation101@gmail.com">patienteducation101@gmail.com</a>
        </div>
        <div class="links">
            <h3>Quick Links</h3>
            <a href="/about">About</a>
            <a href="{{__('modules')}}">Modules</a>
            <a href="{{__('quizzes')}}">Quizzes</a>
            <a href="">Contact</a>
        </div>
        <div class="email-us">
            <h3>Sign up to be alerted of new courses.</h3>
            <div class="d-flex align-center">
                <input type="email" placeholder="Your Email">
                <button>Submit</button>
            </div>
        </div>
    </div>
    <hr class="footer-line">
    <div class="rights">
        <p class='disclaimer'>{{ __('All content is for informational purposes only. The content is not a substitute for professional medical advice, diagnosis or treatment. Please seek the advice of you doctor or other qualified health provider with questions you have regarding a medical condition.') }}</p>
        <div>
            <a href="">Privacy Policy</a>
            <span>|</span>
            <a href="">Terms and Conditions.</a>
        </div>
    </div>
</footer>

@endsection
<script>
    
    
    window.addEventListener('load', function() {
        var modal = document.getElementById('modal-demo');
        console.log(modal);
        modal.classList.toggle('visible');
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
