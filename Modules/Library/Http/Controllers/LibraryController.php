<?php

namespace Modules\Library\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Library\Entities\Library;
use Symfony\Component\HttpFoundation\JsonResponse;

class LibraryController extends Controller
{
    use ValidatesRequests;

    function __construct()
    {
        $this->middleware('permission:کتابخانه - لیست اثر', ['only' => ['index']]);
        $this->middleware('permission:کتابخانه - ایجاد اثر', ['only' => ['create', 'store']]);
        $this->middleware('permission:کتابخانه - ویرایش اثر', ['only' => ['edit', 'update']]);
        $this->middleware('permission:کتابخانه - حذف اثر', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $library = Library::with(['postFormatInfo', 'subjectInfo', 'languageInfo'])->get();
        return view('library::index', compact('library'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('library::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'subject' => 'required|integer|exists:post_subjects,id',
            'post_format' => 'required|integer|exists:post_formats,id',
            'language' => 'required|integer|exists:languages,id',
            'publication_date' => 'required|string|max:10',
            'file' => 'required|file|mimes:pdf,doc,docx,rar,zip,jpg,jpeg,psd,bmp,tif,tiff|max:20480',
        ]);


        $library = Library::create([
            'name' => $request->name,
            'author' => $request->author,
            'subject' => $request->subject,
            'post_format' => $request->post_format,
            'language' => $request->language,
            'publication_date' => $request->publication_date,
            'adder' => auth()->user()->id
        ]);

        $file = $request->file('file')->store('library', 'public');
        $library->file = $file;
        $library->save();

        if ($library) {
            return response()->json(['message' => 'اثر با موفقیت ثبت شد']);
        }
        return response()->json(['message' => 'ثبت اثر با مشکل مواجه شد'], 500);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return string
     */
    public function show($id)
    {
        return Library::with(['postFormatInfo', 'subjectInfo', 'languageInfo'])->findOrFail($id)->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('library::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'subject' => 'required|integer|exists:post_subjects,id',
            'post_format' => 'required|integer|exists:post_formats,id',
            'language' => 'required|integer|exists:languages,id',
            'publication_date' => 'required|string|max:10',
            'file' => 'nullable|file|mimes:pdf,doc,docx,rar,zip,jpg,jpeg,psd,bmp,tif,tiff|max:20480',
        ]);
        $library = Library::findOrFail($id);
        if ($request->hasFile('file')) {
            Storage::delete($library->file);
            $filePath = $request->file('file')->store('library/' . $library->id, 'public');
            $library->file = $filePath;
        }

        $library->update([
            'name' => $request->name,
            'author' => $request->author,
            'subject' => $request->subject,
            'post_format' => $request->post_format,
            'language' => $request->language,
            'publication_date' => $request->publication_date,
            'editor' => auth()->user()->id
        ]);


        if ($library->save()) {
            return response()->json(['message' => 'ویرایش با موفقیت ثبت شد']);
        }
        return response()->json(['message' => 'ویرایش اثر با مشکل مواجه شد'], 500);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $library = Library::findOrFail($id)->delete();
        if ($library) {
            return response()->json(['message' => 'حذف اثر با موفقیت ثبت شد']);
        }
        return response()->json(['message' => 'حذف اثر اثر با مشکل مواجه شد'], 500);
    }
}
