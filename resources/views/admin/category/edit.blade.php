@extends('layouts.master')

@section('title', 'Edit Category')

@section('content')

<div class="card">
    <div class="card-header">
        Edit Category
    </div>

    <div class="card-body">
        <form action="{{ route('admin.category.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="category">Main Category Name*</label>
                <input type="text" id="category" name="category" class="form-control" value="{{ $category->category_name }}" required>
            </div>
            <div class="mb-3">
                <p>Subcategory Creation</p>
                <button type="button" class="btn btn-primary btn-xs mb-5" data-bs-toggle="modal" data-bs-target="#addSubcategoryModal">Add Subcategory L1</button>
                <ul id="subcategoryList" class="list-group">
                    @foreach($category->subcategoriesLevelOne as $indexL1 => $subcategoryL1)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span>{{ $subcategoryL1->category_name }}</span>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-info btn-sm ml-2" data-bs-toggle="modal" data-bs-target="#addSubcategoryL2Modal" onclick="setParentSubcategoryIndex({{ $indexL1 }})">+ L2</button>
                                    <button type="button" class="btn btn-danger btn-sm ml-2 close cls" aria-label="Close" onclick="removeElementMain(this)">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <ul class="list-group nested-list">
                                    @foreach($subcategoryL1->subcategoriesLevelTwo as $subcategoryL2)
                                        <li class="list-group-item">
                                            {{ $subcategoryL2->category_name }}
                                            <button class="btn-close ml-2 btn btn-sm" type="button" aria-label="Close" onclick="removeElement(this)">
                                {{--   <span aria-hidden="true">&times;</span> --}}
                                            </button>
                                            <input type="hidden" name="subcategories[{{ $indexL1 }}][subcategoriesLevelTwo][]" value="{{ $subcategoryL2->category_name }}">
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <input type="hidden" name="subcategories[{{ $indexL1 }}][name]" value="{{ $subcategoryL1->category_name }}">
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary me-2" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal for Adding Subcategory L1 -->
<div class="modal fade" id="addSubcategoryModal" tabindex="-1" aria-labelledby="addSubcategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubcategoryModalLabel">Add Subcategory L1</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="subcategoryL1Name" placeholder="Enter Subcategory L1 Name">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addSubcategoryL1()">Add Subcategory L1</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding Subcategory L2 -->
<div class="modal fade" id="addSubcategoryL2Modal" tabindex="-1" aria-labelledby="addSubcategoryL2ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubcategoryL2ModalLabel">Add Subcategory L2</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="subcategoryL2Name" placeholder="Enter Subcategory L2 Name">
                <input type="hidden" id="parentSubcategoryIndex">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addSubcategoryL2()">Add Subcategory L2</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function addSubcategoryL1() {
        const subcategoryL1Name = document.getElementById("subcategoryL1Name").value.trim();
        if (subcategoryL1Name === '') {
            alert("Please enter a subcategory L1 name!");
            return;
        }

        const subcategoryL1Item = document.createElement("li");
        subcategoryL1Item.classList.add("list-group-item");
        subcategoryL1Item.innerHTML = `
            <div class="d-flex justify-content-between">
                <div>
                    <span>${subcategoryL1Name}</span>
                </div>
                <div>
                    <button type="button" class="btn btn-info btn-sm ml-2" data-bs-toggle="modal" data-bs-target="#addSubcategoryL2Modal" onclick="setParentSubcategoryIndex(${document.getElementById("subcategoryList").children.length})">+ L2</button>
                    <button type="button" class="btn btn-danger btn-sm ml-2 close cls" aria-label="Close" onclick="removeElementMain(this)">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <ul class="list-group nested-list">
                    <!-- Subcategories (Level 2) will be dynamically inserted here -->
                </ul>
            </div>
            <input type="hidden" name="subcategories[${document.getElementById("subcategoryList").children.length}][name]" value="${subcategoryL1Name}">
        `;
        document.getElementById("subcategoryList").appendChild(subcategoryL1Item);

        // Clear input field and close modal
        document.getElementById("subcategoryL1Name").value = '';
        const addSubcategoryModal = new bootstrap.Modal(document.getElementById('addSubcategoryModal'));
        addSubcategoryModal.hide();
    }

    function addSubcategoryL2() {
        const subcategoryL2Name = document.getElementById("subcategoryL2Name").value.trim();
        if (subcategoryL2Name === '') {
            alert("Please enter a subcategory L2 name!");
            return;
        }

        const parentIndex = document.getElementById("parentSubcategoryIndex").value;
        const parentSubcategoryList = document.getElementById("subcategoryList").children[parentIndex].querySelector(".nested-list");

        const subcategoryL2Item = document.createElement("li");
        subcategoryL2Item.classList.add("list-group-item");
        subcategoryL2Item.textContent = subcategoryL2Name;

        const hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = `subcategories[${parentIndex}][subcategoriesLevelTwo][]`;
        hiddenInput.value = subcategoryL2Name;

        const removeButton = document.createElement("button");
        removeButton.classList.add("btn-close", "ml-2", "btn", "btn-sm");
        removeButton.setAttribute("type", "button");
        removeButton.setAttribute("aria-label", "Close");
        removeButton.onclick = function() {
            subcategoryL2Item.remove();
            hiddenInput.remove();
        };

        subcategoryL2Item.appendChild(removeButton);
        subcategoryL2Item.appendChild(hiddenInput);
        parentSubcategoryList.appendChild(subcategoryL2Item);

        // Clear input field and close modal
        document.getElementById("subcategoryL2Name").value = '';
        const addSubcategoryL2Modal = new bootstrap.Modal(document.getElementById('addSubcategoryL2Modal'));
        addSubcategoryL2Modal.hide();
    }

    function setParentSubcategoryIndex(index) {
        document.getElementById("parentSubcategoryIndex").value = index;
    }

    function removeElement(button) {
        button.parentElement.remove();
    }

    function removeElementMain(button) {
        const liElement = button.closest('li');
        if (liElement) {
            liElement.remove();
        }
    }
</script>
@endsection
``
