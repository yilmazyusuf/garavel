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

    'accepted' => ':attribute kabul edilmelidir.',
    'active_url' => ':attribute geçerli bir URL değil.',
    'after' => ':attribute, :date tarihinden daha sonrası olmalıdır.',
    'after_or_equal' => ':attribute, :date tarihi veya sonrası olmalıdır.',
    'alpha' => ':attribute yalnızca alfabetik karakterler içerebilir.',
    'alpha_dash' => ':attribute yalnızca alfabetik karakterler, sayılar ve tire içerebilir.',
    'alpha_num' => ':attribute yalnızca alfabetik karakterler ve sayılar içerebilir.',
    'array' => ':attribute dizi olmalıdır.',
    'before' => ':attribute, :date tarihinden öncesi olmalıdır.',
    'before_or_equal' => ':attribute, :date tarihi veya öncesi olmalıdır.',
    'between' => [
        'numeric' => ':attribute :min - :max arasında olmalıdır.',
        'file' => ':attribute :min - :max kilobayt arasında olmalıdır.',
        'string' => ':attribute :min - :max karakter içermelidir.',
        'array' => ':attribute :min - :max arasında eleman içermelidir.',
    ],
    'boolean' => ':attribute true veya false olmalıdır.',
    'confirmed' => ':attribute onayı eşleşmiyor.',
    'date' => ':attribute geçerli bir tarih değil.',
    'date_format' => ':attribute tarih değeri :format formatıyla uyuşmuyor.',
    'different' => ':attribute ve :other değerleri birbirinden farklı olmalıdır.',
    'digits' => ':attribute :digits haneli olmalıdır.',
    'digits_between' => ':attribute :min - :max haneli olabilir.',
    'dimensions' => ':attribute geçersiz resim ölçülerine sahip.',
    'distinct' => ':attribute çift değere sahip.',
    'email' => ':attribute geçerli bir e-mail olmalıdır.',
    'exists' => ':attribute seçimi geçersiz.',
    'file' => ':attribute bir dosya olmalıdır.',
    'filled' => ':attribute, bir değere sahip olmalıdır.',
    'image' => ':attribute bir Resim olmalıdır.',
    'in' => ':attribute seçimi geçersiz.',
    'in_array' => ':attribute, :other arasında değil.',
    'integer' => ':attribute bir Sayı olmalıdır.',
    'ip' => ':attribute geçerli bir IP Adresi olmalıdır.',
    'ipv4' => ':attribute geçerli bir IPv4 Adresi olmalıdır.',
    'ipv6' => ':attribute geçerli bir IPv6 Adresi olmalıdır.',
    'json' => ':attribute geçerli bir JSON olmalıdır.',
    'max' => [
        'numeric' => ':attribute en fazla :max olabilir.',
        'file' => ':attribute en fazla :max kilobayt olmalıdır.',
        'string' => ':attribute en fazla :max karakter içermelidir.',
        'array' => ':attribute en fazla :max eleman içerebilir.',
    ],
    'mimes' => ':attribute, :values tiplerinde bir dosya olmalıdır.',
    'mimetypes' => ':attribute, :values tiplerinde bir dosya olmalıdır.',
    'min' => [
        'numeric' => ':attribute en az :min olmalıdır.',
        'file' => ':attribute en az :min kilobayt olmalıdır.',
        'string' => ':attribute en az :min karakter içermelidir.',
        'array' => ':attribute en az :min eleman içerebilir.',
    ],
    'not_in' => ':attribute seçimi geçersiz.',
    'numeric' => ':attribute numerik olmalıdır.',
    'present' => ':attribute alanı mevcut olmalıdır.',
    'regex' => ':attribute formatı geçersiz.',
    'required' => ':attribute zorunludur.',
    'required_if' => ':attribute alanı :other  :value olduğunda gereklidir.',
    'required_unless' => ':attribute alanı :other alanının :values arasında olmadıkçta gereklidir.',
    'required_with' => ':attribute alanı :values mevcut olduğunda gereklidir.',
    'required_with_all' => ':attribute alanı :values mevcut olduğunda gereklidir.',
    'required_without' => ':attribute alanı :values mevcut olmadığında gereklidir.',
    'required_without_all' => ':attribute ya da :values alanlarından en az biri zorunludur.',
    'same' => ':attribute ve :other uyuşmalıdır.',
    'size' => [
        'numeric' => ':attribute, :size olmalıdır.',
        'file' => ':attribute, :size kilobayt olmalıdır.',
        'string' => ':attribute, :size karakter olmalıdır.',
        'array' => ':attribute, :size eleman içermelidir.',
    ],
    'string' => ':attribute, string olmalıdır.',
    'timezone' => ':attribute, geçerli bir timezone olmalıdır.',
    'unique' => ':attribute benzersiz olmalıdır. Böyle bir kayıt mevcut.',
    'uploaded' => ':attribute yüklenemedi.',
    'url' => ':attribute değeri geçersiz.',
    'phone' => ':attribute (111) 222-3344 formatında olmalıdır.',
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | Here you may specify custom validation messages for attributes using the
      | convention "attribute.rule" to name the lines. This makes it quick to
      | specify a specific custom language line for a given attribute rule.
      |
     */
    'custom' => [
        'rule_start' => [
            'after' => 'Başlangıç Tarihi, Bugün veya sonrası olmalıdır.',
        ],
        'rule_end' => [
            'after' => 'Bitiş Tarihi, Bugün veya sonrası olmalıdır.',
        ],
        'expedition_date' => [
            'after' => 'Sefer Tarihi, Bugün veya sonrası olmalıdır.',
        ],
        'expedition_time' => [
            'date_format' => 'Sefer Zamanı, SS:DD formatında olmalıdır.',
        ], 
    ],
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Attributes
      |--------------------------------------------------------------------------
      |
      | The following language lines are used to swap attribute place-holders
      | with something more reader friendly such as E-Mail Address instead
      | of "email". This simply helps us make messages a little cleaner.
      |
     */
    'attributes' => [],
];
