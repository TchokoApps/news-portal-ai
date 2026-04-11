@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Languages</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Languages</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>All Languages</h4>
                        <div class="card-header-action">
                            <a href="{{ route('admin.language.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create New
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($languages->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Language Name</th>
                                            <th>Language Code</th>
                                            <th>Flag Code</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($languages as $language)
                                        <tr>
                                            <td>{{ $language->id }}</td>
                                            <td>{{ $language->name }}</td>
                                            <td><span class="badge badge-info">{{ $language->code }}</span></td>
                                            <td>{{ $language->flag_code ?? 'N/A' }}</td>
                                            <td>
                                                @if($language->is_active)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.language.edit', $language->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.language.destroy', $language->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info" role="alert">
                                No languages found. <a href="{{ route('admin.language.create') }}" class="alert-link">Create one now</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
