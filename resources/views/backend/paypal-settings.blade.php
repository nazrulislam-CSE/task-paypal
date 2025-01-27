@extends('layouts.backend', ['pageTitle' => 'PayPal Settings'])

@section('admin')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h3 class="mb-0">PayPal Payment Gateway Settings</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.paypal-settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="client_id">PayPal Client ID</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="client_id" palceholder="Enter Client ID" id="client_id" value="{{ old('client_id', $paypalSettings->client_id ?? '') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="secret">PayPal Secret</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="secret" palceholder="Enter Secret" id="secret" value="{{ old('secret', $paypalSettings->secret ?? '') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mode">Mode</label>
                    <select class="form-control" name="mode" id="mode" required>
                        <option value="sandbox" {{ (old('mode', $paypalSettings->mode ?? '') == 'sandbox') ? 'selected' : '' }}>Sandbox</option>
                        <option value="live" {{ (old('mode', $paypalSettings->mode ?? '') == 'live') ? 'selected' : '' }}>Live</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Save Settings</button>
            </form>
        </div>
    </div>
</div>
@endsection
