@extends('layouts.app')

@section('content')
<div class="jumbotron text-center py-5" style="background-color: #f8f9fa;">
    <h1 class="display-4 fw-bold text-primary">Marketplace Katering</h1>
    <p class="lead text-muted">Connect with local catering services for your office lunch needs.</p>
    <hr class="my-4 w-50 mx-auto">
    <p class="fs-5">Whether you're a catering service or an office, we have the perfect lunch solution for you.</p>
    <div class="d-flex justify-content-center gap-3">
        <a class="btn btn-primary btn-lg px-4 py-2 shadow-sm" href="{{ route('merchant.register') }}" role="button">Register as Merchant</a>
        <a class="btn btn-outline-secondary btn-lg px-4 py-2 shadow-sm" href="{{ route('customer.register') }}" role="button">Register as Customer</a>
    </div>
</div>
@endsection
