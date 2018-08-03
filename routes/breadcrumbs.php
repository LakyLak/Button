<?php 

Breadcrumbs::register('dashboard', function ($breadcrumbs) {
     $breadcrumbs->push('Dashboard', route('dashboard'));
});

Breadcrumbs::register('category', function ($breadcrumbs, $category) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push($category->name, route('category', ['name' => $category->name]));
});