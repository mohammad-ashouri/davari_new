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
use Modules\Post\Entities\Post;

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
        $permissions = [
            'نشر داخلی - نمایش تاریخچه - ارسالی عضو گروه به مدیر گروه' => ['sender_role' => 'عضو گروه', 'receiver_role' => 'مدیر گروه'],
            'نشر داخلی - نمایش تاریخچه - ارسالی مدیر گروه به مدیر پژوهش' => ['sender_role' => 'مدیر گروه', 'receiver_role' => 'مدیر پژوهش'],
            'نشر داخلی - نمایش تاریخچه - ارسالی مدیر گروه به عضو گروه' => ['sender_role' => 'مدیر گروه', 'receiver_role' => 'عضو گروه'],
            'نشر داخلی - نمایش تاریخچه - ارسالی مدیر پژوهش به مدیر گروه' => ['sender_role' => 'مدیر پژوهش', 'receiver_role' => 'مدیر گروه'],
            'نشر داخلی - نمایش تاریخچه - ارسالی مدیر پژوهش به مدیر نشر داخلی' => ['sender_role' => 'مدیر پژوهش', 'receiver_role' => 'مدیر نشر داخلی'],
            'نشر داخلی - نمایش تاریخچه - ارسالی معاون به مدیر پژوهش' => ['sender_role' => 'معاون', 'receiver_role' => 'مدیر پژوهش'],
            'نشر داخلی - نمایش تاریخچه - ارسالی مدیر نشر داخلی به مدیر پژوهش' => ['sender_role' => 'مدیر نشر داخلی', 'receiver_role' => 'مدیر پژوهش'],
            'نشر داخلی - نمایش تاریخچه - ارسالی مدیر نشر داخلی به ویراستار' => ['sender_role' => 'مدیر نشر داخلی', 'receiver_role' => 'ویراستار'],
            'نشر داخلی - نمایش تاریخچه - ارسالی مدیر نشر داخلی به طراح' => ['sender_role' => 'مدیر نشر داخلی', 'receiver_role' => 'طراح'],
            'نشر داخلی - نمایش تاریخچه - ارسالی مدیر نشر داخلی به صفحه آرا' => ['sender_role' => 'مدیر نشر داخلی', 'receiver_role' => 'صفحه آرا'],
            'نشر داخلی - نمایش تاریخچه - ارسالی ویراستار به مدیر نشر داخلی' => ['sender_role' => 'ویراستار', 'receiver_role' => 'مدیر نشر داخلی'],
            'نشر داخلی - نمایش تاریخچه - ارسالی طراح به مدیر نشر داخلی' => ['sender_role' => 'طراح', 'receiver_role' => 'مدیر نشر داخلی'],
            'نشر داخلی - نمایش تاریخچه - ارسالی صفحه آرا به مدیر نشر داخلی' => ['sender_role' => 'صفحه آرا', 'receiver_role' => 'مدیر نشر داخلی'],
            'نشر داخلی - نمایش تاریخچه - ارسالی ادمین کل به مدیر گروه' => ['sender_role' => 'ادمین کل', 'receiver_role' => 'مدیر گروه'],
            'نشر داخلی - نمایش تاریخچه - ارسالی ادمین کل به عضو گروه' => ['sender_role' => 'ادمین کل', 'receiver_role' => 'عضو گروه'],
            'نشر داخلی - نمایش تاریخچه - ارسالی ادمین کل به مدیر پژوهش' => ['sender_role' => 'ادمین کل', 'receiver_role' => 'مدیر پژوهش'],
            'نشر داخلی - نمایش تاریخچه - ارسالی ادمین کل به مدیر نشر داخلی' => ['sender_role' => 'ادمین کل', 'receiver_role' => 'مدیر نشر داخلی'],
            'نشر داخلی - نمایش تاریخچه - ارسالی ادمین کل به معاون' => ['sender_role' => 'ادمین کل', 'receiver_role' => 'معاون'],
            'نشر داخلی - نمایش تاریخچه - ارسالی ادمین کل به ویراستار' => ['sender_role' => 'ادمین کل', 'receiver_role' => 'ویراستار'],
            'نشر داخلی - نمایش تاریخچه - ارسالی ادمین کل به صفحه آرا' => ['sender_role' => 'ادمین کل', 'receiver_role' => 'صفحه آرا'],
            'نشر داخلی - نمایش تاریخچه - ارسالی ادمین کل به طراح' => ['sender_role' => 'ادمین کل', 'receiver_role' => 'طراح'],
            'نشر داخلی - نمایش تاریخچه - ارسالی مدیر نشر داخلی به معاون' => ['sender_role' => 'مدیر نشر داخلی', 'receiver_role' => 'معاون'],
            'نشر داخلی - نمایش تاریخچه - ارسالی معاون به مدیر نشر داخلی' => ['sender_role' => 'معاون', 'receiver_role' => 'مدیر نشر داخلی'],
            'نشر داخلی - نمایش تاریخچه - ارسالی مدیر پژوهش به معاون' => ['sender_role' => 'مدیر پژوهش', 'receiver_role' => 'معاون'],
        ];


        $userPermissions = array_filter(array_keys($permissions), function ($permission) {
            return auth()->user()->hasPermissionTo($permission);
        });

        $movements = InternalPublicationPostMovementHistory::where('p_id', $post->id)
            ->when(!empty($userPermissions), function ($query) use ($userPermissions, $permissions) {
                $query->where(function ($subQuery) use ($userPermissions, $permissions) {
                    foreach ($userPermissions as $permission) {
                        if (isset($permissions[$permission])) {
                            $roles = $permissions[$permission];
                            $subQuery->orWhere(function ($innerQuery) use ($roles) {
                                $innerQuery->where('sender_role', $roles['sender_role'])
                                    ->where('receiver_role', $roles['receiver_role']);
                            });
                        }
                    }
                });
            })
            ->orderByDesc('created_at')
            ->get();

        $initialFile = File::where('p_id', $post->id)->where('module', 'internal_publication')->where('part', 'post')->latest()->first();
        return view('internal-publication::posts.history', compact('post', 'movements', 'initialFile'));
    }
}
