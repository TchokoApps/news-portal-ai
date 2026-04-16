@extends('admin.layouts.master')

@push('styles')
<style>
    .image-preview {
        width: 100%;
        min-height: 320px;
        position: relative;
        overflow: hidden;
        background: #f4f7fb;
        border: 1px dashed #cfd7ff;
        border-radius: 8px;
        background-position: center center;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .image-preview input {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }

    .image-preview label {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
        margin: 0;
        padding: 12px 18px;
        background: rgba(103, 119, 239, 0.9);
        color: #fff;
        border-radius: 999px;
        font-size: 13px;
        letter-spacing: 0.2px;
    }
</style>
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('news.create') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('common.dashboard') }}</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.news.index') }}">{{ __('news.title') }}</a></div>
            <div class="breadcrumb-item">{{ __('common.create') }}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-lg-10">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('news.create_new') }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" id="newsCreateForm">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="language_select">{{ __('news.language') }} <span class="text-danger">*</span></label>
                                        <select class="form-control select2 @error('language') is-invalid @enderror" id="language_select" name="language" data-placeholder="{{ __('common.select') }}">
                                            <option value=""></option>
                                            @foreach($languages as $language)
                                                <option value="{{ $language->code }}" @selected(old('language') === $language->code)>{{ $language->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('language')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">{{ __('news.category') }} <span class="text-danger">*</span></label>
                                        <select class="form-control select2 @error('category') is-invalid @enderror" id="category" name="category" data-placeholder="{{ __('common.select') }}">
                                            <option value="">{{ __('common.select') }}</option>
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('news.image') }} <span class="text-danger">*</span></label>
                                        <div id="image-preview" class="image-preview">
                                            <label for="image-upload" id="image-label">{{ __('news.choose_image') }}</label>
                                            <input type="file" name="image" id="image-upload" accept="image/*">
                                        </div>
                                        @error('image')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">{{ __('news.title_field') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="{{ __('news.title_placeholder') }}">
                                        @error('title')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="content">{{ __('news.content') }} <span class="text-danger">*</span></label>
                                <textarea class="form-control summernote @error('content') is-invalid @enderror" id="content" name="content">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tags">{{ __('news.tags') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" value="{{ old('tags') }}" data-role="tagsinput" placeholder="{{ __('news.tags_placeholder') }}">
                                <small class="form-text text-muted">{{ __('news.tags_hint') }}</small>
                                @error('tags')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meta_title">{{ __('news.meta_title') }}</label>
                                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" value="{{ old('meta_title') }}">
                                        @error('meta_title')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meta_description">{{ __('news.meta_description') }}</label>
                                        <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="4">{{ old('meta_description') }}</textarea>
                                        @error('meta_description')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="custom-control custom-switch mt-2">
                                        <input type="hidden" name="status" value="0">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" @checked(old('status', 1) == 1)>
                                        <label class="custom-control-label" for="status">{{ __('common.status') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-switch mt-2">
                                        <input type="hidden" name="is_breaking_news" value="0">
                                        <input type="checkbox" class="custom-control-input" id="is_breaking_news" name="is_breaking_news" value="1" @checked(old('is_breaking_news') == 1)>
                                        <label class="custom-control-label" for="is_breaking_news">{{ __('news.is_breaking_news') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-switch mt-2">
                                        <input type="hidden" name="show_at_slider" value="0">
                                        <input type="checkbox" class="custom-control-input" id="show_at_slider" name="show_at_slider" value="1" @checked(old('show_at_slider') == 1)>
                                        <label class="custom-control-label" for="show_at_slider">{{ __('news.show_at_slider') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-switch mt-2">
                                        <input type="hidden" name="show_at_popular" value="0">
                                        <input type="checkbox" class="custom-control-input" id="show_at_popular" name="show_at_popular" value="1" @checked(old('show_at_popular') == 1)>
                                        <label class="custom-control-label" for="show_at_popular">{{ __('news.show_at_popular') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> {{ __('news.create') }}
                                </button>
                                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
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
        const categorySelect = $('#category');
        const oldCategory = @json(old('category'));

        function initializeCategorySelect() {
            categorySelect.select2({
                width: '100%',
                placeholder: "{{ __('common.select') }}"
            });
        }

        function loadCategories(languageCode, selectedValue = null) {
            categorySelect.empty().append(new Option("{{ __('common.select') }}", ''));

            if (!languageCode) {
                categorySelect.trigger('change.select2');
                return;
            }

            $.ajax({
                url: "{{ route('admin.news.fetch-category') }}",
                type: 'GET',
                data: {
                    lang: languageCode
                },
                success: function(response) {
                    $.each(response, function(index, category) {
                        const option = new Option(category.name, category.id, false, String(selectedValue) === String(category.id));
                        categorySelect.append(option);
                    });

                    categorySelect.trigger('change.select2');
                },
                error: function() {
                    Swal.fire({
                        title: "{{ __('common.error') }}",
                        text: "{{ __('news.category_fetch_failed') }}",
                        icon: 'error'
                    });
                }
            });
        }

        $('#language_select').select2({
            allowClear: true,
            width: '100%',
            placeholder: "{{ __('common.select') }}"
        }).on('change', function() {
            loadCategories($(this).val());
        });

        initializeCategorySelect();

        $('.summernote').summernote({
            height: 280,
            dialogsInBody: true
        });

        $.uploadPreview({
            input_field: '#image-upload',
            preview_box: '#image-preview',
            label_field: '#image-label',
            label_default: "{{ __('news.choose_image') }}",
            label_selected: "{{ __('news.change_image') }}",
            no_label: false,
            success_callback: null
        });

        const initialLanguage = $('#language_select').val();
        if (initialLanguage) {
            loadCategories(initialLanguage, oldCategory);
        }

        $('#newsCreateForm').on('submit', function() {
            if ($('.summernote').summernote('isEmpty')) {
                $('#content').val('');
            }
        });
    });
</script>
@endpush
@endsection
