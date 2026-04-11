@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('languages.title') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('common.dashboard') }}</a></div>
            <div class="breadcrumb-item">{{ __('languages.title') }}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('languages.all_languages') }}</h4>
                        <div class="card-header-action">
                            <a href="{{ route('admin.language.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> {{ __('languages.create_new') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($languages->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="languagesTable">
                                    <thead>
                                        <tr>
                                            <th>{{ __('common.id') }}</th>
                                            <th>{{ __('languages.name') }}</th>
                                            <th>{{ __('languages.code') }}</th>
                                            <th>{{ __('languages.flag') }}</th>
                                            <th>{{ __('languages.default') }}</th>
                                            <th>{{ __('common.status') }}</th>
                                            <th>{{ __('common.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($languages as $language)
                                        <tr>
                                            <td>{{ $language->id }}</td>
                                            <td>{{ $language->name }}</td>
                                            <td><span class="badge badge-info">{{ $language->code }}</span></td>
                                            <td>{{ $language->flag_code ?? __('common.na') }}</td>
                                            <td>
                                                @if($language->is_default)
                                                    <span class="badge badge-primary"><i class="fas fa-check"></i> {{ __('common.yes') }}</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ __('common.no') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($language->is_active)
                                                    <span class="badge badge-success">{{ __('common.active') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ __('common.inactive') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.language.edit', $language->id) }}" class="btn btn-sm btn-info" title="{{ __('common.edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="javascript:void(0)" class="btn btn-sm btn-danger delete-language" data-id="{{ $language->id }}" data-url="{{ route('admin.language.destroy', $language->id) }}" title="{{ __('common.delete') }}">
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
                                {{ __('languages.no_languages') }} <a href="{{ route('admin.language.create') }}" class="alert-link">{{ __('languages.create_now') }}</a>
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
        // Initialize DataTable
        $('#languagesTable').DataTable({
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

        // Handle delete button clicks
        $(document).on('click', '.delete-language', function(e) {
            e.preventDefault();
            const languageId = $(this).data('id');
            const deleteUrl = $(this).data('url');

            Swal.fire({
                title: "{{ __('common.confirm') }}",
                text: "{{ __('languages.delete_confirmation') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: "{{ __('common.delete') }}",
                cancelButtonText: "{{ __('common.cancel') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX delete request
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        success: function(response) {
                            Swal.fire({
                                title: "{{ __('common.success') }}",
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: "{{ __('common.ok') }}"
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            try {
                                const response = JSON.parse(xhr.responseText);
                                Swal.fire({
                                    title: "{{ __('common.error') }}",
                                    text: response.message || "{{ __('languages.deletion_failed') }}",
                                    icon: 'error',
                                    confirmButtonText: "{{ __('common.ok') }}"
                                });
                            } catch(e) {
                                Swal.fire({
                                    title: "{{ __('common.error') }}",
                                    text: "{{ __('languages.deletion_failed') }}",
                                    icon: 'error',
                                    confirmButtonText: "{{ __('common.ok') }}"
                                });
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
@endsection
