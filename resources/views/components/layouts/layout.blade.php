<!DOCTYPE html>
<html lang={{ str_replace('_', '-', app()->getLocale()) }}>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Отслеживаем продукты глобально' }}</title>
    </head>
    <body>
        <header></header>
        <main>
            {{ $slot }}
        </main>
        <footer>
            <p>by Джипи-Не-Разработчик</p>
        </footer>
    </body>
</html>
