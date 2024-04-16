@extends('layouts.auth')

@section('body')
    <section class="bg-gray vh-100">
        <div class="container h-100 pt-5">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-3">
                    <a href="" class="nav-link mb-5 text-center">
                        <img class="h-32px" src="{{ url('assets/img/logo-blue.png') }}" alt="Laracuss-Logo">
                    </a>
                    <div class="card mb-5">
                        <form action="#" method="POST">
                            <div class="mb-3">
                                <label form="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" autocomplete="off" autofocus>
                            </div>
                            <div class="mb-3">
                                <label form="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control border-end-0 pe-0 rounded-0 rounded-start" id="password" name="password" placeholder="******">
                                    <span class="input-group-text bg-white border-start-0 pe-auto">
                                        <a href="javascript:;" id="password-toggle">
                                            <img src="{{ url("assets/img/eye-slash.png") }}" alt="Password Toggle" class="h-18px" id="password-toggle-image">
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3 d-grid">
                                <button type="submit" class="btn btn-primary rounded-2">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="text-center">
                        Don't have an account? <a href="#" class="text-underline"><u>Sign up</u></a>
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