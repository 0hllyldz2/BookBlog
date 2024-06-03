<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Mail;


//Models
use App\Models\Category;
use App\Models\Article;
use App\Models\Page;
use App\Models\Contact;
use App\Models\Config;

class Homepage extends Controller
{
    public function __construct()
    {
        $config = Config::find(1);

        if ($config && $config->active == 0) {
            redirect()->to('site-aktif-degil')->send();
            exit;
        }
        view()->share('pages', Page::where('status', 1)->orderBy('order', 'asc')->get());
        view()->share('categories', Category::where('status', 1)->inRandomOrder()->get());
    }

    public function index()
    {
        $data['articles'] = Article::with('getCategory')->where('status', 1)->whereHas('getCategory', function ($query) {
                $query->where('status', 1);
            })
            ->orderBy('created_at', 'desc')->paginate(2);
        $data['articles']->withPath('/sayfa');
        return view('front.homepage', $data);
    }

    public function single($category, $slug)
    {
        Category::whereSlug($category)->first() ?? abort(403, 'Böyle bir kategori bulunamadı!');
        $article = Article::whereSlug($slug)->first() ?? abort(403, 'Böyle bir yazı bulunamadı!');
        $article->increment('hit');
        $data['article'] = $article;
        return view('front.single', $data);
    }

    public function category($slug)
    {
        $category = Category::whereSlug($slug)->first() ?? abort(403, 'Böyle bir kategori bulunamadı!');
        $data['category'] = $category;
        $data['articles'] = Article::where('category_id', $category->id)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(1);
        return view('front.category', $data);
    }


    public function page($slug)
    {
        $page = Page::whereSlug($slug)->first() ?? abort(403, 'Böyle bir sayfa bulunamadı!');
        $data['page'] = $page;
        return view('front.page', $data);
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function contactpost(Request $request)
    {
        $rules = [
            'name' => 'required|min:5',
            'email' => 'required|email',
            'topic' => 'required',
            'message' => 'required|min:10'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('contact')->withErrors($validator)->withInput();
        }

        Mail::raw('', function ($message) use ($request) {
            $message->from('iletisim@bookblog.com', 'BookBlog');
            $message->to('hilalyildiz1058@gmail.com');
            $message->html('<p>Mesajı Gönderen: ' . $request->name . '</p>' .
                '<p>Mesajı Gönderen Mail: ' . $request->email . '</p>' .
                '<p>Mesaj Konusu: ' . $request->topic . '</p>' .
                '<p>Mesajı: ' . $request->message . '</p>' .
                '<p>Mesajı Gönderilme Tarihi: ' . now() . '</p>');
            $message->subject($request->name . ' iletişimden mesaj gönderildi');
        });

        return redirect()->route('contact')->with('Başarılı', 'Mesajınız iletildi. Teşekkür ederiz!');
    }

}
