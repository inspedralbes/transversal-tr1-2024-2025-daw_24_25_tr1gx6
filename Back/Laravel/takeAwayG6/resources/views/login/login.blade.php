@extends('Layout.master')

@section('content')
    <section class="vh-100" style="background-color: black;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="https://img.freepik.com/fotos-premium/logotipo-simple-diseno-plano-tienda-ropa-deportiva-ai-generativa_934475-4683.jpg"
                                    alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem; height:100%" />
                            </div>
                            
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form>
                                        <div class="d-flex align-items-center mb-3 pb-1" style="width:15rem; height:5rem;">
                                            <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                            <img src="/Img/Logo.png" style="width:15rem; height:5rem;" />
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Inicia sesión en tu
                                            cuenta</h5>

                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="floatingInput"
                                                placeholder="name@example.com">
                                            <label for="floatingInput">Email address</label>
                                        </div>


                                        <div class="form-floating mb-4">
                                            <input type="password" class="form-control" id="floatingPassword"
                                                placeholder="Password">
                                            <label for="floatingPassword">Password</label>
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-dark btn-lg btn-block" type="button">Login</button>
                                        </div>

                                        <a class="small text-muted" href="#!">Forgot password?</a>
                                        <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a
                                                href="#!" style="color: #393f81;">Register here</a></p>
                                        <a href="#!" class="small text-muted">Terms of use.</a>
                                        <a href="#!" class="small text-muted">Privacy policy</a>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('pages')
@endsection
@section('forms-cruds')
@endsection

@section('scripts')
@endsection
