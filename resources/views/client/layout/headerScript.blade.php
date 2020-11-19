<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ auth()->user()->transportName }} | {{ config('mohan.website_title') }}</title>
    <link rel="icon" href="{{ auth()->user()->profile_image?asset(auth()->user()->profile_image) :asset(config('mohan.website_logo')) }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.min.css') }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/assets/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/_all-skins.min.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('/assets/js/datatable/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/js/datatable/responsive.bootstrap.min.css') }}">
    <script src="{{ asset('/assets/js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/js/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/js/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/assets/js/datatable/dataTables.bootstrap.min.js') }}"></script>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <link href="{{ asset('/assets/css/select2.min.css') }}" rel="stylesheet" />

    
   <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
   <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
   <link rel="stylesheet" type="text/css" href="https://adminlte.io/themes/AdminLTE/plugins/pace/pace.min.css">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/searchbuilder/1.0.0/css/searchBuilder.dataTables.min.css"/>
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowgroup/1.1.2/css/rowGroup.dataTables.min.css"/>


</head>