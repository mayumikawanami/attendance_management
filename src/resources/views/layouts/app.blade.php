<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance_management</title>
    <!-- <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" /> -->
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')
</head>
<body>
    <div class="app">
        <div class="header">
            <h1 class="header__heading">Atte</h1>
            @yield('link')
        </div>
        <div class="content">
        @yield('content')
        </div>
        <div class="footer">
            <p class="footing">Atte,inc.</p>
        </div>
    </div>
</body>
</html>