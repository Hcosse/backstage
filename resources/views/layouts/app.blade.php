<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - BackSports-Events</title>
  <link rel="stylesheet" href="{{ asset('css\style.css') }}">
  @yield('css')
</head>
<body>
  <header class="site-header">
    <div class="header-inner">
      <h1 class="site-logo">BackSports-Events</h1>
      <nav class="main-nav">
        <ul>
          <li><a href="{{ url('/') }}">Accueil</a></li>
          <li><a href="{{ route('events.index') }}">Événements</a></li>
          @if(Auth::check())
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li>
              <a href="{{ route('logout') }}"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Déconnexion
              </a>
            </li>
          @else
            <li><a href="{{ route('login.form') }}">Connexion</a></li>
            <li><a href="{{ route('register.form') }}">Inscription</a></li>
          @endif
        </ul>
      </nav>
    </div>
    @if(Auth::check())
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    @endif
  </header>

  <main class="main-content container">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @yield('content')
  </main>

  <footer class="site-footer">
    <p>&copy; {{ date('Y') }} SportEvents. Tous droits réservés.</p>
  </footer>

  <script src="{{ asset('js\app.js') }}"></script>
  @yield('scripts')
</body>
</html>
