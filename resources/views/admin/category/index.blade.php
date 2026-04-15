@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('categories.title') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('common.dashboard') }}</a></div>
            <div class="breadcrumb-item">{{ __('categories.title') }}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('categories.all_categories') }}</h4>
                        <div class="card-header-action">
                            <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> {{ __('categories.create_new') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($languages->count() > 0)
                            <!-- Language Tabs Navigation -->
                            <ul class="nav nav-tabs border-bottom" role="tablist">
                                @foreach($languages as $language)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link @if($loop->first) active @endif"
                                           id="tab-{{ $language->code }}"
                                           data-toggle="tab"
                                           href="#content-{{ $language->code }}"
                                           role="tab"
                                           aria-controls="content-{{ $language->code }}"
                                           @if($loop->first) aria-selected="true" @else aria-selected="false" @endif>
                                            {{ $language->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <!-- Tab Contents -->
                            <div class="tab-content mt-3">
                                @foreach($languages as $language)
                                    <div class="tab-pane fade @if($loop->first) show active @endif"
                                         id="content-{{ $language->code }}"
                                         role="tabpanel"
                                         aria-labelledby="tab-{{ $language->code }}">

                                        @php
                                            $categories = \App\Models\Category::where('language', $language->code)
                                                ->orderBy('id', 'desc')
                                                ->get();
                                        @endphp

                                        @if($categories->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover" id="categoriesTable-{{ $language->code }}">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('common.id') }}</th>
                                                            <th>{{ __('categories.name') }}</th>
                                                            <th>{{ __('categories.slug') }}</th>
                                                            <th>{{ __('categories.language') }}</th>
                                                            <th>{{ __('categories.show_at_nav') }}</th>
                                                            <th>{{ __('categories.status') }}</th>
                                                            <th>{{ __('common.actions') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($categories as $category)
                                                        <tr>
                                                            <td>{{ $category->id }}</td>
                                                            <td>{{ $category->name }}</td>
                                                            <td><span class="badge badge-info">{{ $category->slug }}</span></td>
                                                            <td>{{ $category->language }}</td>
                                                            <td>
                                                                @if($category->show_at_nav)
                                                                    <span class="badge badge-success">
                                                                        <i class="fas fa-check"></i> {{ __('common.yes') }}
                                                                    </span>
                                                                @else
                                                                    <span class="badge badge-secondary">{{ __('common.no') }}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($category->status)
                                                                    <span class="badge badge-success">{{ __('common.active') }}</span>
                                                                @else
                                                                    <span class="badge badge-danger">{{ __('common.inactive') }}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-sm btn-info" title="{{ __('common.edit') }}">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <a href="{{ route('admin.category.destroy', $category->id) }}" class="btn btn-sm btn-danger delete-item" data-url="{{ route('admin.category.destroy', $category->id) }}" title="{{ __('common.delete') }}">
                                                                    <i class="fas fa-trash"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-info" role="alert">
                                                {{ __('categories.no_categories', ['language' => $language->name]) }}
                                                <a href="{{ route('admin.category.create') }}" class="alert-link">{{ __('categories.create_now') }}</a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning" role="alert">
                                {{ __('categories.no_languages_available') }}
                                <a href="{{ route('admin.language.create') }}" class="alert-link">{{ __('categories.create_language_first') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    $(document).ready(function() {
        @foreach($languages as $language)
            // Initialize DataTable for {{ $language->code }}
            $('#categoriesTable-{{ $language->code }}').DataTable({
                "pageLength": 25,
                "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
                "language": {
                    "search": "{{ __('common.search') }}:",
                    "lengthMenu": "{{ __('common.show') }} _MENU_ {{ __('common.entries') }}",
                    "info": "{{ __('common.showing') }} _START_ {{ __('common.to') }} _END_ {{ __('common.of') }} _TOTAL_ {{ __('common.entries') }}",
                    "paginate": {
                        "previous": "{{ __('common.previous') }}",
                        "next": "{{ __('common.next') }}"
                    }
                }
            });
        @endforeach

        // Delete confirmation
        $('.delete-item').on('click', function(e) {
            e.preventDefault();
            const deleteUrl = $(this).attr('data-url');

            Swal.fire({
                title: "{{ __('common.confirm_delete') }}",
                text: "{{ __('common.delete_warning') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: "{{ __('common.yes_delete') }}",
                cancelButtonText: "{{ __('common.cancel') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: "{{ __('common.success') }}",
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "{{ __('common.error') }}",
                                text: "{{ __('common.delete_failed') }}",
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
@endsection
