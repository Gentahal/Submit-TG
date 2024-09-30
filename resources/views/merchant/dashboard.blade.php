<!-- resources/views/merchant/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Merchant Dashboard</h2>
    <div class="row">
        <div class="col-md-4">
            <h3>Profile</h3>
            <form method="POST" action="{{ route('merchant.profile.update') }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="company_name">Company Name</label>
                    <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $merchant->company_name }}" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" required>{{ $merchant->address }}</textarea>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $merchant->phone }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ $merchant->description }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
        <div class="col-md-8">
            <h3>Menu Items</h3>
            <!-- Add a list or table of menu items here -->
            <a href="{{ route('merchant.menu.create') }}" class="btn btn-success">Add New Menu Item</a>
        </div>
    </div>
</div>