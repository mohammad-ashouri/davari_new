<?php

namespace Modules\Catalog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Catalog\Entities\PostFormat;

class PostFormatController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست قالب اثر', ['only' => ['index']]);
        $this->middleware('permission:ایجاد قالب اثر', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش قالب اثر', ['only' => ['update']]);
        $this->middleware('permission:حذف قالب اثر', ['only' => ['destroy']]);
    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $catalogs = PostFormat::orderBy('name', 'asc')->get();
        return view('Catalog::post-formats.index', compact('catalogs'));
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('Catalog::PostFormats.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:post_formats,name',
        ]);

        $catalog = PostFormat::create(['name' => $request->input('name'), 'adder' => auth()->user()->id]);

        return redirect()->route('post-formats.index')
            ->with('success', 'قالب اثر جدید با موفقیت ایجاد شد.');
    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $catalog = PostFormat::findOrFail($id);

        return view('Catalog::post-formats.edit', compact('catalog'));
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:post_formats,name,' . $id,
        ]);

        $postFormat = PostFormat::findOrFail($id);
        $postFormat->name = $request->input('name');
        $postFormat->status = $request->input('status');
        $postFormat->editor = auth()->user()->id;
        $postFormat->save();

        return redirect()->route('post-formats.index')
            ->with('success', 'نقش کاربری با موفقیت ویرایش شد.');
    }
}
