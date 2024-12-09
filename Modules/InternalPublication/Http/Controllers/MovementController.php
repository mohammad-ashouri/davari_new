<?php

namespace Modules\InternalPublication\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
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
        $senderRole = auth()->user()->getRoleNames()->first();
        $receiverRole = null;
        switch ($request->post_type) {
            case 'ارسال به صفحه آرا':
                $receiverRole = 'صفحه آرا';
                break;
            case 'ارسال به طراح':
                $receiverRole = 'طراح';
                break;
            case 'ارسال به ویراستار':
                $receiverRole = 'ویراستار';
                break;
            case 'ارسال به مدیر پژوهش':
                $receiverRole = 'مدیر پژوهش';
                break;
            case 'ارسال به مدیر گروه':
                $receiverRole = 'مدیر گروه';
                break;
            case 'ارسال به عضو گروه':
                $receiverRole = 'عضو گروه';
                break;
            case 'ارسال به نشر داخلی':
                $receiverRole = 'مدیر نشر داخلی';
                break;
        }
        $movement = InternalPublicationPostMovementHistory::create([
            'p_id' => $post->id,
            'type' => $request->post_type,
            'sender_role' => $senderRole,
            'receiver_role' => $receiverRole,
            'title' => $request->title,
            'description' => $request->description,
            'adder' => auth()->user()->id,
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

    /**
     * Getting movements history
     * @param Post $post
     * @return View
     */
    public function history(Post $post)
    {
        $movements = InternalPublicationPostMovementHistory::where('p_id', $post->id)
            ->when(auth()->user()->hasPermissionTo('نشر داخلی - نمایش تاریخچه - نمایش پیام های مدیر نشر داخلی')
                or auth()->user()->hasPermissionTo('نشر داخلی - نمایش تاریخچه - نمایش پیام های ویراستار')
                or auth()->user()->hasPermissionTo('نشر داخلی - نمایش تاریخچه - نمایش پیام های معاون')
                or auth()->user()->hasPermissionTo('نشر داخلی - نمایش تاریخچه - نمایش پیام های ادمین کل')
                or auth()->user()->hasPermissionTo('نشر داخلی - نمایش تاریخچه - نمایش پیام های صفحه آرا')
                or auth()->user()->hasPermissionTo('نشر داخلی - نمایش تاریخچه - نمایش پیام های طراح')
                or auth()->user()->hasPermissionTo('نشر داخلی - نمایش تاریخچه - نمایش پیام های مدیر گروه')
                or auth()->user()->hasPermissionTo('نشر داخلی - نمایش تاریخچه - نمایش پیام های عضو گروه')
                , function ($query) {
                $query->where(function ($subQuery) {
                    if (auth()->user()->hasPermissionTo('نشر داخلی - نمایش تاریخچه - نمایش پیام های مدیر نشر داخلی')) {
                        $subQuery->where('sender_role', 'مدیر نشر داخلی')
                            ->orWhere('receiver_role', 'مدیر نشر داخلی');
                    }
                    if (auth()->user()->hasPermissionTo('نشر داخلی - نمایش تاریخچه - نمایش پیام های ویراستار')) {
                        $subQuery->orWhere('sender_role', 'ویراستار')
                            ->orWhere('receiver_role', 'ویراستار');
                    }
                    if (auth()->user()->hasPermissionTo('نشر داخلی - نمایش تاریخچه - نمایش پیام های معاون')) {
                        $subQuery->orWhere('sender_role', 'معاون')
                            ->orWhere('receiver_role', 'معاون');
                    }
                    if (auth()->user()->hasPermissionTo('نشر داخلی - نمایش تاریخچه - نمایش پیام های ادمین کل')) {
                        $subQuery->orWhere('sender_role', 'ادمین کل')
                            ->orWhere('receiver_role', 'ادمین کل');
                    }
                    if (auth()->user()->hasPermissionTo('نشر داخلی - نمایش تاریخچه - نمایش پیام های صفحه آرا')) {
                        $subQuery->orWhere('sender_role', 'صفحه آرا')
                            ->orWhere('receiver_role', 'صفحه آرا');
                    }
                    if (auth()->user()->hasPermissionTo('نشر داخلی - نمایش تاریخچه - نمایش پیام های طراح')) {
                        $subQuery->orWhere('sender_role', 'طراح')
                            ->orWhere('receiver_role', 'طراح');
                    }
                    if (auth()->user()->hasPermissionTo('نشر داخلی - نمایش تاریخچه - نمایش پیام های مدیر گروه')) {
                        $subQuery->orWhere('sender_role', 'مدیر گروه')
                            ->orWhere('receiver_role', 'مدیر گروه');
                    }
                    if (auth()->user()->hasPermissionTo('نشر داخلی - نمایش تاریخچه - نمایش پیام های عضو گروه')) {
                        $subQuery->orWhere('sender_role', 'عضو گروه')
                            ->orWhere('receiver_role', 'عضو گروه');
                    }
                });
            })
            ->orderByDesc('created_at')
            ->get();
        $initialFile = File::where('p_id', $post->id)->where('module', 'internal_publication')->where('part', 'post')->latest()->first();
        return view('internal-publication::posts.history', compact('post', 'movements', 'initialFile'));
    }
}
