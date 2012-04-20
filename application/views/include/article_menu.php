<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--<ul>
  <li class="show" id="cms_menu_1" onclick="show_cms_menu('1');"><span class="txt"><a>安  装</a></span></li>
</ul>
<ul id="cms_ul_1">
  <li class="show_a"><a href="/index.php/youyan_help/index/wp_install_online">在线安装</a></li>
  <li class="show_a"><a href="/index.php/youyan_help/index/wp_install_download">下载安装</a></li>
</ul>-->
<ul>
<li id="cms_menu_1" class="<?php echo ($class == 'youyan_help' && $method == 'index' && $name == '' ? 'show' : 'hide'); ?>" onclick="show_cms_menu('1');"><span class="txt"><a href="javascript:void(0);">常见问题</a></span></li></ul>
<ul id="cms_ul_1" style="<?php echo ($class == 'youyan_help' && $method == 'index' && $name == '' ? '' : 'display:none;'); ?>">
  <li class="show_a"><a href="/index.php/youyan_help" style="<?php echo ($class == 'youyan_help' && $method == 'index' && $name == '' ? 'color:#109db6;' : ''); ?>">FAQ</a></li>
</ul>
<ul>
  <li id="cms_menu_2" class="<?php echo ($class == 'youyan_help' && $method == 'index' && ($name == 'general' || $name == 'wp_install_online_help') ? 'show' : 'hide'); ?>" onclick="show_cms_menu('2');"><span class="txt"><a href="javascript:void(0);">安装</a></span></li>
</ul>
<ul id="cms_ul_2" style="<?php echo ($class == 'youyan_help' && $method == 'index' && ($name == 'general' || $name == 'wp_install_online_help') ? '' : 'display:none'); ?>">
  <li class="show_a"><a href="/index.php/youyan_help/index/general" style="<?php echo ($class == 'youyan_help' && $method == 'index' && $name == 'general' ? 'color:#109db6;' : ''); ?>">通用代码</a></li>
  <li class="show_a"><a href="/index.php/youyan_help/index/wp_install_online_help" style="<?php echo ($class == 'youyan_help' && $method == 'index' && $name == 'wp_install_online_help' ? 'color:#109db6;' : ''); ?>">WordPress</a></li>
</ul>
<ul>
  <li class="<?php echo ($class == 'youyan_help' && $method == 'index' && ($name == 'wp_setting_comment' || $name == 'wp_setting_sns' || $name == 'wp_setting_wordpress') ? 'show' : 'hide'); ?>" id="cms_menu_4" onclick="show_cms_menu('4');"><span class="txt"><a>设  置</a></span></li>
</ul>
<ul id="cms_ul_4" style="<?php echo ($class == 'youyan_help' && $method == 'index' && ($name == 'wp_setting_comment' || $name == 'wp_setting_sns' || $name == 'wp_setting_wordpress') ? '' : 'display:none'); ?>">
  <li class="show_a"><a href="/index.php/youyan_help/index/wp_setting_comment" style="<?php echo ($class == 'youyan_help' && $method == 'index' && $name == 'wp_setting_comment' ? 'color:#109db6;' : ''); ?>">评论框设置</a></li>
  <li class="show_a"><a href="/index.php/youyan_help/index/wp_setting_sns" style="<?php echo ($class == 'youyan_help' && $method == 'index' && $name == 'wp_setting_sns' ? 'color:#109db6;' : ''); ?>">绑定SNS</a></li>
  <li class="show_a"><a href="/index.php/youyan_help/index/wp_setting_wordpress" style="<?php echo ($class == 'youyan_help' && $method == 'index' && $name == 'wp_setting_wordpress' ? 'color:#109db6;' : ''); ?>">Wordpress设置</a></li>
</ul>
<ul>
  <li class="<?php echo ($class == 'youyan_help' && $method == 'index' && ($name == 'wp_manage_website' || $name == 'wp_manage_comment' || $name == 'wp_manage_statistics') ? 'show' : 'hide'); ?>" id="cms_menu_3" onclick="show_cms_menu('3');"><span class="txt"><a>管  理</a></span></li>
</ul>
<ul id="cms_ul_3" style="<?php echo ($class == 'youyan_help' && $method == 'index' && ($name == 'wp_manage_website' || $name == 'wp_manage_comment' || $name == 'wp_manage_statistics') ? '' : 'display:none'); ?>">
  <li class="show_a"><a href="/index.php/youyan_help/index/wp_manage_website" style="<?php echo ($class == 'youyan_help' && $method == 'index' && $name == 'wp_manage_website' ? 'color:#109db6;' : ''); ?>">网站管理</a></li>
  <li class="show_a"><a href="/index.php/youyan_help/index/wp_manage_comment" style="<?php echo ($class == 'youyan_help' && $method == 'index' && $name == 'wp_manage_comment' ? 'color:#109db6;' : ''); ?>">评论管理</a></li>
  <li class="show_a"><a href="/index.php/youyan_help/index/wp_manage_statistics" style="<?php echo ($class == 'youyan_help' && $method == 'index' && $name == 'wp_manage_statistics' ? 'color:#109db6;' : ''); ?>">统计与分析</a></li>
</ul>