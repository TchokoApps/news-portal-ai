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
                                <label for="is_default">Set Default Language</label>
                                <select class="form-control @error('is_default') is-invalid @enderror"
                                        id="is_default" name="is_default">
                                    <option value="0" @if(!$language->is_default) selected @endif>-- No --</option>
                                    <option value="1" @if($language->is_default) selected @endif>-- Yes --</option>
                                </select>
                                <small class="form-text text-muted">Set this as the default language for the website</small>
                                @error('is_default')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="is_active">Status</label>
                                <select class="form-control @error('is_active') is-invalid @enderror"
                                        id="is_active" name="is_active">
                                    <option value="1" @if($language->is_active) selected @endif>Active</option>
                                    <option value="0" @if(!$language->is_active) selected @endif>Inactive</option>
                                </select>
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
