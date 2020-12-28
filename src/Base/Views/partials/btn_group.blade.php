<div class="btn-group">
    @foreach($buttons as $button => $properties)
        <a class="btn btn-sm btn-default" href="{{$properties['url']}}"><i class="fa {{$properties['icon_class']}}"></i></a>
    @endforeach
</div>
