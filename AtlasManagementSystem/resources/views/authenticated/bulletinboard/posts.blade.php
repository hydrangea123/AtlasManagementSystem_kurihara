@extends('layouts.sidebar')

@section('content')
    <div class="board_area w-100 border m-auto d-flex">
        <div class="post_view w-75 mt-5">
            @foreach ($posts as $post)
                <div class="post_area border w-75 m-auto p-3">
                    <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん
                    </p>
                    <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>

                    <div class="icon_flex">
                        @foreach ($post->subCategories as $subCategory)
                            <sapn class="category_btn">{{ $subCategory->sub_category }}</sapn>
                        @endforeach

                        <div class="post_bottom_area d-flex">
                            <div class="d-flex post_status">
                                <div class="mr-5">
                                    <i class="fa fa-comment"></i><span
                                        class="">{{ $post_comment->commentCounts($post->id)->count() }}</span>
                                </div>
                                <div>
                                    @if (Auth::user()->is_Like($post->id))
                                        <p class="m-0"><i class="fas fa-heart un_like_btn"
                                                post_id="{{ $post->id }}"></i><span
                                                class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span>
                                        </p>
                                    @else
                                        <p class="m-0"><i class="fas fa fa-heart like_btn"
                                                post_id="{{ $post->id }}"></i><span
                                                class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="other_area w-25">
            <div class="" id="search_content">
                <div class="post_btn"><a href="{{ route('post.input') }}">投稿</a></div>
                <div class="search">
                    <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest"
                        class="search_area">
                    <input type="submit" value="検索" form="postSearchRequest" class="search_btn">
                </div>

                <div class="color_btn">
                    <input type="submit" name="like_posts" class="category_btn posted_like_btn" value="いいねした投稿"
                        form="postSearchRequest">
                    <input type="submit" name="my_posts" class="category_btn my_post_btn" value="自分の投稿"
                        form="postSearchRequest">
                </div>

                <p>カテゴリー検索</p>
                <details class="accordion">
                    @foreach ($categories as $category)
                        <summary class="main_categories" category_id="{{ $category->id }}">
                            {{ $category->main_category }}</summary>

                        @foreach ($category->subCategories as $subCategory)
                            <input type="submit" name="category_word" class="sub_categories"
                                value="{{ $subCategory->sub_category }}" form="postSearchRequest">
                        @endforeach
                    @endforeach
                </details>

            </div>
        </div>
        <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
    </div>
@endsection
