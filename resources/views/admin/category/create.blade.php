@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('categories.create') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('common.dashboard') }}</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">{{ __('categories.title') }}</a></div>
            <div class="breadcrumb-item">{{ __('common.create') }}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('categories.create_category') }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.category.store') }}" method="POST">
                            @csrf

                            <!-- Language Selection -->
                            <div class="form-group">
                                <label for="language">
                                    {{ __('categories.language') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control @error('language') is-invalid @enderror"
                                        id="language" name="language" required>
                                    <option value="">{{ __('common.select') }}</option>
                                    @foreach($languages as $language)
                                        <option value="{{ $language->code }}" @selected(old('language') == $language->code)>
                                            {{ $language->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('language')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category Name -->
                            <div class="form-group">
                                <label for="name">
                                    {{ __('categories.name') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name"
                                       placeholder="{{ __('categories.name_placeholder') }}"
                                       value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Show at Navigation -->
                            <div class="form-group">
                                <label for="show_at_nav">
                                    {{ __('categories.show_at_nav') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control @error('show_at_nav') is-invalid @enderror"
                                        id="show_at_nav" name="show_at_nav" required>
                                    <option value="">{{ __('common.select') }}</option>
                                    <option value="1" @selected(old('show_at_nav') == 1)>{{ __('common.yes') }}</option>
                                    <option value="0" @selected(old('show_at_nav') == 0)>{{ __('common.no') }}</option>
                                </select>
                                <small class="form-text text-muted">{{ __('categories.show_at_nav_hint') }}</small>
                                @error('show_at_nav')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="form-group">
                                <label for="status">
                                    {{ __('common.status') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                    <option value="">{{ __('common.select') }}</option>
                                    <option value="1" @selected(old('status', 1) == 1)>{{ __('common.active') }}</option>
                                    <option value="0" @selected(old('status') == 0)>{{ __('common.inactive') }}</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Buttons -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> {{ __('categories.create') }}
                                </button>
                                <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> {{ __('common.cancel') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
