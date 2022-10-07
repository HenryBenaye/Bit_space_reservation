<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center flex-col items-center">
<h1 class="text-2xl font-bold">List of Spaces</h1>
<div class="flex flex-row">
    @foreach($spaces as $space)
        <div class="border border-2">
            <p>{{$space->name}}</p>
            <div class="flex flex-row">
                <p>Max students:</p>
                <p>{{$space->max_students}}</p>
            </div>
            <div class="flex flex-row">
                <a href="{{route('space.edit',$space->id)}}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </a>
                <form action="{{route('space.destroy', $space->id)}}" method="post">
                    @method('delete')
                    @csrf
                    <button type="submit">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    @endforeach
</div>
<a href="{{route('space.create')}}">Create a new space</a>

</body>
</html>
