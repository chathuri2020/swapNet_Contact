@extends('layouts.master')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            Create Contact
        </div>
        <form action="{{ route("admin.contact.store") }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="title">Name*</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('title', isset($role) ? $role->name : '') }}" required>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="title">Address*</label>
                    <input type="text" id="title" name="address" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('title', isset($role) ? $role->name : '') }}" required>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="title">Email*</label>
                    <input type="text" id="title" name="email" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('title', isset($role) ? $role->name : '') }}" required>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="title">Company Name*</label>
                    <input type="text" id="title" name="company_name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('title', isset($role) ? $role->name : '') }}" required>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="title">Company Registration Number*</label>
                    <input type="text" id="title" name="company_registration_number" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('title', isset($role) ? $role->name : '') }}" required>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="permissions">Categories*
                        <span class="btn btn-info btn-sm select-all">Select All</span>
                        <span class="btn btn-info btn-sm deselect-all">Deselect All</span></label>
                    <select name="permissions[]" id="permissions"
                            class="form-control select2 @error('permissions') is-invalid @enderror" multiple="multiple"
                            required>
                        @foreach($permissions as $id => $permissions)
                            <option
                                value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || isset($role) && $role->permissions->contains($id)) ? 'selected' : '' }}>{{ $permissions }}</option>
                        @endforeach
                    </select>
                    @error('permissions')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

           {{--      <div class="mb-3">
                    <label for="category">Category*</label>
                    <select name="category" id="category" class="form-control">
                        <option value="">Select Category</option>
                        @foreach($category as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="subcategory-level-one">Subcategory Level 1*</label>
                    <select name="subcategory_level_one" id="subcategory-level-one" class="form-control" disabled>
                        <option value="">Select Subcategory Level 1</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="subcategory-level-two">Subcategory Level 2*</label>
                    <select name="subcategory_level_two" id="subcategory-level-two" class="form-control" disabled>
                        <option value="">Select Subcategory Level 2</option>
                    </select>
                </div>
 --}}


            </div>
            <div class="card-footer">
                <button class="btn btn-primary me-2" type="submit">Save</button>
                <a class="btn btn-secondary" href="{{ route('admin.contact.index') }}">
                    Back to list
                </a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.select-all').click(function () {
                let $select2 = $(this).parent().siblings('.select2')
                $select2.find('option').prop('selected', 'selected')
                $select2.trigger('change')
            })
            $('.deselect-all').click(function () {
                let $select2 = $(this).parent().siblings('.select2')
                $select2.find('option').prop('selected', '')
                $select2.trigger('change')
            })

            $(".select2").select2({
                tags: true
            });
        });
    </script>

@endsection
