<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\PostFormat;
use Illuminate\Http\Request;

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
        return view('Catalogs.PostFormats.index', compact('catalogs'));
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('Catalogs.PostFormats.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:post_formats,name',
        ]);

        $role = PostFormat::create(['name' => $request->input('name'), 'adder' => auth()->user()->id]);

        return redirect()->route('PostFormats.index')
            ->with('success', 'قالب اثر جدید با موفقیت ایجاد شد.');
    }

    public function show($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $catalog = PostFormat::firstOrFail($id);

        return view('Catalogs.PostFormats.show', compact('catalog'));
    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $catalog = PostFormat::findOrFail($id);

        return view('Catalogs.PostFormats.edit', compact('catalog'));
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:post_formats,name',
        ]);

        $postFormat = PostFormat::findOrFail($id);
        $postFormat->name = $request->input('name');
        $postFormat->editor = auth()->user()->id;
        $postFormat->save();

        return redirect()->route('PostFormats.index')
            ->with('success', 'نقش کاربری با موفقیت ویرایش شد.');
    }
}
