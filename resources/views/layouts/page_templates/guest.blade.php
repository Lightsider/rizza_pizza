<div id="app">
    @include('layouts.navbars.navs.guest')
    <div class="wrapper wrapper-full-page">
        <div class="page-header login-page header-filter" filter-color="black"
             style="background-image: url('{{ asset('material') }}/img/login.jpg'); background-size: cover; background-position: top center;align-items: center;"
             data-color="purple">
            <div class="container justify-content-center mt-5">
                <div class="row" >
                    @yield('content')
                </div>
                @include('layouts.footers.guest')
            </div>
        </div>
    </div>
</div>