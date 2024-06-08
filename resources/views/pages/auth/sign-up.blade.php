@extends('layouts.auth')

@section('body')
    <section class="bg-gray vh-100">
        <div class="container">
            <div class="row pt-5 justify-content-center">
                <div class="col-12 col-lg-6 my-auto mb-5 mb-lg-auto me-0">
                    <div class="d-none d-lg-block">
                        <h2>Join the Laracuss Community</h2>
                        <p>
                            <ul>
                                <li>Stuck? Ask in the Discussions</li>
                                <li>Get answers from experienced developers from around the world</li>
                                <li>Contribute by answering questions</li>
                            </ul>
                        </p>
                    </div>
                    <div class="d-block d-lg-none text-center">
                        <h2>Create you account in a minute. It's free.</h2>
                    </div>
                </div>
                <div class="col-12 col-lg-3 h-100">
                    <a href="#" class="nav-link mb-5 text-center">
                        <img src="{{ url('assets/img/logo-blue.png') }}" alt="Laracuss Logo" class="h-32px">
                    </a>
                    <div class="card mb-5">
                        <form action="{{ route('auth.sign-up.sign-up') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@example.com" autocomplete="off" autofocus value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control border-end-0 pe-0 rounded-0 rounded-start @error('password') is-invalid @enderror" id="password" name="password" placeholder="******">
                                    <span class="input-group-text bg-white border-start-0 pe-auto @error('password') border-danger rounded-end @enderror">
                                        <a href="javascript:;" id="password-toggle">
                                            <img src="{{ url("assets/img/eye-slash.png") }}" alt="Password Toggle" class="h-18px" id="password-toggle-image">
                                        </a>
                                    </span>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="name" autocomplete="off" value="{{ old('username') }}">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 d-grid">
                                <button type="submit" class="btn btn-primary rounded-2">Sign up</button>
                            </div>
                        </form>
                    </div>
                    <div class="text-center">
                        Already have an account? <a href="{{ route('auth.login.show') }}"><u>Log in</u></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('after-script')
    <script>
        var isPasswordRevealed = false;

        $('#password-toggle').on('click', () => {
            isPasswordRevealed = !isPasswordRevealed;

            if (isPasswordRevealed) {
                $('#password-toggle-image').attr('src', "{{ url('assets/img/eye.png') }}");
                $('#password').attr('type', 'text');
            } else {
                $('#password-toggle-image').attr('src', "{{ url('assets/img/eye-slash.png') }}");
                $('#password').attr('type', 'password');
            }
        })
    </script>
@endsection