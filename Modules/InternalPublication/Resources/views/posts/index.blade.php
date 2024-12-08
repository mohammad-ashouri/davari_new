@php use Morilog\Jalali\Jalalian; @endphp
@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">نشر داخلی - مدیریت آثار</h1>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <div class="bg-white rounded shadow p-6 flex flex-col ">
                @can('نشر داخلی - مدیریت آثار - اثر جدید')
                    <a type="button" href="{{route('posts.create')}}"
                       class="px-4 py-2 bg-green-500 w-40 mb-2 text-center text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                        اثر جدید
                    </a>
                @endcan
                @if(empty($posts) or $posts->isEmpty())
                    <div role="alert" class="alert alert-info">
                        <i style="font-size: 20px" class="las la-info-circle"></i>
                        <span>اطلاعاتی یافت نشد!</span>
                    </div>
                @else
                    <table class="datatable w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                        <thead>
                        <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                            <th class="px-6 py-3  font-bold ">کد</th>
                            <th class="px-6 py-3  font-bold ">نام</th>
                            <th class="px-6 py-3  font-bold ">قالب اثر</th>
                            <th class="px-6 py-3  font-bold ">گروه علمی</th>
                            <th class="px-6 py-3  font-bold ">پدید آورنده</th>
                            <th class="px-6 py-3  font-bold ">کاربر ثبت کننده</th>
                            <th class="px-6 py-3  font-bold ">تاریخ ثبت</th>
                            <th class="px-6 py-3  font-bold ">کاربر ویرایش کننده</th>
                            <th class="px-6 py-3  font-bold ">تاریخ ویرایش</th>
                            <th class="px-6 py-3  font-bold ">وضعیت</th>
                            <th class="px-6 py-3  font-bold action">عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                        @foreach ($posts as $item)
                            <tr class="bg-white">
                                <td class="px-6 py-4">{{ $item->id }}</td>
                                <td class="px-6 py-4">
                                    {{ $item->title }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->postFormat->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->scientificGroup->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->authorInfo->name }} {{ $item->authorInfo->family }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->adderInfo->name }} {{ $item->adderInfo->family }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ Jalalian::fromDateTime($item->created_at)->format('Y/m/d H:i:s') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->editorInfo!=null)
                                        {{ $item->editorInfo->name }} {{ $item->editorInfo->family }}
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->editorInfo!=null)
                                        {{ Jalalian::fromDateTime($item->updated_at)->format('Y/m/d H:i:s') }}
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->status }}
                                </td>
                                <td class="px-6 py-4 w-full action">
                                    @can('نشر داخلی - مدیریت آثار - ویرایش اثر')
                                        <a href="{{ route('posts.edit',$item->id) }}">
                                            <button type="button" data-id="{{ $item->id }}"
                                                    class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
                                                ویرایش
                                            </button>
                                        </a>
                                    @endcan
                                    @can('نشر داخلی - مدیریت آثار - نمایش تاریخچه')
                                        <a href="{{ route('movement.history',$item->id) }}">
                                            <button type="button" data-id="{{ $item->id }}"
                                                    class="px-4 py-2 mr-3 bg-teal-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
                                                تاریخچه
                                            </button>
                                        </a>
                                    @endcan
                                    <a href="{{ Storage::url($item->getInitFile->src) }}">
                                        <button type="button"
                                                class="px-4 py-2 mr-3 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring focus:border-gray-300">
                                            دانلود فایل اصلی
                                        </button>
                                    </a>
                                    <hr>
                                    <x-internal-publication::posts.get-post-index-buttons :post="$item"/>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </main>
@endsection
