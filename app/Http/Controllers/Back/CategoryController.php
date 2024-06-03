<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('back.categories.index', compact('categories'));
    }

    public function create(Request $request)
    {
        $isExist = Category::whereSlug(Str::slug($request->category))->first();
        if ($isExist) {
            toastr()->warning('Uyarı!', $request->category . ' adında bır kategori zaten mevcut!');
            return redirect()->back();
        }
        $category = new Category;
        $category->name = $request->category;
        $category->slug = Str::slug($request->category);
        $category->save();
        toastr()->success('Başarılı', 'Kategori başarıyla oluşturuldu!');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $isExist = Category::whereSlug(Str::slug($request->category))->whereNotIn('id', [$request->category])->first();
        if ($isExist) {
            toastr()->warning('Uyarı!', $request->category . ' adında bır kategori zaten mevcut!');
            return redirect()->back();
        }
        $category = Category::find($request->category_id);
        $category->name = $request->category;
        $category->slug = Str::slug($request->category);
        $category->save();
        toastr()->success('Başarılı', 'Kategori başarıyla güncellendi!');
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $category = Category::findOrFail($request->id);
        if ($category->id == 1) {
            toastr()->error('Başarısız', 'Kategori silinemez!');
            return redirect()->back();
        }
        $message = null;
        $count = $category->articleCount();
        if ($count > 0) {
            Article::where('category_id', $category->id)->update(['category_id' => 1]);
            $defaultCateory = Category::find(1);
            $message = 'Bu kategoriye ait ' . $count . ' metin ' . $defaultCateory->name . ' kategorisine taşındı.';
        }
        $category->delete();
        toastr()->success($message, 'Kategori başarıyla silindi!');
        return redirect()->back();
    }

    public function getData(Request $request)
    {
        $category = Category::findOrFail($request->id);
        return response()->json($category);
    }

    public function switch(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:categories,id',
            'statu' => 'required|boolean',
        ]);
        $category = Category::findOrFail($request->id);
        $category->status = $request->statu ? 1 : 0;
        $category->save();
    }

}
