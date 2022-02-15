<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>The Art of Pete Vitalez</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta property="og:title" content="The Art of Pete Vitalez">
    <meta property="og:description" content="The Official Website of The Maestro, Pete Vitalez">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('assets/default-square.png') }}">
    <meta property="og:image:alt" content="{{ asset('assets/default-square.png') }}">
    <meta property="og:url" content="The Art of Pete Vitalez">
    @routes
</head>
<body>
    @if (Auth::check())
        @php
            $user_auth_data = [
                'isLoggedin' => true,
                'user' =>  Auth::user()
            ];
        @endphp
    @else
        @php
            $user_auth_data = [
                'isLoggedin' => false
            ];
        @endphp
    @endif
    <script>
        window.Laravel = JSON.parse(atob('{{ base64_encode(json_encode($user_auth_data)) }}'));
    </script>
    <div id="app"></div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
