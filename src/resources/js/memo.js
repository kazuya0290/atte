//ログインしましたというアラートメッセージを１度だけ表示する方法：

//スクリプトの位置: home.blade.php 内で < script > タグを使用して JavaScript コードを記述していますが、スクリプトを < script > タグ内に直接書くと、ページの読み込み順序や document.getElementById が正しく動作しないことがあります。特に、@section('scripts') の中でスクリプトが定義されているため、layouts.app2 で @yield('scripts') が適切に呼び出されているか確認する必要があります。

//セッションストレージのキーとバリュー: sessionStorage のキーとバリューが一致しているか確認し、ログイン時にアラートが正しく表示されるようにします。

//スクリプトの最適化: JavaScript コードが正しく動作するように、ログイン時のアラートとログアウトの処理を別々に管理する方法を検討します。


/*
@extends ('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/home.css')}}">
    @endsection

    @section('content')
    @if (Auth::check())
    <div class="home-form">
        <h2 class="home-form__heading"><?php $user = Auth::user(); ?>{{ optional($user)-> name}}さんお疲れ様です！</h2>
    </div>

    <div class="attendance1">
        <button type="submit" class="start__btn">勤務開始</button>
        <button type="submit" class="end__btn">勤務終了</button>
    </div>

    <div class="attendance2">
        <button type="submit" class="rest_start__btn">休憩開始</button>
        <button type="submit" class="rest_end__btn">休憩終了</button>
    </div>
    @else
    <h2 class="home-form__heading"><a href="/login">ログイン</a>してください</h2>
    @endif
    @endsection

    @section('scripts')
    <script>
document.addEventListener('DOMContentLoaded', () => {
  const sessionKey = "login";
        const sessionValue = true;

        // ログイン時にアラートを表示する
        if (!sessionStorage.getItem(sessionKey)) {
            alert('ログインしました');
        sessionStorage.setItem(sessionKey, sessionValue);
  }

        // ログアウトボタンの設定
        const logoutButton = document.getElementById("logout");
        const logoutForm = document.getElementById("logout-form");

        if (logoutButton) {
            logoutButton.addEventListener('click', (event) => {
                event.preventDefault(); // リンクのデフォルト動作を防ぐ
                if (logoutForm) {
                    logoutForm.submit(); // フォームを送信
                }
                sessionStorage.clear(); // セッションストレージをクリア
            });
  }
});
    </script>
    @endsection

    説明
スクリプトの位置: @section('scripts') でスクリプトを定義し、layouts.app2 で @yield('scripts') を呼び出しているため、スクリプトがページの最後にロードされるようにしています。これにより、DOM の要素がすべて読み込まれてからスクリプトが実行されます。

セッションストレージの確認: sessionStorage.getItem(sessionKey) を使って、sessionStorage に保存されたキーをチェックし、アラートを表示します。ログイン時にアラートが表示され、sessionStorage に値が保存されます。次回以降はアラートが表示されません。

ログアウト処理: ログアウトボタンがクリックされると、フォームが送信され、セッションストレージがクリアされます。アラートの表示を省略しましたが、必要であれば追加できます。

確認事項
layouts.app2 におけるスクリプトの呼び出し: layouts.app2 において @yield('scripts') が適切に配置されていることを確認してください。スクリプトが正しく読み込まれるようにするため、<body> タグの直前に @yield('scripts') を配置するのが一般的です。

ブラウザのキャッシュ: スクリプトを修正した後、ブラウザのキャッシュをクリアするか、ハードリロードを行って変更を反映させてください。

これらの修正を行った後、再度動作を確認してみてください。もしまだ問題が解決しない場合は、ブラウザのコンソールに表示されるエラーメッセージを確認することをお勧めします。

@section('scripts') の使用
@section('scripts') と <script></script> の組み合わせは、Blade テンプレートエンジンを使って、ページごとに異なる JavaScript を追加するための一般的な方法です。この方法は、特定のページに必要なスクリプトをそのページ内で定義し、共通のレイアウトファイル（例: app2.blade.php）でそのスクリプトを呼び出すという方法です。

利点:
ページごとのカスタマイズ: ページごとに異なるスクリプトを簡単に追加できる。
コードの分割: スクリプトを関連するビュー内で管理でき、可読性が高くなる。
欠点:
複雑性: 多くのページで異なるスクリプトを使用する場合、管理が複雑になる可能性があります。
再利用性: 共通のスクリプトを複数のページで使用する場合、同じコードを繰り返し記述する必要があります。
外部 JavaScript ファイルの使用
外部の JavaScript ファイルを作成し、それをテンプレートに読み込ませる方法もあります。この方法では、@yield('scripts') を使わなくても済むようになります。

方法:
外部 JavaScript ファイルを作成: public/js/ フォルダに JavaScript ファイルを作成します（例: public/js/app.js）。

javascript
コードをコピーする
// public/js/app.js
document.addEventListener('DOMContentLoaded', () => {
    const sessionKey = "login";
    const sessionValue = true;

    if (!sessionStorage.getItem(sessionKey)) {
        alert('ログインしました');
        sessionStorage.setItem(sessionKey, sessionValue);
    }

    const logoutButton = document.getElementById("logout");
    const logoutForm = document.getElementById("logout-form");

    if (logoutButton) {
        logoutButton.addEventListener('click', (event) => {
            event.preventDefault();
            if (logoutForm) {
                logoutForm.submit();
            }
            sessionStorage.clear();
        });
    }
});
共通レイアウトファイルにスクリプトを追加: app2.blade.php など、共通のレイアウトファイルでスクリプトを読み込みます。

<!DOCTYPE html>
<html lang="ja">
<head>
  <!-- 省略 -->
</head>
<body>
  <!-- 省略 -->
  <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
defer 属性を使うことで、ページの解析が終わった後にスクリプトが実行されます。

利点:
コードの再利用: 複数のページで同じスクリプトを使う場合、一つのファイルにまとめて管理できる。
スクリプトの整理: 大きなアプリケーションでは、JavaScript を外部ファイルで管理することでコードが整理され、保守性が向上します。
欠点:
ページごとのカスタマイズが難しい: 外部ファイルに記述するスクリプトが特定のページに依存する場合、条件に応じた処理が複雑になる可能性があります。
結論
@section('scripts') の使用: ページごとに異なるスクリプトを管理したい場合や、特定のビューでのみスクリプトを実行したい場合に便利です。
外部 JavaScript ファイルの使用: 共通のスクリプトや再利用性が高いスクリプトを管理するのに適しています。
あなたのプロジェクトの規模やニーズに応じて、どちらの方法を選ぶか決定するのが良いでしょう。一般的には、共通のスクリプトや大規模なアプリケーションでは外部 JavaScript ファイルを使い、ページごとの特殊なスクリプトが必要な場合には @section('scripts') を使うのが効果的です。




