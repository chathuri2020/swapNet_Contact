@extends('layouts.master')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            Create Contact
        </div>
        <form action="{{ route('admin.contact.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="title">Name*</label>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('title', isset($role) ? $role->name : '') }}" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="title">Address*</label>
                    <input type="text" id="title" name="address"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('title', isset($role) ? $role->name : '') }}" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="title">Email*</label>
                    <input type="text" id="title" name="email"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('title', isset($role) ? $role->name : '') }}" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="title">Company Name*</label>
                    <input type="text" id="title" name="company_name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('title', isset($role) ? $role->name : '') }}" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="title">Company Registration Number*</label>
                    <input type="text" id="title" name="company_registration_number"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('title', isset($role) ? $role->name : '') }}" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{--  <div class="mb-3">
                    <label for="permissions">Categories*
                        <span class="btn btn-info btn-sm select-all">Select All</span>
                        <span class="btn btn-info btn-sm deselect-all">Deselect All</span></label>
                    <select name="permissions[]" id="permissions"
                            class="form-control select2 @error('permissions') is-invalid @enderror" multiple="multiple"
                            required>
                            @foreach ($category as $category)
                            @foreach ($category->subcategoriesLevelOne as $indexL1 => $subcategoryL1)

                                    @if ($indexL1 === 0)
                                        <td rowspan="{{ $category->subcategoriesLevelOne->count() }}" style="vertical-align: middle;">{{ $category->category_name }}</td>
                                    @endif

                                        <option value="1">{{ $subcategoryL1->category_name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                    @error('permissions')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
--}}




                {{--      <div class="mb-3">
                    <label for="category">Category*</label>
                    <select name="category" id="category" class="form-control">
                        <option value="">Select Category</option>
                        @foreach ($category as $category)
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

                <div class="d-flex gap-3 mb-3">
                    <input type="hidden" name="category_id" id="selected_category_id" value="">
                    <div class="mb-3 col-3">
                        <label for="parent_category" class="form-label">Parent Category:</label>
                        <select id="parent_category" name="parent_category" class="form-select ">
                            <option value="">Select Parent Category</option>
                            @foreach ($categories as $category)
                                @if ($category->category_type == 'parent')
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Subcategory Level 1 Selection -->
                    <div id="sub1_container" style="display: none;" class="mb-3 col-3">
                        <label for="sub1_category" class="form-label">Subcategory Level 1:</label>
                        <select id="sub1_category" name="sub1_category" class="form-select">
                            <option value="">Select Subcategory Level 1</option>
                        </select>
                    </div>

                    <!-- Subcategory Level 2 Selection -->
                    <div id="sub2_container" style="display: none;" class="mb-3 col-3">
                        <label for="sub2_category" class="form-label">Subcategory Level 2:</label>
                        <select id="sub2_category" name="sub2_category" class="form-select">
                            <option value="">Select Subcategory Level 2</option>
                        </select>
                    </div>
                </div>

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
       $(document).ready(function() {
    const categories = @json($categories);

    // Hidden input to store the selected last level category ID
    let selectedCategoryId = '';

    $('#parent_category').change(function() {
        const parentId = $(this).val();
        $('#sub1_category').empty().append('<option value="">Select Subcategory Level 1</option>');
        $('#sub2_category').empty().append('<option value="">Select Subcategory Level 2</option>');
        $('#selected_category_id').val(parentId); // Always store the parent ID initially

        if (parentId) {
            const selectedCategory = categories.find(cat => cat.id == parentId);
            const subcategoriesLevelOne = selectedCategory ? selectedCategory.subcategories_level_one : [];

            if (subcategoriesLevelOne.length > 0) {
                $('#sub1_container').show();
                subcategoriesLevelOne.forEach(subcategoryL1 => {
                    $('#sub1_category').append('<option value="' + subcategoryL1.id + '">' + subcategoryL1.category_name + '</option>');
                });
            } else {
                $('#sub1_container').hide();
            }

            $('#sub2_container').hide();
        } else {
            $('#sub1_container').hide();
            $('#sub2_container').hide();
        }
    });

    $('#sub1_category').change(function() {
        const sub1Id = $(this).val();
        $('#sub2_category').empty().append('<option value="">Select Subcategory Level 2</option>');
        $('#selected_category_id').val(sub1Id); // Store Level 1 ID if selected

        if (sub1Id) {
            const subcategoryLevelOne = categories
                .flatMap(cat => cat.subcategories_level_one)
                .find(sub => sub.id == sub1Id);

            const subcategoriesLevelTwo = subcategoryLevelOne ? subcategoryLevelOne.subcategories_level_two : [];

            if (subcategoriesLevelTwo.length > 0) {
                $('#sub2_container').show();
                subcategoriesLevelTwo.forEach(subcategoryL2 => {
                    $('#sub2_category').append('<option value="' + subcategoryL2.id + '">' + subcategoryL2.category_name + '</option>');
                });
            } else {
                $('#sub2_container').hide();
            }
        } else {
            $('#sub2_container').hide();
            $('#selected_category_id').val($('#parent_category').val()); // Fallback to parent ID
        }
    });

    $('#sub2_category').change(function() {
        const sub2Id = $(this).val();
        $('#selected_category_id').val(sub2Id); // Store Level 2 ID if selected
    });
});





        $(document).ready(function() {
            $('.select-all').click(function() {
                let $select2 = $(this).parent().siblings('.select2')
                $select2.find('option').prop('selected', 'selected')
                $select2.trigger('change')
            })
            $('.deselect-all').click(function() {
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
