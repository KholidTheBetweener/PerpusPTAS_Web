<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\Categories;

class CategoriesController extends Controller
{
    protected function index()
    {
        $kategori = Categories::orderBy('id')->orderBy('updated_at', 'desc')->paginate(10);
        return view('admin.categories.index', compact('kategori'));
    }
    public function create()
    {
        return view('admin.categories.create');
    }
    protected function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $input = $request->all();
        Categories::create($input);
        return redirect()->route('categories.index')->with('success','Kategori has been created successfully.');
    }
    public function edit(Categories $category)
    {
        return view('admin.categories.edit',compact('category'));
    }
    protected function update(Request $request, Categories $category)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $category->fill($request->post())->save();
        return redirect()->route('categories.index')->with('success','Kategori Has Been updated successfully');
    }
    protected function destroy(Categories $kategori)
    {
        $kategori->delete();
        return redirect()->route('categories.index')->with('success','Kategori has been deleted successfully');
    }
}
