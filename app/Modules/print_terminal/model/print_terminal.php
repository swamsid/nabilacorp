<?php

namespace App\Modules\print_terminal\model;

use Illuminate\Database\Eloquent\Model;

use Auth;
use Storage;

class print_terminal extends Model
{  
   public static function enqueue($m_username, $filename) {
      $print_queue = Storage::get('print_queue.txt');
      $print_queue = json_decode($print_queue);
      // Convert data
      $queues = [];
      foreach ($print_queue as $x => $unit) {
        $queues[$x] = [];
        if( count($unit) > 0 ) {
          foreach ($unit as $subunit) {
            array_push($queues[$x], $subunit);
          }
        }
      }
      $target = $queues[$username];
      if($target != null) {
        $queues = [];
        if( count($target) > 0 ) {
          foreach ($target as $unit) {
            array_push($queues, $unit);
          }
        }
        array_push($queues[$username], $filename);
        $rewrite_queues = json_encode($queues);
        Storage::put('print_queue.txt', $rewrite_$queues)

        return true;
      }
      else {
        return false;
      }
   }
}
	