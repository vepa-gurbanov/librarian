<form action="{{ url()->current() }}">
    <input type="hidden" name="q" value="{{ isset($q) ? $q : old('q') }}">
    <div class="accordion" id="accordion">
        <div class="accordion-item">
            <button class="accordion-button" type="button" id="panels-h1" data-bs-toggle="collapse" data-bs-target="#panels-c1" aria-expanded="true" aria-controls="panels-c1">
                @lang('app.users')
            </button>
{{--            <div id="panels-c1" class="accordion-collapse collapse show" aria-labelledby="panels-h1">--}}
{{--                <div class="accordion-body p-1">--}}
{{--                    @foreach($users as $user)--}}
{{--                        <div class="form-check m-2">--}}
{{--                            <input class="form-check-input" type="checkbox" id="u{{ $user->id }}" name="u[]"--}}
{{--                                   value="{{ $user->id }}" {{ $f_users->contains($user->id) ? 'checked' : '' }}>--}}
{{--                            <label class="form-check-label" for="u{{ $user->id }}">--}}
{{--                                {{ $user->name }}--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
</form>
