 <!-- /resources/views/layouts/app.blade.php -->
 <!doctype html>
 <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">

     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">

     <title>{{ config('app.name', 'Laravel') }}</title>

     <!-- Fonts -->
     <link rel="dns-prefetch" href="//fonts.bunny.net">
     <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

     <!-- Scripts -->

     @vite(['resources/sass/app.scss'])
     @stack('css')
 </head>

 <body>
     <div id="app">
         @include('layouts.header')
         <main class="py-4">
             @yield('content')
         </main>
     </div>
     @stack('scripts')
     @vite(['resources/js/app.js'])
     <script type="module">
     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
     </script>

 </html>