<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{

    public function index(): View
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('category.index', [
            'categories' => $categories,
        ]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        Category::query()->create([
            'name' => $data['name'],
            'money' => $data['money'],
            'label' => $data['label'],
        ]);

        return back()->with('success', 'Create category successfully');
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();
        $category->update([
            'name' => $data['name'],
            'money' => $data['money'],
            'label' => $data['label'],
        ]);

        return back()->with('success', 'Update category successfully');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return back()->with('success', 'Delete category successfully');
    }

}
