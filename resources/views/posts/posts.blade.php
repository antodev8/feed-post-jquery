

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<!-- HEADER -->
<header class="header"> <!-- Header per contenuto di navigazione -->
    <nav class="header__nav"> <!-- lista di link -->
        <ul>
            <li>Dashboard</li>
            <li><a href="{{ route('posts.create') }}">Aggiungi</a></li>
            <li>Impostazioni</li>
        </ul>
    </nav>
</header>

<!-- CONTENT -->
<div class="content">
    <table id="table">
        <caption>Lista post</caption>
        <input class="custom-input" type="text">
        <tr>
            <th scope="col">title</th>
            <th scope="col">Post Content</th>

        </tr>
        @foreach($posts as $post)
            <tr>
                <td>{{$post->title}}</td>
                <td>{{$post->text}}</td>

                <td>
                    <a href="{{ route('posts.edit',['post' => $post]) }}">Modifica</a>




                    <form action="{{ route('posts.destroy',['post' => $post]) }}" method="POST">
                        @csrf
                        {{ method_field('DELETE') }}
                        <button type="submit">Elimina</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</div>
</body>

</html>

<style>
</style>

<script>
</script>
