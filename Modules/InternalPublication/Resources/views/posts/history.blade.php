@php use Morilog\Jalali\Jalalian; @endphp
@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">نشر داخلی - مدیریت آثار - نمایش تاریخچه: {{ $post->title }}</h1>
            @include('layouts.components.errors')
            @include('layouts.components.success')
            <div class="bg-white rounded shadow p-6 flex flex-col ">
                @if(empty($movements) or $movements->isEmpty())
                    <div role="alert" class="alert alert-info">
                        <i style="font-size: 20px" class="las la-info-circle"></i>
                        <span>اطلاعاتی یافت نشد!</span>
                    </div>
                @else
                    <table class="datatable w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                        <thead>
                        <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                            <th class="px-6 py-3  font-bold ">کد</th>
                            <th class="px-6 py-3  font-bold ">نوع</th>
                            <th class="px-6 py-3  font-bold ">توضیحات</th>
                            <th class="px-6 py-3  font-bold ">فایل پیوست</th>
                            <th class="px-6 py-3  font-bold ">کاربر ثبت کننده</th>
                            <th class="px-6 py-3  font-bold ">تاریخ ثبت</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                        @foreach ($posts as $item)
                            <tr class="bg-white">
                                <td class="px-6 py-4">{{ $item->id }}</td>
                                <td class="px-6 py-4">
                                    {{ $item->type }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->description }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->adderInfo->name }} {{ $item->adderInfo->family }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ Jalalian::fromDateTime($item->created_at)->format('Y/m/d H:i:s') }}
                                </td>
                                <td class="px-6 py-4 w-full">
                                    <a href="{{ Storage::url($item->getInitFile->src) }}">
                                        <button type="button"
                                                class="px-4 py-2 mr-3 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring focus:border-gray-300">
                                            دانلود فایل اصلی
                                        </button>
                                    </a>
                                    <hr>
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
