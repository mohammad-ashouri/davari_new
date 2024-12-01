<?php

namespace Modules\Catalog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Catalog\Entities\ScientificGroup;

class ScientificGroupController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست گروه علمی', ['only' => ['index']]);
        $this->middleware('permission:ایجاد گروه علمی', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش گروه علمی', ['only' => ['update']]);
        $this->middleware('permission:حذف گروه علمی', ['only' => ['destroy']]);
    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $catalogs = ScientificGroup::orderBy('name', 'asc')->get();
        return view('Catalog::scientific-groups.index', compact('catalogs'));
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('Catalog::scientific-groups.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:scientific_groups,name',
        ]);

        $role = ScientificGroup::create(['name' => $request->input('name'), 'adder' => auth()->user()->id]);

        return redirect()->route('scientific-groups.index')
            ->with('success', 'گروه علمی جدید با موفقیت ایجاد شد.');
    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $catalog = ScientificGroup::findOrFail($id);

        return view('Catalog::scientific-groups.edit', compact('catalog'));
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:scientific_groups,name,' . $id,
        ]);

        $postFormat = ScientificGroup::findOrFail($id);
        $postFormat->name = $request->input('name');
        $postFormat->status = $request->input('status');
        $postFormat->editor = auth()->user()->id;
        $postFormat->save();

        return redirect()->route('scientific-groups.index')
            ->with('success', 'نقش کاربری با موفقیت ویرایش شد.');
    }
}
