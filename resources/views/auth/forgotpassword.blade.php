@extends('auth.base')

@section('title', 'forgot password')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Login to  E-Commerce</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('reset') }}" method="POST">
                        @csrf


                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>

                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Submit to reset password</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
