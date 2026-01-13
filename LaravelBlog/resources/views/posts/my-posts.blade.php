<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Мои посты') }}
            </h2>
            <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded">
                Создать пост
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @forelse ($posts as $post)
                        <article class="mb-6 pb-6 border-b last:border-b-0">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="text-2xl font-bold mb-2">
                                        {{ $post->title }}
                                        @if ($post->is_published)
                                            <span class="text-sm bg-green-200 text-green-800 px-2 py-1 rounded">Опубликован</span>
                                        @else
                                            <span class="text-sm bg-gray-200 text-gray-800 px-2 py-1 rounded">Черновик</span>
                                        @endif
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-3">
                                        Создан: {{ $post->created_at->format('d.m.Y H:i') }}
                                        @if ($post->published_at)
                                            | Опубликован: {{ $post->published_at->format('d.m.Y H:i') }}
                                        @endif
                                    </p>
                                    <p class="text-gray-700">
                                        {{ Str::limit($post->content, 200) }}
                                    </p>
                                </div>
                                <div class="ml-4 flex flex-col space-y-2">
                                    <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:underline text-sm">
                                        Просмотр
                                    </a>
                                    <a href="{{ route('posts.edit', $post) }}" class="text-blue-600 hover:underline text-sm">
                                        Редактировать
                                    </a>
                                    @if ($post->is_published)
                                        <form action="{{ route('posts.unpublish', $post) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-orange-600 hover:underline text-sm">
                                                Снять с публикации
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('posts.publish', $post) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:underline text-sm">
                                                Опубликовать
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Вы уверены?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm">
                                            Удалить
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @empty
                        <p class="text-gray-500">У вас пока нет постов. <a href="{{ route('posts.create') }}" class="text-blue-600 hover:underline">Создать первый пост</a></p>
                    @endforelse

                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>