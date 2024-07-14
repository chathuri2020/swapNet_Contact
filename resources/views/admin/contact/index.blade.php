@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header">
            Contact List

                <a class="btn btn-success btn-sm text-white float-end" href="{{ route("admin.contact.create") }}">
                    Add New
                </a>

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                           Address
                        </th>
                        <th>
                           Email
                        </th>
                        <th>
                           Company name
                        </th>
                        <th>
                            Company Registration Number
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $key => $role)
                        <tr data-entry-id="{{ $role->id }}">
                            <td>
                                {{ $role->id ?? '' }}
                            </td>
                            <td>
                                {{ $role->name ?? '' }}
                            </td>

                            <td>
                                {{ $role->address ?? '' }}
                            </td>

                            <td>
                                {{ $role->email ?? '' }}
                            </td>
                            <td>
                                {{ $role->company_name ?? '' }}
                            </td>
                            <td>
                                {{ $role->company_registration_number ?? '' }}
                            </td>

                            <td>

                                    <a class="btn btn-sm btn-primary mb-1" href="{{ route('admin.roles.show', $role->id) }}">
                                        View
                                    </a>


                                    <a class="badge bg-info" href="{{ route('admin.roles.edit', $role->id) }}">
                                        Edit
                                    </a>

                                    <a href="javascript:void(0)" class="badge bg-danger text-white" onclick="
                                        if(confirm('Are you sure, You want to Delete this ??'))
                                        {
                                        event.preventDefault();
                                        document.getElementById('delete-form-{{ $role->id }}').submit();
                                        }">Delete
                                    </a>
                                    <form id="delete-form-{{ $role->id }}" method="post"
                                          action="{{ route('admin.roles.destroy', $role->id) }}" style="display: none">
                                        {{csrf_field()}}
                                        {{ method_field('DELETE') }}
                                    </form>


                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer clearfix">
            {{ $roles->links() }}
        </div>
    </div>
@endsection
