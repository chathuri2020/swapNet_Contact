@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            Contact List
            @can('contact_create')
            <a class="btn btn-success btn-sm text-white float-end" href="{{ route('admin.contact.create') }}">
                Add New
            </a>
            @endcan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Company name</th>
                            <th>Registration Number</th>
                            <th>Category</th>
                            @can('contact_edit')
                            <th>Action</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $key => $role)
                            <tr data-entry-id="{{ $role->id }}">
                                <td>{{ $role->id ?? '' }}</td>
                                <td>{{ $role->name ?? '' }}</td>
                                <td>{{ $role->address ?? '' }}</td>
                                <td>{{ $role->email ?? '' }}</td>
                                <td>{{ $role->company_name ?? '' }}</td>
                                <td>{{ $role->company_registration_number ?? '' }}</td>
                                <td>
                                    @if ($role->categories->isNotEmpty())
                                        @foreach ($role->categories as $category)
                                            @if ($category->category_type == 'sub2')
                                                @php
                                                    $sublevel1 = \App\Models\Category::find($category->reference_id);
                                                    $sublevel1Parent = $sublevel1
                                                        ? \App\Models\Category::find($sublevel1->reference_id)
                                                        : null;
                                                @endphp
                                                <!-- Level 2 category -->
                                                @if ($sublevel1)
                                                    <!-- Level 1 category -->
                                                    @if ($sublevel1Parent)
                                                        <!-- Parent category -->
                                                        <div class="mb-2">
                                                            <ul class="list-unstyled">
                                                                <!-- Parent category -->
                                                                <li>
                                                                    <span class="me-2">•</span>
                                                                    {{ $sublevel1Parent->category_name }}<br>
                                                                    <!-- Level 1 category -->
                                                                    <ul class="list-unstyled ps-4">
                                                                        <li>
                                                                            <span class="me-2">◦</span>
                                                                            {{ $sublevel1->category_name }}<br>
                                                                            <!-- Level 2 category -->
                                                                            <ul class="list-unstyled ps-4">
                                                                                <li>
                                                                                    <span class="me-2">▸</span>
                                                                                    <strong>{{ $category->category_name }}</strong>
                                                                                </li>
                                                                            </ul>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @else
                                                        <!-- Only Level 1 category available -->
                                                        <div class="mb-2">
                                                            <ul class="list-unstyled">
                                                                <!-- Level 1 category -->
                                                                <li>
                                                                    <span class="me-2">◦</span>
                                                                    {{ $sublevel1->category_name }}<br>
                                                                    <!-- Level 2 category -->
                                                                    <ul class="list-unstyled ps-4">
                                                                        <li>
                                                                            <span class="me-2">▸</span>
                                                                            <strong>{{ $category->category_name }}</strong>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                @endif
                                            @elseif($category->category_type == 'sub1')
                                                @php
                                                    $parentCategory = \App\Models\Category::find(
                                                        $category->reference_id,
                                                    );
                                                @endphp
                                                <!-- Level 1 category -->
                                                @if ($parentCategory)
                                                    <!-- Parent category -->
                                                    <div class="mb-2">
                                                        <ul class="list-unstyled">
                                                            <!-- Parent category -->
                                                            <li>
                                                                <span class="me-2">•</span>
                                                                {{ $parentCategory->category_name }}<br>
                                                                <!-- Level 1 category -->
                                                                <ul class="list-unstyled ps-4">
                                                                    <li>
                                                                        <span class="me-2">◦</span>
                                                                        <strong>{{ $category->category_name }}</strong>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @else
                                                    <!-- Only Level 1 category available -->
                                                    <div class="mb-2">
                                                        <ul class="list-unstyled">
                                                            <!-- Level 1 category -->
                                                            <li>
                                                                <span class="me-2">◦</span>
                                                                <strong>{{ $category->category_name }}</strong>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            @else
                                                <!-- Parent category -->
                                                <div class="mb-2">
                                                    <ul class="list-unstyled">
                                                        <li>
                                                            <span class="me-2">•</span>
                                                            <strong>{{ $category->category_name }}</strong>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <span class="text-muted">No Categories</span>
                                    @endif
                                </td>
                                @can('contact_edit')
                                <td>

                                        <a class="btn btn-sm btn-info mb-1"
                                            href="{{ route('admin.contact.edit', $role->id) }}">Edit</a>
                                    @endcan

                                    @can('contact_delete')
                                    <a class="btn btn-sm btn-danger text-white" href="javascript:void(0)"
                                        onclick="
                                    if(confirm('Are you sure you want to delete this?')) {
                                        event.preventDefault();
                                        document.getElementById('delete-form-{{ $role->id }}').submit();
                                    }
                                ">Delete
                                    </a>

                                    <!-- Hidden Delete Form -->
                                    <form id="delete-form-{{ $role->id }}"
                                        action="{{ route('admin.contact.destroy', $role->id) }}" method="POST"
                                        style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endcan

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
