<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'custom' => [
        'between' => [
            'numeric' => ':attribute باید بین :min و :max باشد.',
            'file'    => ':attribute باید بین :min و :max کیلوبایت باشد.',
            'string'  => ':attribute باید بین :min و :max کاراکتر باشد.',
            'array'   => ':attribute باید بین :min و :max آیتم داشته باشد.',
        ],
        'array' => [
            'min' => ':attribute باید حداقل :min آیتم داشته باشد.',
        ],
    ],

    'accepted'             => ':attribute باید پذیرفته شود.',
    'accepted_if'          => ':attribute باید پذیرفته شود زمانی که :other برابر با :value باشد.',
    'active_url'           => ':attribute یک آدرس معتبر نیست.',
    'after'                => ':attribute باید تاریخی بعد از :date باشد.',
    'after_or_equal'       => ':attribute باید تاریخی مساوی یا بعد از :date باشد.',
    'alpha'                => ':attribute فقط می‌تواند شامل حروف باشد.',
    'alpha_dash'           => ':attribute فقط می‌تواند شامل حروف، اعداد، خط تیره و زیرخط باشد.',
    'alpha_num'            => ':attribute فقط می‌تواند شامل حروف و اعداد باشد.',
    'array'                => ':attribute باید آرایه باشد.',
    'before'               => ':attribute باید تاریخی قبل از :date باشد.',
    'before_or_equal'      => ':attribute باید تاریخی مساوی یا قبل از :date باشد.',
    'between'              => [
        'numeric' => ':attribute باید بین :min و :max باشد.',
        'file'    => ':attribute باید بین :min و :max کیلوبایت باشد.',
        'string'  => ':attribute باید بین :min و :max کاراکتر باشد.',
        'array'   => ':attribute باید بین :min و :max آیتم داشته باشد.',
    ],
    'boolean'              => 'فیلد :attribute باید مقدار صحیح یا غلط داشته باشد.',
    'confirmed'            => 'تأییدیه :attribute مطابقت ندارد.',
    'current_password'     => 'رمز عبور نادرست است.',
    'date'                 => ':attribute تاریخ معتبری نیست.',
    'date_equals'          => ':attribute باید تاریخی مساوی با :date باشد.',
    'date_format'          => ':attribute با قالب :format مطابقت ندارد.',
    'different'            => ':attribute و :other باید متفاوت باشند.',
    'digits'               => ':attribute باید :digits رقم باشد.',
    'digits_between'       => ':attribute باید بین :min و :max رقم باشد.',
    'dimensions'           => ':attribute ابعاد تصویر نامعتبر دارد.',
    'distinct'             => 'فیلد :attribute مقدار تکراری دارد.',
    'email'                => ':attribute باید یک آدرس ایمیل معتبر باشد.',
    'ends_with'            => ':attribute باید با یکی از مقادیر زیر خاتمه یابد: :values.',
    'exists'               => ':attribute انتخاب‌شده معتبر نیست.',
    'file'                 => ':attribute باید یک فایل باشد.',
    'filled'               => ':attribute باید مقدار داشته باشد.',
    'gt'                   => [
        'numeric' => ':attribute باید بزرگ‌تر از :value باشد.',
        'file'    => ':attribute باید بزرگ‌تر از :value کیلوبایت باشد.',
        'string'  => ':attribute باید بزرگ‌تر از :value کاراکتر باشد.',
        'array'   => ':attribute باید بیشتر از :value آیتم داشته باشد.',
    ],
    'gte'                  => [
        'numeric' => ':attribute باید بزرگ‌تر یا مساوی :value باشد.',
        'file'    => ':attribute باید بزرگ‌تر یا مساوی :value کیلوبایت باشد.',
        'string'  => ':attribute باید بزرگ‌تر یا مساوی :value کاراکتر باشد.',
        'array'   => ':attribute باید حداقل :value آیتم داشته باشد.',
    ],
    'image'                => ':attribute باید یک تصویر باشد.',
    'in'                   => ':attribute انتخاب‌شده معتبر نیست.',
    'in_array'             => ':attribute در :other موجود نیست.',
    'integer'              => ':attribute باید عدد صحیح باشد.',
    'ip'                   => ':attribute باید یک آدرس IP معتبر باشد.',
    'ipv4'                 => ':attribute باید یک آدرس IPv4 معتبر باشد.',
    'ipv6'                 => ':attribute باید یک آدرس IPv6 معتبر باشد.',
    'json'                 => ':attribute باید یک رشته JSON معتبر باشد.',
    'lt'                   => [
        'numeric' => ':attribute باید کوچک‌تر از :value باشد.',
        'file'    => ':attribute باید کوچک‌تر از :value کیلوبایت باشد.',
        'string'  => ':attribute باید کوچک‌تر از :value کاراکتر باشد.',
        'array'   => ':attribute باید کمتر از :value آیتم داشته باشد.',
    ],
    'lte'                  => [
        'numeric' => ':attribute باید کوچک‌تر یا مساوی :value باشد.',
        'file'    => ':attribute باید کوچک‌تر یا مساوی :value کیلوبایت باشد.',
        'string'  => ':attribute باید کوچک‌تر یا مساوی :value کاراکتر باشد.',
        'array'   => ':attribute نباید بیشتر از :value آیتم داشته باشد.',
    ],
    'mac_address'          => ':attribute باید یک آدرس MAC معتبر باشد.',
    'max'                  => [
        'numeric' => ':attribute نباید بزرگ‌تر از :max باشد.',
        'file'    => ':attribute نباید بزرگ‌تر از :max کیلوبایت باشد.',
        'string'  => ':attribute نباید بزرگ‌تر از :max کاراکتر باشد.',
        'array'   => ':attribute نباید بیشتر از :max آیتم داشته باشد.',
    ],
    'mimes'                => ':attribute باید فایلی از نوع: :values باشد.',
    'mimetypes'            => ':attribute باید فایلی از نوع: :values باشد.',
    'min'                  => [
        'numeric' => ':attribute باید حداقل :min باشد.',
        'file'    => ':attribute باید حداقل :min کیلوبایت باشد.',
        'string'  => ':attribute باید حداقل :min کاراکتر باشد.',
        'array'   => ':attribute باید حداقل :min آیتم داشته باشد.',
    ],
    'more'                 => 'و :count خطای دیگر',
    'more_errors'          => 'و :count خطای دیگر وجود دارد',
    'multiple_of'          => ':attribute باید مضربی از :value باشد.',
    'not_in'               => ':attribute انتخاب‌شده معتبر نیست.',
    'not_regex'            => 'فرمت :attribute معتبر نیست.',
    'numeric'              => ':attribute باید یک عدد باشد.',
    'password'             => 'رمز عبور اشتباه است.',
    'present'              => ':attribute باید موجود باشد.',
    'prohibited'           => ':attribute مجاز نیست.',
    'prohibited_if'        => ':attribute زمانی که :other برابر با :value باشد مجاز نیست.',
    'prohibited_unless'    => ':attribute مگر اینکه :other در :values باشد مجاز نیست.',
    'prohibits'            => ':attribute اجازه نمی‌دهد که :other موجود باشد.',
    'plural_error'         => 'و :count خطای دیگر وجود دارد.',
    'regex'                => 'فرمت :attribute معتبر نیست.',
    'required'             => ':attribute الزامی است.',
    'required_if'          => ':attribute زمانی که :other برابر با :value است الزامی است.',
    'required_unless'      => ':attribute مگر اینکه :other در :values باشد الزامی است.',
    'required_with'        => ':attribute زمانی که :values موجود است الزامی است.',
    'required_with_all'    => ':attribute زمانی که :values موجود هستند الزامی است.',
    'required_without'     => ':attribute زمانی که :values موجود نیست الزامی است.',
    'required_without_all' => ':attribute زمانی که هیچ‌یک از :values موجود نیستند الزامی است.',
    'same'                 => ':attribute و :other باید یکسان باشند.',
    'size'                 => [
        'numeric' => ':attribute باید :size باشد.',
        'file'    => ':attribute باید :size کیلوبایت باشد.',
        'string'  => ':attribute باید :size کاراکتر باشد.',
        'array'   => ':attribute باید شامل :size آیتم باشد.',
    ],
    'starts_with'          => ':attribute باید با یکی از مقادیر زیر شروع شود: :values.',
    'string'               => ':attribute باید رشته باشد.',
    'timezone'             => ':attribute باید یک منطقه زمانی معتبر باشد.',
    'unique'               => ':attribute قبلاً استفاده شده است.',
    'uploaded'             => 'آپلود :attribute ناموفق بود.',
    'url'                  => ':attribute باید یک URL معتبر باشد.',
    'uuid'                 => ':attribute باید یک UUID معتبر باشد.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader-friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name'        => 'نام',
        'email'       => 'ایمیل',
        'password'    => 'رمز عبور',
        'title'       => 'عنوان',
        'description' => 'توضیحات',
    ],
];
