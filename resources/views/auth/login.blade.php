@extends('layouts.login')

@section('content')

<form method="POST" action="{{ route('login') }}" novalidate>
    @csrf

    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">
            Email

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>Email erróneo</strong>
                </span>
            @enderror
        </label>

        <div class="col-md-6">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="email@dominio.es">
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">
            Contraseña

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>Contraseña errónea</strong>
                </span>
            @enderror
        </label>

        <div class="col-md-6">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">
        </div>
    </div>

    <div class="form-group row">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

            <label class="form-check-label" for="remember">Recuérdame</label>
        </div>

        <button type="submit" class="btn btn-primary">Acceder</button>

        <div style="clear:both"></div>
    </div>
</form>

@if (Route::has('password.request'))
    <a class="btn btn-link" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
@endif
                
@endsection
