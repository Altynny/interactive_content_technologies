<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Все посты') }}
        </h2>
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
                            <h3 class="text-2xl font-bold mb-2">
                                <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-600 mb-3">
                                Автор: {{ $post->user->name }} | 
                                {{ $post->published_at->format('d.m.Y H:i') }}
                            </p>
                            <p class="text-gray-700">
                                {{ Str::limit($post->content, 200) }}
                            </p>
                            <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:underline mt-2 inline-block">
                                Читать далее →
                            </a>
                        </article>
                    @empty
                        <p class="text-gray-500">Пока нет опубликованных постов.</p>
                    @endforelse

                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>