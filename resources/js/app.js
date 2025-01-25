import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.css';
import $ from 'jquery';
import Swal from 'sweetalert2';
import Alpine from 'alpinejs'
import Intersect from '@alpinejs/intersect'
// Initialization for ES Users
import {initTE, Modal, Ripple,} from "tw-elements";
// import 'tinymce/tinymce';
// import 'tinymce/skins/ui/oxide/skin.min.css';
// import 'tinymce/skins/content/default/content.min.css';
// import 'tinymce/skins/content/default/content.css';
// import 'tinymce/icons/default/icons';
// import 'tinymce/themes/silver/theme';
// import 'tinymce/models/dom/model';
// import 'tinymce/plugins/table/plugin.js';
// import 'tinymce/plugins/fullscreen/plugin.js';
// import 'tinymce/plugins/autoresize/plugin.js';

initTE({Modal, Ripple});

window.Swal = Swal;

//AlpineJS
Alpine.plugin(Intersect)
Alpine.start()
window.Alpine = Alpine


//menu scripts
document.addEventListener('DOMContentLoaded', () => {
    const currentPath = window.location.pathname;

    // Get all the menu items
    const menuItems = document.querySelectorAll('.menu-item');

    // Loop through the menu items and check if the href matches the current path
    menuItems.forEach(item => {
        const link = item.querySelector('a');
        if (link && currentPath.includes(link.getAttribute('href'))) {
            // If it's a child menu, open the parent details element
            const detailsElement = item.closest('details');
            if (detailsElement) {
                detailsElement.setAttribute('open', true);
            }

            // Add the active class to the matched menu item
            item.classList.add('active');
        }
    });
});

// Function to handle click on menu items
function handleMenuItemClick(event) {
    // Get all the menu items
    const menuItems = document.querySelectorAll('.menu-item');

    // Remove the active class from all menu items
    menuItems.forEach(item => item.classList.remove('active'));

    // Add the active class to the clicked menu item
    event.currentTarget.classList.add('active');

    // Save the selected menu item ID to the sessionStorage
    sessionStorage.setItem('selectedMenuItem', event.currentTarget.id);
}

// Add event listeners to each menu item
const menuItems = document.querySelectorAll('.menu-item');
menuItems.forEach(item => {
    item.addEventListener('click', handleMenuItemClick);
});

// Function to handle click on child menu items
function handleChildMenuItemClick(event) {
    const detailsElement = event.currentTarget.closest('details');
    if (detailsElement) {
        // Set the 'open' attribute for the details element
        detailsElement.setAttribute('open', true);
    }

    // Remove the active class from all child menu items
    const childMenuItems = document.querySelectorAll('.menu-item');
    childMenuItems.forEach(item => item.classList.remove('active'));

    // Add the active class to the clicked child menu item
    event.currentTarget.classList.add('active');

    // Save the selected child menu item ID to the sessionStorage
    sessionStorage.setItem('selectedChildMenuItem', event.currentTarget.id);
}

// Add event listeners to each child menu item
const childMenuItems = document.querySelectorAll('.menu-item');
childMenuItems.forEach(item => {
    item.addEventListener('click', handleChildMenuItemClick);
});

function handleLogout() {
    // Clear the selected menu item and child menu item from sessionStorage
    sessionStorage.removeItem('selectedMenuItem');
    sessionStorage.removeItem('selectedChildMenuItem');
}

// Add event listener to the "خروج" (Logout) menu item
const logoutMenuItem = document.getElementById('logout');
logoutMenuItem.addEventListener('click', handleLogout);

//end menu scripts


function openModal(imageUrl) {
    const modal = document.querySelector('.modal-container');
    modal.querySelector('img').src = imageUrl;
    modal.parentElement.classList.remove('hidden');
}

function swalFire(title = null, text, icon, confirmButtonText) {
    Swal.fire({
        title: title, text: text, icon: icon, confirmButtonText: confirmButtonText,
    });
}

function toggleModal(modalID) {
    let modal = document.getElementById(modalID);
    if (modal.classList.contains('modal-active')) {
        modal.classList.remove('animate-fade-in');
        modal.classList.add('animate-fade-out');
        setTimeout(() => {
            modal.classList.remove('modal-active');
            modal.classList.remove('animate-fade-out');
        }, 150);
    } else {
        modal.classList.add('modal-active');
        modal.classList.remove('animate-fade-out');
        modal.classList.add('animate-fade-in');
    }
}

function hasOnlyPersianCharacters(input) {
    let persianPattern = /^[\u0600-\u06FF0-9()\s]+$/;
    return persianPattern.test(input);
}

function hasOnlyEnglishCharacters(input) {
    let englishPattern = /^[a-zA-Z0-9\s-]+$/;
    return englishPattern.test(input);
}

function swalFireWithQuestion() {
    Swal.fire({
        title: 'آیا مطمئن هستید؟',
        text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'خیر',
        confirmButtonText: 'بله',
    }).then((result) => {
        if (result.isConfirmed) {

        } else if (result.dismiss === Swal.DismissReason.cancel) {

        }
    });
}

