@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('languages.edit') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('common.dashboard') }}</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.language.index') }}">{{ __('languages.title') }}</a></div>
            <div class="breadcrumb-item">{{ __('common.edit') }}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('languages.edit') }}: {{ $language->name }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.language.update', $language->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">{{ __('languages.name') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" placeholder="{{ __('languages.name_placeholder') }}"
                                       value="{{ old('name', $language->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="code">{{ __('languages.code') }}</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                       id="code" name="code" placeholder="{{ __('languages.code_placeholder') }}"
                                       value="{{ old('code', $language->code) }}" required>
                                <small class="form-text text-muted">{{ __('languages.code_hint') }}</small>
                                @error('code')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="flag_code">{{ __('languages.flag') }} ({{ __('common.optional') }})</label>
                                <input type="text" class="form-control @error('flag_code') is-invalid @enderror"
                                       id="flag_code" name="flag_code" placeholder="{{ __('languages.flag_placeholder') }}"
                                       value="{{ old('flag_code', $language->flag_code) }}">
                                <small class="form-text text-muted">{{ __('languages.flag_hint') }}</small>
                                @error('flag_code')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="is_default">{{ __('languages.set_default') }}</label>
                                <select class="form-control @error('is_default') is-invalid @enderror"
                                        id="is_default" name="is_default">
                                    <option value="0" @if(!$language->is_default) selected @endif>{{ __('common.no') }}</option>
                                    <option value="1" @if($language->is_default) selected @endif>{{ __('common.yes') }}</option>
                                </select>
                                <small class="form-text text-muted">{{ __('languages.default_hint') }}</small>
                                @error('is_default')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="is_active">{{ __('common.status') }}</label>
                                <select class="form-control @error('is_active') is-invalid @enderror"
                                        id="is_active" name="is_active">
                                    <option value="1" @if($language->is_active) selected @endif>{{ __('common.active') }}</option>
                                    <option value="0" @if(!$language->is_active) selected @endif>{{ __('common.inactive') }}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{ __('languages.update') }}</button>
                                <a href="{{ route('admin.language.index') }}" class="btn btn-secondary">{{ __('common.cancel') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
