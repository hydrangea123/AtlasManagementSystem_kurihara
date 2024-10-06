@extends('layouts.sidebar')

@section('content')
    <div class="search_content w-100 border d-flex">
        <div class="reserve_users_area">
            @foreach ($users as $user)
                <div class="one_person shadow">
                    <div>
                        <span>ID : </span><span class="profile_p">{{ $user->id }}</span>
                    </div>
                    <div><span>名前 : </span>
                        <a href="{{ route('user.profile', ['id' => $user->id]) }}">
                            <span class="profile_p">{{ $user->over_name }}</span>
                            <span class="profile_p">{{ $user->under_name }}</span>
                        </a>
                    </div>
                    <div>
                        <span>カナ : </span>
                        <span class="profile_p">({{ $user->over_name_kana }}</span>
                        <span class="profile_p">{{ $user->under_name_kana }})</span>
                    </div>
                    <div>
                        @if ($user->sex == 1)
                            <span>性別 : </span><span class="profile_p">男</span>
                        @elseif($user->sex == 2)
                            <span>性別 : </span><span class="profile_p">女</span>
                        @else
                            <span>性別 : </span><span class="profile_p">その他</span>
                        @endif
                    </div>
                    <div>
                        <span>生年月日 : </span><span class="profile_p">{{ $user->birth_day }}</span>
                    </div>
                    <div>
                        @if ($user->role == 1)
                            <span>権限 : </span><span class="profile_p">教師(国語)</span>
                        @elseif($user->role == 2)
                            <span>権限 : </span><span class="profile_p">教師(数学)</span>
                        @elseif($user->role == 3)
                            <span>権限 : </span><span class="profile_p">講師(英語)</span>
                        @else
                            <span>権限 : </span><span class="profile_p">生徒</span>
                        @endif
                    </div>
                    <div>
                        @if ($user->role == 4)
                            <span>選択科目 :</span>
                            @foreach ($user->subjects as $subject)
                                <span>{{ $subject->subject }}</span>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="search_area w-25 border">
            <div class="search_area_inner">
                <div>
                    <lavel class="lavel_l">検索</lavel>
                    <input type="text" class="answer" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
                </div>
                <div>
                    <lavel class="lavel_m">カテゴリ</lavel>
                    <select form="userSearchRequest" name="category">
                        <option class="answer" value="name">名前</option>
                        <option class="answer" value="id">社員ID</option>
                    </select>
                </div>
                <div>
                    <label class="lavel_m">並び替え</label>
                    <select name="updown" form="userSearchRequest">
                        <option value="ASC">昇順</option>
                        <option value="DESC">降順</option>
                    </select>
                </div>
                <details class="accordion">
                    <summary class="m-0 search_conditions lavel_m"><span class="lavel_m">検索条件の追加</span></summary>
                    <span class="line"></span>
                    <div class="search_conditions_inner">
                        <div>
                            <label class="lavel_m">性別</label>
                            <div class="sex_area">
                                <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
                                <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
                                <span>その他</span><input type="radio" name="sex" value="3"
                                    form="userSearchRequest">
                            </div>
                        </div>
                        <div>
                            <label class="lavel_m">権限</label>
                            <select name="role" form="userSearchRequest" class="engineer">
                                <option selected disabled>----</option>
                                <option value="1">教師(国語)</option>
                                <option value="2">教師(数学)</option>
                                <option value="3">教師(英語)</option>
                                <option value="4" class="">生徒</option>
                            </select>
                        </div>
                        <div class="selected_engineer">
                            <label class="lavel_m">選択科目</label>
                            @foreach ($subjects as $subject)
                                <div class="select_area">
                                    <lavel>{{ $subject->subject }}</lavel>
                                    <input type="checkbox" name="subjects[]" value="{{ $subject->id }}"
                                        form="userSearchRequest">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </details>
                <div>
                    <input type="submit" name="search_btn" value="検索" form="userSearchRequest" class="post_btn">
                </div>
                <div>
                    <input type="reset" value="リセット" form="userSearchRequest" class="reset_btn">

                </div>
                <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
            </div>
        </div>
    @endsection
