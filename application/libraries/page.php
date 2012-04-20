<?php
/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-8-5下午11:04:16
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page
{
	/*
	 * 每页显示记录类
	 * @public integer
	 */
	public $pagesize             =  10;

	/*
	 * 页码偏移量
	 * @public integer
	 */
	public $pernum               =  10;

	/*
	 * 要传递的变量数组
	 * @public string
	 */
	public $varstr               =  '';

	/*
	 * 总页数
	 * @public integer
	 */
	public $tpage                =  0;

	/* 
	 * 记录组总数
	 * @public integer
	 */
	public $pers                 =  0;

	/*
	 * SQL server 分页支点
	 * @public integer
	 */
	public $sid                  = 0;

	/*
	 * 当前页码
	 * @public integer
	 */
	public $page                 = 0;

	/* 
	 * MySQL分页生成语句
	 * @public string
	 */
	public $limit                =  '';

	/*
	 * 取得传递变量精数组,并检测它是否为空
	 * @return v
	 */
	public function get(){
		$i = 0;
		foreach($_GET as $k => $v) {
			$i++;
			$str = ($i==1) ? '?' : '&';
			$this->varstr = ($k<>'page' && $k<>'pagesize') ? $this->varstr.$str.$k.'='.$v : $this->varstr;
		}

		$this->varstr = $this->varstr ? $this->varstr.'&' : '?';
		$this->page = isset($_GET['page']) ? $_GET['page'] : 1;
		// 用于 SQL server 分页记录读取值 //
		$this->sid = ($this->page - 1) * $this->pagesize;
		// 用于 MySQL 分页生成语句 //  
		$this->limit = ($this->page - 1) * $this->pagesize.','.$this->pagesize;
	}


	/*
	 * 统计页码数
	 */
	public function total($number){
		$this->tpage = ceil($number / $this->pagesize);
		$this->pers  = ceil($this->tpage / $this->pernum);
	}
	  

	/*
	 * 分类函数PP(parse page ),$page为当页数
	 * $number 为记录总数, $pagesize 为每页显示数目
	 * @return string
	 */
	public function getpage($number=0, $pagesize=0){
		
		$this->pagesize = $pagesize ? $pagesize : $this->pagesize;;
		$this->get();
		$this->total($number);
		if($number < $pagesize || $this->page > $this->tpage){
			return '';
		}
		
$astyle = <<<EOT
	<style>
	.pagerpro_container{overflow:hidden;margin:10px 0;width:100%;}
	.pagerpro_container .pagerpro{float:right;display:block;}
	.pagerpro_container .pagerpro_li{float:left;margin:0 2px 0 0;}
	.pagerpro_container .current{padding:0px 5px 0px;background:none repeat scroll 0 0 #3B5998;color:#FFFFFF;}
	.pagerpro_container a{padding:3px 5px 2px;}
	.pagerpro_container a:hover{background:none repeat scroll 0 0 #3B5998;color:#FFFFFF; text-decoration:none;}
	</style>
	<div class="pagerpro_container">
	<ul class="pagerpro">
EOT;
$zstyle = '</ul></div>';
		
		//总列数
		$total_columns = ceil($this->tpage/$this->pernum);
		//当前列
		$current_columns = $this->page ? ceil($this->page/$this->pernum) : 1;
		
		//$current_columns：当前列数
		//$this->page：当前页码
		//$this->tpage：总页数
		//$this->pernum：页码偏移量
		

		$text = $astyle;
		$text .= '<li style="float:left;padding-right:10px;">共有 '.$number.' 条记录</li>';
		
		
		$lastsetid = $current_columns > 1 ? ($current_columns-1)*$this->pernum : 1;
		$text .= '<li class="pagerpro_li"><a title=上一列 href="'.$this->varstr.'page='.$lastsetid.'">&lsaquo;&lsaquo;上'.$this->pernum.'页</a></li>';
		
		//当前列不在第一列的时候显示第一页
		if ($current_columns > 1){
			$pre = $this->page > 1 ? $this->page - 1 : 1;
			$text .= '<li class="pagerpro_li"><a href="'.$this->varstr.'page='.$pre.'" title="上一页">上一页</a></li>';
			
			
			$text .= '<li class="pagerpro_li"><a href="'.$this->varstr.'page=1" title="第1页">1</a></li>';
			$text .= '<li class="pagerpro_li">...</li>';
		}
		
		$i = ($current_columns - 1) * $this->pernum;
		
		if(($this->tpage - $i) < $this->pernum){
			if($this->tpage - $this->pernum > 0){
				$i = $this->tpage - $this->pernum;
			}
		}
		
		$pagenum = ($this->tpage > $this->pernum) ? $this->pernum : $this->tpage;
		for($j = $i; $j < ($i + $pagenum) && $j < $this->tpage; $j++) {
			$newpage = $j + 1;
			if ($this->page == $j + 1) {
				$text .= '<li class="current pagerpro_li">'.($j + 1).'</li> ';
			} else {
				$text .= '<li class="pagerpro_li"><a href="'.$this->varstr.'page='.$newpage.'" title="第'.$newpage.'页">'.($j + 1).'</a></li>';
			}
		}

		$next = $this->page < $this->tpage ? $this->page + 1 : $this->page;
		
		//如果当前列小于总列数，显示尾页
		if ($current_columns < $total_columns){
			$text .= '<li class="pagerpro_li">...</li>';
			$text .= '<li class="pagerpro_li"><a href="'.$this->varstr.'page='.$this->tpage.'" title="第'.$this->tpage.'页">'.$this->tpage.'</a></li>';
			if ($this->tpage > $this->pernum){
				$text .= '<li class="pagerpro_li"><a href="'.$this->varstr.'page='.$next.'" title="下一页">下一页</a></li>';
			}
		}
		
		$nextpre = $current_columns < $this->pers ? $current_columns*$this->pernum+1 : $this->tpage;
		$text .= '<li class="pagerpro_li"><a title=下一列 href="'.$this->varstr.'page='.$nextpre.'">下'.$this->pernum.'页&rsaquo;&rsaquo;</a></li>';

		$text = $text.$zstyle;
		return $text;
	}
}
?>