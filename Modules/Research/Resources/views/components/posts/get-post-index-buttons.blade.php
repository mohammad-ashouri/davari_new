@props(['post'])
<div class="grid grid-cols-3 w-full px-3 space-x-1 py-4 gap-2">
    @php
        $roles = auth()->user()->getRoleNames()->toArray();
    @endphp

    @if(array_intersect(['مدیر گروه', 'ادمین کل'], $roles) and $post->status=='ارسال به مدیر گروه')
        <button type="button" data-id="{{ $post->id }}"
                class="w-full px-2 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 send-to-research-manager">
            <i class="las la-share" style="font-size: 20px"></i>
            مدیر پژوهش
        </button>
        <button type="button" data-id="{{ $post->id }}"
                class="w-full px-2 py-1 bg-purple-500 text-white rounded-md hover:bg-purple-600 focus:outline-none focus:ring focus:border-purple-300 send-to-group-member">
            <i class="las la-share" style="font-size: 20px"></i>
            عضو گروه
        </button>
    @endif

    @if(array_intersect(['عضو گروه', 'ادمین کل'], $roles) and $post->status=='ارسال به عضو گروه')
        <button type="button" data-id="{{ $post->id }}"
                class="w-full px-2 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 send-to-group-manager">
            <i class="las la-share" style="font-size: 20px"></i>
            مدیر گروه
        </button>
    @endif
</div>
