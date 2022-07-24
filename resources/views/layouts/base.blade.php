<!doctype html>
 <html lang="en">
 <head>
 <meta charset="UTF-8">
 <title></title>
 </head>
 <body>
    <div class="row">@include('layouts.nav')</div>
 @yield('body')
 @include('layouts.header')
{{--  <script src="{{ mix('js/app.js') }}"></script> --}}
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    @stack('scripts')
 </body>
 </html>