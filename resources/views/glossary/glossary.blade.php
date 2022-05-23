@extends('layouts.master')
@section("content")
<div class="home-page">
    <h1 class="heading-primary">
        Glossary
    </h1>
    <h2 class="heading-secondary">Morbi et sapien id augue imperdiet lobortis.</h2>
    <div class="form-search">
        <div class="input-group">
            <span class="input-group-prepend">
                <div class="input-group-text bg-transparent border-right-0">
                    <i class="fa fa-search"></i>
                </div>
            </span>
            <input class="form-control py-2 border-left-0 border" type="search" placeholder="Search" id="example-search-input" />
        </div>
        <div class="dropdown topic">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Topic
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="cardiovascular">
                    <label class="form-check-label" for="exampleCheck1">Cardiovascular</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="respiratory">
                    <label class="form-check-label" for="exampleCheck1">Respiratory</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="infectious">
                    <label class="form-check-label" for="exampleCheck1">Infectious diseases</label>
                </div>
            </div>
        </div>
        <div class="dropdown sort">
            <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Sort
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="popular">
                    <label class="form-check-label" for="exampleCheck1">Popular</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="nameAZ">
                    <label class="form-check-label" for="exampleCheck1">Name, A-Z</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="nameZA">
                    <label class="form-check-label" for="exampleCheck1">Name, Z-A</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="newest">
                    <label class="form-check-label" for="exampleCheck1">Newest</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="oldest">
                    <label class="form-check-label" for="exampleCheck1">Oldest</label>
                </div>
            </div>
        </div>
    </div>


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