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

                <button type="button" class="mb-2 btn btn-sm" style="background-color:#202c46 ; color:rgb(255, 255, 255)" id="add-category">Add Category</button>


                <div id="category-container" style="background-color:rgb(240, 240, 240); padding:1%">
                    <!-- Initial category selection block -->
                    <div class="category-group">
                        <!-- Hidden input to store selected category ID -->
                        <input type="hidden" name="category_ids[]" class="category_ids" value="">
                        <div class="d-flex gap-3 mb-3">
                            <div class="mb-3 col-3">
                                <label for="parent_category" class="form-label">Parent Category:</label>
                                <select class="form-select parent_category" name="parent_category[]">
                                    <option value="">Select Parent Category</option>
                                    @foreach ($categories as $category)
                                        @if ($category->category_type == 'parent')
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div style="display: none;" class="mb-3 col-3 sub1_container">
                                <label for="sub1_category" class="form-label">Subcategory Level 1:</label>
                                <select class="form-select sub1_category" name="sub1_category[]">
                                    <option value="">Select Subcategory Level 1</option>
                                </select>
                            </div>

                            <div style="display: none;" class="mb-3 col-3 sub2_container">
                                <label for="sub2_category" class="form-label">Subcategory Level 2:</label>
                                <select class="form-select sub2_category" name="sub2_category[]">
                                    <option value="">Select Subcategory Level 2</option>
                                </select>
                            </div>

                            <div class="mt-3 col-3 d-flex align-items-center">
                                <button type="button" class="btn btn-danger btn-sm remove-category-button">Remove</button>
                            </div>
                        </div>
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

        function setupCategorySelection(categoryGroup) {
            const categoryIdsInput = categoryGroup.find('.category_ids');

            categoryGroup.find('.parent_category').change(function() {
                const parentId = $(this).val();
                const sub1Container = categoryGroup.find('.sub1_container');
                const sub2Container = categoryGroup.find('.sub2_container');
                const sub1Select = categoryGroup.find('.sub1_category');
                const sub2Select = categoryGroup.find('.sub2_category');

                sub1Select.empty().append('<option value="">Select Subcategory Level 1</option>');
                sub2Select.empty().append('<option value="">Select Subcategory Level 2</option>');

                if (parentId) {
                    const selectedCategory = categories.find(cat => cat.id == parentId);
                    const subcategoriesLevelOne = selectedCategory ? selectedCategory.subcategories_level_one : [];

                    if (subcategoriesLevelOne.length > 0) {
                        sub1Container.show();
                        subcategoriesLevelOne.forEach(subcategoryL1 => {
                            sub1Select.append('<option value="' + subcategoryL1.id + '">' + subcategoryL1.category_name + '</option>');
                        });
                    } else {
                        sub1Container.hide();
                    }

                    sub2Container.hide();
                    categoryIdsInput.val(parentId); // Store the selected parent ID
                } else {
                    sub1Container.hide();
                    sub2Container.hide();
                    categoryIdsInput.val(''); // Clear the ID if no parent is selected
                }
            });

            categoryGroup.find('.sub1_category').change(function() {
                const sub1Id = $(this).val();
                const sub2Container = categoryGroup.find('.sub2_container');
                const sub2Select = categoryGroup.find('.sub2_category');

                sub2Select.empty().append('<option value="">Select Subcategory Level 2</option>');

                if (sub1Id) {
                    const subcategoryLevelOne = categories
                        .flatMap(cat => cat.subcategories_level_one)
                        .find(sub => sub.id == sub1Id);

                    const subcategoriesLevelTwo = subcategoryLevelOne ? subcategoryLevelOne.subcategories_level_two : [];

                    if (subcategoriesLevelTwo.length > 0) {
                        sub2Container.show();
                        subcategoriesLevelTwo.forEach(subcategoryL2 => {
                            sub2Select.append('<option value="' + subcategoryL2.id + '">' + subcategoryL2.category_name + '</option>');
                        });
                    } else {
                        sub2Container.hide();
                    }

                    categoryIdsInput.val(sub1Id); // Store the selected subcategory level 1 ID
                } else {
                    sub2Container.hide();
                    categoryIdsInput.val(categoryGroup.find('.parent_category').val()); // Fallback to parent ID
                }
            });

            categoryGroup.find('.sub2_category').change(function() {
                const sub2Id = $(this).val();
                categoryIdsInput.val(sub2Id); // Store the selected subcategory level 2 ID
            });

            categoryGroup.find('.remove-category-button').click(function() {
                categoryGroup.remove();
            });
        }

        $('#add-category').click(function() {
            const newCategoryGroup = $('.category-group:first').clone();
            newCategoryGroup.find('select').val(''); // Reset the selects
            newCategoryGroup.find('.sub1_container').hide();
            newCategoryGroup.find('.sub2_container').hide();
            newCategoryGroup.find('.category_ids').val(''); // Clear the hidden input
            $('#category-container').append(newCategoryGroup);
            setupCategorySelection(newCategoryGroup);
        });

        setupCategorySelection($('.category-group:first')); // Initialize for the first category group
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
