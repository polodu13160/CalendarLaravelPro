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
        <header class="header" role="banner">
            Lorem Elsass ipsum lacus leverwurscht Wurschtsalad mamsell Gal. gewurztraminer turpis, suspendisse commodo
            Oberschaeffolsheim ornare aliquam semper Miss Dahlias Mauris turpis sagittis kuglopf eleifend dignissim
            baeckeoffe geht's Richard Schirmeck mollis
            habitant schnaps ante et sit leo schpeck sit Salu bissame Salut bisamme varius quam.
        </header>
        <aside class="aside">
            <nav class="navigation" role="navigation">
                <ul class="navigation-list">
                    <li class="navigation-item"><a class="navigation-link {{$select1 ?? ""}}"
                            href="{{route('fullcalender')}}">Calendar</a></li>
                    <li class="navigation-item"><a class="navigation-link {{$select2 ?? ""}}"
                            href="{{route('welcome')}}">Welcome</a></li>
                    <li class="navigation-item"><a class="navigation-link {{$select3 ?? ""}}" href="">Carola</a></li>
                    <li class="navigation-item"><a class="navigation-link {{$select4 ?? ""}}" href="">Kuglof</a></li>
                    <li class="navigation-item"><a class="navigation-link {{$select5 ?? ""}}" href="">Wurscht</a></li>
                </ul>
            </nav>
            <p>Lorem Salu bissame ! Wie geht's les samis ? Hans apporte moi une Wurschtsalad avec un picon bitte, s'il
                te plaît. Voss ? Une Carola et du Melfor ? Yo dû, espèce de Knäckes, ch'ai dit un picon !</p>
        </aside>

        <main id="main" role="main" class="main">
            {{ $slot }}
        </main>

        <footer class="footer" role="contentinfo">
            Lorem Elsass ipsum lacus leverwurscht Wurschtsalad mamsell Gal. gewurztraminer turpis, suspendisse commodo
            Oberschaeffolsheim ornare aliquam semper Miss Dahlias Mauris turpis sagittis kuglopf, Gal !
        </footer>
    </div>
</body>

</html>