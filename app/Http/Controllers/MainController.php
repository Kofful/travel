<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public static function index() {
        $nights = rand(3, 8);
        $dispatch1 = date("Y-m-d", strtotime("+" . rand(5, 30) . " day", time()));
        $dispatch2 = date("Y-m-d", strtotime($dispatch1 . "+$nights days"));
        $date_to_check_reservations = date('Y-m-d', strtotime($dispatch2 . ' +1 days'));
        $hot_hotels = DB::select("SELECT * FROM (SELECT `rooms`.id, `rooms`.`hotel_id`, `room-types`.`type` AS room_type,
 `rooms`.places, (`rooms`.price * {$nights} + IFNULL(SUM(`transfers`.price), 0)) AS price, COUNT(`transfers`.`id`) as tickets,
  `hotels`.`hotel`, `hotels`.`description`,  `nutrition`.`name` AS nutrition, `states`.state, `countries`.`country`,
   `photos`.`path` FROM `rooms` JOIN `hotels` ON `hotels`.id = hotel_id JOIN `states` ON `states`.id = `hotels`.`state_id`
    JOIN `countries` ON `countries`.id = `states`.`country_id` JOIN `photos`
     ON `photos`.id = (SELECT id FROM `photos` WHERE `hotel_id` = `hotels`.id LIMIT 1) LEFT JOIN `transfers`
     ON (`transfers`.`state1_id` = 15 AND `transfers`.state2_id = `states`.id AND `transfers`.`dispatch` = '{$dispatch1}')
     OR (`transfers`.`state1_id` = `states`.id AND `transfers`.state2_id = 15 AND `transfers`.`dispatch` = '{$dispatch2}')
     LEFT JOIN `nutrition` ON `nutrition`.`id` = `hotels`.`nutrition_id` JOIN `room-types` ON `room-types`.`id` = `rooms`.`type_id`
     WHERE (`countries`.`id` = 12 OR `transfers`.`dispatch` = '{$dispatch1}' OR `transfers`.`dispatch` = '{$dispatch2}')
     AND (SELECT COUNT(*) FROM `reservations` WHERE `reservations`.`reserved` BETWEEN '{$dispatch1}' AND '{$date_to_check_reservations}' AND `reservations`.`room_id` = `rooms`.`id`) = 0
     AND is_hot = 1 GROUP BY id) AS temp GROUP BY hotel_id HAVING (tickets = 0 OR tickets = 2) ORDER BY RAND() LIMIT 4");
        $common_hotels = DB::select("SELECT * FROM (SELECT `rooms`.id, `rooms`.`hotel_id`, `room-types`.`type` AS room_type,
 `rooms`.places, (`rooms`.price * {$nights} + IFNULL(SUM(`transfers`.price), 0)) AS price, COUNT(`transfers`.`id`) as tickets,
  `hotels`.`hotel`, `hotels`.`description`,  `nutrition`.`name` AS nutrition, `states`.state, `countries`.`country`,
   `photos`.`path` FROM `rooms` JOIN `hotels` ON `hotels`.id = hotel_id JOIN `states` ON `states`.id = `hotels`.`state_id`
    JOIN `countries` ON `countries`.id = `states`.`country_id` JOIN `photos`
     ON `photos`.id = (SELECT id FROM `photos` WHERE `hotel_id` = `hotels`.id LIMIT 1) LEFT JOIN `transfers`
     ON (`transfers`.`state1_id` = 15 AND `transfers`.state2_id = `states`.id AND `transfers`.`dispatch` = '{$dispatch1}')
     OR (`transfers`.`state1_id` = `states`.id AND `transfers`.state2_id = 15 AND `transfers`.`dispatch` = '{$dispatch2}')
     LEFT JOIN `nutrition` ON `nutrition`.`id` = `hotels`.`nutrition_id` JOIN `room-types` ON `room-types`.`id` = `rooms`.`type_id`
     WHERE (`countries`.`id` = 12 OR `transfers`.`dispatch` = '{$dispatch1}' OR `transfers`.`dispatch` = '{$dispatch2}')
     AND (SELECT COUNT(*) FROM `reservations` WHERE `reservations`.`reserved` BETWEEN '{$dispatch1}' AND '{$date_to_check_reservations}' AND `reservations`.`room_id` = `rooms`.`id`) = 0
    GROUP BY id) AS temp GROUP BY hotel_id HAVING (tickets = 0 OR tickets = 2) ORDER BY RAND() LIMIT 4");
        $data = array_merge(compact('common_hotels'), compact('hot_hotels'), compact('nights'), compact('dispatch1'));
        return view('main', compact('data'));
    }
}
