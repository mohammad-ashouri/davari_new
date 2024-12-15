<?php

namespace Modules\Research\Http\Controllers;

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
        return view('research::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('research::create');
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
            'post_type' => 'required|string|in:ارسال به عضو گروه,ارسال به مدیر گروه,ارسال به مدیر پژوهش',
        ]);
        $post = Post::findOrFail($request->post_id);
        if (!$post) {
            return response()->json(['success' => false, 'message' => 'پست پیدا نشد!'], 400);
        }
        $senderRole = auth()->user()->getRoleNames()->first();
        $receiverRole = null;
        switch ($request->post_type) {
            case 'ارسال به مدیر پژوهش':
                $receiverRole = 'مدیر پژوهش';
                break;
            case 'ارسال به مدیر گروه':
                $receiverRole = 'مدیر گروه';
                break;
            case 'ارسال به عضو گروه':
                $receiverRole = 'عضو گروه';
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
            $path = $request->file('post_file')->store('public/research/posts/' . $post->id . '/movements-' . $movement->id);

            File::create([
                'module' => 'research',
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
        return view('research::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('research::edit');
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
            'پژوهش - نمایش تاریخچه - ارسالی عضو گروه به مدیر گروه' => ['sender_role' => 'عضو گروه', 'receiver_role' => 'مدیر گروه'],
            'پژوهش - نمایش تاریخچه - ارسالی مدیر گروه به مدیر پژوهش' => ['sender_role' => 'مدیر گروه', 'receiver_role' => 'مدیر پژوهش'],
            'پژوهش - نمایش تاریخچه - ارسالی مدیر گروه به عضو گروه' => ['sender_role' => 'مدیر گروه', 'receiver_role' => 'عضو گروه'],
            'نشر داخلی - نمایش تاریخچه - ارسالی مدیر پژوهش به مدیر گروه' => ['sender_role' => 'مدیر پژوهش', 'receiver_role' => 'مدیر گروه'],
            'پژوهش - نمایش تاریخچه - ارسالی ادمین کل به مدیر گروه' => ['sender_role' => 'ادمین کل', 'receiver_role' => 'مدیر گروه'],
            'پژوهش - نمایش تاریخچه - ارسالی ادمین کل به عضو گروه' => ['sender_role' => 'ادمین کل', 'receiver_role' => 'عضو گروه'],
        ];


        $userPermissions = array_filter(array_keys($permissions), function ($permission) {
            return auth()->user()->hasPermissionTo($permission);
        });

        $data = InternalPublicationPostMovementHistory::where('p_id', $post->id);

        if (auth()->user()->hasRole('عضو گروه')) {
            $data->where('author', auth()->user()->id);
        }
        $movements = $data->when(!empty($userPermissions), function ($query) use ($userPermissions, $permissions) {
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

        $initialFile = File::where('p_id', $post->id)->where('module', 'research')->where('part', 'post')->latest()->first();
        return view('research::posts.history', compact('post', 'movements', 'initialFile'));
    }
}
