<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Contact;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        //dd($user);
        $userId = $user->id;
        $isAdmin = $user->hasRole('Admin');

        if ($isAdmin) {
          //  dd("he is an admin");
              $contacts = Contact::with('user')->get(); // Eager load the user relationship
        } else {
           // dd("he is not an admin");
            $contacts = Contact::with('user')->where('user_id', $userId)->get();
        }

        return view('admin.contact.index', compact('contacts'));
    }



    public function create()
    {
        /* abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
 */

        $permissions = Category::with(['subcategoriesLevelOne.subcategoriesLevelTwo'])->where('category_type', 'parent')->get();
        $categories = Category::with(['subcategoriesLevelOne.subcategoriesLevelTwo'])->where('category_type', 'parent')->get();
        //dd($categories->toArray());
        return view('admin.contact.create', compact('permissions', 'categories'));
    }

    public function store(Request $request)
    {
        //dd($request->toArray());
        //category_id
        //$role = Contact::create(['name' => $request->name]);
        //  $role->permissions()->sync($request->input('permissions', []));
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->address = $request->address;
        $contact->email  = $request->email;
        $contact->company_name = $request->company_name;
        $contact->company_registration_number  = $request->company_registration_number;
        $contact->user_id = Auth::id(); // Set the authenticated user's ID

        if ($contact->save()) {
            $contact->categories()->attach($request->category_ids);
            flash()->addSuccess('Contact successfully created.');
            return redirect()->route('admin.contact.index');
        }

        flash()->addError('Whoops! Contact create failed!');
        return redirect()->back();
    }

    public function edit($id)
    {
        // Fetch the contact with its categories
        $contact = Contact::with('categories')->findOrFail($id);

        // Fetch all categories
        $categories = Category::all()->keyBy('id');
        $categoriesDyn = Category::with(['subcategoriesLevelOne.subcategoriesLevelTwo'])->where('category_type', 'parent')->get();
        // Initialize arrays to store dropdown data
        $parentCategories = Category::where('category_type', 'parent')->get();
        $sub1Categories = Category::where('category_type', 'sub1')->get();
        $sub2Categories = Category::where('category_type', 'sub2')->get();

        $selectedCategories = [];

        foreach ($contact->categories as $category) {
            if ($category->category_type == 'sub2') {
                $sub1Category = $categories->get($category->reference_id);
                $parentCategory = $sub1Category ? $categories->get($sub1Category->reference_id) : null;
                $selectedCategories[] = [
                    'parent' => $parentCategory,
                    'sub1' => $sub1Category,
                    'sub2' => $category,
                ];
            } elseif ($category->category_type == 'sub1') {
                $parentCategory = $categories->get($category->reference_id);
                $selectedCategories[] = [
                    'parent' => $parentCategory,
                    'sub1' => $category,
                    'sub2' => null,
                ];
            } else {
                $selectedCategories[] = [
                    'parent' => $category,
                    'sub1' => null,
                    'sub2' => null,
                ];
            }
        }

        return view('admin.contact.edit', compact('contact', 'categories', 'parentCategories', 'sub1Categories', 'sub2Categories', 'selectedCategories', 'categoriesDyn'));
    }








    public function update(Request $request, Contact $contact)
    {
        //dd($request->category_ids);
        $contact->update($request->only(['name', 'address', 'email', 'company_name', 'company_registration_number']));

        // Update the categories
        $contact->categories()->sync($request->category_ids);

        flash()->addSuccess('Contact updated successfully.');
        return redirect()->route('admin.contact.index');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        flash()->addSuccess('Contact deleted successfully.');
        return back();
    }
}
