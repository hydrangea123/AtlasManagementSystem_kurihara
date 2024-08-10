<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\User;
class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */


    // public function getValidatorInstance(){
    //    if($this->input('old_year') && $this->input('old_month') && $this->input('old_day'))
    //    {
    //        $birthDate = implode('-', $this->only(['old_year','old_month','old_day']));
    //        $this->marge([
    //            'data' => $birthDate,
    //        ]);
    //    }
    //        return parent::getValidatorInstance();
    //    }
//
    public function rules()
    {
        return [
            'over_name'                      => 'required|string|max:10',
            'under_name'                     => 'required|string|max:10',
            'over_name_kana'                 => 'required|max:30|katakana',
            'under_name_kana'                => 'required|max:30|katakana',
            'mail_address'                   => 'required|email|unique:users|max:100',
            'sex'                            => ['required','regex:/(1|2|3)/'],
            //'data'                           => 'after:"2000/01/01"|date',
            //'old_year'                       => 'required_with:old_month,old_day',
            //'old_month'                      => 'required_with:old_year,old_day'
            //'old_day'                        => 'required_with:old_year,old_month,
            //'role'                           => 'required|Rule::in([1,2,3,4])',
            //'password'                       => 'required|between:8,30|confirmed',
        ];
    }


    public function messages(){
        return [
            'over_name.required'      => '名前は必ず入力してください',
            'over_name.string'        => '文字列で入力してください',
            'over_name.max'           => '10文字以内で入力してください',

            'under_name.required'     => '名前は必ず入力してください',
            'under_name.string'       => '文字列で入力してください',
            'under_name.max'          => '10文字以内で入力してください',

            'over_name_kana.required'    => '名前は必ず入力してください',
            'over_name_kana.katakana'    => 'カタカナで入力してください',
            'over_name_kana.max'         => '30文字以内で入力してください',

            'under_name_kana.required'     => '名前は必ず入力してください',
            'under_name_kana.katakana'     => 'カタカナで入力してください',
            'under_name_kana.max'          => '30文字以内で入力してください',

            'mail_address.required'   => 'メールアドレスは必ず入力してください',
            'mail_address.email'      => 'メール形式で入力してください',
            'mail_address.unique'     => 'このメールアドレスはすでに登録されています',
            'mail_address.max'        => '100文字以内で入力してください',

            'sex.required'            => '性別は必ず入力してください',
            'sex.Rule'                => 'いずれかを選択してください',

            'data.data'               => '有効な日付で入力してください',
            'data.after'              => '2000年1月日以降で入力してください',

            'old_year.required'       => '生年月日（年）は必ず入力してください',
            'old_month.required'      => '生年月日（月）は必ず入力してください',
            'old_day.required'        => '生年月日（日）は必ず入力してください',

            'role.required'            => '役職は必ず入力してください',
            'role.Rule'                => 'いずれかを選択してください',

            'password.required'        => '名前は必ず入力してください',
            'password.between'        => '8文字以上30文字以下で入力してください',
            'password.confirmed'       => 'パスワードが一致しません',

        ];
    }
    }

