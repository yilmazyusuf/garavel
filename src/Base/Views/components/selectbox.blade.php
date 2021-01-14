<select class="form-control {{$selectBox->class}}"
        id="{{$selectBox->id}}"
        name="{{$selectBox->name}}" @if($selectBox->isMultiple) multiple @endif>
    <option value="">Seçiniz</option>
    @foreach($selectBox->getData() as $data)
        <option value="{{ $data->{$selectBox->constructMap['value']} }}">{{ $data->{$selectBox->constructMap['text']} }}</option>
    @endforeach
</select>