<?php 
class Result
{
    static function returnPagination($pag, $count, $limit)
	{
		$end = $limit * $pag;
		$begin = $end - $limit;
		$numberPages = ceil($count/$limit);
		return array('begin' => $begin, 'count' => $count, 'numberPages' => $numberPages);
	}
}