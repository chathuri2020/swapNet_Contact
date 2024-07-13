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

class CategoryController extends Controller
{
    public function index()
    {
        $profile = Auth::user();
        return view('admin.category.edit', compact('profile'));
    }

    
    public function update(Request $request)
    {
     /*    echo 'hi';
        dd($request->all());
 */

       /*  $validatedData = $request->validate([
            'name' => 'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8', // Adjust the min length as per your requirements
        ]); */

        $category = new Category();

        $category->name = $request->category;
      
    
        if ($category->save()) {

            if ($request->has('subcategories')) {
                foreach ($request->input('subcategories') as $subcategoryL1Data) {
                    // Create the subcategory level one
                    $subcategoryL1 = new SubcategoryLevelOne();
                    $subcategoryL1->name = $subcategoryL1Data['name'];
                    $subcategoryL1->category_id = $category->id; // Assuming you have a category_id field in your subcategory level one table
                    $subcategoryL1->save();

                    // Process level two subcategories if they exist
                    if (isset($subcategoryL1Data['subcategoriesLevelTwo'])) {
                        foreach ($subcategoryL1Data['subcategoriesLevelTwo'] as $subcategoryL2Name) {
                            // Create the subcategory level two
                            $subcategoryL2 = new SubcategoryLevelTwo();
                            $subcategoryL2->name = $subcategoryL2Name;
                            $subcategoryL2->category_l_one_id = $subcategoryL1->id;
                            $subcategoryL2->save();
                        }
                    }
                }
            }


            flash()->addSuccess('Category created successfully.');
            return redirect()->route('admin.category.edit');
        }
        flash()->addError('Category create fail!');
        return redirect()->route('admin.category.edit');


      /*   $user = User::findOrFail(auth()->id());
        $user->name = $request->name;
        $user->email = $request->email;

        if ($user->save()) {
            flash()->addSuccess('Profile Profile successfully.');
            return redirect()->back();
        }
        flash()->addError('Password update fail!.');
        return redirect()->back()->with('error', 'Profile update fail!'); */
    }

        /* 

    public function password()
    {
        return view('admin.profile.change-password');
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        #Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }

        #Update the new Password
        $updated = User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        if ($updated) {
            flash()->addSuccess('Password changed successfully.');
            return redirect()->back();
        } else {
            flash()->addError('Password change fail!.');
            return redirect()->back();
        }
    } */
}
