<div style="display:flex; align-items:center; justify-content:space-between;">
    <div style="display:flex; align-items:center;">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height:36px; margin-right:12px;">
        <strong>{{ config('app.name') }}</strong>
    </div>
    <nav>
        <a href="{{ route('home') }}" style="color:#fff; margin-right:12px;">Главная</a>
        <a href="{{ route('listings.index') }}" style="color:#fff; margin-right:12px;">Объявления</a>
        <a href="{{ route('users.index') }}" style="color:#fff; margin-right:12px;">Поставщики услуг</a>
        <a href="{{ route('service-types.index') }}" style="color:#fff; margin-right:12px;">Типы услуг</a>
    </nav>
</div>
