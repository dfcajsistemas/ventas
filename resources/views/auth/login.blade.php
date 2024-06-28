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
                        <a href="index.html" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <svg width="25" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 67.7">
                                    <g>
                                        <path fill="#696cff"
                                            d="M29.9,14c-2.2,2.2-3.9,4.1-4.9,5.5c-1,1.4-2.1,3.5-3.3,6.2c-0.9,2-1.5,4-1.9,6.2c-0.5,1.9-0.7,4.4-0.7,7.4c0,4.3,0.4,7.8,1.2,10.7 c0.8,2.8,2,5,3.6,6.4c1.6,1.4,3.5,2.2,5.8,2.2c1.8,0,3.7-0.7,5.6-2c1.9-1.3,3.6-3.1,5.2-5.2c1.5-2.2,2.8-4.6,3.7-7.3 c0.9-2.7,1.4-5.2,1.4-7.7c0-4.5-1.5-9.1-4.6-14c-1.1-2-1.7-3.3-1.7-4c0-1.3,0.7-2.7,2.2-4c1.7-1.6,3.6-3,5.7-4.2 c2.1-1.2,3.8-1.9,5.1-1.9c0.7,0,1.5,0.2,2.3,0.5c0.8,0.3,1.4,0.8,1.8,1.3c1,1.1,1.9,3.1,2.6,5.9s1,5.9,1,9.2 c0,7.7-1.6,14.8-4.7,21.3c-3.1,6.5-7.4,11.6-12.8,15.4c-5.4,3.8-11.2,5.7-17.5,5.7c-3.6,0-7.2-0.7-10.7-2c-3.5-1.3-6.4-3.1-8.6-5.4 C1.9,56.6,0,51.7,0,45.6c0-3.5,0.7-7.2,2.1-11.2c1.4-3.9,3.2-7.8,5.6-11.5c2.4-3.7,5.2-7.1,8.3-10.2c3.1-3.1,6.4-5.5,9.7-7.3 c3-1.6,6.3-2.9,9.8-3.9C38.9,0.5,42,0,44.6,0c3.7,0,5.6,0.6,5.6,1.7c0,0.5-0.4,1.2-1.2,2.1c-1.4,1.3-2.7,2.3-3.7,2.8 c-1.1,0.6-2.8,1.2-5.2,1.9c-2.6,0.8-4.5,1.5-5.7,2.1S31.8,12.4,29.9,14z" />
                                    </g>
                                    <path fill="#696cff" fill-opacity="0.8" d="M41.1,35.8l16.7,16.7c3,3,3,7.8,0,10.8l-3.6,3.6c-1,1-2.7,1-3.7,0L30.2,46.7c-3-3-3-7.8,0-10.8l0,0
                                  C33.2,32.8,38.1,32.8,41.1,35.8z" />
                                </svg>
                            </span>
                            <span class="app-brand-text demo text-body fw-bold">Quipu</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-2">Bienvenido al Quipu 👋</h4>
                    <p class="mb-4">Inicie sesión en su cuenta y comience la aventura.</p>

                    <x-validation-errors class="mb-4" />

                    <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="doc_numero" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="doc_numero" name="doc_numero"
                                placeholder="Ingrese su usuario" :value="old('doc_numero')" autofocus
                                autocomplete="doc_numero" />
                            @error('doc_numero')
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
