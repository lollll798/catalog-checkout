<?php

namespace App\UseCases\API;

class GenerateCatalogPage
{
    public function execute($totalItemsCount, $totalPages, $selectedPage)
    {
        $pageItemCount = (int)$this->countPageItems($totalItemsCount, $totalPages);
        $endItemsCount = (int)$this->countEndItem($selectedPage, $pageItemCount, $totalItemsCount);
        $startItemsCount = (int)$this->countStartItem($endItemsCount, $pageItemCount, $selectedPage, $totalPages);
        $pageBar = $this->processPageBar($selectedPage, $totalPages);
        return compact('startItemsCount', 'endItemsCount', 'totalItemsCount', 'totalPages', 'selectedPage', 'pageBar');
    }

    private function countPageItems($totalItemsCount, $totalPages)
    {
        return ceil($totalItemsCount / $totalPages);
    }

    private function countStartItem($endItemsCount, $pageItemCount, $selectedPage, $totalPages)
    {
        if ($selectedPage == $totalPages) {
            return $pageItemCount * ($selectedPage - 1);
        }
        if ($endItemsCount - $pageItemCount == 0) {
            return 1;
        }
        return $endItemsCount - $pageItemCount + 1;
    }

    private function countEndItem($selectedPage, $pageItemCount, $totalItemsCount)
    {
        if ($selectedPage * $pageItemCount  <= $totalItemsCount) {
            return $selectedPage * $pageItemCount;
        }
        return $totalItemsCount;
    }

    private function processPageBar($selectedPage, $totalPages) {
        $maxShowBox = 10;
        $halfCeil = ceil($maxShowBox/2);
        $left = $maxShowBox-2;
        if ($totalPages <= $maxShowBox) {
            return $this->generatePageBarAll($totalPages);
        }

        if ($selectedPage < $maxShowBox && $selectedPage <= $halfCeil) {
            return $this->generatePageBarPrevious($totalPages, $left);
        }

        if ($selectedPage >= $halfCeil && $selectedPage <= ($totalPages - $halfCeil)) {
            return $this->generatePageBarBetween($selectedPage, $totalPages, $maxShowBox);
        }

        return $this->generatePageBarLast($totalPages, $maxShowBox);
    }

    private function generatePageBarAll($totalPages) {
        $showBar = ['1'];
        for($i=1; $i<$totalPages; $i++) {
            $showBar[count($showBar)] = strval($showBar[count($showBar) - 1] + 1);
        }
        return $showBar;
    }

    private function generatePageBarPrevious($totalPages, $left) {
        $showBar = ['1'];
        for($i=1; $i<$left; $i++) {
            $showBar[count($showBar)] = strval($showBar[count($showBar) - 1] + 1);
        }
        array_push($showBar, '...', strval($totalPages));
        return $showBar;
    }

    private function generatePageBarBetween($selectedPage, $totalPages, $maxShowBox) {
        $showBar = ['1','...'];
        $startValue = $selectedPage - 1;
        for($i=1; $i<=$maxShowBox - 4; $i++) {
            array_push($showBar, strval($startValue));
            $startValue++;
        }
        array_push($showBar, '...', strval($totalPages));
        return $showBar;
    }

    private function generatePageBarLast($totalPages, $maxShowBox) {
        $showBar = [strval($totalPages)];
        for($i=0; $i<$maxShowBox - 3; $i++) {
            array_unshift($showBar, strval($showBar[0]-1));
        }
        array_unshift($showBar, '1', '...');
        return $showBar;
    }
}
