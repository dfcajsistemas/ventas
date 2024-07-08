<x-guest-layout>
    <div class="authentication-wrapper authentication-cover">
        <div class="authentication-inner row m-0">
            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5">
                <div class="w-100 d-flex justify-content-center">
                    <img src="{{ asset('../../assets/img/illustrations/boy-with-rocket-light.png') }}" class="img-fluid"
                        alt="Login image" width="700" data-app-dark-img="illustrations/boy-with-rocket-dark.png"
                        data-app-light-img="illustrations/boy-with-rocket-light.png" />
                </div>
            </div>
            <!-- /Left Text -->

            <!-- Login -->
            <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
                <div class="w-px-400 mx-auto">
                    <!-- Logo -->
                    <div class="app-brand mb-5">
                        <a href="{{route("index")}}" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <svg id="a" data-name="Capa 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 71.28 63.71">
                                    <rect x="41.22" y="-3.15" width="16.76" height="70" rx="8.38" ry="8.38" transform="translate(22.57 -20.53) rotate(30)" fill="#696cff" fill-opacity="0.8" stroke-width="0"/>
                                    <rect x="11.75" y="-3.15" width="23" height="70" rx="11.5" ry="11.5" transform="translate(-12.81 15.89) rotate(-30)" fill="#696cff" stroke-width="0"/>
                                </svg>
                            </span>
                            <span class="app-brand-text demo text-body fw-bold">Vensis</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-2">Bienvenido a Vensis 👋</h4>
                    <p class="mb-4">Inicie sesión en su cuenta y comience la aventura.</p>

                    <x-validation-errors class="mb-4" />

                    <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="ndocumento" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="ndocumento" name="ndocumento"
                                placeholder="Ingrese su usuario" :value="old('ndocumento')" autofocus
                                autocomplete="ndocumento" />
                            @error('ndocumento')
                                <span class="invalid-feedback" role="alert">
                                    <span class="fw-medium">{{ $message }}</span>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">
                                        <small>Recuperar contraseña</small>
                                    </a>
                                @endif
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    autocomplete="current-password" aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <span class="fw-medium">{{ $message }}</span>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me" name="remember"
                                    {{ old('remember') ? 'checked' : '' }} />
                                <label class="form-check-label" for="remember-me"> Recuérdame </label>
                            </div>
                        </div>
                        <button class="btn btn-primary d-grid w-100" type="submit">Iniciar sesión</button>
                    </form>
                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>
</x-guest-layout>
