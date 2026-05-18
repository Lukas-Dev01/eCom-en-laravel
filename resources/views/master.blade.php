<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <title>CartFuse</title>
</head> 
<body>

{{View::make('header')}}
    @yield('content')
{{View::make('footer')}}
<button class="back-to-top" type="button" data-back-to-top aria-label="Back to top">
    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
        <path d="M12 5.25 4.8 12.45a1 1 0 0 0 1.4 1.42L11 9.08V18a1 1 0 1 0 2 0V9.08l4.8 4.79a1 1 0 0 0 1.4-1.42L12 5.25Z"/>
    </svg>
</button>
</body>


</html>
