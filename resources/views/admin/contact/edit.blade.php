@extends('layouts.master')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            Edit Contact
        </div>
        <form action="{{ route('admin.contact.update', $contact->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="mb-3">
                    <label for="name">Name*</label>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $contact->name) }}"
                        required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address">Address*</label>
                    <input type="text" id="address" name="address"
                        class="form-control @error('address') is-invalid @enderror"
                        value="{{ old('address', $contact->address) }}" required>
                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email">Email*</label>
                    <input type="text" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $contact->email) }}" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="company_name">Company Name*</label>
                    <input type="text" id="company_name" name="company_name"
                        class="form-control @error('company_name') is-invalid @enderror"
                        value="{{ old('company_name', $contact->company_name) }}" required>
                    @error('company_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="company_registration_number">Company Registration Number*</label>
                    <input type="text" id="company_registration_number" name="company_registration_number"
                        class="form-control @error('company_registration_number') is-invalid @enderror"
                        value="{{ old('company_registration_number', $contact->company_registration_number) }}" required>
                    @error('company_registration_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="button" class="mb-2 btn btn-sm" style="background-color:#202c46 ; color:rgb(255, 255, 255)"
                    id="add-category">Add Category</button>

                <div id="category-container" style="background-color:rgb(240, 240, 240); padding:1%">
                    @foreach ($selectedCategories as $selected)
                        <div class="category-group">
                            <input type="hidden" name="category_ids[]" class="category_ids"
                                value="{{ $selected['sub2'] ? $selected['sub2']->id : ($selected['sub1'] ? $selected['sub1']->id : $selected['parent']->id) }}">
                            <div class="d-flex gap-3 mb-3">
                                <!-- Parent Category -->
                                <div class="mb-3 col-3">
                                    <label for="parent_category" class="form-label">Parent Category:</label>
                                    <select class="form-select parent_category" name="parent_category[]">
                                        <option value="">Select Parent Category</option>
                                        @foreach ($parentCategories as $parent)
                                            <option value="{{ $parent->id }}"
                                                {{ $selected['parent'] && $parent->id == $selected['parent']->id ? 'selected' : '' }}>
                                                {{ $parent->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Subcategory Level 1 -->
                                <div class="mb-3 col-3 sub1_container"
                                    style="display: {{ $selected['sub1'] ? 'block' : 'none' }};">
                                    <label for="sub1_category" class="form-label">Subcategory Level 1:</label>
                                    <select class="form-select sub1_category" name="sub1_category[]">
                                        <option value="">Select Subcategory Level 1</option>
                                        @if ($selected['parent'])
                                            @foreach ($sub1Categories->where('reference_id', $selected['parent']->id) as $sub1)
                                                <option value="{{ $sub1->id }}"
                                                    {{ $selected['sub1'] && $sub1->id == $selected['sub1']->id ? 'selected' : '' }}>
                                                    {{ $sub1->category_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <!-- Subcategory Level 2 -->
                                <div class="mb-3 col-3 sub2_container"
                                    style="display: {{ $selected['sub2'] ? 'block' : 'none' }};">
                                    <label for="sub2_category" class="form-label">Subcategory Level 2:</label>
                                    <select class="form-select sub2_category" name="sub2_category[]">
                                        <option value="">Select Subcategory Level 2</option>
                                        @if ($selected['sub1'])
                                            @foreach ($sub2Categories->where('reference_id', $selected['sub1']->id) as $sub2)
                                                <option value="{{ $sub2->id }}"
                                                    {{ $selected['sub2'] && $sub2->id == $selected['sub2']->id ? 'selected' : '' }}>
                                                    {{ $sub2->category_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <!-- Remove Button -->
                                <div class="mt-3 col-3 d-flex align-items-center">
                                    <button type="button"
                                        class="btn btn-danger btn-sm remove-category-button">Remove</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
            const categories = @json($categoriesDyn);

            function setupCategorySelection(categoryGroup) {
                const categoryIdsInput = categoryGroup.find('.category_ids');

                categoryGroup.find('.parent_category').change(function() {
                    const parentId = $(this).val();
                    const sub1Container = categoryGroup.find('.sub1_container');
                    const sub2Container = categoryGroup.find('.sub2_container');
                    const sub1Select = categoryGroup.find('.sub1_category');
                    const sub2Select = categoryGroup.find('.sub2_category');

                    // Reset subcategory level 1 and level 2 selections
                    sub1Select.empty().append('<option value="">Select Subcategory Level 1</option>');
                    sub2Select.empty().append('<option value="">Select Subcategory Level 2</option>');

                    if (parentId) {
                        const selectedCategory = categories.find(cat => cat.id == parentId);
                        const subcategoriesLevelOne = selectedCategory ? selectedCategory
                            .subcategories_level_one : [];

                        if (subcategoriesLevelOne.length > 0) {
                            sub1Container.show();
                            subcategoriesLevelOne.forEach(subcategoryL1 => {
                                sub1Select.append('<option value="' + subcategoryL1.id + '">' +
                                    subcategoryL1.category_name + '</option>');
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

                    // Reset subcategory level 2 selection
                    sub2Select.empty().append('<option value="">Select Subcategory Level 2</option>');

                    if (sub1Id) {
                        const subcategoryLevelOne = categories
                            .flatMap(cat => cat.subcategories_level_one)
                            .find(sub => sub.id == sub1Id);

                        const subcategoriesLevelTwo = subcategoryLevelOne ? subcategoryLevelOne
                            .subcategories_level_two : [];

                        if (subcategoriesLevelTwo.length > 0) {
                            sub2Container.show();
                            subcategoriesLevelTwo.forEach(subcategoryL2 => {
                                sub2Select.append('<option value="' + subcategoryL2.id + '">' +
                                    subcategoryL2.category_name + '</option>');
                            });
                        } else {
                            sub2Container.hide();
                        }

                        categoryIdsInput.val(sub1Id); // Store the selected subcategory level 1 ID
                    } else {
                        sub2Container.hide();
                        categoryIdsInput.val(categoryGroup.find('.parent_category')
                    .val()); // Fallback to parent ID
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

            // Initialize for all existing category groups
            $('.category-group').each(function() {
                setupCategorySelection($(this));
            });
        });
    </script>
@endsection
