<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Catalog\Entities\PostSubject;

class PostSubjectController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست موضوع اثر', ['only' => ['index']]);
        $this->middleware('permission:ایجاد موضوع اثر', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش موضوع اثر', ['only' => ['update']]);
        $this->middleware('permission:حذف موضوع اثر', ['only' => ['destroy']]);
    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $catalogs = PostSubject::orderBy('name', 'asc')->get();
        return view('Catalog::post-subjects.index', compact('catalogs'));
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('Catalog::post-subjects.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:post_subjects,name',
        ]);

        $catalog = PostSubject::create(['name' => $request->input('name'), 'adder' => auth()->user()->id]);

        return redirect()->route('post-subjects.index')
            ->with('success', 'موضوع اثر جدید با موفقیت ایجاد شد.');
    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $catalog = PostSubject::findOrFail($id);

        return view('Catalog::post-subjects.edit', compact('catalog'));
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:post_subjects,name,' . $id,
        ]);

        $postFormat = PostSubject::findOrFail($id);
        $postFormat->name = $request->input('name');
        $postFormat->status = $request->input('status');
        $postFormat->editor = auth()->user()->id;
        $postFormat->save();

        return redirect()->route('post-subjects.index')
            ->with('success', 'موضوع اثر با موفقیت ویرایش شد.');
    }

    /**
     * Get all post subjects
     * @return mixed
     */
    public function allPostSubjects()
    {
        $postSubjects = PostSubject::select('id','name')->where('status',1)->orderBy('name')->get()->toJson();
        return $postSubjects;
    }
}
