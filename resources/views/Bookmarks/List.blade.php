@extends('Partials.Layout')
@section('title', $title)

@section('content')
    @if(session('status'))
        <span class="alert alert-{{ session('status') }}">{{ session('text') }}</span>
    @endif
    @if($bookmarks->isNotEmpty())
        <div class="control">
            <div class="buttons">
                <a href="{{ route('Bookmarks.Export') }}" class="btn btn-primary">Экспорт в Excel</a>
            </div>
            <form action="#" method="GET" class="search">
                <input type="text" name="text" placeholder="Введите текст для поиска">
                <button type="submit" class="btn"><i class="fas fa-search fa-fw"></i></button>
            </form>
        </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th class="thin">#</th>
                <th class="{{ $bookmarks->isNotEmpty() ? 'sortable' : '' }}">
                    @if($bookmarks->isNotEmpty())
                        @sortablelink('title', 'Заголовок')
                    @else
                        Заголовок
                    @endif
                </th>
                <th class="{{ $bookmarks->isNotEmpty() ? 'sortable' : '' }}">
                    @if($bookmarks->isNotEmpty())
                        @sortablelink('url', 'Адрес')
                    @else
                        Адрес
                    @endif
                </th>
                <th class="thin {{ $bookmarks->isNotEmpty() ? 'sortable' : '' }}">
                    @if($bookmarks->isNotEmpty())
                        @sortablelink('created_at', 'Дата создания')
                    @else
                        Дата создания
                    @endif
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookmarks as $bookmark)
                <tr>
                    <td class="thin">
                        @if($bookmark->favicon)
                            <img src="{{ url('storage/favicons/'.$bookmark->favicon) }}" alt="{{ $bookmark->url }}" width="16" height="16">
                        @else
                            -
                        @endif
                    </td>
                    <td><a href="{{ route('Bookmarks.Show', $bookmark->id) }}">{{ $bookmark->title }}</a></td>
                    <td><a href="{{ $bookmark->url }}" target="_blank">{{ $bookmark->url }}</a></td>
                    <td class="thin">{{ $bookmark->format_created_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Закладок пока нет. Вы можете <a href="{{ route('Bookmarks.Add') }}">добавить</a> новую закладку.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $bookmarks->appends(\Request::except('page'))->render() }}
@endsection