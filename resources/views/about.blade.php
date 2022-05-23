@extends('layouts.master')
@section("content")
<div class="home-page main-page about">
    <h1 class="heading-primary">
        About
    </h1>
    {{-- <h2 class="heading-secondary">Providing education to everyone.</h2>--}}
    <p>
        Chronic disease is the leading cause of death and disability in the United States. Unfortunately, chronic
        disease management can be a complex and difficult experience for patients. Patients are tasked with
        medication adherence, lifestyle changes, and navigating the health care system. Health literacy is a
        necessary skill for patients to successfully manage chronic conditions. However, it has been reported that
        only 12% of American adults have proficient health literacy, and 30% have low health literacy. Low health
        literacy is associated with poor medical management and worse clinical outcomes.
    </p>
    <div class="our-mission">
        <h1 class="heading-primary">
            Our Mission
        </h1>

        <p>
            We aim to improve health literacy for all patients using digital health education.
        </p>
    </div>
    {{-- <div class=" team-members">--}}
    {{-- <div class="image">--}}
    {{-- <img src="img/alex.png" alt="">--}}
    {{-- </div>--}}
    {{-- <div class="desc">--}}
    {{-- <h3>Alex Rosenberg, MD</h3>--}}
    {{-- <hr class="green-line">--}}
    {{-- <p>Alex earned a Bachelor of Arts in Biological Basis of Behavior at the University of Pennsylvania. He--}}
    {{-- worked with Teacher For America as a middle school math teacher in San Pablo, California. He then--}}
    {{-- attended Albert Einstein College of Medicine and earned a Doctor of Medicine (M.D.). Currently, he is--}}
    {{-- completing his third year of internal medicine residency at LAC+USC Medical Center. Next, he will be a--}}
    {{-- hospitalist at LAC+USC Medical Center and a clinical assistant professor of medicine at the Keck School--}}
    {{-- of Medicine of USC.</p>--}}
    {{-- </div>--}}
    {{-- </div>--}}
    {{-- <div class=" team-members">--}}
    {{-- <div class="desc">--}}
    {{-- <h3>Ketetha Olengue, MD</h3>--}}
    {{-- <hr class="green-line">--}}
    {{-- <p>Ketetha earned a Bachelor of Science in Computer Science and a Bachelor of Arts in Chemistry at Southern--}}
    {{-- Methodist University. She is currently an M.D. Candidate at Keck School of Medicine at the University of--}}
    {{-- Southern California and is expected to graduate in May 2020 with a Graduate Certificate in Health,--}}
    {{-- Technology, and Engineering. She plans to complete her residency in Psychiatry & Behavioral Sciences at--}}
    {{-- a program of her choosing and to complete a two-year fellowship in Clinical Informatics and a one-year--}}
    {{-- fellowship in Forensic Psychiatry.--}}
    {{-- <br>--}}
    {{-- <br>--}}
    {{-- Ketetha enjoys traveling, spending time with her pup Ushii, film--}}
    {{-- photography, spending time in nature, and is currently working on her meditation practice daily..--}}
    {{-- </p>--}}
    {{-- </div>--}}
    {{-- <div class="image">--}}
    {{-- <img src="img/ketetha.png" alt="">--}}
    {{-- </div>--}}
    {{-- </div>--}}
    <div class="team">
        <h2>Team</h2>
        <p>We are a team of physicians and medical students devoted to improving health literacy for all patients.
            We have experience in clinical medicine, education, and technology.</p>
        {{-- <div class="team-grid">--}}
        {{-- <div class="team-grid_member">--}}
        {{-- <div class="image">--}}
        {{-- <img src="img/alex.png" alt="alex">--}}
        {{-- </div>--}}

        {{-- <h3>Alex Rosenberg, MD</h3>--}}
        {{-- <hr class="green-line">--}}
        {{-- <p>--}}
        {{-- Alex earned a Bachelor of Arts in Biological Basis of Behavior at the University of--}}
        {{-- Pennsylvania. He--}}
        {{-- worked with Teacher For America as a middle school math teacher in San Pablo, California. He--}}
        {{-- then--}}
        {{-- attended Albert Einstein College of Medicine and earned a Doctor of Medicine (M.D.). Currently,--}}
        {{-- he is--}}
        {{-- completing his third year of internal medicine residency at LAC+USC Medical Center. Next, he--}}
        {{-- will be a--}}
        {{-- hospitalist at LAC+USC Medical Center and a clinical assistant professor of medicine at the Keck--}}
        {{-- School--}}
        {{-- of Medicine of USC.--}}

        {{-- </p>--}}
        {{-- </div>--}}
        {{-- <div class="team-grid_member">--}}
        {{-- <div class="image">--}}
        {{-- <img src="img/ketetha.png" alt="ketetha">--}}
        {{-- </div>--}}

        {{-- <h3>Ketetha Olengue, MD</h3>--}}
        {{-- <hr class="green-line">--}}
        {{-- <p>--}}
        {{-- Ketetha earned a Bachelor of Science in Computer Science and a Bachelor of Arts in Chemistry at--}}
        {{-- Southern--}}
        {{-- Methodist University. She is currently an M.D. Candidate at Keck School of Medicine at the--}}
        {{-- University of--}}
        {{-- Southern California and is expected to graduate in May 2020 with a Graduate Certificate in--}}
        {{-- Health,--}}
        {{-- Technology, and Engineering. She plans to complete her residency in Psychiatry & Behavioral--}}
        {{-- Sciences at--}}
        {{-- a program of her choosing and to complete a two-year fellowship in Clinical Informatics and a--}}
        {{-- one-year--}}
        {{-- fellowship in Forensic Psychiatry.--}}
        {{-- <br>--}}
        {{-- <br>--}}
        {{-- Ketetha enjoys traveling, spending time with her pup Ushii, film--}}
        {{-- photography, spending time in nature, and is currently working on her meditation practice--}}
        {{-- daily..--}}
        {{-- </p>--}}
        {{-- </div>--}}
        {{-- </div>--}}
    </div>

</div>
<footer>
    <div>
        <div class="logo">
            {{-- <img src="img/logo.png" alt="">--}}
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
