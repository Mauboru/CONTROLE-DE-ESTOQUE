<div>
    <div class="row">
        <div class="col">
            @if($type == "file")
                <div class="input-group mb-3">
                <span class="input-group-text bg-success text-white">{{$label}}</span>
            @else 
                <div class="form-floating mb-3">
            @endif
                <input
                    type="{{$type}}"
                    class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }}"
                    name="{{ $name }}"
                    id="{{ $name }}"

                    @if($type != "file")
                        placeholder="{{ $label }}"
                        @if($value == "null") value="{{old($name)}}" @else value="{{$value}}" @endif 
                        @if($disabled == "true") disabled @endif 
                    @else
                        accept="application/pdf, image/gif, image/jpeg"
                    @endif
                />
                @if($type != "file") <label for="{{$name}}">{{$label}}</label> @endif
                @if($errors->has($name))
                    <div class='invalid-feedback'>
                        {{ $errors->first($name) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>