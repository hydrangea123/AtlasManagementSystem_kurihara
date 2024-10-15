<?php
namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    $weeks = $this->getWeeks();
    foreach($weeks as $week){
      $html[] = '<tr class="'.$week->getClassName().'">';

      $days = $week->getDays();
      foreach($days as $day){
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");

        // 1日以降　&&　今日より前だったら
        if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
          $html[] = '<td class="calendar-td past-day '.$day->getClassName().'">';
        }else{
          $html[] = '<td class="calendar-td '.$day->getClassName().'">';
        }
        $html[] = $day->render();

        //if 当月予約されていたら
        if(in_array($day->everyDay(), $day->authReserveDay())){
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;

        // 当月１日から末日まで（10月すべて）&&（かつ）今日よりも以前の日（過去日）
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px;color:black;">リモ'.$reservePart.'部参加</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
                        // ↑予約している過去日
          }else{
            $html[] = '<a class="js-modal-open btn btn-danger p-0 w-75" style="font-size:12px" href="">リモ'. $reservePart .'部</a>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
                        // ↑予約している未来日
            //   モーダルの中身
                   $html[] = '<div class="modal js-modal">';
                   $html[] =    '<div class="modal__bg js-modal-close"></div>';
                   $html[] =        '<div class="modal__content">';
                   $html[] =            '<form action="'.route('deleteParts') .'" method="post" id="modal_p">';
                   $html[] =                '<p clas="date">予約日：'.$day->authReserveDate($day->everyDay())->first()->setting_reserve.'</p>';
                   $html[] =                '<p>時間：リモ'.$reservePart.'部</p>';
                   $html[] =                '<p>上記の予約をキャンセルしてもよろしいですか？</p>';
                   $html[] =                 csrf_field() ;
                   $html[] =            '<div class="modal_btn">';
                   $html[] =                '<a class="js-modal-close btn btn-primary" href="">閉じる</a>';
                   $html[] =                '<input type="submit" class="btn btn-danger" value="キャンセル">';
                   $html[] =                '<input type="hidden" name="getDate[]" value="'.$day->authReserveDate($day->everyDay())->first()->setting_reserve.'">';
                   $html[] =                '<input type="hidden" name="getPart[]"  value="'.$reservePart.'">';
                   $html[] =            '</form>';
                   $html[] =    '</div>';
                   $html[] ='</div>';
          }
        }else{
            if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
                $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px;color:black;">受付終了</p>';
                $html[] = '<input type="hidden" name="getPart[]" form="reserveParts">';
                        // ↑予約していない過去日
              }else{
          $html[] = $day->selectPart($day->everyDay());
              }
                        // ↑予約していない未来日

        }
        $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';

    return implode('', $html);
  }

  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while($tmpDay->lte($lastDay)){
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
