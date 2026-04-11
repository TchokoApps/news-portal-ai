@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('languages.create') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('common.dashboard') }}</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.language.index') }}">{{ __('languages.title') }}</a></div>
            <div class="breadcrumb-item">{{ __('common.create') }}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('languages.add_new') }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.language.store') }}" method="POST" id="languageCreateForm">
                            @csrf

                            <!-- Language Selection Dropdown -->
                            <div class="form-group">
                                <label for="language-select">
                                    {{ __('languages.select_language') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control select2 @error('code') is-invalid @enderror"
                                        id="language-select" data-placeholder="{{ __('languages.search_select') }}">
                                    <option></option>
                                    @foreach(config('languages') as $code => $lang)
                                        <option value="{{ $code }}" data-name="{{ $lang['name'] }}">
                                            {{ $lang['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('code')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Language Name Field -->
                            <div class="form-group">
                                <label for="name">
                                    {{ __('languages.name') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" placeholder="{{ __('languages.name_placeholder') }}"
                                       value="{{ old('name') }}" readonly>
                                <small class="form-text text-muted">{{ __('languages.auto_populated') }}</small>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Language Code Field -->
                            <div class="form-group">
                                <label for="code">
                                    {{ __('languages.code') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                       id="code" name="code" placeholder="{{ __('languages.code_placeholder') }}"
                                       value="{{ old('code') }}" readonly>
                                <small class="form-text text-muted">{{ __('languages.code_hint') }}</small>
                                @error('code')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Set as Default -->
                            <div class="form-group">
                                <label for="is_default">
                                    {{ __('languages.set_default') }}
                                </label>
                                <select class="form-control @error('is_default') is-invalid @enderror"
                                        id="is_default" name="is_default">
                                    <option value="0">{{ __('common.no') }}</option>
                                    <option value="1" @selected(old('is_default') == 1)>{{ __('common.yes') }}</option>
                                </select>
                                <small class="form-text text-muted">{{ __('languages.default_hint') }}</small>
                                @error('is_default')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="form-group">
                                <label for="is_active">
                                    {{ __('common.status') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control @error('is_active') is-invalid @enderror"
                                        id="is_active" name="is_active">
                                    <option value="1" @selected(old('is_active', 1) == 1)>{{ __('common.active') }}</option>
                                    <option value="0" @selected(old('is_active') == 0)>{{ __('common.inactive') }}</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Buttons -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="fas fa-save"></i> {{ __('languages.create') }}
                                </button>
                                <a href="{{ route('admin.language.index') }}" class="btn btn-secondary">
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

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('#language-select').select2({
            allowClear: true,
            width: '100%',
            placeholder: "{{ __('languages.search_select') }}"
        });

        // Handle language selection change
        $('#language-select').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const code = selectedOption.val();
            const name = selectedOption.data('name');

            // Update name and code fields
            if (code) {
                $('#name').val(name || '');
                $('#code').val(code);
            } else {
                $('#name').val('');
                $('#code').val('');
            }
        });

        // Form submission handler - validate that a language was selected
        $('#languageCreateForm').on('submit', function(e) {
            const code = $('#code').val();

            if (!code) {
                e.preventDefault();
                Swal.fire({
                    title: "{{ __('common.warning') }}",
                    text: "{{ __('languages.select_language_first') }}",
                    icon: 'warning',
                    confirmButtonText: "{{ __('common.ok') }}"
                });
                return false;
            }
        });
    });
</script>
@endpush
@endsection
