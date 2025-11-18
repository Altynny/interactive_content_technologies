<div style="display:flex; align-items:center; justify-content:space-between;">
    <div style="display:flex; align-items:center;">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height:36px; margin-right:12px;">
        <strong>{{ config('app.name') }}</strong>
    </div>
    <nav>
        <a href="{{ route('home') }}" style="color:#fff; margin-right:12px;">Главная</a>
        <a href="{{ route('form.show') }}" style="color:#fff; margin-right:12px;">Форма</a>
        <a href="{{ route('submissions.list') }}" style="color:#fff;">Все записи</a>
    </nav>
</div>
