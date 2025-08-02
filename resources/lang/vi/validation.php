<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Các dòng thông báo xác thực
    |--------------------------------------------------------------------------
    |
    | Các dòng thông báo sau chứa các thông báo lỗi mặc định được sử dụng
    | bởi lớp xác thực. Một số quy tắc có nhiều phiên bản như size.
    |
    */

    'accepted'             => 'Trường :attribute phải được chấp nhận.',
    'active_url'           => 'Trường :attribute không phải là một URL hợp lệ.',
    'after'                => 'Trường :attribute phải là một ngày sau ngày :date.',
    'alpha'                => 'Trường :attribute chỉ có thể chứa chữ cái.',
    'alpha_dash'           => 'Trường :attribute chỉ có thể chứa chữ cái, số và dấu gạch ngang.',
    'alpha_num'            => 'Trường :attribute chỉ có thể chứa chữ cái và số.',
    'array'                => 'Trường :attribute phải là một mảng.',
    'before'               => 'Trường :attribute phải là một ngày trước ngày :date.',
    'between'              => [
        'numeric' => 'Trường :attribute phải từ :min đến :max.',
        'file'    => 'Dung lượng tệp :attribute phải từ :min đến :max kilobytes.',
        'string'  => 'Trường :attribute phải từ :min đến :max ký tự.',
        'array'   => 'Trường :attribute phải có từ :min đến :max phần tử.',
    ],
    'boolean'              => 'Trường :attribute phải là true hoặc false.',
    'confirmed'            => 'Xác nhận mật khẩu không khớp.',
    'date'                 => 'Trường :attribute không phải là ngày hợp lệ.',
    'date_format'          => 'Trường :attribute không khớp với định dạng :format.',
    'different'            => 'Trường :attribute và :other phải khác nhau.',
    'digits'               => 'Trường :attribute phải gồm :digits chữ số.',
    'digits_between'       => 'Trường :attribute phải từ :min đến :max chữ số.',
    'email'                => 'Trường :attribute phải là địa chỉ email hợp lệ.',
    'exists'               => 'Email không tồn tại trong hệ thống.',
    'file'                 => 'Trường :attribute phải là tệp.',
    'filled'               => 'Trường :attribute không được để trống.',
    'image'                => 'Trường :attribute phải là hình ảnh.',
    'in'                   => 'Giá trị đã chọn trong :attribute không hợp lệ.',
    'integer'              => 'Trường :attribute phải là số nguyên.',
    'ip'                   => 'Trường :attribute phải là địa chỉ IP hợp lệ.',
    'max'                  => [
        'numeric' => 'Trường :attribute không được lớn hơn :max.',
        'file'    => 'Dung lượng tệp :attribute không được lớn hơn :max kilobytes.',
        'string'  => 'Trường :attribute không được nhiều hơn :max ký tự.',
        'array'   => 'Trường :attribute không được nhiều hơn :max phần tử.',
    ],
    'mimes'                => 'Trường :attribute phải là tệp kiểu: :values.',
    'min'                  => [
        'numeric' => 'Trường :attribute phải ít nhất :min.',
        'file'    => 'Dung lượng tệp :attribute phải ít nhất :min kilobytes.',
        'string'  => 'Trường :attribute phải ít nhất :min ký tự.',
        'array'   => 'Trường :attribute phải có ít nhất :min phần tử.',
    ],
    'not_in'               => 'Giá trị đã chọn trong :attribute không hợp lệ.',
    'numeric'              => 'Trường :attribute phải là số.',
    'present'              => 'Trường :attribute phải tồn tại.',
    'regex'                => 'Định dạng trường :attribute không hợp lệ.',
    'required'             => 'Trường :attribute không được để trống.',
    'required_if'          => 'Trường :attribute không được để trống khi :other là :value.',
    'required_unless'      => 'Trường :attribute không được để trống trừ khi :other nằm trong :values.',
    'required_with'        => 'Trường :attribute không được để trống khi có :values.',
    'required_with_all'    => 'Trường :attribute không được để trống khi có tất cả :values.',
    'required_without'     => 'Trường :attribute không được để trống khi không có :values.',
    'required_without_all' => 'Trường :attribute không được để trống khi không có bất kỳ :values nào.',
    'same'                 => 'Trường :attribute và :other phải khớp nhau.',
    'size'                 => [
        'numeric' => 'Trường :attribute phải bằng :size.',
        'file'    => 'Dung lượng tệp :attribute phải bằng :size kilobytes.',
        'string'  => 'Trường :attribute phải chứa :size ký tự.',
        'array'   => 'Trường :attribute phải chứa :size phần tử.',
    ],
    'string'               => 'Trường :attribute phải là chuỗi.',
    'timezone'             => 'Trường :attribute phải là múi giờ hợp lệ.',
    'unique'               => 'Trường :attribute đã tồn tại.',
    'url'                  => 'Định dạng trường :attribute không hợp lệ.',

    /*
    |--------------------------------------------------------------------------
    | Tùy chỉnh thông báo
    |--------------------------------------------------------------------------
    */

    'custom' => [
        'email' => [
            'exists' => 'Email không tồn tại trong hệ thống.',
        ],
        'password' => [
            'confirmed' => 'Mật khẩu xác nhận không khớp.',
            'min' => 'Mật khẩu phải ít nhất :min ký tự.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Thuộc tính
    |--------------------------------------------------------------------------
    */

    'attributes' => [],
];
