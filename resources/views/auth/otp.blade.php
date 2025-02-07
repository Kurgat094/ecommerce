@extends('auth.base')

@section('title', 'Otp Verification')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Otp Verification</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('verifyOtp') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="otp">Enter OTP</label>
                            <input type="text" id="otp" name="otp" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Verify OTP</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
