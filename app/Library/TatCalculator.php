<?php

namespace App\Library;

use App\Model\Holiday;
use DateTime;

class TatCalculator 
{
    public function calculateTat($hr,$request_date){
      
        $deadline = date('Y-m-d H:i:s',strtotime($request_date.' +'.$hr.' hours'));
        $day = date('D',strtotime($deadline));
        if($day=='Sat'){
           $deadline = date('Y-m-d H:i:s',strtotime($deadline.' +2 Days'));
        }elseif($day=='Sun'){
            $deadline = date('Y-m-d H:i:s',strtotime($deadline.' +1 Days'));
           
        }
        $final_deadline = $this->calculateHoliday($deadline);
        
        return $final_deadline;
    }

    public function calculateHoliday($deadline){
      $holidaysObj = Holiday::select('holiday_date')->get()->toArray();
      $array = array_column($holidaysObj, 'holiday_date');//converting multidim array to single dim array
      $date = date('Y-m-d',strtotime($deadline));
      if(in_array($date,$array)){
         $deadline = date('Y-m-d H:i:s',strtotime($deadline.' +1 Days')); //add 1 day to last date
         $deadline = $this->calculateHoliday($deadline); //check whether deadline has holiday or not recurrsively
         //echo $deadline.'<br>';
      }
      return $deadline;
    }

    public function rfiDeadline($pending_in,$pending_out,$tat){
       
       $pending_differnce_time = strtotime($pending_out)-strtotime($pending_in);
       
       $deadline = date('Y-m-d H:i:s',strtotime($tat.' +'.$pending_differnce_time.' seconds'));

       /*dd(strtotime($pending_in),strtotime($pending_out),$pending_in,$pending_out,$tat,$pending_differnce_time,$deadline);*/
      return $deadline;
    }
}
