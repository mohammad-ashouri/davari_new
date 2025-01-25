@extends('layouts.PanelMaster')
@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">ایجاد اثر</h1>
            @include('layouts.components.errors')
            <div class="bg-white rounded shadow flex flex-col ">
                {{ html()->form('POST')->route('research.posts.store')->acceptsFiles()->id('create-catalog')->open() }}
                <div class="bg-white rounded shadow flex flex-col p-4">
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="title"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نام اثر</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="" required>
                        </div>
                        @if(auth()->user()->hasRole('مدیر گروه'))
                            <div>
                                <label for="author"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">گردآورنده</label>
                                <select name="author"
                                        class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required>
                                    <option selected disabled value="">انتخاب کنید...</option>
                                    @foreach($authors as $author)
                                        <option
                                            value="{{ $author->id }}" @selected(old('author')==$author->id)>{{ $author->name }} {{ $author->family }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div>
                            <label for="post_format"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">قالب اثر</label>
                            <select name="post_format"
                                    class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                <option selected disabled value="">انتخاب کنید...</option>
                                @foreach($postFormats as $postFormat)
                                    <option
                                        value="{{ $postFormat->id }}" @selected(old('post_format')==$postFormat->id)>{{ $postFormat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="description"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">توضیحات
                                (اختیاری)</label>
                            <textarea
                                rows="6"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                id="description" name="description">{{ old('description') }}</textarea>
                        </div>
                        <div>
                            <label for="post_file"
                                   class="text-gray-900 text-sm font-bold whitespace-nowrap">فایل
                                اثر:</label>
                            <input id="post_file" name="post_file" type="file"
                                   accept=".pdf, .doc, .docx,.rar,.zip,.jpg,.jpeg,.psd,.bmp,.tif,.tiff"
                                   class="border border-gray-300-300 px-3 py-2 w-full rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <div class="mt-1 text-sm">
                                <div class="text-red-500 font-medium mb-1">الزامات فایل</div>
                                <ul class=" text-xs font-normal ml-4 space-y-1">
                                    <li class="text-red-500">
                                        فرمت های قابل پشتیبانی: pdf, doc, docx,.rar,.zip,.jpg,.jpeg,.psd,.bmp,.tif,.tiff
                                    </li>
                                    <li class="text-red-500">
                                        حداکثر حجم: 15 مگابایت
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    @can('پژوهش - مدیریت آثار - اثر جدید')
                        <button type="submit"
                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                            ایجاد اثر
                        </button>
                    @endcan
                    <button id="backward_page" type="button"
                            class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                        بازگشت
                    </button>
                </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </main>
@endsection
