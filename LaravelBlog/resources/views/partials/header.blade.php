<header class="site-header">
    <div class="container">
        <div class="header-content">
            <h1 class="site-title">
                <a href="{{ route('posts.index') }}">LaravelBlog</a>
            </h1>
            <nav class="main-nav">
                <ul>
                    <li><a href="{{ route('posts.index') }}">Главная</a></li>
                    <li><a href="{{ route('posts.create') }}">Создать пост</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
