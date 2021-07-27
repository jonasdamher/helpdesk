@include('includes.head')

@include('includes.nav')
<div class="d-flex">
    @include('includes.menu')
    <div class="d-flex flex-column ml-navbar pt-3 w-100">
        <main class="container-fluid">
            <div class="row">
                @section('main')
                @show
            </div>
        </main>
        @include('includes.footer')
    </div>
</div>
@include('includes.tail')