@section('alerts')
    <div class="alert alert-{{$type}} alert-dismissible mt-3">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <ul class="m-0 pl-2">
            @foreach($messages as $message)
                <li>{{$message}}</li>
            @endforeach
        </ul>
    </div>
@endsection
