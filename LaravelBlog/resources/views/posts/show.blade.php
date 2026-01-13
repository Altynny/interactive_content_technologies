<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <article>
                        <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
                        <p class="text-sm text-gray-600 mb-6">
                            Автор: {{ $post->user->name }} | 
                            {{ $post->published_at ? $post->published_at->format('d.m.Y H:i') : $post->created_at->format('d.m.Y H:i') }}
                        </p>
                        <div class="prose max-w-none">
                            {!! nl2br(e($post->content)) !!}
                        </div>
                    </article>
                </div>
            </div>

            <!-- Панель модерации (только для автора) -->
            @auth
                @if ($post->user_id === Auth::id())
                    @php
                        $pendingComments = $post->comments()->where('is_approved', false)->with('user')->get();
                    @endphp
                    
                    @if ($pendingComments->count() > 0)
                        <div class="bg-yellow-50 border border-yellow-200 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-4 text-yellow-800">
                                    Комментарии на модерации ({{ $pendingComments->count() }})
                                </h3>
                                
                                @foreach ($pendingComments as $comment)
                                    <div class="mb-4 pb-4 border-b last:border-b-0 bg-white p-4 rounded">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <p class="font-bold">{{ $comment->user->name }}</p>
                                                <p class="text-sm text-gray-600 mb-2">{{ $comment->created_at->format('d.m.Y H:i') }}</p>
                                                <p class="text-gray-700">{{ $comment->content }}</p>
                                            </div>
                                            <div class="ml-4 flex flex-col space-y-2">
                                                <form action="{{ route('comments.moderate', $comment) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-green-500 hover:bg-green-700 font-bold py-1 px-3 rounded text-sm">
                                                        Одобрить
                                                    </button>
                                                </form>
                                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Удалить этот комментарий?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 font-bold py-1 px-3 rounded text-sm">
                                                        Отклонить
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif
            @endauth

            <!-- Комментарии -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Комментарии ({{ $post->moderatedComments->count() }})</h3>

                    @auth
                        <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-6">
                            @csrf
                            <div class="mb-4">
                                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">
                                    Добавить комментарий
                                </label>
                                <textarea name="content" id="content" rows="4" 
                                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
                                @error('content')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded">
                                Отправить комментарий
                            </button>
                        </form>
                    @else
                        <p class="mb-6 text-gray-600">
                            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Войдите</a>, чтобы оставить комментарий.
                        </p>
                    @endauth

                    @forelse ($post->moderatedComments as $comment)
                        <div class="mb-4 pb-4 border-b last:border-b-0">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="font-bold">{{ $comment->user->name }}</p>
                                    <p class="text-sm text-gray-600 mb-2">{{ $comment->created_at->format('d.m.Y H:i') }}</p>
                                    <p class="text-gray-700">{{ $comment->content }}</p>
                                </div>
                                @auth
                                    @if ($comment->user_id === Auth::id())
                                        <div class="ml-4 flex space-x-2">
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Вы уверены?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline text-sm">
                                                    Удалить
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Пока нет комментариев.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>