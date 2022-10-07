<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center flex-col items-center">
<form class="drop-shadow-lg flex flex-col space-y-4" action="{{route('space.store')}}">
    @csrf
    @method('post')
    <label for="Space">
        Space
        <input type="text" name="space_name" placeholder="Name of space ">
    </label>
    <label for="Max-student">
        Max-students
        <input type="number" name="max_students" placeholder="Number of max students">
    </label>
    <input class="border rounded-full" type="submit">
</form>


</body>
</html>
