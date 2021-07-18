<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

</head>

<body>
<h2>Modifica Post</h2>

@if($errors->all())
    {{ var_dump($errors->all()) }}
@endif
<form method="POST" action="{{ route('posts.update',['post'=>$post]) }}">
    @csrf
    {{method_field('DELETE')}}
    <label for="title">Title:</label><br><br>
    <input type="text" id="title" name="title" value="{{$post->title}}"><br><br>
    <label for="text">Post Content:</label><br>
    <input type="text" id="text" name="text" value="{{$post->text}}"><br><br>

    <input type="submit" value="Submit">
</form>

</body>
</html>

<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>
