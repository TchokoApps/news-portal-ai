@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('news.title') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('common.dashboard') }}</a></div>
            <div class="breadcrumb-item">{{ __('news.all_news') }}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('news.all_news') }}</h4>
                        <div class="card-header-action">
                            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> {{ __('news.create_new') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="newsTable">
                                <thead>
                                    <tr>
                                        <th>{{ __('common.id') }}</th>
                                        <th>{{ __('news.image') }}</th>
                                        <th>{{ __('news.title_field') }}</th>
                                        <th>{{ __('news.language') }}</th>
                                        <th>{{ __('news.category') }}</th>
                                        <th>{{ __('news.author') }}</th>
                                        <th>{{ __('news.tags') }}</th>
                                        <th>{{ __('common.status') }}</th>
                                        <th>{{ __('common.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($newsItems as $news)
                                        <tr>
                                            <td>{{ $news->id }}</td>
                                            <td>
                                                @if($news->image_url)
                                                    <img src="{{ $news->image_url }}" alt="{{ $news->title }}" width="70" class="img-fluid rounded">
                                                @else
                                                    <span class="badge badge-light">{{ __('common.na') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="font-weight-600">{{ $news->title }}</div>
                                                <div class="text-muted small">/{{ $news->slug }}</div>
                                            </td>
                                            <td>{{ strtoupper($news->language) }}</td>
                                            <td>{{ $news->category?->name ?? __('common.na') }}</td>
                                            <td>{{ $news->author?->name ?? __('common.na') }}</td>
                                            <td>
                                                @forelse($news->tags as $tag)
                                                    <span class="badge badge-info">{{ $tag->name }}</span>
                                                @empty
                                                    <span class="badge badge-light">{{ __('common.na') }}</span>
                                                @endforelse
                                            </td>
                                            <td>
                                                @if($news->status)
                                                    <span class="badge badge-success">{{ __('common.active') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ __('common.inactive') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-sm btn-info" title="{{ __('common.edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.news.destroy', $news->id) }}" class="btn btn-sm btn-danger delete-item" data-url="{{ route('admin.news.destroy', $news->id) }}" title="{{ __('common.delete') }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted">{{ __('news.no_news_found') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#newsTable').DataTable({
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            language: {
                search: "{{ __('common.search') }}:",
                lengthMenu: "{{ __('common.show') }} _MENU_ {{ __('common.entries') }}",
                info: "{{ __('common.showing') }} _START_ {{ __('common.to') }} _END_ {{ __('common.of') }} _TOTAL_ {{ __('common.entries') }}",
                paginate: {
                    previous: "{{ __('common.previous') }}",
                    next: "{{ __('common.next') }}"
                }
            }
        });

        $('.delete-item').on('click', function(e) {
            e.preventDefault();
            const deleteUrl = $(this).data('url');

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
                if (!result.isConfirmed) {
                    return;
                }

                $.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: "{{ __('common.success') }}",
                                text: response.message,
                                icon: 'success'
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: "{{ __('common.error') }}",
                            text: "{{ __('common.delete_failed') }}",
                            icon: 'error'
                        });
                    }
                });
            });
        });
    });
</script>
@endpush
@endsection
