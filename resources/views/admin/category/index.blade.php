@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            Category List
            @can('category_create')
                <a class="btn btn-success btn-sm text-white float-end" href="{{ route('admin.category.create') }}">
                    Add New
                </a>
            @endcan


        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Main Category</th>
                            <th>Subcategory Level One</th>
                            <th>Subcategory Level Two</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($category as $category)
                            @if ($category->subcategoriesLevelOne->count())
                                @foreach ($category->subcategoriesLevelOne as $indexL1 => $subcategoryL1)
                                    <tr>
                                        @if ($indexL1 === 0)
                                            <td rowspan="{{ $category->subcategoriesLevelOne->count() }}"
                                                style="vertical-align: middle;">{{ $category->category_name }}</td>
                                        @endif

                                        <td>{{ $subcategoryL1->category_name }}</td>
                                        <td style="border-right: 1px solid #dee2e6;">
                                            <ul>
                                                @foreach ($subcategoryL1->subcategoriesLevelTwo as $subcategoryL2)
                                                    <li>{{ $subcategoryL2->category_name }}</li>
                                                @endforeach
                                            </ul>
                                        </td>

                                        @if ($indexL1 === 0)
                                            <td rowspan="{{ $category->subcategoriesLevelOne->count() }}"
                                                style="vertical-align: middle;">
                                                <a class="btn btn-sm btn-primary mb-1"
                                                    href="{{ route('admin.category.edit', $category->id) }}">
                                                    Edit
                                                </a>

                                                <a href="javascript:void(0)" class="btn btn-sm btn-danger mb-1"
                                                    onclick="
                                                if(confirm('Are you sure, You want to Delete this ??'))
                                                {
                                                    event.preventDefault();
                                                    document.getElementById('delete-form-{{ $category->id }}').submit();
                                                }">Delete
                                                </a>
                                                <form id="delete-form-{{ $category->id }}" method="post"
                                                    action="{{ route('admin.category.destroy', $category->id) }}"
                                                    style="display: none">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="border-right: 1px solid #dee2e6;">{{ $category->category_name }}</td>
                                    <td style="border-right: 1px solid #dee2e6;">-</td>
                                    <td style="border-right: 1px solid #dee2e6;">-</td>
                                    <td style="vertical-align: middle;">
                                        <a class="btn btn-sm btn-primary mb-1"
                                            href="{{ route('admin.category.edit', $category->id) }}">
                                            Edit
                                        </a>

                                        <a href="javascript:void(0)" class="btn btn-sm btn-danger mb-1"
                                            onclick="
                                                if(confirm('Are you sure, You want to Delete this ??'))
                                                {
                                                    event.preventDefault();
                                                    document.getElementById('delete-form-{{ $category->id }}').submit();
                                                }">Delete
                                        </a>
                                        <form id="delete-form-{{ $category->id }}" method="post"
                                            action="{{ route('admin.category.destroy', $category->id) }}"
                                            style="display: none">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
