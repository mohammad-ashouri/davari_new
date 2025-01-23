@props(['post'])
<div class="grid grid-cols-3 w-full px-3 space-x-1 py-4 gap-2">
    @php
        $roles = auth()->user()->getRoleNames()->toArray();
    @endphp

    @if(array_intersect(['مدیر پژوهش', 'ادمین کل'], $roles) and $post->status=='ارسال به مدیر پژوهش')
        <button type="button" data-id="{{ $post->id }}"
                class="w-full px-2 py-1 bg-green-500 text-md-center text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300 send-to-internal-publication-manager">
            <i class="las la-share" style="font-size: 20px"></i>
            نشر داخلی
        </button>
        <button type="button" data-id="{{ $post->id }}"
                class="w-full px-2 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-red-300 send-to-group-manager">
            <i class="las la-share" style="font-size: 20px"></i>
            مدیر گروه
        </button>
        <button type="button" data-id="{{ $post->id }}"
                class="w-full px-2 py-1 bg-amber-500 text-white rounded-md hover:bg-amber-600 focus:outline-none focus:ring focus:border-amber-300 send-to-group-deputy">
            <i class="las la-share" style="font-size: 20px"></i>
            معاون
        </button>
    @endif

    @if(array_intersect(['معاون', 'ادمین کل'], $roles) and $post->status=='ارسال به معاون')
        <button type="button" data-id="{{ $post->id }}"
                class="w-full px-2 py-1 bg-green-500 text-md-center text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300 send-to-internal-publication-manager">
            <i class="las la-share" style="font-size: 20px"></i>
            نشر داخلی
        </button>
        <button type="button" data-id="{{ $post->id }}"
                class="w-full px-2 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-red-300 send-to-group-manager">
            <i class="las la-share" style="font-size: 20px"></i>
            مدیر گروه
        </button>
        <button type="button" data-id="{{ $post->id }}"
                class="w-full px-2 py-1 bg-lime-500 text-white rounded-md hover:bg-lime-600 focus:outline-none focus:ring focus:border-lime-300 send-to-research-manager">
            <i class="las la-share" style="font-size: 20px"></i>
            مدیر پژوهش
        </button>
    @endif

    @if(array_intersect(['مدیر نشر داخلی', 'ادمین کل'], $roles) and $post->status=='ارسال به نشر داخلی')
        <button type="button" data-id="{{ $post->id }}"
                class="w-full px-2 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 send-to-research-manager">
            <i class="las la-share" style="font-size: 20px"></i>
            مدیر پژوهش
        </button>
        <button type="button" data-id="{{ $post->id }}"
                class="w-full px-2 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300 send-to-editor">
            <i class="las la-share" style="font-size: 20px"></i>
            ویراستار
        </button>
        <button type="button" data-id="{{ $post->id }}"
                class="w-full px-2 py-1 bg-yellow-400 text-white rounded-md hover:bg-yellow-600 focus:outline-none focus:ring focus:border-yellow-300 send-to-designer">
            <i class="las la-share" style="font-size: 20px"></i>
            طراح
        </button>
        <button type="button" data-id="{{ $post->id }}"
                class="w-full px-2 py-1 bg-purple-500 text-white rounded-md hover:bg-purple-600 focus:outline-none focus:ring focus:border-purple-300 send-to-layout-designer">
            <i class="las la-share" style="font-size: 20px"></i>
            صفحه آرا
        </button>
    @endif

    @if(array_intersect(['صفحه آرا','طراح','ویراستار', 'ادمین کل'], $roles) and ($post->status=='ارسال به ویراستار' or $post->status=='ارسال به صفحه آرا' or $post->status=='ارسال به طراح'))
        <button type="button" data-id="{{ $post->id }}"
                class="w-full px-2 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 send-to-internal-publication-manager">
            <i class="las la-share" style="font-size: 20px"></i>
            مدیر نشر داخلی
        </button>
    @endif
</div>
