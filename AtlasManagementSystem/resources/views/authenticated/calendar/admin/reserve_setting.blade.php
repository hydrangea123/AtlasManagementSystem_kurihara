@extends('layouts.sidebar')
@section('content')
    <div class="vh-100 pt-5" style="background:#ECF1F6;">
        <div class="shadow_border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
            <p class="text-center">{{ $calendar->getTitle() }}</p>

            <div class="m-auto border table_w">
                {!! $calendar->render() !!}
            </div>
            <div class="adjust-table-btn m-auto text-right">
                <input type="submit" class="btn btn-primary reserve_setting_btn" value="登録" form="reserveSetting"
                    onclick="return confirm('登録してよろしいですか？')">
            </div>
        </div>
    </div>
@endsection
