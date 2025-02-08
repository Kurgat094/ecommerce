@extends('auth.base')

@section('title', 'Set new password')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Reset Your Password</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('resetpasswordpost',$token) }}" method="POST">
                        @csrf

                    @if (session('success'))
                        <div class="bg-green-500 text-white p-4 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-500 text-white p-4 rounded mb-4">
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">New password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="New password" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="" class="form-label">Confirm password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="confirm_password" placeholder="Confirm password" required>
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
