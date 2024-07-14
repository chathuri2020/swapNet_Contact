<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Contact;
use App\Models\Category;

class ContactController extends Controller
{
    //
    public function index()
    {
        /*  abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
*/
        $roles = Contact::paginate(15);

        return view('admin.contact.index', compact('roles'));
    }

    public function create()
    {
        /* abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
 */
        $permissions = Category::all()->pluck('name', 'id');

        return view('admin.contact.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        //$role = Contact::create(['name' => $request->name]);
        //  $role->permissions()->sync($request->input('permissions', []));
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->address = $request->address;
        $contact->email  = $request->email;
        $contact->company_name = $request->company_name;
        $contact->company_registration_number  = $request->company_registration_number;

        if ($contact->save()) {
            flash()->addSuccess('Contact successfully created.');
            return redirect()->route('admin.contact.index');
        }

        flash()->addError('Whoops! Contact create failed!');
        return redirect()->back();
    }

    public function edit(Role $role)
    {
        abort_if(Gate::denies('role_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = Permission::all()->pluck('name', 'id');

        $role->load('permissions');

        return view('admin.roles.edit', compact('permissions', 'role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update(['name' => $request->name]);
        $role->permissions()->sync($request->input('permissions', []));
        flash()->addSuccess('Role updated successfully.');

        return redirect()->route('admin.roles.index');
    }

    public function show(Role $role)
    {
        abort_if(Gate::denies('role_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role->load('permissions');

        return view('admin.roles.show', compact('role'));
    }

    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role->delete();
        flash()->addSuccess('Role deleted successfully.');
        return back();
    }
}
