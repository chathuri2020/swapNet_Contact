..<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Flasher\Laravel\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

Breadcrumbs::for('admin.index', function (BreadcrumbTrail $trail): void {
    $trail->push('Dashboard', route('admin.index'));
});
Breadcrumbs::for('admin.users.index', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin.index');
    $trail->push('Users', route('admin.users.index'));
});
Breadcrumbs::for('admin.users.create', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin.users.index');
    $trail->push('Add new user', route('admin.users.create'));
});
// Role
Breadcrumbs::for('admin.roles.index', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin.index');
    $trail->push('Roles', route('admin.roles.index'));
});
Breadcrumbs::for('admin.roles.create', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin.roles.index');

    $trail->push('Add new role', route('admin.roles.create'));
});
Breadcrumbs::for('admin.roles.edit', function (BreadcrumbTrail $trail, Role $post): void {
    $trail->parent('admin.roles.index');

    $trail->push($post->name, route('admin.roles.edit', $post));
});
// Permission
Breadcrumbs::for('admin.permissions.index', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin.index');
    $trail->push('Permissions', route('admin.permissions.index'));
});
Breadcrumbs::for('admin.permissions.create', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin.permissions.index');

    $trail->push('Add new permission', route('admin.permissions.create'));
});
Breadcrumbs::for('admin.permissions.edit', function (BreadcrumbTrail $trail, Permission $post): void {
    $trail->parent('admin.permissions.index');

    $trail->push($post->name, route('admin.permissions.edit', $post));
});
// profile
Breadcrumbs::for('admin.profile.index', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin.index');
    $trail->push('Profile', route('admin.profile.index'));
});
// change password
Breadcrumbs::for('admin.password.index', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin.index');
    $trail->push('Change Password', route('admin.password.index'));
});


// category
Breadcrumbs::for('admin.category.index', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin.index');
    $trail->push('Category', route('admin.category.index'));
});

Breadcrumbs::for('admin.category.create', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin.index');
    $trail->push('Category', route('admin.category.create'));
});


Breadcrumbs::for('admin.category.edit', function (BreadcrumbTrail $trail, $categoryId): void {
    $trail->parent('admin.category.index'); // Assuming 'admin.category.index' exists for listing categories
    $trail->push('Edit Category', route('admin.category.edit', $categoryId)); // Adjust the route name and label as needed
});



// contact
Breadcrumbs::for('admin.contact.index', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin.index');
    $trail->push('Contact', route('admin.contact.index'));
});
Breadcrumbs::for('admin.contact.create', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin.contact.index');
    $trail->push('Add new Contact', route('admin.contact.create'));
});

Breadcrumbs::for('admin.contact.edit', function (BreadcrumbTrail $trail, $contact): void {
    $trail->parent('admin.contact.index'); // Assuming 'admin.category.index' exists for listing categories
    $trail->push('Edit Contact', route('admin.contact.edit', $contact)); // Adjust the route name and label as needed
});

