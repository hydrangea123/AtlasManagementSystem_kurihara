@extends('layouts.sidebar')

@section('content')
    <div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
        <div class="w-50 m-auto h-75">
            <p><span>日</span><span class="ml-3">部</span></p>
            <div class="h-75 border">
                <table class="reserve_detail_table">
                    <tr class="text-center">
                        <th class="w-25">ID</th>
                        <th class="w-25">名前</th>
                        <th class="w-25">場所</th>
                    </tr>
                    <tr class="text-center">
                        <td class="w-25"></td>
                        <td class="w-25"></td>
                        <td class="w-25"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