function hasNumber(text) {
    return /\d/.test(text);
}

function resetFields() {
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => input.value = "");
    const selectors = document.querySelectorAll('select');
    selectors.forEach(select => select.value = "");
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => textarea.value = "");

    // const radios = document.querySelectorAll('input');
    // radios.forEach(input => input.selected = "");
    // const checkboxes = document.querySelectorAll("input");
    // checkboxes.forEach(input => input.selected = "");
}

function showLoadingPopup() {
    loading_popup.style.display = 'flex';
}

function hideLoadingPopup() {
    loading_popup.style.display = 'none';
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    let regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'), results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

//Get Jalali time and date
function getJalaliDate() {
    return new Promise(function (resolve, reject) {
        $.ajax({
            type: 'GET', url: "/date", success: function (response) {
                resolve(response);
            }, error: function (error) {
                reject(error);
            }
        });
    });
}


$(document).ready(function () {
    hideLoadingPopup();
    $('#backward_page').on('click', function () {
        window.history.back();
    });

    $('#create-catalog').submit(function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            text: 'این مورد ثبت خواهد شد!',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'خیر',
            confirmButtonText: 'بله',
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).off('submit');
                $(this).submit();
            }
        });
    });
    $('#edit-catalog').submit(function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            text: 'این مورد ویرایش خواهد شد!',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'خیر',
            confirmButtonText: 'بله',
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).off('submit');
                $(this).submit();
            }
        });
    });

    let pathname = window.location.pathname;

    if (pathname.includes('internal-publication') || pathname.includes('research')) {
        $('.send-to-internal-publication-manager,.send-to-group-manager,.send-to-research-manager,.send-to-editor,.send-to-designer,.send-to-layout-designer,.send-to-group-member,.send-to-group-manager,.send-to-group-deputy').click(function () {
            let title = null;
            if ($(this).hasClass('send-to-internal-publication-manager')) {
                title = 'ارسال به نشر داخلی';
            } else if ($(this).hasClass('send-to-group-manager')) {
                title = 'ارسال به مدیر گروه';
            } else if ($(this).hasClass('send-to-research-manager')) {
                title = 'ارسال به مدیر پژوهش';
            } else if ($(this).hasClass('send-to-editor')) {
                title = 'ارسال به ویراستار';
            } else if ($(this).hasClass('send-to-designer')) {
                title = 'ارسال به طراح';
            } else if ($(this).hasClass('send-to-layout-designer')) {
                title = 'ارسال به صفحه آرا';
            } else if ($(this).hasClass('send-to-group-member')) {
                title = 'ارسال به عضو گروه';
            } else if ($(this).hasClass('send-to-group-manager')) {
                title = 'ارسال به مدیر گروه';
            } else if ($(this).hasClass('send-to-group-deputy')) {
                title = 'ارسال به معاون';
            }

            const postId = $(this).data('id');
            Swal.fire({
                title: title,
                html: `
        <form id="move-data" class="text-right" enctype="multipart/form-data">
        <div>
            <label for="title"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان</label>
            <input type="text" id="title" name="title"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                   placeholder="" required>
        </div>
        <div class=" mt-3">
        <label for="description"
               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">توضیحات
            (اختیاری)</label>
        <textarea
            rows="6"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            id="description" name="description"></textarea>
        </div>
        <div class=" mt-3">
          <label for="post_file"
               class="text-gray-900 text-sm font-bold whitespace-nowrap">فایل
          ضمیمه(اختیاری):</label>
          <input id="post_file" name="post_file" type="file"
               accept=".pdf, .doc, .docx"
               class="border border-gray-300 px-3 py-2 w-full rounded-lg focus:ring-blue-500 focus:border-blue-500">
               <div class="mt-1 text-sm">
                    <div class="text-red-500 font-medium mb-1">الزامات فایل</div>
                    <ul class=" text-xs font-normal ml-4 space-y-1">
                        <li class="text-red-500">
                            فرمت های قابل پشتیبانی: pdf, doc, docx
                        </li>
                        <li class="text-red-500">
                            حداکثر حجم: 15 مگابایت
                        </li>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="post_type" value="${title}">
            <input type="hidden" name="post_id" value="${postId}">
          </form>
      `,
                showCancelButton: true,
                cancelButtonText: 'لغو',
                confirmButtonText: 'ارسال',
                focusConfirm: false,
                preConfirm: () => {
                    const form = document.getElementById('move-data');
                    const formData = new FormData(form);

                    // نمایش پیام تایید قبل از ارسال
                    return Swal.fire({
                        title: 'آیا از ارسال اطلاعات اطمینان دارید؟',
                        text: "",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'بله، ارسال کن!',
                        cancelButtonText: 'لغو'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // ارسال فرم اگر کاربر تایید کرد
                            return fetch('/internal-publication/movement/send', {
                                method: 'POST', body: formData, headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }
                            })
                                .then(response => {
                                    if (response.status === 404) {
                                        throw new Error('منبع موردنظر پیدا نشد.');
                                    }
                                    if (!response.ok) {
                                        return response.json().then(err => {
                                            if (err.errors && typeof err.errors === 'object') {
                                                const firstError = Object.values(err.errors)[0];
                                                if (firstError && firstError[0]) {
                                                    throw new Error(firstError[0]);
                                                }
                                            }
                                            throw new Error(err.message || 'ارسال ناموفق بود!');
                                        });
                                    }
                                    let timerInterval;
                                    Swal.fire({
                                        title: "اثر شما با موفقیت ارسال شد.",
                                        html: "این پیام بعد از <b></b> ثانیه به صورت خودکار بسته میشود.",
                                        timer: 3000,
                                        timerProgressBar: true,
                                        didOpen: () => {
                                            Swal.showLoading();
                                            const timer = Swal.getPopup().querySelector("b");
                                            timerInterval = setInterval(() => {
                                                timer.textContent = `${Swal.getTimerLeft()}`;
                                            }, 100);
                                        },
                                        willClose: () => {
                                            clearInterval(timerInterval);
                                        }
                                    }).then((result) => {
                                        /* Read more about handling dismissals below */
                                        window.location.reload();
                                    });
                                })
                                .catch(error => {
                                    Swal.showValidationMessage(`خطا: ${error.message}`);
                                });
                        } else {
                            return false;
                        }
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                }
            }).catch(() => {
                // در صورتی که عملیات لغو شد، فرم بسته نشود
                console.log('عملیات لغو شد');
            });
        });

        $('.send-to-group-member,.send-to-group-manager').click(function () {
            let title = null;
            if ($(this).hasClass('send-to-group-member')) {
                title = 'ارسال به عضو گروه';
            } else if ($(this).hasClass('send-to-group-manager')) {
                title = 'ارسال به مدیر گروه';
            }

            const postId = $(this).data('id');
            Swal.fire({
                title: title,
                html: `
        <form id="move-data" class="text-right" enctype="multipart/form-data">
        <div>
            <label for="title"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان</label>
            <input type="text" id="title" name="title"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                   placeholder="" required>
        </div>
        <div class=" mt-3">
        <label for="description"
               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">توضیحات
            (اختیاری)</label>
        <textarea
            rows="6"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            id="description" name="description"></textarea>
        </div>
        <div class=" mt-3">
          <label for="post_file"
               class="text-gray-900 text-sm font-bold whitespace-nowrap">فایل
          ضمیمه(اختیاری):</label>
          <input id="post_file" name="post_file" type="file"
               accept=".pdf, .doc, .docx"
               class="border border-gray-300 px-3 py-2 w-full rounded-lg focus:ring-blue-500 focus:border-blue-500">
               <div class="mt-1 text-sm">
                    <div class="text-red-500 font-medium mb-1">الزامات فایل</div>
                    <ul class=" text-xs font-normal ml-4 space-y-1">
                        <li class="text-red-500">
                            فرمت های قابل پشتیبانی: pdf, doc, docx
                        </li>
                        <li class="text-red-500">
                            حداکثر حجم: 15 مگابایت
                        </li>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="post_type" value="${title}">
            <input type="hidden" name="post_id" value="${postId}">
          </form>
      `,
                showCancelButton: true,
                cancelButtonText: 'لغو',
                confirmButtonText: 'ارسال',
                focusConfirm: false,
                preConfirm: () => {
                    const form = document.getElementById('move-data');
                    const formData = new FormData(form);

                    // نمایش پیام تایید قبل از ارسال
                    return Swal.fire({
                        title: 'آیا از ارسال اطلاعات اطمینان دارید؟',
                        text: "",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'بله، ارسال کن!',
                        cancelButtonText: 'لغو'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // ارسال فرم اگر کاربر تایید کرد
                            return fetch('/research/movement/send', {
                                method: 'POST', body: formData, headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }
                            })
                                .then(response => {
                                    if (response.status === 404) {
                                        throw new Error('منبع موردنظر پیدا نشد.');
                                    }
                                    if (!response.ok) {
                                        return response.json().then(err => {
                                            if (err.errors && typeof err.errors === 'object') {
                                                const firstError = Object.values(err.errors)[0];
                                                if (firstError && firstError[0]) {
                                                    throw new Error(firstError[0]);
                                                }
                                            }
                                            throw new Error(err.message || 'ارسال ناموفق بود!');
                                        });
                                    }
                                    let timerInterval;
                                    Swal.fire({
                                        title: "اثر شما با موفقیت ارسال شد.",
                                        html: "این پیام بعد از <b></b> ثانیه به صورت خودکار بسته میشود.",
                                        timer: 3000,
                                        timerProgressBar: true,
                                        didOpen: () => {
                                            Swal.showLoading();
                                            const timer = Swal.getPopup().querySelector("b");
                                            timerInterval = setInterval(() => {
                                                timer.textContent = `${Swal.getTimerLeft()}`;
                                            }, 100);
                                        },
                                        willClose: () => {
                                            clearInterval(timerInterval);
                                        }
                                    }).then((result) => {
                                        /* Read more about handling dismissals below */
                                        window.location.reload();
                                    });
                                })
                                .catch(error => {
                                    Swal.showValidationMessage(`خطا: ${error.message}`);
                                });
                        } else {
                            return false;
                        }
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                }
            }).catch(() => {
                // در صورتی که عملیات لغو شد، فرم بسته نشود
                console.log('عملیات لغو شد');
            });
        });

        $('.post-revocation').click(function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST', url: "/internal-publication/revocation",
                data: {
                    id: $(this).data('id')
                }
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }, success: function (response) {
                    if (response) {
                        let timerInterval;
                        Swal.fire({
                            title: "اثر شما با موفقیت باطل شد.",
                            html: "این پیام بعد از <b></b> ثانیه به صورت خودکار بسته میشود.",
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                                const timer = Swal.getPopup().querySelector("b");
                                timerInterval = setInterval(() => {
                                    timer.textContent = `${Swal.getTimerLeft()}`;
                                }, 100);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            }
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            window.location.reload();
                        });
                    }
                }, error: function (xhr, textStatus, errorThrown) {
                    // console.log(xhr);
                }
            });
        });
    } else {
        switch (pathname) {
            case '/dashboard':
                break;
            case '/library':

            async function loadLanguages() {
                try {
                    const response = await fetch('/catalog/languages/get-all');
                    if (!response.ok) throw new Error('خطا در دریافت داده‌ها');
                    return await response.json();
                } catch (error) {
                    Swal.fire('خطا!', 'بارگذاری زبان‌ها ناموفق بود', 'error');
                    return [];
                }
            }

            async function loadPostSubjects() {
                try {
                    const response = await fetch('/catalog/post-subjects/get-all');
                    if (!response.ok) throw new Error('خطا در دریافت داده‌ها');
                    return await response.json();
                } catch (error) {
                    Swal.fire('خطا!', 'بارگذاری موضوعات اثر ناموفق بود', 'error');
                    return [];
                }
            }

            async function loadPostFormats() {
                try {
                    const response = await fetch('/catalog/post-formats/get-all');
                    if (!response.ok) throw new Error('خطا در دریافت داده‌ها');
                    return await response.json();
                } catch (error) {
                    Swal.fire('خطا!', 'بارگذاری قالب های اثر ناموفق بود', 'error');
                    return [];
                }
            }

            async function showForm(existingData = null, languages = [], postSubjects = [], postFormats = [], postId = null) {
                try {
                    // اگر داده‌ای وجود نداشت، لیست‌ها را از سرور بگیرید
                    if (!languages.length || !postSubjects.length || !postFormats.length) {
                        [languages, postSubjects, postFormats] = await Promise.all([
                            loadLanguages(),
                            loadPostSubjects(),
                            loadPostFormats(),
                        ]);
                    }

                    const languageOptions = languages.map(lang =>
                        `<option value="${lang.id}" ${existingData?.language_info?.id == lang.id ? 'selected' : ''}>${lang.name}</option>`
                    ).join('');

                    const postSubjectOptions = postSubjects.map(subject =>
                        `<option value="${subject.id}" ${existingData?.subject_info?.id == subject.id ? 'selected' : ''}>${subject.name}</option>`
                    ).join('');

                    const postFormatOptions = postFormats.map(format =>
                        `<option value="${format.id}" ${existingData?.post_format_info?.id == format.id ? 'selected' : ''}>${format.name}</option>`
                    ).join('');

                    // ساخت فرم
                    Swal.fire({
                        title: existingData ? 'ویرایش اثر' : 'فرم ثبت اثر',
                        html: `
                    <div class="text-right mb-3">
                        <label for="name"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نام اثر</label>
                        <input id="name" value="${existingData?.name || ''}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="نام اثر" required>
                    </div>
                    <div class="text-right mb-3">
                        <label for="author"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">نویسنده</label>
                        <input id="author" value="${existingData?.author || ''}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="نویسنده" required>
                    </div>
                    <div class="text-right mb-3">
                     <label for="subject"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> موضوع اثر</label>
                        <select id="subject" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="">موضوع اثر را انتخاب کنید</option>
                            ${postSubjectOptions}
                        </select>
                    </div>
                    <div class="text-right mb-3">
                            <label for="post_format"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> قالب اثر</label>
                        <select id="post_format" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="">قالب اثر را انتخاب کنید</option>
                            ${postFormatOptions}
                        </select>
                    </div>
                    <div class="text-right mb-3">
                            <label for="language"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> زبان اثر</label>
                        <select id="language" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="">زبان را انتخاب کنید</option>
                            ${languageOptions}
                        </select>
                    </div>
                    <div class="text-right mb-3">
                            <label for="pub-date"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> تاریخ انتشار</label>
                        <input id="pub-date"  value="${existingData?.publication_date || ''}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="فرمت تاریخ باید به صورت 1403/10/20 باشد" required>
                    </div>
                    <div class="text-right mb-3">
                            <label for="file"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> فایل اثر (در حالت ویرایش، در صورت نیاز فایل را انتخاب کنید)</label>
                        <input id="file" type="file" ${existingData ? '' : 'required'} accept=".pdf,.doc,.docx" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="فرمت تاریخ باید به صورت 1403/10/20 باشد" required>
                    </div>
                `,
                        confirmButtonText: existingData ? 'ویرایش اثر' : 'ثبت اثر',
                        showCancelButton: true,
                        cancelButtonText: 'انصراف',
                        focusConfirm: false,
                        customClass: {
                            confirmButton: 'btn btn-success mx-2',
                            cancelButton: 'btn btn-danger'
                        },
                        didOpen: () => {
                            const popup = Swal.getPopup();
                            popup.style.width = '700px';
                        },
                        // بقیه تنظیمات مشابه قبل
                        preConfirm: () => {
                            const popup = Swal.getPopup();
                            const isEdit = !!existingData;

                            const fields = {
                                name: popup.querySelector('#name'),
                                author: popup.querySelector('#author'),
                                subject: popup.querySelector('#subject'),
                                post_format: popup.querySelector('#post_format'),
                                language: popup.querySelector('#language'),
                                pub_date: popup.querySelector('#pub-date'),
                                file: popup.querySelector('#file')
                            };

                            // اعتبارسنجی فیلدهای اصلی (بدون فایل)
                            const mainFields = [fields.name, fields.author, fields.subject, fields.post_format, fields.language, fields.pub_date];
                            const emptyMainFields = mainFields.filter(field => !field.value.trim());

                            if (emptyMainFields.length > 0) {
                                Swal.showValidationMessage('لطفا تمام فیلدهای الزامی را پر کنید');
                                return false;
                            }

                            // اعتبارسنجی فایل فقط در حالت ایجاد
                            if (!isEdit && fields.file.files.length === 0) {
                                Swal.showValidationMessage('لطفا فایل اثر را انتخاب کنید');
                                return false;
                            }

                            // اعتبارسنجی تاریخ
                            const datePattern = /^14\d{2}\/\d{2}\/\d{2}$/;
                            if (!datePattern.test(fields.pub_date.value)) {
                                Swal.showValidationMessage('فرمت تاریخ باید به صورت 1403/10/20 باشد');
                                return false;
                            }

                            return {
                                name: fields.name.value,
                                author: fields.author.value,
                                subject: fields.subject.value,
                                post_format: fields.post_format.value,
                                language: fields.language.value,
                                publication_date: fields.pub_date.value,
                                file: fields.file.files[0] || null
                            };
                        }
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            try {
                                const isEdit = !!postId;
                                const url = isEdit ? `/library/${postId}` : '/library';
                                const method ='POST';

                                // ساخت FormData
                                const formData = new FormData();
                                formData.append('name', result.value.name);
                                formData.append('author', result.value.author);
                                formData.append('subject', result.value.subject);
                                formData.append('post_format', result.value.post_format);
                                formData.append('language', result.value.language);
                                formData.append('publication_date', result.value.publication_date);

                                if (result.value.file) {
                                    formData.append('file', result.value.file);
                                }

                                // ارسال درخواست
                                const response = await fetch(url, {
                                    method: method,
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    },
                                    body: formData
                                });
                                const data = await response.json();

                                if (!response.ok) throw new Error(data.message || 'خطا در عملیات');

                                Swal.fire({
                                    title: isEdit ? 'ویرایش موفق' : 'ثبت موفق',
                                    text: isEdit ? 'اطلاعات با موفقیت ویرایش شد' : 'اطلاعات با موفقیت ثبت شد',
                                    icon: 'success'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } catch (error) {
                                Swal.fire({
                                    title: 'خطا!',
                                    text: error.message,
                                    icon: 'error'
                                });
                            }
                        }
                    });

                } catch (error) {
                    Swal.fire('خطا!', error.message, 'error');
                }
            }

            async function editPost(postId) {
                try {
                    // نمایش لودینگ
                    Swal.fire({
                        title: 'در حال بارگذاری...',
                        html: 'لطفا منتظر بمانید',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });

                    // دریافت اطلاعات اثر
                    const response = await fetch(`/library/${postId}`);
                    if (!response.ok) throw new Error('خطا در دریافت داده‌ها');
                    const postData = await response.json();

                    // بارگذاری لیست‌های مربوطه
                    const [languages, postSubjects, postFormats] = await Promise.all([
                        loadLanguages(),
                        loadPostSubjects(),
                        loadPostFormats(),
                    ]);

                    // پر کردن فرم با داده‌های موجود
                    showForm(postData, languages, postSubjects, postFormats, postId);

                } catch (error) {
                    Swal.fire('خطا!', error.message, 'error');
                }
            }

                $('.library-add-post').on('click', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'در حال بارگذاری...',
                        html: 'لطفا منتظر بمانید',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                    showForm();
                });
                $('.library-edit-post').on('click', function (e) {
                    e.preventDefault();
                    editPost($(this).data('id'));
                });
                $('.library-remove-post').on('click', function (e) {
                    e.preventDefault();
                    const postId = $(this).data('id');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                    Swal.fire({
                        title: 'آیا مطمئن هستید؟',
                        text: "این عمل قابل بازگشت نیست!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'بله، حذف شود!',
                        cancelButtonText: 'انصراف',
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            try {
                                // نمایش لودینگ
                                Swal.fire({
                                    title: 'در حال حذف...',
                                    allowOutsideClick: false,
                                    didOpen: () => Swal.showLoading()
                                });

                                // ارسال درخواست حذف
                                const response = await fetch(`/library/${postId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken
                                    }
                                });

                                const data = await response.json();

                                if (!response.ok) throw new Error(data.message || 'خطا در حذف اطلاعات');

                                // نمایش پیام موفقیت
                                Swal.fire({
                                    title: 'حذف شد!',
                                    text: 'آیتم مورد نظر با موفقیت حذف شد',
                                    icon: 'success'
                                }).then(() => {
                                    window.location.reload();
                                });

                            } catch (error) {
                                Swal.fire({
                                    title: 'خطا!',
                                    text: error.message,
                                    icon: 'error'
                                });
                            }
                        }
                    });
                });

                break;
            case "/Profile":
                resetFields();
                $('#change-password').submit(function (e) {
                    e.preventDefault();
                    let form = $(this);
                    let data = form.serialize();

                    $.ajax({
                        type: 'POST', url: "/ChangePasswordInc", data: data, headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }, success: function (response) {
                            if (response.success) {
                                swalFire('عملیات موفقیت آمیز بود!', response.errors.passwordChanged[0], 'success', 'بستن');
                                oldPass.value = '';
                                newPass.value = '';
                                repeatNewPass.value = '';
                            } else {
                                if (response.errors.oldPassNull) {
                                    swalFire('خطا!', response.errors.oldPassNull[0], 'error', 'تلاش مجدد');
                                } else if (response.errors.newPassNull) {
                                    swalFire('خطا!', response.errors.newPassNull[0], 'error', 'تلاش مجدد');
                                } else if (response.errors.repeatNewPassNull) {
                                    swalFire('خطا!', response.errors.repeatNewPassNull[0], 'error', 'تلاش مجدد');
                                } else if (response.errors.lowerThan8) {
                                    swalFire('خطا!', response.errors.lowerThan8[0], 'error', 'تلاش مجدد');
                                } else if (response.errors.higherThan12) {
                                    swalFire('خطا!', response.errors.higherThan12[0], 'error', 'تلاش مجدد');
                                } else if (response.errors.wrongRepeat) {
                                    swalFire('خطا!', response.errors.wrongRepeat[0], 'error', 'تلاش مجدد');
                                } else if (response.errors.wrongPassword) {
                                    swalFire('خطا!', response.errors.wrongPassword[0], 'error', 'تلاش مجدد');
                                } else {
                                    location.reload();
                                }
                            }
                        }, error: function (xhr, textStatus, errorThrown) {
                            // console.log(xhr);
                        }
                    });
                });
                $('#change-user-image').submit(function (e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = new FormData(form[0]);
                    $.ajax({
                        type: 'POST', url: "/ChangeUserImage", data: formData, headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }, contentType: false, processData: false, success: function (response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                if (response.errors.wrongImage) {
                                    swalFire('خطا!', response.errors.wrongImage[0], 'error', 'تلاش مجدد');
                                } else {
                                    location.reload();
                                }
                            }
                        }, error: function (xhr, textStatus, errorThrown) {
                            // console.log(xhr);
                        }
                    });
                });
                break;
            case "/UserManager":
                resetFields();
                $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                    toggleModal(newUserModal.id)
                });
                $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                    toggleModal(editUserModal.id)
                });
                $('#type').on('change', function () {
                    if ($(this).val() == 5 || $(this).val() == 6) {
                        $('.scientificGroupDiv').removeClass('hidden');
                    } else {
                        $('.scientificGroupDiv').addClass('hidden');
                    }
                });
                $('#editedType').on('change', function () {
                    if ($(this).val() == 5 || $(this).val() == 6) {
                        $('.editedScientificGroupDiv').removeClass('hidden');
                    } else {
                        $('.editedScientificGroupDiv').addClass('hidden');
                    }
                });
                //Activation Status In User Manager
                $(document).on('click', '.ASUM', function (e) {
                    const username = $(this).data('username');
                    const active = $(this).data('active');
                    let status = null;
                    if (active == 1) {
                        status = 'غیرفعال';
                    } else if (active == 0) {
                        status = 'فعال';
                    }
                    e.preventDefault();
                    Swal.fire({
                        title: 'آیا مطمئن هستید؟',
                        text: 'کاربر انتخاب شده ' + status + ' خواهد شد.',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'خیر',
                        confirmButtonText: 'بله',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST', url: '/ChangeUserActivationStatus', headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, data: {
                                    username: username,
                                }, success: function (response) {
                                    if (response.success) {
                                        swalFire('عملیات موفقیت آمیز بود!', response.message.changedUserActivation[0], 'success', 'بستن');
                                        const activeButton = $(`button[data-username="${username}"]`);
                                        if (active == 1) {
                                            activeButton.removeClass('bg-red-500').addClass('bg-green-500');
                                            activeButton.removeClass('hover:bg-red-600').addClass('hover:bg-green-600');
                                            activeButton.text('فعال‌سازی');
                                            activeButton.data('active', 0);
                                        } else if (active == 0) {
                                            activeButton.removeClass('bg-green-500').addClass('bg-red-500');
                                            activeButton.removeClass('hover:bg-green-600').addClass('hover:bg-red-600');
                                            activeButton.text('غیرفعال‌سازی');
                                            activeButton.data('active', 1);
                                        }
                                    } else {
                                        swalFire('خطا!', response.errors.changedUserActivationFailed[0], 'error', 'تلاش مجدد');
                                    }
                                }
                            });
                        }
                    });
                });
                //NTCP Status In User Manager
                $(document).on('click', '.ntcp', function (e) {
                    const username = $(this).data('ntcp-username');
                    const NTCP = $(this).data('ntcp');
                    let status = null;
                    if (NTCP == 1) {
                        status = 'نمی باشد';
                    } else if (NTCP == 0) {
                        status = 'می باشد';
                    }
                    e.preventDefault();
                    Swal.fire({
                        title: 'آیا مطمئن هستید؟',
                        text: 'کاربر انتخاب شده نیازمند تغییر رمزعبور ' + status + '؟',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'خیر',
                        confirmButtonText: 'بله',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST', url: '/ChangeUserNTCP', headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, data: {
                                    username: username,
                                }, success: function (response) {
                                    if (response.success) {
                                        swalFire('عملیات موفقیت آمیز بود!', response.message.changedUserNTCP[0], 'success', 'بستن');
                                        const ntcpButton = $(`button[data-ntcp-username="${username}"]`);
                                        if (NTCP == 1) {
                                            ntcpButton.removeClass('bg-red-500').addClass('bg-green-500');
                                            ntcpButton.removeClass('hover:bg-red-600').addClass('hover:bg-green-600');
                                            ntcpButton.text('نمی باشد');
                                            ntcpButton.data('ntcp', 0);
                                        } else if (NTCP == 0) {
                                            ntcpButton.removeClass('bg-green-500').addClass('bg-red-500');
                                            ntcpButton.removeClass('hover:bg-green-600').addClass('hover:bg-red-600');
                                            ntcpButton.text('می باشد');
                                            ntcpButton.data('ntcp', 1);
                                        }
                                    } else {
                                        swalFire('خطا!', response.errors.changedUserNTCPFailed[0], 'error', 'تلاش مجدد');
                                    }
                                }
                            });
                        }
                    });
                });
                //Reset Password In User Manager
                $(document).on('click', '.rp', function (e) {
                    const username = $(this).data('rp-username');
                    let status = null;

                    e.preventDefault();
                    Swal.fire({
                        title: 'آیا مطمئن هستید؟',
                        text: 'رمز عبور کاربر انتخاب شده به 12345678 بازنشانی خواهد شد.',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'خیر',
                        confirmButtonText: 'بله',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST', url: '/ResetPassword', headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, data: {
                                    username: username,
                                }, success: function (response) {
                                    if (response.success) {
                                        swalFire('عملیات موفقیت آمیز بود!', response.message.passwordResetted[0], 'success', 'بستن');
                                    } else {
                                        swalFire('خطا!', response.errors.resetPasswordFailed[0], 'error', 'تلاش مجدد');
                                    }
                                }
                            });
                        }
                    });
                });
                //Showing Or Hiding Modal
                $('#new-user-button, #cancel-new-user').on('click', function () {
                    toggleModal(newUserModal.id);
                });
                $('#edit-user-button, #cancel-edit-user').on('click', function () {
                    toggleModal(editUserModal.id);
                });
                //New User
                $('#new-user').submit(function (e) {
                    e.preventDefault();
                    let name = document.getElementById('name').value;
                    let family = document.getElementById('family').value;
                    let username = document.getElementById('username').value;
                    let password = document.getElementById('password').value;
                    let type = document.getElementById('type').value;

                    if (name.length === 0) {
                        swalFire('خطا!', 'نام وارد نشده است.', 'error', 'تلاش مجدد');
                    } else if (family.length === 0) {
                        swalFire('خطا!', 'نام وارد نشده است.', 'error', 'تلاش مجدد');
                    } else if (!hasOnlyPersianCharacters(name)) {
                        swalFire('خطا!', 'نام نمی تواند مقدار غیر از کاراکتر فارسی یا عدد داشته باشد.', 'error', 'تلاش مجدد');
                    } else if (!hasOnlyPersianCharacters(family)) {
                        swalFire('خطا!', 'نام خانوادگی نمی تواند مقدار غیر از کاراکتر فارسی یا عدد داشته باشد.', 'error', 'تلاش مجدد');
                    } else if (username.length === 0) {
                        swalFire('خطا!', 'نام کاربری وارد نشده است.', 'error', 'تلاش مجدد');
                    } else if (password.length === 0) {
                        swalFire('خطا!', 'رمز عبور وارد نشده است.', 'error', 'تلاش مجدد');
                    } else if (type.length === 0) {
                        swalFire('خطا!', 'نوع کاربری انتخاب نشده است.', 'error', 'تلاش مجدد');
                    } else if (hasOnlyPersianCharacters(username)) {
                        swalFire('خطا!', 'نام کاربری نمی تواند مقدار فارسی داشته باشد.', 'error', 'تلاش مجدد');
                    } else {
                        let form = $(this);
                        let data = form.serialize();

                        $.ajax({
                            type: 'POST', url: '/NewUser', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors && response.errors.userFounded) {
                                    swalFire('خطا!', response.errors.userFounded[0], 'error', 'تلاش مجدد');
                                } else if (response.success) {
                                    // swalFire('عملیات موفقیت آمیز بود!', response.message.userAdded[0], 'success', 'بستن');
                                    // toggleModal(newUserModal.id);
                                    // resetFields();
                                    location.reload();
                                }

                            }
                        });
                    }
                });
                //Getting User Information
                $('#userIdForEdit').change(function (e) {
                    e.preventDefault();
                    if (userIdForEdit.value === null || userIdForEdit.value === '') {
                        swalFire('خطا!', 'کاربر انتخاب نشده است.', 'error', 'تلاش مجدد');
                    } else {
                        $.ajax({
                            type: 'GET', url: '/GetUserInfo', data: {
                                userID: userIdForEdit.value
                            }, success: function (response) {
                                userEditDiv.hidden = false;
                                editedName.value = response.name;
                                editedFamily.value = response.family;
                                editedType.value = response.type;
                                if (response.type == 5 || response.type == 6) {
                                    editedScientificGroup.value = response.scientific_group;
                                    $('.editedScientificGroupDiv').removeClass('hidden');
                                    $('.editedScientificGroup').val(response.scientific_group).trigger('change');
                                } else {
                                    $('.editedScientificGroupDiv').addClass('hidden');
                                }
                            }
                        });
                    }
                });
                //Edit User
                $('#edit-user').submit(function (e) {
                    e.preventDefault();
                    let userID = userIdForEdit.value;
                    let name = editedName.value;
                    let family = editedFamily.value;
                    let type = editedType.value;

                    if (name.length === 0) {
                        swalFire('خطا!', 'نام وارد نشده است.', 'error', 'تلاش مجدد');
                    } else if (family.length === 0) {
                        swalFire('خطا!', 'نام خانوادگی وارد نشده است.', 'error', 'تلاش مجدد');
                    } else if (!hasOnlyPersianCharacters(name)) {
                        swalFire('خطا!', 'نام نمی تواند مقدار غیر از کاراکتر فارسی یا عدد داشته باشد.', 'error', 'تلاش مجدد');
                    } else if (!hasOnlyPersianCharacters(family)) {
                        swalFire('خطا!', 'نام نمی تواند مقدار غیر از کاراکتر فارسی یا عدد داشته باشد.', 'error', 'تلاش مجدد');
                    } else if (userID.length === 0) {
                        swalFire('خطا!', 'کاربر انتخاب نشده است.', 'error', 'تلاش مجدد');
                    } else if (type.length === 0) {
                        swalFire('خطا!', 'نوع کاربری انتخاب نشده است.', 'error', 'تلاش مجدد');
                    } else {
                        let form = $(this);
                        let data = form.serialize();

                        showLoadingPopup();
                        $.ajax({
                            type: 'POST', url: '/EditUser', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors && response.errors.userFounded) {
                                    swalFire('خطا!', response.errors.userFounded[0], 'error', 'تلاش مجدد');
                                } else if (response.success) {
                                    // swalFire('عملیات موفقیت آمیز بود!', response.message.userEdited[0], 'success', 'بستن');
                                    // toggleModal(editUserModal.id);
                                    // resetFields();
                                    location.reload();
                                }

                            }
                        });
                    }
                });
                break;
            case '/BackupDatabase':
                $('#create-backup').on('click', function (e) {
                    e.preventDefault();
                    showLoadingPopup();
                    $.ajax({
                        type: 'POST', url: '/BackupDatabase', headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }, success: function (response) {
                            if (response.errors) {
                                if (response.errors.error) {
                                    swalFire('خطا!', response.errors.error[0], 'error', 'تلاش مجدد');
                                }
                            } else {
                                location.reload();
                            }
                        }
                    });
                });

                break;
        }
    }
});
