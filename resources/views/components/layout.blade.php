<html lang="fr">

<head>
    <meta charset="UTF-8">
    {{$headSlot ?? ""}}
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Todo Manager' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="website">
        <aside class="aside">
            <nav class="navigation" role="navigation">
                <ul class="navigation-list">
                    <li class="navigation-item"><a class="navigation-link {{$select1 ?? ""}}"
                            href="{{route('fullcalendar')}}">Calendar</a></li>
                    <li class="navigation-item"><a class="navigation-link {{$select2 ?? ""}}"
                            href="{{route('welcome')}}">Welcome</a></li>
                    <li class="navigation-item"><a class="navigation-link {{$select3 ?? ""}}" href="">Activités</a></li>
                    <li class="navigation-item"><a class="navigation-link {{$select4 ?? ""}}" href="">RDV</a></li>
                    <li class="navigation-item"><a class="navigation-link {{$select5 ?? ""}}" href="">Appels</a></li>
                </ul>
            </nav>
        </aside>

        <main id="main" role="main" class="main">
            {{ $slot }}
        </main>

        <footer class="footer" role="contentinfo">
            Copyleft 2024
        </footer>
    </div>
</body>

</html>