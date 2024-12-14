<?php

namespace Modules\InternalPublication\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\PostFormat;
use Modules\Catalog\Entities\ScientificGroup;
use Modules\File\Entities\File;
use Modules\Post\Entities\Post;

class PostController extends Controller
{
    use ValidatesRequests;

    function __construct()
    {
        $this->middleware('permission:نشر داخلی - مدیریت آثار', ['only' => ['index']]);
        $this->middleware('permission:نشر داخلی - مدیریت آثار - اثر جدید', ['only' => ['create', 'store']]);
        $this->middleware('permission:نشر داخلی - مدیریت آثار - ویرایش اثر', ['only' => ['edit', 'update']]);
        $this->middleware('permission:نشر داخلی - مدیریت آثار - حذف اثر', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $posts = Post::with(['movements'])
            ->when(auth()->user()->hasRole('مدیر نشر داخلی'), function ($query) {
                $query->whereHas('movements', function ($query) {
                    $query->where('type', 'ارسال به مدیر نشر داخلی');
                });
            })
            ->when(auth()->user()->hasRole('ویراستار'), function ($query) {
                $query->whereHas('movements', function ($query) {
                    $query->where('type', 'ارسال به ویراستار');
                });
            })
            ->when(auth()->user()->hasRole('طراح'), function ($query) {
                $query->whereHas('movements', function ($query) {
                    $query->where('type', 'ارسال به طراح');
                });
            })
            ->when(auth()->user()->hasRole('صفحه آرا'), function ($query) {
                $query->whereHas('movements', function ($query) {
                    $query->where('type', 'ارسال به صفحه آرا');
                });
            })
            ->orderByDesc('updated_at')->get();
        dd($posts);
        return view('internal-publication::posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $scientificGroups = ScientificGroup::get();
        $postFormats = PostFormat::get();
        $authors = User::whereHas('roles', function ($query) {
            $query->where('name', 'عضو گروه');
        })->orderBy('family')->get();
        return view('internal-publication::posts.create', compact('scientificGroups', 'postFormats', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'author' => 'required|integer|exists:users,id',
            'scientific_group' => 'required|integer|exists:scientific_groups,id',
            'post_format' => 'required|integer|exists:post_formats,id',
            'description' => 'nullable|string',
            'post_file' => 'required|file|mimes:pdf,doc,docx',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'author' => $request->author,
            'scientific_group' => $request->scientific_group,
            'post_format' => $request->post_format,
            'description' => $request->description,
            'adder' => auth()->user()->id,
        ]);

        $path = $request->file('post_file')->store('public/internal_publications/posts/' . $post->id);
        $file = File::create([
            'module' => 'post',
            'part' => 'init',
            'title' => 'init',
            'p_id' => $post->id,
            'src' => $path,
            'adder' => auth()->user()->id,
        ]);

        if ($post and $path and $file) {
            return redirect()->route('posts.index')->with('success', 'اثر با موفقیت ایجاد شد.');
        }
        $post->delete();
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد اثر']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('internal-publication::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $scientificGroups = ScientificGroup::get();
        $postFormats = PostFormat::get();
        $authors = User::whereHas('roles', function ($query) {
            $query->where('name', 'عضو گروه');
        })->orderBy('family')->get();
        $post = Post::findOrFail($id);
        return view('internal-publication::posts.edit', compact('post', 'scientificGroups', 'postFormats', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'id' => 'required|integer|exists:posts,id',
            'title' => 'required|string|max:255',
            'author' => 'required|integer|exists:users,id',
            'scientific_group' => 'required|integer|exists:scientific_groups,id',
            'post_format' => 'required|integer|exists:post_formats,id',
            'description' => 'required|text',
        ]);
        $post = Post::findOrFail($id)->update([
            'title' => $request->title,
            'author' => $request->author,
            'scientific_group' => $request->scientific_group,
            'post_format' => $request->post_format,
            'description' => $request->description,
            'adder' => auth()->user()->id,
        ]);

        if (request()->hasFile('post_file')) {
            $path = $request->file('post_file')->store('public/internal_publications/posts/' . $post->id);
            File::where('module', 'internal_publication')->where('part', 'post')->where('title', 'init')->where('p_id', $post->id)->delete();
            $file = File::create([
                'module' => 'post',
                'part' => 'init',
                'title' => 'init',
                'p_id' => $post->id,
                'src' => $path,
                'adder' => auth()->user()->id,
            ]);
        }
        if ($post) {
            return redirect()->route('posts.index')->with('success', 'اثر با موفقیت ویرایش شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ویرایش اثر']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

}
