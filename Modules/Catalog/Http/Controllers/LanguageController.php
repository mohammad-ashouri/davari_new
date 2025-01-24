<?php

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Catalog\Entities\Language;

class LanguageController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست زبان', ['only' => ['index']]);
        $this->middleware('permission:ایجاد زبان', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش زبان', ['only' => ['update']]);
        $this->middleware('permission:حذف زبان', ['only' => ['destroy']]);
    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $catalogs = Language::orderBy('name', 'asc')->get();
        return view('Catalog::languages.index', compact('catalogs'));
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('Catalog::languages.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:languages,name',
        ]);

        $catalog = Language::create(['name' => $request->input('name'), 'adder' => auth()->user()->id]);

        return redirect()->route('languages.index')
            ->with('success', 'زبان جدید با موفقیت ایجاد شد.');
    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $catalog = Language::findOrFail($id);

        return view('Catalog::languages.edit', compact('catalog'));
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:languages,name,' . $id,
        ]);

        $postFormat = Language::findOrFail($id);
        $postFormat->name = $request->input('name');
        $postFormat->status = $request->input('status');
        $postFormat->editor = auth()->user()->id;
        $postFormat->save();

        return redirect()->route('languages.index')
            ->with('success', 'زبان با موفقیت ویرایش شد.');
    }
}
