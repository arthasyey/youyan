<?php
/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-9-25下午05:35:11
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category
{
	private $CI;
	private $TypeName;//显示分类横向菜单的容器，显示类型如：顶级菜单->二级菜单->三级菜单
	private $SplitSymbol;//分类之间的间隔符号，如"->"
	private $categoryArr;//生成树型结构所需要的2维数组
	private $icon;//生成树型结构所需修饰符号，可以换成图片
	private $ret;//生成树状选择下拉菜单的容器

	public function __construct($SplitSymbol = ' > ')
	{
		$this->CI =& get_instance();
		
		$this->TypeName = '';
		$this->SplitSymbol = $SplitSymbol;
		$this->categoryArr = array();
		$this->icon = array('│','├','└');
		$this->ret = '';
	}

	//所有分类
	public function getCategoryInfo(){
//		$query = $this->CI->db->query("SELECT cid,parentid,typename FROM ".tname('cms_category')." WHERE 1");
//		if($query){
//			return $query->result_array();
//		}
//		return array();
		return cache_read('cms_category');
	}

	//获取全部的一级分类
	public function getTopInfo(){
//		$query = $this->CI->db->query("SELECT cid,parentid,typename,sortrank FROM ".tname('cms_category')." WHERE parentid='0' ORDER BY sortrank");
//		if($query){
//			return $query->result_array();
//		}
//		return array();
		$category = cache_read('cms_category');
		$topcate = array();
		if($category){
			foreach ($category as $val){
				if($val['parentid'] == 0){
					$topcate[] = $val;
				}
			}
		}
		return $topcate;
	}

	//得到某个ID对应的菜单属性
	public function getMenuRow($CID){
		return GetRow("SELECT * FROM ".tname('cms_category')." WHERE cid='{$CID}'");
	}

	//获得某个分类中的所有子类目,管理员后台分类管理的时候AJAX调用
	public function getAllSunList($cid, $step = '　')
	{
		$query = $this->CI->db->query("SELECT * FROM ".tname('cms_category')." WHERE parentid='{$cid}' ORDER BY sortrank");
		if($query){
			foreach ($query->result_array() as $row){
				echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" id="category_tr_'.$row['cid'].'">';
				echo "<tr style='background:#FFFFCC;'>";
				echo "<td width='15%'>{$row['cid']}</td>";	
				echo "<td width='30%' style='text-align:left;'>{$step}├  <a href='".SITE_URL."/categorycp/edit/".$row['cid']."'>{$row['typename']}</a></td>";
				echo "<td width='35%'>";
				echo "<a href='".SITE_URL."/categorycp/add/".$row['cid']."'><U>添加子分类</U></a>";
				echo "| <a href='".SITE_URL."/categorycp/edit/".$row['cid']."'><U>修改该分类</U></a>";
				echo "| <a href='/categorycp/delete/{$row['cid']}' id='category_delete_{$row['cid']}' onclick='ajaxmenu(event, this.id);'><U>删除该分类</U></a></td>";
				echo "<td width='20%'><input name='sortrank{$row['cid']}' type='text' id='sortrank{$row['cid']}' value='{$row['sortrank']}' size='2' maxlength='4' style='text-align:center;' /></td>";
				echo "</tr></table>";
				$this->getAllSunList($row['cid'], $step.'　');
			}
		}
	}

	//获得某个分类菜单以及其上级菜单
	public function getMenu($CID,$type='nolink',$class = 'agrayx')
	{
		$meuninfo = $this->getMenuRow($CID);
		if(!$meuninfo) return FALSE;
		if($type == 'nolink'){
			$this->TypeName = $meuninfo['typename'];
		}else{
			$this->TypeName = "<a class='{$class}' href=/{$type}_cate_list.html?id={$meuninfo['cid']} target='_blank'>".$meuninfo['typename']."</a>";
		}
		if($meuninfo['parentid'] != 0) {
			$this->logicGetMenu($meuninfo['parentid'],$type,$class);
		}
		return $this->TypeName;
	}

	//获得某类目菜单的递归逻辑部分
	public function logicGetMenu($CID,$type,$class)
	{
		$suninfo = $this->getMenuRow($CID);
		if($type == 'nolink'){
			$this->TypeName = $suninfo['typename'].$this->SplitSymbol.$this->TypeName;
		}else{
			$this->TypeName = "<a class='{$class}' href=/{$type}_cate_list.html?id={$suninfo['cid']} target='_blank'>".$suninfo['typename']."</a>".$this->SplitSymbol.$this->TypeName;
		}
		if($suninfo['parentid'] != 0) {
			$this->logicGetMenu($suninfo['parentid'],$type,$class);
		} else {
			return 0;
		}
	}
	
	//根据CID获取顶级分类CID
	public function get_top_cid($cid){
		$sql = "SELECT parentid 
			FROM ".tname('cms_category')." 
			WHERE cid='".$cid."'";
		$parentid = GetOne($sql);
		if($parentid){
			return $this->get_top_cid($parentid);
		} else {
			return $cid;
		}
	}
	
	public function get_top_cate($cid){
		$sql = "SELECT parentid,action  
			FROM ".tname('cms_category')." 
			WHERE cid='".$cid."'";
		$category = GetRow($sql);
		if($category){
			if($category['parentid']){
				return $this->get_top_cate($category['parentid']);
			} else {
				return $category;
			}
		} else {
			return FALSE;
		}
	}

	//得到子级数组
	public function get_child($cid)
	{		
		$child = array();
		
		if(empty($this->categoryArr)){
			$this->categoryArr = cache_read('cms_category');
		}
		
		if($this->categoryArr){
			foreach($this->categoryArr as $key => $val){
				if($val['parentid'] == $cid) {
					$child[$key] = $val;
				}
			}
		}
		return $child;
	}

	/**
	* 得到树型结构
	* @param int CID：表示获得这个CID下的所有子级
	* @param string str：生成树型结构的基本代码，例如："<option value='\$cid' \$selected>\$spacer\$typename</option>"
	* @param int selectID：被选中的ID，在做树型下拉框的时候需要用到
	* @param string adds：修饰属性结构的字符串
	* @return string
	*/
	public function get_tree($CID, $str, $selectID = 0, $adds = '')
	{
		$number = 1;
		$child = $this->get_child($CID);
		if(is_array($child)){
			$total = count($child);
			foreach($child as $id=>$menuInfo){
				$j = $k = '';
				if($number == $total){
					$j .= $this->icon[2];
				} else {
					$j .= $this->icon[1];
					$k = $adds ? $this->icon[0] : '';
				}
				$spacer = $adds ? $adds.$j : '';
				$selected = $menuInfo['cid'] == $selectID ? "selected" : '';
				@extract($menuInfo);
				eval("\$nstr = \"$str\";");
				$this->ret .= $nstr;
				$this->get_tree($cid,$str,$selectID,$adds.$k.'&nbsp;');
				$number++;
			}
		}
		return $this->ret;
	}

	/*
	*得到树形下拉选择菜单
	*$selectID:选中的菜单项
	*$selectName：选择框的名字
	*$defaultAlt：默认没有分类时候的选项
	*$property：<sclect>里的其他属性
	*/
	public function categorySelect($selectID = 0, $selectName = 'parentid', $property = '', $defaultAlt = '无（作为一级分类）')
	{
		$this->categoryArr = $this->getCategoryInfo();//先给categoryArr赋值
		if(empty($property)) $property = "id='{$selectName}'";
		$content = '';
		if(is_array($this->categoryArr)) {
			$content = $this->get_tree(0, "<option value='\$cid' \$selected>\$spacer\$typename</option>", $selectID);
		}
		$content = "<select name='".$selectName."' ".$property."><option value='0'>".$defaultAlt."</option>".$content."</select>";
		return $content;
	}
	//删除CID类别及其所有子类别
	public function delTypeName($CID){
		$CID = intval($CID);
		if($CID <= 0) {
			return false;
		} else {
			$this->CI->db->query("DELETE FROM ".tname('cms_category')." WHERE cid='{$CID}'");
			$query = $this->CI->db->query("SELECT cid,parentid,typename,sortrank FROM ".tname('cms_category')." WHERE parentid='{$CID}' ORDER BY sortrank");
			if($query){
				foreach ($query->result_array() as $row){
					$this->delTypeName($row['cid']);
				}
			}
			return true;
		}
	}

	/**
	* 生成js数组
	* @param integer $parentid parentid
	* @param integer $depth 层次
	* @param integer $cateArray　返回js数组值
	*/
	public function getJSContent($parentid,$depth,&$cateArray)
	{
		$sql = "SELECT cid,parentid,typename FROM ".tname('cms_category')." WHERE parentid='".$parentid."' ORDER BY sortrank";
		if(GetOne($sql)){
			$query = $this->CI->db->query($sql);
			if($query){
				foreach ($query->result_array() as $row){
					$cateArray .= str_repeat("\t",$depth)."[".$depth.",\"".$row['typename']."\",\"".$row['cid']."\"],\n";
					$depth++;
					$this->getJSContent($row['cid'],$depth,$cateArray);
					$depth--;
				}
			}
		}
	}
	//更新JS文件
	public function updateJSfile($jsPath, $arrayName = 'CSK')
	{
		$js = "var ".$arrayName." = new Array(\n";
		$this->getJsContent(0,0,$cateArray);
		$js .= substr($cateArray,0,strlen($cateArray)-2);
		$js .= "\n);\n";
		if(file_put_contents($jsPath, $js)){
			return true;
		} else {
			return false;
		}
	}


	public function getJS_industry($parentid,$depth,&$industryArray)
	{
		$sql = "SELECT cid,parentid,typename FROM ".tname('cms_category')." WHERE parentid='".$parentid."' ORDER BY sortrank";
		if(GetOne($sql)){
			$query = $this->CI->db->query($sql);
			if($query){
				foreach ($query->result_array() as $row){
					$industryArray .= str_repeat("\t",$depth);
					if($row['parentid'] == 0){
						$industryArray .= "topCat = new TopCategory('".$row['cid']."', '".$row['typename']."')\n";
						$industryArray .= "topCatArr = topCatArr.concat(topCat)\n";
					} else {
						if($depth == 1){
							$industryArray .= "sCat = new Category(topCat, '".$row['cid']."', '".$row['typename']."')\n";
						} else {
							$industryArray .= "new LeafCat(sCat, '".$row['cid']."', '".$row['typename']."')\n";
						}
					}
					$depth++;
					$this->getJS_industry($row['cid'],$depth,$industryArray);
					$depth--;
				}
			}
		}
	}
	public function updateJS_industry($jsPath)
	{
		$js = "var topCatArr = new Array();\n";
		$js .= "var topCat;\n";
		$js .= "var sCat;\n";
		$this->getJS_industry(0,0,$industryArray);
		$js .= $industryArray;
		$js .= "\n";
		if(file_put_contents($jsPath, $js)){
			return true;
		} else {
			return false;
		}
	}
	public function getJavaMenu($parentid){
		$sql = "SELECT cid,parentid,typename FROM ".tname('cms_category')." WHERE parentid='".$parentid."' ORDER BY sortrank";
		if(GetOne($sql)){
			$query = $this->CI->db->query($sql);
			
			$did = "";
			$ndid = "";
			$i= 0;
			
			if($query){
				foreach ($query->result_array() as $row){
					$did .= ":".$row['cid'];
					$sql = "SELECT cid,parentid,typename FROM ".tname('cms_category')." WHERE parentid='".$row['cid']."' ORDER BY sortrank";
					$nquery = $this->CI->db->query($sql);
					if($nquery){
						foreach ($nquery->result_array() as $nrow){
							$ndid .= ":".$nrow['cid'];
						}
					}
					$i++;
				}
			}
			return $did.$ndid;
		} else {
			return "";
		}
	}
}