<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Category;
use App\Models\SubcategoryLevelOne;
use App\Models\SubcategoryLevelTwo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::with(['subcategoriesLevelOne.subcategoriesLevelTwo'])->where('category_type', 'parent')->get();
        //$subcategory = SubcategoryLevelOne::paginate(15);
        return view('admin.category.index', compact('category'));
    }

    public function create()
    {
        /* abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
 */
        $profile = Auth::user();
        return view('admin.category.create', compact('profile'));
    }


    public function store(Request $request)
{
    try {
        $request->validate([
            'category' => 'required|string|max:255',
        ]);

        $category = new Category();
        $category->category_name = $request->input('category');
        $category->category_type = 'parent';
        $category->slug = strtolower(str_replace(' ', '-', $request->input('category')));
        $category->save();


        if ($request->has('subcategories')) {
            foreach ($request->input('subcategories') as $sub1) {
                $subcategoryL1 = new Category();
                $subcategoryL1->category_name = $sub1['name'];
                $subcategoryL1->category_type = 'sub1';
                $subcategoryL1->reference_id = $category->id;
                $subcategoryL1->slug = strtolower(str_replace(' ', '-', $sub1['name']) . '-' . rand(1000, 9999));
                $subcategoryL1->save();

                if (isset($sub1['subcategoriesLevelTwo'])) {
                    foreach ($sub1['subcategoriesLevelTwo'] as $sub2) {
                        $subcategoryL2 = new Category();
                        $subcategoryL2->category_name = $sub2;
                        $subcategoryL2->category_type = 'sub2';
                        $subcategoryL2->reference_id = $subcategoryL1->id;
                        $subcategoryL2->slug = strtolower(str_replace(' ', '-', $sub2) . '-' . rand(1000, 9999));
                        $subcategoryL2->save();
                    }
                }
            }
        }

        return redirect()->route('admin.category.index')->with('success', 'Category created successfully.');
    } catch (\Exception $e) {
        Log::error('Error creating category: ' . $e->getMessage());
        return redirect()->back()->with('error', 'There was an error creating the category. Please try again.');
    }
}





    public function edit($id)
    {

        $category = Category::findOrFail($id);
        $category->load('subcategoriesLevelOne.subcategoriesLevelTwo');
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        try {
            $category = Category::findOrFail($id);
            $category->category_name = $request->input('category');
            $category->slug = strtolower(str_replace(' ', '-', $request->input('category')));
            $category->save();

            $subCategoryL1 = Category::where('reference_id', $category->id);
            foreach ($subCategoryL1 as $sub1) {
                Category::where('reference_id', $sub1->id)->delete();
            }
            Category::where('reference_id', $category->id)->delete();

            foreach ($request->input('subcategories', []) as $sub1) {
                //dd($sub1) ;
                if (isset($sub1['id'])) {
                    $subcategoryL1 = Category::findOrFail($sub1['id']);
                } else {
                    $subcategoryL1 = new Category();
                }

                $subcategoryL1->category_name = $sub1['name'];
                $subcategoryL1->category_type = 'sub1';
                $subcategoryL1->slug = strtolower(str_replace(' ', '-', $sub1['name']));
                $subcategoryL1->reference_id = $category->id;
                $subcategoryL1->save();


                if (isset($sub1['subcategoriesLevelTwo'])) {
                    foreach ($sub1['subcategoriesLevelTwo'] as $sub2) {
                        if (isset($sub2['id'])) {
                            $subcategoryL2 = Category::findOrFail($sub2['id']);
                        } else {
                            $subcategoryL2 = new Category();
                        }

                        $subcategoryL2->category_name = $sub2;
                        $subcategoryL2->category_type = 'sub2';
                        $subcategoryL2->slug = strtolower(str_replace(' ', '-', $sub2));
                        $subcategoryL2->reference_id = $subcategoryL1->id;
                        $subcategoryL2->save();
                    }
                }
            }

            // Optionally, you may delete removed subcategories here if needed

            return redirect()->route('admin.category.index')->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->delete()) {
            flash()->addSuccess('Category deleted successfully.');
            return redirect()->route('admin.category.index');
        } else {
            flash()->addError('Category deletion failed.');
            return redirect()->route('admin.category.index');
        }
    }
}
