@extends('layouts.sidebar')

@section('content')
    <div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
        <div class="m-auto h-75">
            <p><span class="title_top">{{ $date }}</span><span class="ml-3"
                    class="title_top">{{ $part }}部</span></p>
            <div class="shadow one_person reserve_detail_content">
                <table class="reserve_detail_table">
                    <tr id="table_title" class="reserve_detail_tr">
                        <th class="w-25 table_title_t">ID</th>
                        <th class="w-25 table_title_t">名前</th>
                        <th class="w-25 table_title_t">場所</th>
                    </tr>
                    @foreach ($reservePersons as $reservePerson)
                        @foreach ($reservePerson->users as $one_person)
                            <tr class="reserve_detail_tr">
                                <td class="w-25 table_title_t">{{ $one_person->id }}</td>
                                <td class="w-25 table_title_t">
                                    {{ $one_person->over_name }}{{ $one_person->under_name }}</td>
                                <td class="w-25 table_title_t">リモート</td>
                            </tr>
                        @endforeach
                    @endforeach

                </table>
            </div>
        </div>
    </div>
@endsection
