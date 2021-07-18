<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

</head>

<body>
<h2>Crea Post</h2>

@if($errors->all())
    {{ var_dump($errors->all()) }}
@endif
<form method="POST" action="{{ route('posts.store') }}">
    @csrf


            <label for="title">Title</label><br><br>
            <input type="text" id="title" name="title" value=""><br><br>
            <label for="text">Post Content</label><br><br>
            <input type="text" id="text" name="text" value=""><br><br>

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
