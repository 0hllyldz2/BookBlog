<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('back.pages.index', compact('pages'));
    }

    public function orders(Request $request){
        foreach($request->get('page') as $key => $order){
            Page::where('id', $order)->update(['order' => $key]);
        }
    }

    public function create()
    {
        return view('back.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $last = Page::orderBy('order', 'desc')->first();

        $page = new Page;
        $page->title = $request->title;
        $page->content = $request->content;
        $page->order = $last->order + 1;
        $page->slug = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $titleSlug = Str::slug($request->title);
            $extension = $request->image->getClientOriginalExtension();
            $imageName = $titleSlug . '.' . $extension;
            $request->image->move(public_path('uploads'), $imageName);
            $page->image = 'uploads/' . $imageName;
        }
        $page->save();
        toastr()->success('Başarılı', 'Sayfa başarıyla oluşturuldu!');
        return redirect()->route('admin.page.index');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('back.pages.update', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:3',
            'image' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $page = Page::findOrFail($id);
        $page->title = $request->title;
        $page->content = $request->content;
        $page->slug = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $titleSlug = Str::slug($request->title);
            $extension = $request->image->getClientOriginalExtension();
            $imageName = $titleSlug . '.' . $extension;
            $request->image->move(public_path('uploads'), $imageName);
            $page->image = 'uploads/' . $imageName;
        }
        $page->save();
        toastr()->success('Başarılı', 'Sayfa başarıyla güncellendi!');
        return redirect()->route('admin.page.index');
    }

    public function delete($id)
    {
        Page::find($id)->delete(); {
            toastr()->success('Başarılı', 'Sayfa, silinen sayfalara taşındı!');
            return redirect()->route('admin.page.index');
        }
    }

    public function trashed()
    {
        $pages = Page::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('back.pages.trashed', compact('pages'));
    }

    public function recover($id)
    {
        Page::onlyTrashed()->find($id)->restore();
        toastr()->success('Başarılı', 'Sayfa başarıyla kurtarıldı!');
        return redirect()->back();
    }

    public function harddelete($id)
    {
        $page = Page::onlyTrashed()->find($id);
        if (File::exists($page->image)) {
            File::delete(public_path($page->image));
        }
        $page->forceDelete();
        toastr()->success('Başarılı', 'Sayfa başarıyla silindi!');
        return redirect()->route('admin.page.index');

    }

    public function switch(Request $request)
    {
        $page = Page::findOrFail($request->id);
        $page->status = $request->statu == "true" ? 1 : 0;
        $page->save();
    }
}
