@php use Morilog\Jalali\Jalalian; @endphp
@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">کتابخانه - مدیریت بر اطلاعات اثر</h1>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <div class="bg-white rounded shadow p-6 flex flex-col ">
                @can('کتابخانه - ایجاد اثر')
                    <button type="button"
                            class="px-4 py-2 bg-green-500 w-40 mb-2 text-center text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 library-add-post">
                        اثر جدید
                    </button>
                @endcan
                @if(empty($library) or $library->isEmpty())
                    <div role="alert" class="alert alert-info">
                        <i style="font-size: 20px" class="las la-info-circle"></i>
                        <span>اطلاعاتی یافت نشد!</span>
                    </div>
                @else
                    <table class="datatable w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                        <thead>
                        <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                            <th class="px-6 py-3  font-bold ">ردیف</th>
                            <th class="px-6 py-3  font-bold ">نام اثر</th>
                            <th class="px-6 py-3  font-bold ">نویسنده</th>
                            <th class="px-6 py-3  font-bold ">موضوع اثر</th>
                            <th class="px-6 py-3  font-bold ">قالب اثر</th>
                            <th class="px-6 py-3  font-bold ">زبان اثر</th>
                            <th class="px-6 py-3  font-bold ">تاریخ انتشار</th>
                            <th class="px-6 py-3  font-bold ">فایل اثر</th>
                            <th class="px-6 py-3  font-bold ">کاربر ثبت کننده</th>
                            <th class="px-6 py-3  font-bold ">تاریخ ثبت</th>
                            <th class="px-6 py-3  font-bold ">کاربر ویرایش کننده</th>
                            <th class="px-6 py-3  font-bold ">تاریخ ویرایش</th>
                            <th class="px-6 py-3  font-bold action">عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                        @foreach ($library as $item)
                            <tr class="bg-white">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    {{ $item->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->author }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->postFormatInfo->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->subjectInfo->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->languageInfo->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->publication_date }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ Storage::url($item->file) }}" target="_blank">
                                        <button type="button"
                                                class="px-2 py-2 bg-green-500 w-24 mb-2 text-center text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 ">
                                            دانلود فایل
                                        </button>
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->adderInfo->name }} {{ $item->adderInfo->family }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ Jalalian::fromDateTime($item->created_at)->format('H:i:s Y/m/d') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->editorInfo!=null)
                                        {{ $item->editorInfo->name }} {{ $item->editorInfo->family }}
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->editorInfo!=null)
                                        {{ Jalalian::fromDateTime($item->updated_at)->format('H:i:s Y/m/d') }}
                                    @endif
                                </td>
                                <td class="flex px-6 py-4">
                                    @can('کتابخانه - ویرایش اثر')
                                        <button type="button" data-id="{{ $item->id }}"
                                                class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 library-edit-post">
                                            ویرایش
                                        </button>
                                    @endcan
                                    @can('کتابخانه - حذف اثر')
                                        <button type="button" data-id="{{ $item->id }}"
                                                class="px-4 py-2 mr-1 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-red-300 library-remove-post">
                                            حذف
                                        </button>
                                    @endcan
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
