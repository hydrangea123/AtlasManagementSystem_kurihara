@extends('layouts.sidebar')

@section('content')
    <div class="post_create_container d-flex">
        <div class="post_create_area border w-50 m-5 p-5">
            <div class="">
                @if ($errors->first('post_category_id'))
                    <span class="error_message">{{ $errors->first('post_category_id') }}</span>
                @endif
                <p class="mb-0">カテゴリー</p>
                <select class="w-100" form="postCreate" name="post_category_id">
                    @foreach ($main_categories as $main_category)
                        <optgroup label="{{ $main_category->main_category }}"></optgroup>
                        @foreach ($main_category->sub_categories as $sub_category)
                            <option value="{{ $sub_category->id }}">{{ $sub_category->sub_category }}</option>
                        @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            <div class="mt-3">
                @if ($errors->first('post_title'))
                    <span class="error_message">{{ $errors->first('post_title') }}</span>
                @endif
                <p class="mb-0">タイトル</p>
                <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
            </div>
            <div class="mt-3">
                @if ($errors->first('post'))
                    <span class="error_message">{{ $errors->first('post') }}</span>
                @endif
                <p class="mb-0">投稿内容</p>
                <textarea class="w-100" form="postCreate" name="post">{{ old('post') }}</textarea>
            </div>
            <div class="mt-3 text-right">
                <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
            </div>
            <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>
        </div>
        @can('admin')
            <div class="w-25 ml-auto mr-auto">
                <div class="category_area mt-5 p-5">

                    <div class="errors" style="font-size:13px">
                        @if ($errors->has('main_category_name'))
                            <p>{{ $errors->first('main_category_name') }}</p>
                        @endif
                    </div>

                    <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryRequest">
                        {{ csrf_field() }}
                        <!-- メインカテゴリー -->
                        <div class="main_category">
                            <p class="m-0">メインカテゴリー</p>
                            <input type="text" class="w-100" name="main_category_name" form="mainCategoryRequest">
                            <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="mainCategoryRequest">
                        </div>
                    </form>

                    <div class="errors" style="font-size:13px">
                        @if ($errors->has('sub_category_name'))
                            <p>{{ $errors->first('sub_category_name') }}</p>
                        @endif
                    </div>
                    <div class="errors" style="font-size:13px">
                        @if ($errors->has('main_category_id'))
                            <p>{{ $errors->first('main_category_id') }}</p>
                        @endif
                    </div>
                    <!-- サブカテゴリー-->
                    <form action="{{ route('sub.category.create') }}" method="post" id="subCategoryRequest">
                        {{ csrf_field() }}
                        <div class="sub_category">
                            <p class="m-0">サブカテゴリー</p>
                            <select class="form-control" id="main_category_id" name="post_category_id">
                                <option>選択してください</option>
                                @foreach ($main_categories as $main_category)
                                    <option value="{{ $main_category->id }}">{{ $main_category->main_category }}</option>
                                @endforeach
                            </select>
                            <input type="text" class="w-100" name="sub_category_name" form="subCategoryRequest">
                            <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="subCategoryRequest">
                        </div>
                    </form>
                </div>
            </div>
        @endcan
    </div>
@endsection
