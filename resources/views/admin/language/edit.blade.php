@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Edit Language</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.language.index') }}">Languages</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Language: {{ $language->name }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.language.update', $language->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Language Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" placeholder="e.g., English, Chinese, Korean"
                                       value="{{ old('name', $language->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="code">Language Code</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                       id="code" name="code" placeholder="e.g., en, zh, ko"
                                       value="{{ old('code', $language->code) }}" required>
                                <small class="form-text text-muted">ISO 639-1 language code (2 letters)</small>
                                @error('code')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="flag_code">Flag Code (Optional)</label>
                                <input type="text" class="form-control @error('flag_code') is-invalid @enderror"
                                       id="flag_code" name="flag_code" placeholder="e.g., us, cn, kr"
                                       value="{{ old('flag_code', $language->flag_code) }}">
                                <small class="form-text text-muted">Country/Flag code for flag icon display</small>
                                @error('flag_code')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="is_active">Status</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                                           @if($language->is_active) checked @endif>
                                    <label class="custom-control-label" for="is_active">Active</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update Language</button>
                                <a href="{{ route('admin.language.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
