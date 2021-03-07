@if (count($errors) > 0)
    <ul class="cycle cycle-danger" role="cycle">
        @foreach ($errors->all() as $error)
            <li class="ml-4">{{ $error }}</li>
        @endforeach
    </ul>
@endif