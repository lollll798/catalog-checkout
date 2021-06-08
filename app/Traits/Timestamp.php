<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

trait Timestamp {

    public function formatDateTime($datetime, $col = 0, $datetype = 0)
    {
        if (empty($datetime)) {
            return null;
        }
        $reformatDatetime = $this->reformatDatetime($datetime);
        if ($col === 1) {
            return $this->getDateOnly($reformatDatetime, $datetype);
        }
        if ($col === 2) {
            return $this->getTimeOnly($reformatDatetime);
        }
        if ($col === 3) {
            return $this->getViewDatetime($reformatDatetime);
        }
        return $reformatDatetime;
    }

    private function getDateOnly($datetime, $datetype)
    {
        $format = $datetype == 0? 'Y-m-d' : 'd/m/Y';
        return Carbon::parse($datetime)->format($format);
    }

    private function getTimeOnly($datetime)
    {
        return Carbon::parse($datetime)->format('H:i:s');
    }

    private function getViewDatetime($datetime)
    {
        $date = $this->getDateOnly($datetime, 1);
        $time = $this->getTimeOnly($datetime);
        return $date.' '.$time;
    }

    private function reformatDatetime($datetime) {
        $detect = explode('T', $datetime);
        if (isset($detect[1])) {
            return $detect[0].' '.$detect[1];
        }
        return $datetime;
    }
}
