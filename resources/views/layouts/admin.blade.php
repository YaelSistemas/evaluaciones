<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin · '.config('app.name'))</title>

  {{-- Si luego quieres mover estilos a /public/css/admin.css, quita el <style> y agrega: --}}
  {{-- <link rel="stylesheet" href="{{ asset('css/admin.css') }}"> --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <style>
    :root{
      --topbar:#0f172a;      /* azul muy oscuro */
      --sidebar:#111827;     /* gris carbón */
      --sidebar-hov:#1f2937;
      --sidebar-act:#374151;
      --txt:#111;
      --muted:#6b7280;
      --border:#e5e7eb;
      --bg:#f3f4f6;
      --white:#fff;
    }
    *{box-sizing:border-box}
    body{margin:0;background:var(--bg);font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,"Noto Sans",sans-serif;color:var(--txt)}

    /* Topbar */
    .admin-topbar{
      height:48px;background:var(--topbar);color:#fff;
      display:flex;align-items:center;justify-content:space-between;
      padding:0 20px
    }
    .admin-topbar a{color:#e5e7eb;text-decoration:none;margin-left:14px}
    .admin-topbar a:hover{color:#fff}

    /* Layout principal */
    .admin-wrapper{display:flex;min-height:calc(100vh - 48px)}
    .admin-sidebar{
      width:220px;background:var(--sidebar);color:#e5e7eb;padding:16px
    }
    .admin-sidebar nav a{
      display:block;color:#e5e7eb;text-decoration:none;
      padding:8px 10px;border-radius:6px;margin-bottom:6px
    }
    .admin-sidebar nav a:hover{background:var(--sidebar-hov)}
    .admin-sidebar nav a.active{background:var(--sidebar-act);color:#fff;font-weight:700}
    .admin-main{
      flex:1;background:var(--white);padding:20px;min-width:0 /* evita overflow en tablas */
    }
  </style>
</head>
<body>

  <!-- TOPBAR -->
  <div class="admin-topbar">
    <div><strong>Panel Admin</strong> · {{ config('app.name') }}</div>
    <div>
      <a href="{{ route('dashboard') }}">Volver al sitio</a>
      <a href="{{ route('logout') }}"
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Cerrar sesión
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
      </form>
    </div>
  </div>

  <!-- SIDEBAR + MAIN -->
  <div class="admin-wrapper">
    <aside class="admin-sidebar">
      <nav>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Usuarios</a>
        {{-- agrega más secciones aquí --}}
      </nav>
    </aside>

    <main class="admin-main">
      @yield('content')
    </main>
  </div>

</body>
</html>
