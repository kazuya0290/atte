@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
@if (Auth::check())
<div class="home-form">
  <h2 class="home-form__heading">{{ Auth::user()->name }}さんお疲れ様です！</h2>
  <div id="timer" class="timer"></div>
</div>

<div class="attendance1">
    <button type="button" class="start__btn">勤務開始</button>
    <button type="button" class="end__btn" disabled>勤務終了</button>
</div>

<div class="attendance2">
    <button type="button" class="rest_start__btn" disabled>休憩開始</button>
    <button type="button" class="rest_end__btn" disabled>休憩終了</button>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const sessionKey = "login";
    const sessionValue = true;

    const startButton = document.querySelector('.start__btn');
    const endButton = document.querySelector('.end__btn');
    const restStartButton = document.querySelector('.rest_start__btn');
    const restEndButton = document.querySelector('.rest_end__btn');

    const BUTTON_STATE_KEY = 'buttonState';
    let timerInterval;
    let endTime;
    let timerRunning = false;
    let restStartTime;

    function resetButtonStates() {
        startButton.disabled = false;  
        endButton.disabled = true;    
        restStartButton.disabled = true; 
        restEndButton.disabled = true;  
    }

    
    if (!sessionStorage.getItem(sessionKey)) {
        alert('ログインしました');
        sessionStorage.setItem(sessionKey, sessionValue);

        
        resetButtonStates();
        localStorage.setItem(BUTTON_STATE_KEY, JSON.stringify({
            startButton: false,  
            endButton: true,     
            restStartButton: true, 
            restEndButton: true   
        }));
    } else {
        
        updateButtonStates();
    }

    function updateButtonStates() {
        const savedState = JSON.parse(localStorage.getItem(BUTTON_STATE_KEY) || '{}');
        if (savedState) {
            startButton.disabled = savedState.startButton ?? false;
            endButton.disabled = savedState.endButton ?? true;
            restStartButton.disabled = savedState.restStartButton ?? true;
            restEndButton.disabled = savedState.restEndButton ?? true;
        } else {
            resetButtonStates();
        }
    }

    function saveButtonState() {
        localStorage.setItem(BUTTON_STATE_KEY, JSON.stringify({
            startButton: startButton.disabled,
            endButton: endButton.disabled,
            restStartButton: restStartButton.disabled,
            restEndButton: restEndButton.disabled
        }));
    }

    updateButtonStates();

    startButton.addEventListener('click', function() {
        startButton.disabled = true;  
        endButton.disabled = false;  
        restStartButton.disabled = false;
        restEndButton.disabled = true; 

        saveButtonState();  

        fetch('{{ route('attendance.start') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: new URLSearchParams({})
        }).then(response => response.json())
          .then(data => {
              alert('勤務開始時刻が記録されました');
          })
    });

    endButton.addEventListener('click', function() {
        startButton.disabled = true;  
        endButton.disabled = true;    
        restStartButton.disabled = true; 
        restEndButton.disabled = true; 

        saveButtonState();  

        fetch('{{ route('attendance.end') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: new URLSearchParams({})
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  document.getElementById('total_time').textContent = data.total;
                  alert('勤務終了時刻が記録されました、ログアウトをお忘れなく。');
              } else {
                  alert('勤務終了時刻が記録されました、ログアウトをお忘れなく。');
              }
          }).catch(error => {
              console.error('Error:', error);
              alert('勤務終了時刻が記録されました、ログアウトをお忘れなく。');
          });
    });

    
    restStartButton.addEventListener('click', function() {
        const minutes = parseInt(prompt('休憩時間を分単位で入力してください', '60'));

        if (isNaN(minutes) || minutes <= 0) {
            alert('正しい休憩時間を入力してください。');
            return;
        }

        restStartTime = new Date();

        document.getElementById('timer').style.display = 'block'; 
        document.getElementById('timer').textContent = '00:00'; 
        
         endTime = Date.now() + minutes * 60000;
        clearInterval(timerInterval);
        timerInterval = setInterval(updateTimer, 1000);

        alert('休憩を開始します。休憩を中断する場合は休憩終了ボタンをクリックしてください。');

        endButton.disabled = true; 
        restEndButton.disabled = false;
        restStartButton.disabled = true;

        saveButtonState(); 
        timerRunning = true;
    });
   
    restEndButton.addEventListener('click', function() {
        if (timerRunning) {
            clearInterval(timerInterval);
            document.getElementById('timer').style.display = 'none';
            alert('休憩終了ボタンが押されました。');

            fetch('{{ route('attendance.recordRest') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: new URLSearchParams({
                    rest_start_time: restStartTime.toISOString().slice(0, 19).replace('T', ' '),
                    rest_end_time: new Date().toISOString().slice(0, 19).replace('T', ' ')
                })
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      document.getElementById('rest_time').textContent = data.rest_time;
                  } else {
                      alert('休憩終了時刻を登録しました。');
                  }
              }).catch(error => {
                  console.error('Error:', error);
                  alert('休憩終了時刻を登録しました。');
              });
                endButton.disabled = false;
            localStorage.setItem(BUTTON_STATE_KEY, JSON.stringify({
                startButton: false,
                endButton: false,
                restStartButton: true,
                restEndButton: true
            }));
            restEndButton.disabled = true;
            restStartButton.disabled = false;
            timerRunning = false;
        } else {
            alert('休憩を終了します');
            document.getElementById('timer').style.display = 'none';
            fetch('{{ route('attendance.recordRest') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: new URLSearchParams({
                    rest_start_time: restStartTime.toISOString().slice(0, 19).replace('T', ' '),
                    rest_end_time: new Date().toISOString().slice(0, 19).replace('T', ' ')
                })
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      document.getElementById('rest_time').textContent = data.rest_time;
                  } else {
                      alert('休憩終了時刻を登録しました。');
                  }
              }).catch(error => {
                  console.error('Error:', error);
                  alert('休憩終了時刻を登録しました。');
              });

            localStorage.setItem(BUTTON_STATE_KEY, JSON.stringify({
                startButton: false,
                endButton: false,
                restStartButton: true,
                restEndButton: true
            }));
            restEndButton.disabled = true;
            restStartButton.disabled = false;
        }
    });

    
    function updateTimer() {
    const now = Date.now();
    const timeLeft = endTime - now;
    if (timeLeft <= 0) {
        clearInterval(timerInterval);
        document.getElementById('timer').style.display = 'none';
        document.getElementById('timer').textContent = ''; 
        alert('休憩時間が終了しました、休憩終了ボタンを押してください。');
        return;
    }

    const minutes = Math.floor(timeLeft / 60000);
    const seconds = Math.floor((timeLeft % 60000) / 1000);
    document.getElementById('timer').textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
}
  });
</script>
@else
<h2 class="home-form__heading2"><a href="/login">ログイン</a>してください</h2>
@endif
@endsection
