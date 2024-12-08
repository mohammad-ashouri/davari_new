<?php

namespace Modules\InternalPublication\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\File\Entities\File;
use Modules\InternalPublication\Entities\InternalPublicationPostMovementHistory;
use Modules\InternalPublication\Entities\Post;

class MovementController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('internalpublication::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('internalpublication::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'post_file' => 'nullable|file|mimes:doc,docx,pdf|max:15360',
            'post_id' => 'nullable|integer|exists:posts,id',
            'post_type' => 'required|string|in:ارسال به نشر داخلی,ارسال به مدیر گروه,ارسال به مدیر پژوهش,ارسال به ویراستار,ارسال به طراح,ارسال به صفحه آرا',
        ]);
        $post = Post::findOrFail($request->post_id);
        if (!$post) {
            return response()->json(['success' => false, 'message' => 'پست پیدا نشد!'], 400);
        }

        $movement = InternalPublicationPostMovementHistory::create([
            'p_id' => $post->id,
            'type' => $request->post_type,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if (!$movement) {
            return response()->json(['success' => false, 'message' => 'خطا در انتقال! لطفا مجددا تلاش کنید'], 400);
        }

        if ($request->hasFile('post_file')) {
            $path = $request->file('post_file')->store('public/internal_publications/posts/' . $post->id . '/movements-' . $movement->id);

            File::create([
                'module' => 'internal_publication',
                'part' => 'post-movement',
                'title' => $request->post_type,
                'p_id' => $post->id,
                'm_id' => $movement->id,
                'src' => $path,
                'adder' => auth()->user()->id,
            ]);
        }

        $post->status = $request->post_type;
        $post->save();

        return response()->json(['success' => true, 'message' => 'انتقال با موفقیت انجام شد!'], 200);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('internalpublication::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('internalpublication::edit');
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
