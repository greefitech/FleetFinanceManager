<!DOCTYPE html>
<html>
{{--     <script>
        window.__pushpro = {
            site_uuid: "1f43eb66-a2bf-4959-bc43-0950b95afe25",
        }
    </script>
    <script src="https://storage.googleapis.com/push-pro-java-scripts/pushpro-lib.js"></script> --}}
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
    @if(env('APP_ENV') == 'production')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-92345002-2"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-92345002-2');
        </script>
    @endif
</html>