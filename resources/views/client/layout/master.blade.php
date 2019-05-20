<!DOCTYPE html>
<html>
    @include('client.layout.headerScript')
    <body class="hold-transition sidebar-mini skin-black-light">
        <div class="wrapper">
            <!-- header -->
            @include('client.layout.header')
        <!-- color for side bar -->

            <!-- Nav Bar -->
            @include('client.layout.navbar')
            <!-- Content -->
                <div class="content-wrapper">
                    <section class="content">
                        @include('errors')
                        @yield('content')

                    </section>
                </div>
            <!-- End Content -->

            <!-- Footer -->
            @include('client.layout.footer')
        <!-- End Footer -->
        </div>
    </body>
</html>