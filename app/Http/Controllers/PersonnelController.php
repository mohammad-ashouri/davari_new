<?php

namespace App\Http\Controllers;

use App\Models\Catalogs\Building;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Personnel;
use Illuminate\Http\Request;

class PersonnelController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:لیست پرسنل', ['only' => ['index']]);
        $this->middleware('permission:ایجاد پرسنل', ['only' => ['create', 'store']]);
        $this->middleware('permission:ویرایش پرسنل', ['only' => ['update', 'edit']]);
    }

    public function index()
    {
        $personnels = Personnel::with(['buildingInfo', 'adderInfo', 'editorInfo'])->orderByDesc('created_at')->get();
        return view('Personnels.index', compact('personnels'));
    }

    public function create()
    {
        return view('Personnels.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'personnel_code' => 'required|integer|unique:personnels,id',
        ]);

        $personnels = Personnel::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'personnel_code' => $request->input('personnel_code'),
            'adder' => $this->getMyUserId()
        ]);

        if ($personnels) {
            return redirect()->route('Personnels.index')->with('success', 'پرسنل با موفقیت ایجاد شد.');
        }
        return redirect()->back()->withErrors(['errors' => 'خطا در ایجاد پرسنل']);
    }

    public function edit($id)
    {
        $personnel = Personnel::findOrFail($id);

        return view('Personnels.edit', compact('personnel', 'buildings'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ]);

        $personnel = Personnel::findOrFail($id);
        $personnel->first_name = $request->input('first_name');
        $personnel->last_name = $request->input('last_name');
        $personnel->personnel_code = $request->input('personnel_code');
        $personnel->status = $request->input('status');
        $personnel->editor = $this->getMyUserId();
        $personnel->save();

        return redirect()->route('Personnels.index')->with('success', 'پرسنل با موفقیت ویرایش شد.');
    }

}
