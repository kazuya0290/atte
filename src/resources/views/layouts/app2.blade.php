<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Atte</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/common2.css') }}" />
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <div class="header-utilities">
      <a class="header__logo" href="/">
        Atte
      </a>
      <nav>
        @if(Auth::check())
         <ul class="header-nav">
             <a class="header-nav__link" href="/">ホーム</a>
             <a class="header-nav__link" href="/attendance"> 日付一覧</a>
             <a href="#" id="logout" class="header-nav__link" >ログアウト</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
         </ul>
       </nav>
       @else
                <ul disable></ul>
                @endif
       </header>
       <main>
        @if(Auth::check())
    <script>
        document.getElementById('logout').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('logout-form').submit();
        alert("ログアウトしました");
        });
    </script>
@endif
    @yield('content')
        </main>
       <footer class="footer">
        <small>&copy; Atte, Inc.</small>
      </footer>
      @yield('scripts')
     </div>
    </div>
</body>

</html>