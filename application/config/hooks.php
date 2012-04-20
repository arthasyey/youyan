<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

/*
 挂勾点

以下是一组可用的挂钩点.
    * pre_system
      系统执行的早期调用.仅仅在benchmark 和 hooks 类 加载完毕的时候. 没有执行路由或者其它的过程.
    * pre_controller
      在调用你的任何控制器之前调用.此时所用的基础类,路由选择和安全性检查都已完成.
    * post_controller_constructor
      在你的控制器实例化之后,任何方法调用之前调用.
    * post_controller
      在你的控制器完全运行之后调用.
    * display_override
      覆盖_display()函数, 用来在系统执行末尾向web浏览器发送最终页面.这允许你用自己的方法来显示.注意，你需要通过 $this->CI =& get_instance() 引用 CI 超级对象，然后这样的最终数据可以通过调用 $this->CI->output->get_output() 来获得。
    * cache_override
      可以让你调用自己的函数来取代output类中的_display_cache() 函数.这可以让你使用自己的缓存显示方法
    * scaffolding_override
      可以让scaffolding(脚手架)的请求去触发你自己的脚本替代.
    * post_system
      在最终着色页面发送到浏览器之后,浏览器接收完最终数据的系统执行末尾调用

*/
//在控制器实例化之后,任何方法调用之前调用. system/application/helpers/hooks_helper.php 里的 pagecache方法
$hook['post_controller_constructor'][] = array(
    'class'    => '',
    'function' => 'pagecache',
    'filename' => 'hooks_helper.php',
    'filepath' => 'helpers',
    'params'   => ''
);

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */