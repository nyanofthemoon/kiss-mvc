<?php

class Paginator {

	private $page_max;
	private $link_max;

	private $linkformat = '<a href="#pageslink#">#pagenumber#</a></li>';
	private $onpageformat = '<strong>#pagenumber#</strong></li>';
	private $separator = " | ";
	private $firstlink = '&lsaquo;';
	private $prevlink = '&laquo;';
	private $nextlink = '&rsaquo;';
	private $lastlink = '&raquo;';

	public function __construct( $page_max = 5, $link_max = 25 )
	{
		$this->page_max = $page_max;
		$this->link_max = $link_max;
	}

	public function getPages($start, $total, $link = '', $ajax = false)
	{
	
		$pages = '';
		if ( $total > $this->page_max )
		{
		
		$pages = array();
		if ( $start == 0 )
		{
			$start = 1;
		}
		$numberofpages = ceil($total/$this->page_max);
		$onpagenumber = ceil(($start+1)/$this->page_max);
		if($numberofpages == 0) $numberofpages = 1;
		if($start > $total) $start = 1;

		$middlepagelink = ceil($this->link_max/2);

		$startpagelinks = $onpagenumber-$middlepagelink;
		$endpagelinks = $onpagenumber+$middlepagelink;
		if($startpagelinks < 1) $startpagelinks = 1;
		if($endpagelinks > $numberofpages) $endpagelinks = $numberofpages;

		if(($startpagelinks + $endpagelinks) < $this->link_max)
		{
			if($startpagelinks != 1) $startpagelinks = ($startpagelinks + $endpagelinks)-$this->link_max;
			elseif($endpagelinks != $numberofpages) $endpagelinks = ($endpagelinks-$startpagelinks)+$middlepagelink;

			if($startpagelinks < 1) $startpagelinks = 1;
			if($endpagelinks > $numberofpages) $endpagelinks = $numberofpages;
		}

		if($startpagelinks > 1)
		{
			$itemcount = 0;
			$new_page = str_replace('#pageslink#', ($link.$itemcount), str_replace('#pagenumber#', $this->firstlink, $this->linkformat));
			if ($ajax)
			{
				$new_page = str_replace( "=')".$itemcount, "=".$itemcount."')", $new_page );
			}
			$pages[] = $new_page;
		}
		if($onpagenumber > 1)
		{
			$itemcount = (($onpagenumber-2)*$this->page_max);
			$new_page = str_replace('#pageslink#', ($link.$itemcount), str_replace('#pagenumber#', $this->prevlink, $this->linkformat));
			if ($ajax)
			{
				$new_page = str_replace( "=')".$itemcount, "=".$itemcount."')", $new_page );
			}
			$pages[] = $new_page;
		}
		
		for($x = $startpagelinks; $x <= $endpagelinks; ++$x) {
			$itemcount = (($x-1)*$this->page_max);
			$pagelink = $link.$itemcount;
			if ($ajax)
			{
				$pagelink = str_replace( "=')".$itemcount, "=".$itemcount."')", $pagelink );
			}
			if($x == $onpagenumber)
			{
				$pages[] = str_replace('#pagenumber#', $x, $this->onpageformat);
			}
			else 
			{
				$pages[] = str_replace('#pageslink#', $pagelink, str_replace('#pagenumber#', $x, $this->linkformat));
			}
		}

		if($onpagenumber < $endpagelinks)
		{
			$itemcount = (($onpagenumber)*$this->page_max);
			$new_page = str_replace('#pageslink#', ($link.$itemcount), str_replace('#pagenumber#', $this->nextlink, $this->linkformat));
			if ($ajax)
			{
				$new_page = str_replace( "=')".$itemcount, "=".$itemcount."')", $new_page );	
			}
			$pages[] = $new_page;
		}
		if($endpagelinks < $numberofpages)
		{
			$itemcount = (($numberofpages-1)*$this->page_max);
			$new_page = str_replace('#pageslink#', ($link.$itemcount), str_replace('#pagenumber#', $this->lastlink, $this->linkformat));
			if ($ajax)
			{
				$new_page = str_replace( "=')".$itemcount, "=".$itemcount."')", $new_page );	
			}
			$pages[] = $new_page;
		}
		
		$pages = implode( $this->separator,$pages );
		}
		
		return ( $pages );
	}
	
}