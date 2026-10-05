<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Rastreo de paquetes')</title>
    <style>
        :root {
            --navy: #10243B; --ink: #1C2B3A; --paper: #F6F8FA; --line: #D5DEE6;
            --tape: #F5B800; --sea: #0E7C86; --ok: #1E7A4A; --bad: #B3321F;
            --font: "Segoe UI", system-ui, -apple-system, Roboto, Helvetica, Arial, sans-serif;
        }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: var(--font); color: var(--ink); background: var(--paper); line-height: 1.5; }
        a { color: var(--sea); }
        :focus-visible { outline: 3px solid var(--tape); outline-offset: 2px; }
        .bar { background: var(--navy); color: #fff; padding: 14px 20px; display: flex; justify-content: space-between; align-items: center; }
        .bar strong { font-size: 1.05rem; }
        .bar a, .bar button { color: #fff; background: none; border: 0; font: inherit; cursor: pointer; text-decoration: underline; }
        main { max-width: 760px; margin: 0 auto; padding: 28px 20px 60px; }
        h1 { font-size: clamp(1.7rem, 5vw, 2.4rem); line-height: 1.15; margin: 0 0 8px; color: var(--navy); }
        h2 { font-size: 1.15rem; margin: 32px 0 12px; color: var(--navy); }
        label { display: block; font-weight: 600; margin: 14px 0 4px; }
        input, select { width: 100%; padding: 11px 12px; font: inherit; border: 1px solid var(--line); border-radius: 6px; background: #fff; }
        .btn { margin-top: 16px; padding: 12px 20px; font: inherit; font-weight: 700; color: var(--navy); background: var(--tape); border: 0; border-radius: 6px; cursor: pointer; }
        .btn:hover { filter: brightness(.95); }
        .grid { display: grid; gap: 0 16px; grid-template-columns: 1fr 1fr; }
        @media (max-width: 560px) { .grid { grid-template-columns: 1fr; } }
        .msg { padding: 12px 14px; border-radius: 6px; margin: 16px 0; }
        .msg.ok { background: #E4F3EA; color: var(--ok); }
        .msg.bad { background: #FBE9E6; color: var(--bad); }
        .errors { margin: 0; padding-left: 18px; }
        table { width: 100%; border-collapse: collapse; background: #fff; border: 1px solid var(--line); }
        th, td { text-align: left; padding: 10px 12px; border-bottom: 1px solid var(--line); font-size: .93rem; }
        th { background: #EDF1F5; }
        .scroll { overflow-x: auto; }
        .route { list-style: none; margin: 24px 0; padding: 0 0 0 22px; border-left: 3px solid var(--line); }
        .route li { position: relative; padding: 0 0 18px 18px; color: #6B7C8C; }
        .route li::before { content: ""; position: absolute; left: -31px; top: 3px; width: 15px; height: 15px; border-radius: 50%; background: var(--paper); border: 3px solid var(--line); }
        .route li.done { color: var(--ink); }
        .route li.done::before { background: var(--sea); border-color: var(--sea); }
        .route li.now { font-weight: 700; color: var(--navy); }
        .route li.now::before { background: var(--tape); border-color: var(--navy); }
        .now-box { background: var(--navy); color: #fff; padding: 20px; border-radius: 8px; margin-top: 22px; }
        .now-box .big { font-size: 1.6rem; font-weight: 700; }
        .muted { color: #5B6B7A; font-size: .92rem; }
        .hist { list-style: none; padding: 0; margin: 0; }
        .hist li { padding: 10px 0; border-bottom: 1px solid var(--line); }
    </style>
</head>
<body>
    <header class="bar">
        <strong>Rastreo de paquetes</strong>
        @auth
            <span>
                <a href="{{ route('tracking.index') }}">Ver página de clientes</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">@csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            </span>
        @endauth
    </header>
    <main>@yield('content')</main>
</body>
</html>
