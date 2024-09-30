@extends('layouts.app')

@section('content')
<h2>Search Results</h2>
@foreach($merchants as $merchant)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $merchant->company_name }}</h5>
            <p class="card-text">{{ $merchant->description }}</p>
            <a href="{{ route('customer.view_merchant', $merchant) }}" class="btn btn-primary">View Menu</a>
        </div>
    </div>
@endforeach
{{ $merchants->links() }}
@endsection