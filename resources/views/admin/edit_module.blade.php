@extends('layouts.master')
@section("content")
<div class="home-page">
    <h1 class="heading-primary">
        Edit Module - {{ $module->title }}
    </h1>
    <h2 class="heading-secondary">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In facilisis <br>
        lacus id nisi faucibus semper. Morbi et sapien id augue imperdiet lobortis.</h2>

    <update-drag-component :module="{{ $module }}"></update-drag-component>

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

</script>