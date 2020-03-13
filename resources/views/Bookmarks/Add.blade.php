@extends('Partials.Layout')
@section('title', $title)

@section('content')
    <form action="{{ route('Bookmarks.Create') }}" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="url">Адрес сайта</label>
            <input type="text" name="url" class="form-control" id="url" aria-describedby="url" value="{{ old('url') }}">
            @error('url')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Добавить</button>
    </form>
@endsection