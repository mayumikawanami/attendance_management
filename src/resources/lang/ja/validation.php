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

    'accepted' => ':attributeを承認してください。',
    'accepted_if' => ':otherが:valueの場合、:attributeを承認してください。',
    'active_url' => ':attributeは正しいURLではありません。',
    'after' => ':attributeは:dateより後の日付にしてください。',
    'after_or_equal' => ':attributeは:date以降の日付にしてください。',
    'alpha' => ':attributeは英字のみで入力してください。',
    'alpha_dash' => ':attributeは英数字とハイフンとアンダースコアのみで入力してください。',
    'alpha_num' => ':attributeは英数字のみで入力してください。',
    'array' => ':attributeは配列にしてください。',
    'ascii' => ':attributeは英数字と記号のみで入力してください。',
    'before' => ':attributeは:dateより前の日付にしてください。',
    'before_or_equal' => ':attributeは:date以前の日付にしてください。',
    'between' => [
        'array' => ':attributeは:min個から:max個の間で指定してください。',
        'file' => ':attributeは:min KBから:max KBの間で指定してください。',
        'numeric' => ':attributeは:minから:maxの間で指定してください。',
        'string' => ':attributeは:min文字から:max文字の間で指定してください。',
    ],
    'boolean' => ':attributeはtrueかfalseにしてください。',
    'can' => ':attributeに無効な値が含まれています。',
    'confirmed' => ':attributeと:attribute確認が一致しません。',
    'current_password' => 'パスワードが正しくありません。',
    'date' => ':attributeは正しい日付ではありません。',
    'date_equals' => ':attributeは:dateと同じ日付にしてください。',
    'date_format' => ':attributeは:format形式で入力してください。',
    'decimal' => ':attributeは小数点以下:decimal桁で入力してください。',
    'declined' => ':attributeを拒否してください。',
    'declined_if' => ':otherが:valueの場合、:attributeを拒否してください。',
    'different' => ':attributeと:otherは異なる値にしてください。',
    'digits' => ':attributeは:digits桁で入力してください。',
    'digits_between' => ':attributeは:min桁から:max桁の間で入力してください。',
    'dimensions' => ':attributeの画像サイズが無効です。',
    'distinct' => ':attributeの値が重複しています。',
    'doesnt_end_with' => ':attributeは:valuesで終わらない値にしてください。',
    'doesnt_start_with' => ':attributeは:valuesで始まらない値にしてください。',
    'email' => ':attributeは正しいメールアドレス形式で入力してください。',
    'ends_with' => ':attributeは:valuesで終わる値にしてください。',
    'enum' => '選択された:attributeは無効です。',
    'exists' => '選択された:attributeは無効です。',
    'extensions' => ':attributeは以下の拡張子のいずれかである必要があります: :values。',
    'file' => ':attributeはファイルにしてください。',
    'filled' => ':attributeは必須項目です。',
    'gt' => [
        'array' => ':attributeは:value個より多く指定してください。',
        'file' => ':attributeは:value KBより大きいファイルにしてください。',
        'numeric' => ':attributeは:valueより大きい値にしてください。',
        'string' => ':attributeは:value文字より多く入力してください。',
    ],
    'gte' => [
        'array' => ':attributeは:value個以上指定してください。',
        'file' => ':attributeは:value KB以上のファイルにしてください。',
        'numeric' => ':attributeは:value以上の値にしてください。',
        'string' => ':attributeは:value文字以上入力してください。',
    ],
    'hex_color' => ':attributeは有効な16進色コードである必要があります。',
    'image' => ':attributeは画像にしてください。',
    'in' => '選択された:attributeは無効です。',
    'in_array' => ':attributeは:otherに含まれていません。',
    'integer' => ':attributeは整数で入力してください。',
    'ip' => ':attributeは正しいIPアドレスで入力してください。',
    'ipv4' => ':attributeは正しいIPv4アドレスで入力してください。',
    'ipv6' => ':attributeは正しいIPv6アドレスで入力してください。',
    'json' => ':attributeは正しいJSON形式で入力してください。',
    'lowercase' => ':attributeは小文字で入力してください。',
    'lt' => [
        'array' => ':attributeは:value個より少なく指定してください。',
        'file' => ':attributeは:value KBより小さいファイルにしてください。',
        'numeric' => ':attributeは:valueより小さい値にしてください。',
        'string' => ':attributeは:value文字より少なく入力してください。',
    ],
    'lte' => [
        'array' => ':attributeは:value個以下で指定してください。',
        'file' => ':attributeは:value KB以下のファイルにしてください。',
        'numeric' => ':attributeは:value以下の値にしてください。',
        'string' => ':attributeは:value文字以下で入力してください。',
    ],
    'mac_address' => ':attributeは有効なMACアドレスである必要があります。',
    'max' => [
        'array' => ':attributeは:max個以下で指定してください。',
        'file' => ':attributeは:max KB以下のファイルにしてください。',
        'numeric' => ':attributeは:max以下の値にしてください。',
        'string' => ':attributeは:max文字以下で入力してください。',
    ],
    'max_digits' => ':attributeは:max桁以下で入力してください。',
    'mimes' => ':attributeは:values形式のファイルにしてください。',
    'mimetypes' => ':attributeは:values形式のファイルにしてください。',
    'min' => [
        'array' => ':attributeは:min個以上で指定してください。',
        'file' => ':attributeは:min KB以上のファイルにしてください。',
        'numeric' => ':attributeは:min以上の値にしてください。',
        'string' => ':attributeは:min文字以上で入力してください。',
    ],
    'min_digits' => ':attributeは:min桁以上で入力してください。',
    'missing' => ':attributeが不足しています。',
    'missing_if' => ':otherが:valueの場合、:attributeが不足しています。',
    'missing_unless' => ':otherが:valueでない場合、:attributeが不足しています。',
    'missing_with' => ':valuesが存在する場合、:attributeが不足しています。',
    'missing_with_all' => ':valuesがすべて存在する場合、:attributeが不足しています。',
    'multiple_of' => ':attributeは:valueの倍数にしてください。',
    'not_in' => '選択された:attributeは無効です。',
    'not_regex' => ':attributeの形式が無効です。',
    'numeric' => ':attributeは数値で入力してください。',
    'password' => [
        'letters' => ':attributeには少なくとも1つの文字が含まれている必要があります。',
        'mixed' => ':attributeには少なくとも1つの大文字と1つの小文字が含まれている必要があります。',
        'numbers' => ':attributeには少なくとも1つの数字が含まれている必要があります。',
        'symbols' => ':attributeには少なくとも1つの記号が含まれている必要があります。',
        'uncompromised' => '指定された:attributeがデータ漏洩に表示されています。別の:attributeを選択してください。',
    ],
    'present' => ':attributeは必須項目です。',
    'present_if' => ':otherが:valueの場合、:attributeは必須項目です。',
    'present_unless' => ':otherが:valueでない場合、:attributeは必須項目です。',
    'present_with' => ':valuesが存在する場合、:attributeは必須項目です。',
    'present_with_all' => ':valuesがすべて存在する場合、:attributeは必須項目です。',
    'prohibited' => ':attributeフィールドは禁止されています。',
    'prohibited_if' => ':otherが:valueの場合、:attributeフィールドは禁止されています。',
    'prohibited_unless' => ':otherが:valuesに含まれていない場合、:attributeフィールドは禁止されています。',
    'prohibits' => ':attributeフィールドは:otherの存在を禁止します。',
    'regex' => ':attributeの形式が無効です。',
    'required' => ':attributeは必須項目です。',
    'required_array_keys' => ':attributeフィールドには以下のエントリが含まれている必要があります: :values。',
    'required_if' => ':otherが:valueの場合、:attributeは必須項目です。',
    'required_if_accepted' => ':otherが承認された場合、:attributeは必須項目です。',
    'required_unless' => ':otherが:valuesに含まれていない場合、:attributeは必須項目です。',
    'required_with' => ':valuesが存在する場合、:attributeは必須項目です。',
    'required_with_all' => ':valuesがすべて存在する場合、:attributeは必須項目です。',
    'required_without' => ':valuesが存在しない場合、:attributeは必須項目です。',
    'required_without_all' => ':valuesがすべて存在しない場合、:attributeは必須項目です。',
    'same' => ':attributeと:otherは一致する必要があります。',
    'size' => [
        'array' => ':attributeは:size個で指定してください。',
        'file' => ':attributeは:size KBのファイルにしてください。',
        'numeric' => ':attributeは:sizeにしてください。',
        'string' => ':attributeは:size文字で入力してください。',
    ],
    'starts_with' => ':attributeは:valuesで始まる値にしてください。',
    'string' => ':attributeは文字列で入力してください。',
    'timezone' => ':attributeは正しいタイムゾーンで入力してください。',
    'unique' => ':attributeは既に使用されています。',
    'uploaded' => ':attributeのアップロードに失敗しました。',
    'uppercase' => ':attributeは大文字で入力してください。',
    'url' => ':attributeは正しいURL形式で入力してください。',
    'ulid' => ':attributeは有効なULIDである必要があります。',
    'uuid' => ':attributeは有効なUUIDである必要があります。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "rule.attribute" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => '名前',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'password_confirmation' => 'パスワード確認',
        'current_password' => '現在のパスワード',
        'new_password' => '新しいパスワード',
        'new_password_confirmation' => '新しいパスワード確認',
    ],

]; 