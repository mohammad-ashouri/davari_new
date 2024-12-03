<?php

namespace Modules\InternalPublication\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\PostFormat;
use Modules\Catalog\Entities\ScientificGroup;
use Modules\InternalPublication\Entities\Post;

class PostController extends Controller
{
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
        $posts = Post::orderByDesc('updated_at')->get();
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
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
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
        return view('internal-publication::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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
