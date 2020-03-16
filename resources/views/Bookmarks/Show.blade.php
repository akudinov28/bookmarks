@extends('Partials.Layout')
@section('title', $title)

@section('content')
    @if(session('status'))
        <span class="alert alert-{{ session('status') }}">{{ session('text') }}</span>
    @endif
    <table class="table">
        <tbody>
            <tr>
                <td class="thin">Адрес страницы:</td>
                <td><a href="{{ $bookmark->url }}" target="_blank">{{ $bookmark->url }}</a></td>
            </tr>
            <tr>
                <td class="thin">Иконка:</td>
                <td>
                    @if($bookmark->favicon)
                        <img src="{{ url('storage/favicons/'.$bookmark->favicon) }}" alt="{{ $bookmark->url }}" width="16" height="16">
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td class="thin">Заголовок:</td>
                <td>{{ $bookmark->title }}</td>
            </tr>
            <tr>
                <td class="thin">Описание:</td>
                <td>
                    @if($bookmark->description)
                        {{ $bookmark->description }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td class="thin">Ключевые слова:</td>
                <td>
                    @if($bookmark->keywords)
                        {{ $bookmark->format_keywords }}
                    @else
                        -
                    @endif
                </td>
            </tr>
        <tr>
            <td class="thin">Дата создания:</td>
            <td>{{ $bookmark->format_created_at }}</td>
        </tr>
        </tbody>
    </table>
    <form action="{{ route('Bookmarks.Delete', $bookmark->id) }}" method="POST" id="bookmarkDelete">
        {{ csrf_field() }}
        <input type="hidden" name="password" value="">
        <a class="btn btn-danger">Удалить</a>
    </form>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        $(document).ready(function(){
            $('#bookmarkDelete').children('a').click(function(){
                Swal.fire({
                    text: 'Введите пароль для удаления закладки',
                    input: 'password'
                }).then((result) => {
                    $('#bookmarkDelete').children('input[name="password"]').val(result.value).parent('form').submit();
                })
            });
        });
    </script>
@endsection