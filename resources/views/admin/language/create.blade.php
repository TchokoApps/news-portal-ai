@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Create Language</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.language.index') }}">Languages</a></div>
            <div class="breadcrumb-item">Create</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Language</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.language.store') }}" method="POST" id="languageCreateForm">
                            @csrf

                            <!-- Language Name Select Dropdown -->
                            <div class="form-group">
                                <label for="name">Language Name</label>
                                <select class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" required onchange="updateLanguageCode()">
                                    <option value="">-- Select Language --</option>
                                    @foreach($languages as $lang)
                                        <option value="{{ $lang->name }}" data-code="{{ $lang->code }}">
                                            {{ $lang->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Language Code (Readonly) -->
                            <div class="form-group">
                                <label for="code">Language Code</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                       id="code" name="code" placeholder="Language code will auto-populate"
                                       value="{{ old('code') }}" readonly>
                                <small class="form-text text-muted">ISO 639-1 language code (auto-populated)</small>
                                @error('code')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Is Default Select -->
                            <div class="form-group">
                                <label for="is_default">Set Default Language</label>
                                <select class="form-control @error('is_default') is-invalid @enderror"
                                        id="is_default" name="is_default">
                                    <option value="0">-- No --</option>
                                    <option value="1">-- Yes --</option>
                                </select>
                                <small class="form-text text-muted">Set this as the default language for the website</small>
                                @error('is_default')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status Select Dropdown -->
                            <div class="form-group">
                                <label for="is_active">Status</label>
                                <select class="form-control @error('is_active') is-invalid @enderror"
                                        id="is_active" name="is_active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Language
                                </button>
                                <a href="{{ route('admin.language.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Function to auto-populate language code when language is selected
function updateLanguageCode() {
    const select = document.getElementById('name');
    const codeInput = document.getElementById('code');
    const selectedOption = select.options[select.selectedIndex];
    const code = selectedOption.getAttribute('data-code');
    codeInput.value = code || '';
}
</script>
@endsection
