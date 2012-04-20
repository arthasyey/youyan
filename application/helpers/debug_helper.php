<?php
/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-7-25下午06:38:30
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function show_debug($debug_query){
        if(OPEN_DEBUG) {
            print<<<EOF
            <style>
            .tclass, .tclass2 {
            text-align:left;width:900px;border:0;border-collapse:collapse;margin-bottom:5px;table-layout: fixed; word-wrap: break-word;background:#FFF;}
            .tclass table, .tclass2 table {width:100%;border:0;table-layout: fixed; word-wrap: break-word;}
            .tclass table td, .tclass2 table td {border-bottom:0;border-right:0;border-color: #ADADAD;}
            .tclass th, .tclass2 th {border:1px solid #000;background:#CCC;padding: 2px;font-family: Courier New, Arial;font-size: 11px;}
            .tclass td, .tclass2 td {border:1px solid #000;background:#FFFCCC;padding: 2px;font-family: Courier New, Arial;font-size: 11px;}
            .tclass2 th {background:#D5EAEA;}
            .tclass2 td {background:#FFFFFF;}
            .firsttr td {border-top:0;}
            .firsttd {border-left:none !important;}
            .bold {font-weight:bold;}
            </style>
            <div id="site_debug" style="display:;">
EOF;
            $class = 'tclass2';
            if(empty($debug_query)) {
            	$debug_query = array();
            } else {
	            ($class == 'tclass')?$class = 'tclass2':$class = 'tclass';
	            echo '<table class="'.$class.'">';
	            echo '<tr><th width="20">&nbsp;</th><td style="font-weight:bold;font-size:16px;">SQL：</td></tr>';
	            echo '</table>';
            }
            
            
            foreach ($debug_query as $dkey => $debug) {
                ($class == 'tclass')?$class = 'tclass2':$class = 'tclass';
                echo '<table cellspacing="0" class="'.$class.'"><tr><th rowspan="2" width="20">'.($dkey+1).'</th><td width="61">'.$debug['query_times'].'s</td><td class="bold">'.shtmlspecialchars($debug['sql']).'</td></tr>';

                if(!empty($debug['explain'])) {
                    echo '<tr><td>Explain</td><td><table cellspacing="0"><tr class="firsttr"><td width="5%" class="firsttd">id</td><td width="11%">select_type</td><td width="12%">table</td><td width="6%">type</td><td width="19%">possible_keys</td><td width="10%">key</td><td width="8%">key_len</td><td width="5%">ref</td><td width="5%">rows</td><td width="19%">Extra</td></tr><tr>';
                    foreach ($debug['explain'] as $ekey => $explain) {
                        ($ekey == 'id')?$tdclass = ' class="firsttd"':$tdclass='';
                        if(empty($explain)) $explain = '-';
                        echo '<td'.$tdclass.'>'.$explain.'</td>';
                    }
                    echo '</tr></table></td></tr>';
                }
                echo '</table>';
            }
        	
            $values = $_COOKIE;
            ($class == 'tclass')?$class = 'tclass2':$class = 'tclass';
            $i = 1;
            echo '<table class="'.$class.'">';
            foreach ($values as $ckey => $cookie) {
            	echo '<tr><th width="20">'.$i.'</th><td width="250">$_COOKIE[\''.$ckey.'\']</td><td>'.$cookie.'</td></tr>';
            	$i++;
            }
            echo '</table>';
            
            $files = get_included_files();
            ($class == 'tclass')?$class = 'tclass2':$class = 'tclass';
            echo '<table class="'.$class.'">';
            foreach ($files as $fkey => $file) {
            	echo '<tr><th width="20">'.($fkey+1).'</th><td>'.$file.'</td></tr>';
            }
            echo '</table>';
                
            	
            $values = $_SERVER;
            ($class == 'tclass')?$class = 'tclass2':$class = 'tclass';
            $i = 1;
            echo '<table class="'.$class.'">';
            foreach ($values as $ckey => $cookie) {
            	echo '<tr><th width="20">'.$i.'</th><td width="250">$_SERVER[\''.$ckey.'\']</td><td>'.$cookie.'</td></tr>';
            	$i++;
            }
            echo '</table>';
            echo '</div>';
        }
    }