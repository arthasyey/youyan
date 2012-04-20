<script language="javascript" src="../../../js/global.js"></script>
<script language="javascript" src="../js/jquery.boxy.js"></script>
<script language="javascript" src="../js/youyan_admin_view.js"></script>
<script language="javascript" src="../js/youyan_homepage_view.js"></script>
<script language="javascript" src="../jquery.ui/jquery-1.4.2.min.js"></script>
<script language="javascript" src="../../../easyXDM/easyXDM.min.js"></script>
<script type="text/javascript">
SINA_ACCESS_TOKEN = '<?php echo $_SESSION['domain_data']['SINA_ACCESS_TOKEN'];?>';
SINA_ACCESS_SECRETE = '<?php echo $_SESSION['domain_data']['SINA_ACCESS_SECRETE'];?>'
SINA_APP_KEY = '<?php echo $_SESSION['domain_data']['SINA_APP_KEY'];?>';
SINA_APP_SECRETE = '<?php echo $_SESSION['domain_data']['SINA_APP_SECRETE'];?>';
domain = '<?php echo $_SESSION['domain_data']['domain'];?>';
OP_WIDTH = <?php echo $_SESSION['domain_data']['width'];?>;
OP_SELECTED_IDX = nCommentsToIdxMap[<?php echo $_SESSION['domain_data']['numCommentsPerPage'];?>];
OP_LIMIT = <?php echo $_SESSION['domain_data']['numLimit'];?>;
OP_STYLE = <?php echo $_SESSION['domain_data']['commentStyle'];?>;
OP_DIG = '<?php echo $_SESSION['domain_data']['digName'];?>';
OP_DIGDOWN = '<?php echo $_SESSION['domain_data']['digDownName'];?>';
OP_MAIL_NOTIFY = <?php echo $_SESSION['domain_data']['mailNotify'];?>;
OP_ACCOUNT_ORDER = '<?php echo $_SESSION['domain_data']['account_order'];?>';
OP_DEL_STYLE = <?php echo $_SESSION['domain_data']['delStyle'];?>;
OP_DESC_WORD = '<?php echo $_SESSION['domain_data']['descWord'];?>';
OP_DEFAULT_SORT = <?php echo $_SESSION['domain_data']['defaultSort'];?>;
OP_HAS_BINDED_SINA = (SINA_ACCESS_TOKEN != '');
OP_DEFAULT_PROFILE = '<?php echo $_SESSION['domain_data']['default_profile'];?>';
OP_DOMAIN_NAME = '<?php echo $_SESSION['domain_data']['domain_name'];?>';
OP_ANON_URL = '<?php echo $_SESSION['domain_data']['anon_url'];?>';
SNSTypeToName['EMAIL'] = '<?php echo $_SESSION['domain_data']['anon_word'];?>';
OP_STYLE_NUM = <?php echo $_SESSION['domain_data']['styleNum'];?>;
OP_BUTTON_STYLE = <?php echo $_SESSION['domain_data']['buttonStyle'];?>;
OP_AUTOBAR_STYLE = <?php echo $_SESSION['domain_data']['login_bar_auto_hide'];?>;
OP_REPLYPOSITION_STYLE = <?php echo $_SESSION['domain_data']['reply_position'];?>;
OP_REPLYNUM_STYLE = <?php echo $_SESSION['domain_data']['num_replys_per_thread'];?>;
OP_EMOTION_STYLE = <?php echo $_SESSION['domain_data']['use_emotions'];?>;
OP_COMMUNITY_STYLE = <?php echo $_SESSION['domain_data']['use_community'];?>;
OP_COMMENTHOTHEAD_STYLE = <?php echo $_SESSION['domain_data']['commentHotHead'];?>;
OP_COMMENTTIMEHEAD_STYLE = <?php echo $_SESSION['domain_data']['commentTimeHead'];?>;
OP_MESSAGESNS_STYLE = '<?php echo $_SESSION['domain_data']['message_sns'];?>';
OP_IMAGESTYLE_STYLE = <?php echo $_SESSION['domain_data']['image_style'];?>;
OP_VERYFYCHECK_STYLE = <?php echo $_SESSION['domain_data']['veryfyCheck'];?>;
OP_COMMENTTIMEWIDTH_STYLE = <?php echo $_SESSION['domain_data']['commentTimeWidth'];?>;
OP_COMMENTHOTWIDTH_STYLE = '<?php echo $_SESSION['domain_data']['commentHotWidth'];?>';
OP_ARTICLEHOTWIDTH_STYLE = <?php echo $_SESSION['domain_data']['articleHotWidth'];?>;
OP_ARTICLETIMEWIDTH_STYLE = <?php echo $_SESSION['domain_data']['articleTimeWidth'];?>;
OP_COMMENTHOTPERIOD_STYLE = <?php echo $_SESSION['domain_data']['commentHotPeriod'];?>;
OP_ARTICLEHOTPERIOD_STYLE = <?php echo $_SESSION['domain_data']['articleHotPeriod'];?>;
OP_PROFILEBAR_STYLE = <?php echo $_SESSION['domain_data']['profile_bar'];?>;
OP_SHOWSCOREITEM_STYLE = <?php echo $_SESSION['domain_data']['showScoreItem'];?>;
OP_FORCESTAR_STYLE = <?php echo $_SESSION['domain_data']['forceStar'];?>;
OP_SSO_NAME = '<?php echo $_SESSION['domain_data']['sso_name'];?>';

</script>
<?php 
$titleStr = $_SESSION['domain_data']['listTitle'];
$titleArr = explode('}_{',$titleStr);
$titleCommentHot = $titleArr[0];
$titleCommentTime = $titleArr[1];
$titleArticleHot = $titleArr[2];
$titleArticleTime = $titleArr[3];
?>

<link href="../css/global.css" rel="stylesheet" type="text/css" />
<link href="../css/boxy.css" rel="stylesheet" type="text/css" />
<link href="../css/admin.css" rel="stylesheet" type="text/css" />
<link href="../css/homepage.css" rel="stylesheet" type="text/css" />
<link href="../css/admin_edit.css" rel="stylesheet" type="text/css" />
<div class="contentWrapper">
    <!--menu-->
    <div class="categoryMenuTopWrapper">
        <div class="categoryMenuTopContainer">
        <div class="siteNameContainer" id="siteNameContainer"><?php echo $_SESSION['showDomain'];?> <?php if($verify==0){echo '<span class="verifyState">[请验证域名所属，在插入评论框代码后将自动验证]</span>';				
        }else if($verify==2){echo '<a class="verifyState" href="http://uyan.cc/index.php/youyan_check_domain">[点击此处验证域名所属]</a>';}?></div>
            <a class="menuTopButton menuTopCurrent" >安装与设置</a>
            <a class="menuTopButton" href="/index.php/youyan_admin_trace_user/index/">统计与分析</a>
            <a class="menuTopButton" href="/index.php/youyan_admin/index/">评论管理</a>
            <div class="clear"></div>
        </div>
    </div>

<div class="contentContainer">
<?php /*?><div class="backWrapper">

<a class="backEditBTN"  href="/index.php/youyan_admin/index/"><?php echo $_SESSION['showDomain'];?> 管理</a> > 修改代码
<div class="clear"></div>
</div><?php */?>
<div class="editNavigationContainer">
<!--<a class="naviBTN naviBTNCurrent" onClick="showNavi('install')" id="install">安装代码</a>-->
<a class="naviBTN naviBTNCurrent" onClick="showNavi('setting')" id="setting">风格设置</a>
<a class="naviBTN" onClick="showNavi('plugin')" id="plugin">功能组件</a>
<a class="naviBTN" onClick="showNavi('visual')" id="visual">CSS样式</a>
<a class="naviBTN" onClick="showNavi('spam')" id="spam">黑名单</a>
<a class="naviBTN" onClick="showNavi('data')" id="databak">数据备份</a>
<!--<a class="naviBTN" onClick="showNavi('example')" id="example">样例与反馈</a>-->
<div class="clear"></div>
</div>
<div id="visualEdit">
    <div class="navigationInstall" style="display:block;">
        <a class="installNavi installNaviSelected" onClick="changeCSSNav('box',this)">评论框样式</a><a class="installNavi" onClick="changeCSSNav('comment',this)">评论榜单样式</a><a class="installNavi" onClick="changeCSSNav('article',this)">文章榜单样式</a>
        <div class="clear"></div>
    </div>
    <div id="articleCSSWrapper">
        <div class="introCSSInput">输入CSS修改文章榜单样式</div>	
        <div class="visualInputWrapper">
            <div class="designPaneWindow">
                <div class="designPaneTop"></div>            
                <div id="showMid" class="designPaneMid">
                    <textarea name="createArticleCSS" id="createArticleCSS"   ><?php if(file_exists("user_css/article/".$_SESSION['showDomain'].".css")){ echo file_get_contents("user_css/article/".$_SESSION['showDomain'].".css");}?></textarea>
                </div>   
            </div>    
            <div class="rightStyleIntro">
                <div class="rightStyleTitle">CSS修改样例</div>
                <div class="rightStyleTitleIntro">复制到左侧框体内</div>
                <div class="rightStyleInTitle">隐藏标题栏文字</div>
                <div class="rightStyleCode">.UYHotlistTitle{display:none;}</div>	
                <div class="rightStyleSampelIntro">样例中为部分样式说明，也可以通过Firebug等插件直接读取评论框css,并将更改内容写至左侧。</div>
            </div>

            <div class="clear"></div>
        </div>
        <div class="externalIntro">
    要引用其它CSS样式可以书写为: @import url(http://CSS文件所在地址); </div>
        <?php if($verify==2){?>
        <a class="showCodeBTN" id="saveStyle" >保存样式</a>
        <span class="showCodeVerify">请在验证域名后保存 <a href="http://uyan.cc/index.php/youyan_check_domain">验证域名</a></span>
        <?php }else{ ?>
        <a class="showCodeBTN" onClick="createArticleCSS()" id="saveArticleStyle" >保存样式</a>
        <?php }?>
        <div class="clear"></div>
    </div>
    <div id="commentCSSWrapper">
        <div class="introCSSInput">输入CSS修改评论榜单样式</div>	
        <div class="visualInputWrapper">
            <div class="designPaneWindow">
                <div class="designPaneTop"></div>            
                <div id="showMidComment" class="designPaneMid">
                    <textarea name="createCommentCSS" id="createCommentCSS"><?php if(file_exists("user_css/comment/".$_SESSION['showDomain'].".css")){ echo file_get_contents("user_css/comment/".$_SESSION['showDomain'].".css");}?></textarea>
                </div>   
            </div>    
            <div class="rightStyleIntro">
                <div class="rightStyleTitle">CSS修改样例</div>
                <div class="rightStyleTitleIntro">复制到左侧框体内</div>
                <div class="rightStyleInTitle">隐藏标题栏文字</div>
                <div class="rightStyleCode">.UYHotlistTitle{display:none;}</div>
                <div class="rightStyleSampelIntro">样例中为部分样式说明，也可以通过Firebug等插件直接读取评论框css,并将更改内容写至左侧。</div>
            </div>

            <div class="clear"></div>
        </div>
        <div class="externalIntro">
    要引用其它CSS样式可以书写为: @import url(http://CSS文件所在地址); </div>
        <?php if($verify==2){?>
        <a class="showCodeBTN" id="saveStyle" >保存样式</a>
        <span class="showCodeVerify">请在验证域名后保存 <a href="http://uyan.cc/index.php/youyan_check_domain">验证域名</a></span>
        <?php }else{ ?>
        <a class="showCodeBTN" onClick="createCommentCSS()" id="saveCommentStyle" >保存样式</a>
        <?php }?>
        <div class="clear"></div>
    </div>

    <div id="boxCSSWrapper">
        <div class="introCSSInput">输入CSS修改评论框样式细节</div>	
        <div class="visualInputWrapper">
            <div class="designPaneWindow">
                <div class="designPaneTop"></div>            
                <div id="showMid" class="designPaneMid">
                    <textarea name="createCSS" id="createCSS"   ><?php if(file_exists("user_css/".$_SESSION['showDomain'].".css")){ echo file_get_contents("user_css/".$_SESSION['showDomain'].".css");}?></textarea>
                </div>   
            </div>    
            <div class="rightStyleIntro">
                <div class="rightStyleTitle">CSS修改样例</div>
                <div class="rightStyleTitleIntro">复制到左侧框体内</div>
                <div class="rightStyleInTitle">隐藏评论框标题(disqus样式)</div>
                <div class="rightStyleCode">.UYIntroducePane{display:none;}</div>
                <div class="rightStyleInTitle">隐藏评论框标题(facebook样式)</div>
                <div class="rightStyleCode">a.sortBTN{display:none;}</div>	
                <div class="rightStyleInTitle">隐藏喜欢人数</div>
                <div class="rightStyleCode">.recommendAmount{display:none;}</div>
                <div class="rightStyleInTitle">隐藏顶部登陆按钮</div>
                <div class="rightStyleCode">.UYrightLoginBTN{display:none;}</div>
                <div class="rightStyleInTitle">隐藏登录顶栏</div>
                <div class="rightStyleCode">.UYTitle{display:none;}</div>	
                <div class="rightStyleInTitle">隐藏登录按钮系列</div>
                <div class="rightStyleCode">.UYLoginSerious{display:none;}</div>
                <div class="rightStyleInTitle">隐藏顶踩按钮</div>
                <div class="rightStyleCode">.recommendWrapper{display:none;}</div>		
                <div class="rightStyleInTitle">隐藏评论排序方式(disqus样式)</div>
                <div class="rightStyleCode">.UYsortWrapper{display:none;}</div>
                <div class="rightStyleInTitle">隐藏当前页数与当前评论数(disqus样式)</div>
                <div class="rightStyleCode">.UYIntroCurrentPage{display:none;}</div>			
                <div class="rightStyleSampelIntro">样例中为部分样式说明，也可以通过Firebug等插件直接读取评论框css,并将更改内容写至左侧。</div>
            </div>

            <div class="clear"></div>
        </div>
        <div class="externalIntro">
    要引用其它CSS样式可以书写为: @import url(http://CSS文件所在地址); </div>
        <?php if($verify==2){?>
        <a class="showCodeBTN" id="saveStyle" >保存样式</a>
        <span class="showCodeVerify">请在验证域名后保存 <a href="http://uyan.cc/index.php/youyan_check_domain">验证域名</a></span>
        <?php }else{ ?>
        <a class="showCodeBTN" onClick="createCSS()" id="saveStyle" >保存样式</a>
        <?php }?>
        <div class="clear"></div>
    </div>
</div>
<div id="dataBakWrapper">
<div class="spamTitle">导入评论数据 <a class="showDataFormat" onclick="showXMLFormate()">查看XML格式</a></div>
<div class="bakupContainer">
<div class='formateShow'>导入的评论内容格式样例为:<br/>
<textarea  wrap="off" rows="5" class="contentContainerText">
<post>
<content>商家的产品很不错</content>
<page_title>UY测试页面</page_title>
<user_id>94</user_id>
<time>2011-08-29 19:57:01</time>
<from_type>EMAIL</from_type>
<page>uyan.cc_uyan.cc/demo.php</page>
<page_url>http://uyan.cc/demo.php</page_url>
<domain>uyan.cc</domain>
</post>
</textarea>

</div>
    <form id="youyan_upload_xml_form" action="youyan_upload_xml" target="upload_xml" enctype="multipart/form-data" name="uploadXMLForm" method="post">
        <input type="hidden" name="domain_upload_xml" id="domain_upload_xml" value="<?php echo $_SESSION['showDomain'];?>"/>	<?php if($verify!=2){?>
        <input type="file" name="xmlpath" id="xmlpath" onChange="document.uploadXMLForm.path.value=this.value;readyToUpload(this);"> 
        <?php }?>
        <input name="path" id="showpath" style="display:none;" readonly>
        <?php if($verify==2){?>
        <input type="button" value="导入XML格式数据" class="importDataBTN" ><span class="showCodeVerify">请在验证域名后导入 <a href="http://uyan.cc/index.php/youyan_check_domain">验证域名</a></span>
        <?php }else{?>
        <input type="button" value="导入XML格式数据" class="importDataBTN" onclick="document.uploadXMLForm.xmlpath.click()">
        <?php }?>
        <input type="submit" class="confirmImportXML" id="startXML" value="开始导入">
        <input type="button" class="confirmImportXML" id="processXML" value="导入中">
    </form>	
<iframe name="upload_xml" style="width: 300px; height: 140px; display:none;"></iframe>	


    <div class="clear"></div>

    <div class="bakupDataIntroImport">依据数据量，数据将在数分钟内导入完成，请稍候。</div>
</div>

<div class="spamTitle" style="border-top:none;">导出评论数据 </div>
<div class="bakupContainer">
<?php if($verify==2){?>
<div></div>
    <a class="exportDataBTN">下载XML格式数据</a>
    <span class="showCodeVerify">请在验证域名后下载 <a href="http://uyan.cc/index.php/youyan_check_domain">验证域名</a></span>
<?php }else{ ?>
<div></div>
    <a class="exportDataBTN" onClick="createBakXml()">下载XML格式数据</a>

<?php }?>

    <div class="clear"></div>
    <div class="bakupDataIntro">数据将在生成后发送到您的邮箱中，请注意查收。</div>
</div>

</div>
<div id="stepTwoWrapper">
        <div class="designPaneWrapper_edit">        
            <div class="designPaneEditRight">
                <div class="itemAdminEditWrapper" style="border-top:none;">
                    <div class="editFrameTitle">评论框样式</div>
                    <div class="selectStylePane">
                        <div class="selectStyleItem simpleStyle">
                            <div class="selectStyleAction">
                                <input type="radio" class="selectStyleRadio" name="selectStyleRadio" checked="checked" id="selectStyleRadio3" value="0" />
                                <div class="selectStyleRadioIntro">facebook风格</div>
                                <div class="clear"></div>
                             </div>
                        </div>
                        <div class="selectStyleItem standardStyle">
                            <div class="selectStyleAction">
                                <input type="radio" class="selectStyleRadio" name="selectStyleRadio" id="selectStyleRadio4" value="1" />
                                <div class="selectStyleRadioIntro">disqus风格</div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                
                <div class="itemAdminEditWrapper">
                    <div class="editFrameTitle">置顶登录按钮</div>
                    <div class="editFramContainer">
                    <input type="radio" name="topLoginBTNRadio" id="topLoginBTNUse" class="digRadio" value="1"  onchange="changeTopBTNState(1);"/>
                    <div class="introTextRadio digPositionChange">使用</div>
                    <input type="radio" name="topLoginBTNRadio" id="topLoginBTNUN" class="digRadio" value="0" onchange="changeTopBTNState(0);"  />
                    <div class="introTextRadio">不使用</div>
                    <div class="clear"></div>
                </div>
                </div>
                <div class="itemAdminEditWrapper" id="topBTNStyleContainer">
                    <div class="editFrameTitle">置顶登录按钮样式</div>
                    <div class="selectStylePane">
                        <div class="basicStyle">
                            <div class="selectLongAction">
                                <input type="radio" class="selectStyleRadio" name="selectBTNRadio" id="selectBTNRadio3" checked="checked" value="3" />
     
                                <div class="clear"></div>
                            </div>
                        </div>

                        <div class="shortStyle">
                            <div class="selectShortAction">
                                <input type="radio" class="selectStyleRadio" name="selectBTNRadio"  id="selectBTNRadio2" value="2" />
                                <div class="clear"></div>
                             </div>
                        </div>
                        <div class="longStyle">
                            <div class="selectLongAction">
                                <input type="radio" class="selectStyleRadio" name="selectBTNRadio" id="selectBTNRadio1" checked="checked" value="1" />

                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="itemAdminEditWrapper" id="topBTNRankContainer">
                    <div class="editFrameTitle">置顶登录排序(置顶的登陆方式，在功能区有额外的登录按钮)</div>
                    <div class="editTitleWordsWrapper">
                            <div class="loginPaneLeft">
                                <div class="connecntMenuTop">
                                    <a onClick="hideMenu(this, &quot;comment&quot;)" style="padding-left:0; text-align:center;width:126px; cursor:default;" class="closeMenu">未置顶</a>
                                    <div class="itemsListContainer">
                                        <div id="unselectItemsTopAdd"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="loginPaneRight">
                                <div class="connecntMenuTop">
                                    <a onClick="hideMenu(this, &quot;comment&quot;)" class="closeMenu" style="padding-left:0; text-align:center;width:166px; cursor:default;">当前置顶</a>
                                    <div class="itemsListContainer"> 
                                        <div id="selectedItemsTopAdd"></div>
                                    </div>
                                </div>
                            </div>  

                            <div class="clear"></div>
                        </div>
                </div>
                <div class="itemAdminEditWrapper">
                    <div class="editFrameTitle">打分系统</div>
                    <div class="selectStylePane">
                        <div class="starStyle">
                            <div class="selectStarAction">
                                <input type="radio" class="selectStyleRadio" name="selectStarBTNRadio" id="selectStarBTNRadio1" value="1"  onclick="if($('#selectStarBTNRadio1').attr('checked')==true){$('.selectForceAction').show();}else{$('.selectForceAction').hide();$('#selectForceVote').removeAttr('checked');}"/>
                                <div class="selectStyleRadioIntro">使用评分系统</div>
                                <div class="clear"></div>
                            </div>
                            <div class="selectForceAction">
                                <input type="checkbox" class="" name="selectStarForce" id="selectForceVote" value="1" />							
                                <div class="selectStyleRadioIntro">强制评分后发表评论</div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="shortStyle" style="background:none;margin-top:-10px;">
                            <div class="selectShortAction">
                                <input type="radio" class="selectStyleRadio" name="selectStarBTNRadio"  id="selectStarBTNRadio2" checked="checked" onclick="if($('#selectStarBTNRadio1').attr('checked')==true){$('.selectForceAction').show();}else{$('.selectForceAction').hide();$('#selectForceVote').removeAttr('checked');}" value="2" />
                                <div class="selectStyleRadioIntro">不使用</div>
                                <div class="clear"></div>
                             </div>
                        </div>

                        <div class="clear"></div>
                    </div>
                </div>			
                <div class="itemAdminEditWrapper">
                    <div class="editFrameTitle">菜单登录排序</div>
                    <div class="editTitleWordsWrapper">
                            <div class="loginPaneLeft">
                                <div class="connecntMenu">
                                    <a onClick="hideMenu(this, &quot;comment&quot;)" style="padding-left:0; text-align:center;width:126px; cursor:default;" class="closeMenu">未选择</a>
                                    <div class="itemsListContainer">
                                        <div id="unselectItemsAdd"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="loginPaneRight">
                                <div class="connecntMenu">
                                    <a onClick="hideMenu(this, &quot;comment&quot;)" class="closeMenu"  style="padding-left:0; text-align:center;width:166px; cursor:default;">当前类别</a>
                                    <div class="itemsListContainer"> 
                                        <div id="selectedItemsAdd"></div>
                                    </div>
                                </div>

                            </div>  
                            <div class="clear"></div>
                        </div>
                </div>



                <div class="itemAdminEditWrapper" style="border-bottom:none;">
                    <div class="editFrameTitle">设置默认头像</div>
                    <div id="inserImagePane">
                        <div id="inserImageTitle" class="dialogTitleWrapper"><span class="dialogTitleInner">上传头像</span><a class="close closediag" href="#"></a></div>
                        <div class="uploadImageWrapper">
                        <img src="<?php echo $_SESSION['domain_data']['default_profile'];?>" class="uploadLoadImage" width="50px" height="50px"/>
                        <div class="inserImageWrapper">
                            <div class="uploadImageWrapDone">
                                <form id="uploadImageAction" method="POST" enctype="multipart/form-data" target="upload_iframe" action="youyan_upload_image">
                                <input type="hidden" name="domain_upload" id="domain_upload" value="<?php echo $_SESSION['showDomain'];?>"/>
                                <input type="hidden" name="fileframe" value="true" />
                                <input type="file" id="uploadImage" class="uploadImage" name="uploadImage" onchange="submitImage(this);" />     
                                <input type="submit" id="upload_button" value="save file" disabled style="display:none;"/>
                                </form>
                                <iframe name="upload_iframe" style="width: 300px; height: 140px; display:none;"></iframe>
                            <div id="upload_status">支持格式 JPG/PNG/GIP/BMP</div>
                            <div class="upload_intro">请修正大小为50px*50px以保证清晰</div>
                        </div>
                        </div>
                        </div>
                    </div>
                </div>    
                                <div class="itemAdminEditWrapper">
                    <div class="editFrameTitle">表情功能</div>
                    <div class="editFramContainer">
                    <input type="radio" name="emotionRadio" id="showEmotion" class="digRadio" value="1"  checked />
                    <div class="introTextRadio digPositionChange">使用</div>
                    <input type="radio" name="emotionRadio" id="hideEmotion" class="digRadio" value="0"  />
                    <div class="introTextRadio">不使用</div>
                    <div class="clear"></div>
                </div>
                </div>
                <div class="itemAdminEditWrapper">
                    <div class="editFrameTitle">社区功能</div>
                    <div class="editFramContainer">
                    <input type="radio" name="comunityRadio" id="showComunity" class="digRadio" value="1"  checked />
                    <div class="introTextRadio digPositionChange">使用</div>
                    <input type="radio" name="comunityRadio" id="hideComunity" class="digRadio" value="0"  />
                    <div class="introTextRadio">不使用</div>
                    <div class="clear"></div>
                </div>
                </div>
                <div class="itemAdminEditWrapper">
                    <div class="editFrameTitle">用户登录后显示个人信息</div>
                    <div class="editFramContainer">
                    <input type="radio" name="profileRadio" id="showProfile" class="digRadio" value="1"  checked />
                    <div class="introTextRadio digPositionChange">显示</div>
                    <input type="radio" name="profileRadio" id="hideProfile" class="digRadio" value="0"  />
                    <div class="introTextRadio">不显示</div>
                    <div class="clear"></div>
                </div>
                </div> 
				<div class="itemAdminEditWrapper" >
                    <div class="editFrameTitle">新评论邮件提醒</div>
                    <div class="editCheckEmailWrapper">
                        <input type="checkbox" name="checkAlertEmail" id="checkAlertEmail" onClick="if($('#checkAlertEmail').attr('checked')==true){moreEmail('more');}else{moreEmail('less');}"  />
                        <div class="checkEmailIntro">当网站有新评论时邮件提醒我</div>
                        <div class="clear"></div>
                    </div>
                </div>           
            </div>
            <div class="designPaneEditLeft">
                <div class="itemAdminEditWrapper" style="border-top:none;">
                    <div class="editFrameTitle">网站名</div>
                    <div class="editFramContainer">
                        <input type="text" name="domain_name" id="domain_name" />
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="itemAdminEditWrapper">
                    <div class="editFrameTitle">评论框标题文字</div>
                    <div class="editFramContainer">
                            <input type="text" name="titleWords" id="titleWords" value="" />
                            <div class="clear"></div>
                        </div>
                </div>
                <div class="itemAdminEditWrapper">
                    <div class="editFrameTitle">框体宽度</div>
                    <div class="editFramContainer"><input type="radio" name="widthRadio" id="widthRadio" value="0" onClick="$('#pixelWidth').css({'display':'none'});$('.introText').css({'display':'none'});" checked /><div class="introTextRadio">自适应</div><input type="radio" name="widthRadio" id="diyWidth" value="1" onClick="$('#pixelWidth').css({'display':'block'});$('.introText').css({'display':'block'});" /><div class="introTextRadio">定义宽度</div><input type="text" name="pixelWidth" id="pixelWidth" /><div class="introText">像素</div><div class="clear"></div></div>
                </div>
                <div class="itemAdminEditWrapper">
                    <div class="editFrameTitle">每页显示评论条数</div>
                    <select id="selectItemAmount" name="selectItemAmount" onchange= "changeItemAmount(this);">
                            <option value="1">1条</option>
                            <option value="3">3条</option>
                            <option value="5">5条</option>
                            <option selected="selected" value="10">10条</option>
                            <option value="20">20条</option>
                            <option value="50">50条</option>
                        </select>
                </div>
                <div class="itemAdminEditWrapper">
                    <div class="editFrameTitle">每条评论显示回复条数</div>
                    <select id="selectReplyItemAmount" name="selectReplyItemAmount" onchange= "changeItemAmount(this);">
                            <option value="1">1条</option>
                            <option selected="selected" value="3">3条</option>
                            <option value="5">5条</option>
                            <option value="10">10条</option>
                            <option value="20">20条</option>
                            <option value="50">50条</option>
                        </select>
                </div>
                <div class="itemAdminEditWrapper">
                    <div class="editFrameTitle">评论默认排序方式</div>
                    <div class="editFramContainer">
                    <input type="radio" name="sortRadio" id="alldel" class="digRadio" value="0"  checked />
                    <div class="introTextRadio digPositionChange">按时间</div>
                    <input type="radio" name="sortRadio" id="disdel" class="digRadio" value="1"  />
                    <div class="introTextRadio">按热度</div>
                    <div class="clear"></div>
                </div>
                </div>
                <div class="itemAdminEditWrapper">
                    <div class="editFrameTitle">字数上限</div>
                    <div class="editFramContainer">
                        <input type="radio" name="limitRadio" id="limitRadio" value="0" onClick="$('#limitNumber').css({'display':'none'});$('.limitIntroText').css({'display':'none'});"  />
                        <div class="introTextRadio">无上限</div>
                        <input type="radio" name="limitRadio" id="diyLimit" value="1" onClick="$('#limitNumber').css({'display':'block'});$('.limitIntroText').css({'display':'block'});" checked />
                        <div class="introTextRadio">自定义上限</div>
                        <input type="text" name="limitNumber" value="280" id="limitNumber" />
                        <div class="limitIntroText">字</div><div class="clear"></div>
                    </div>
                </div>
          <script language="javascript" type="text/javascript">
          $("#widthRadio").attr("checked","checked");
$("#limitRadio").attr("checked","checked");
</script>
                <div class="itemAdminEditWrapper">
                    <div class="editFrameTitle">按时间排序方式</div>
                    <div class="editFramContainer">
                    <input type="radio" name="replyPositionRadio" id="showPositionReplyTop" class="digRadio" value="0"  checked />
                    <div class="introTextRadio digPositionChange">新评论至于顶部</div>
                    <input type="radio" name="replyPositionRadio" id="showPositionReplyBottom" class="digRadio" value="1"  />
                    <div class="introTextRadio">旧评论置于顶部</div>
                    <div class="clear"></div>
                </div>
                </div>
                <div class="itemAdminEditWrapper">
                    <div class="editFrameTitle">推荐模式</div>
                    <div class="editDigContainer">
                        <input type="radio" name="digRadio" id="onlyDig" class="digRadio" value="0"  checked />
                        <div class="introTextRadio digPositionChange">只可"<span class="upAl">顶</span>"</div>
                        <input type="radio" name="digRadio" id="bothDig" class="digRadio" value="1"  />
                        <div class="introTextRadio">允许"<span class="upAl">顶</span>"与"<span class="downAl">踩</span>"</div>
                        <div class="clear"></div>
                    </div>
                    <div class="editDigContentWrapper">
                        <div class="editDigLeft">关键词</div>
                        <input type="text" name="digName" id="digName" class="digName" onBlur="changeDigState();" value="顶" />
                        <div class="editDigLeft" id="digConnect">与</div>
                        <input type="text" name="digDownName" id="digDownName" onBlur="changeDigState();" class="digName" value="踩" />
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="itemAdminEditWrapper">
                    <div class="editFrameTitle">评论删除模式</div>
                    <div class="editFramContainer">
                        <input type="radio" name="delRadio" id="alldel" class="digRadio" value="0"  checked />
                        <div class="introTextRadio digPositionChange">被删除的评论及其回复均不显示</div><div class="clear"></div>
                        <input type="radio" name="delRadio" id="disdel" class="digRadio" value="1"  />
                        <div class="introTextRadio">被删除的评论文字替换为"已被删除"</div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="itemAdminEditWrapper">
                    <div class="editFrameTitle">匿名用户默认链接</div>
                    <div class="editFramContainer">
                        <input type="text" name="anon_url" id="anon_url" value="http://uyan.cc" />
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="itemAdminEditWrapper">
                    <div class="editFrameTitle">登录后隐藏置顶登录按钮</div>
                    <div class="editFramContainer">
                    <input type="radio" name="topLoginRadio" id="showTopLoginBTN" class="digRadio" value="1"  checked />
                    <div class="introTextRadio digPositionChange">显示</div>
                    <input type="radio" name="topLoginRadio" id="hideTopLoginBTN" class="digRadio" value="0"  />
                    <div class="introTextRadio">隐藏</div>
                    <div class="clear"></div>
                </div>
                </div>
                <div class="itemAdminEditWrapper">
                    <div class="editFrameTitle">评论需要审阅后呈现</div>
                    <div class="editFramContainer">
                    <input type="radio" name="checkCommentRadio" id="showCommentBTN" class="digRadio" value="0"  checked />
                    <div class="introTextRadio digPositionChange">直接呈现</div>
                    <input type="radio" name="checkCommentRadio" id="checkCommentBTN" class="digRadio" value="1"  />
                    <div class="introTextRadio">需要审阅</div>
                    <div class="clear"></div>
                </div>
                </div>				 
                
                <div class="itemAdminEditWrapper" style="border-bottom:none;">
                    <div class="editFrameTitle">用户评论转发样式</div>
                    <div class="editFramContainer">
                        <textarea type="text" name="sns_message" id="sns_message" ></textarea>
                        <div class="editFrameIntroPane">
                            {user_comment}：用户发表的评论内容<br/>{page_title}：当前页面的标题<br/>{website_info}：网站名及网址<br/>{short_link}：当前文章的链接地址
                        </div>
                        <div class="editDigContainer" style="padding-top:10px">
                            <input type="radio" name="snsWithPhoto" id="snsWithPhoto" class="digRadio" value="1"  checked />
                            <div class="introTextRadio digPositionChange">转发图片</div>
                            <input type="radio" name="snsWithPhoto" id="snsWithOutPhoto" class="digRadio" value="0"  />
                            <div class="introTextRadio">不转发图片</div>
                            <div class="clear"></div>
                        </div>						

                        <div class="clear"></div>
                    </div>
                </div>

                    <div class="clear"></div>   
                </div>
            <div class="clear"></div>
        </div>

        <div class="submitSettingWrapper">
            <?php if($verify==2){?>
            <a class="submitAllSettingEdit showCodeBTN" id="allSav" >保存设置</a>
            <span class="showCodeVerify">请在验证域名后保存 <a href="http://uyan.cc/index.php/youyan_check_domain">验证域名</a></span>
            <?php }else{ ?>
            <a class="submitAllSettingEdit showCodeBTN" id="allSav" onClick="changeSettingBTNstate(this,'allSav');generateCodeShow();">保存设置</a>
            <?php }?>
            <div class="clear"></div>
        </div>
</div>
<div id="installWrapper">
    <div class="navigationInstall" style="display:block;">
        <a class="installNavi installNaviSelected" onClick="changeInstallNav('plugin',this)">Wordpress插件</a><a class="installNavi" onClick="changeInstallNav('general',this)">通用代码</a>
        <span class="installNavIntro">(通用代码适用于任何网站)</span>
        <div class="clear"></div>
    </div>
    <div id="generalInstallWrapper">
        <h3 class="introductionTitle"><div class='itemTitleNum'>1</div><div class='itemTitleLine'>将如下代码插入到网站中需要评论框的位置中</div><div class='clear'></div></h3>
        <div id="showCodePane">
            <div class="codePaneWindow">            
                <div class="designPaneTop"></div>
                <div class="designPaneMid">
                <textarea class="getCodePane" onClick="select()" id="text0" wrap="off" rows="5"><!-- UY BEGIN -->
<div id="uyan_frame"></div>
<script type="text/javascript" id="UYScript" src="http://uyan.cc/js/iframe.js?UYUserId=<?php echo $_SESSION['uid']?>" async=""></script>
<!-- UY END --></textarea>
                <div class="designPaneCodeArrow"></div>
            </div>
            </div>
        </div>

        <div class="introductionCode">
            <div class="introductionTitle relevantTitle"><div class='itemTitleNum'>2</div><div class='itemTitleLine'>设置判断独立页面的参数（可选）</div><div class='clear'></div></div>
            <div class="introductionContent">程序默认将每个URL识别为独立的评论页面，如果您遇到错误的识别, 希望多个页面使用同一个评论框, 或者页面为模板动态生成，请在javascript中赋予全局变量UYId页面辨别参数。UYId可以为动态生成的值。例如: UYId = &lt;?php echo $_GET[’page’];?&gt;;</div>      
            <code class="introCodeWrapper">
                <div class="lineF">&lt;meta name="UYId" content="评论框标识ID" /&gt;</div>
            </code>

            <div class="introductionHelp">如在使用过程中出现任何问题，欢迎随时发邮件给我们help@uyan.cc 或QQ：1735067958</div>
            <div class="clear"></div>
        </div>
    </div>

    <div id="wordpressInstallWrapper">
        <div id="pluginPane">         
           <div class="pluginRightPane">
               <div id="wordpressPlugin">
                   <h2>WordPress插件安装步骤</h2>                    
                   <h3><div class='itemTitleNum'>1</div><div class='itemTitleLine'>获取友言插件并安装</div><div class='clear'></div></h3>
                   <p>如果您正在使用WordPress 2.7及以上版本，请登录WordPress管理系统后，在左侧菜单选择"<strong>插件</strong>">"<strong>安装插件</strong>"，搜索"<strong>youyan</strong>"找到插件选择安装。<br/><br/>如果无法正常安装或者WordPress版本较老，请点击<a href="http://wordpress.org/extend/plugins/youyan-social-comment-system/" target="_blank" class="pluginDowload">下载插件</a>，并在你的WordPress插件文件夹中解压。<br/><br/>
        <span class="contentIntro">WordPress的默认插件文件夹在/path/to/wordpress/wp-content/plugins/</span><br/>
        <span class="contentIntro">你应当将全部文件放置在/path/to/wordpress/wp-content/plugins<strong>/youyan-social-comment-system/</strong>(文件夹名不能更改)</span><br/>
                   </p>
                   <h3><div class='itemTitleNum'>2</div><div class='itemTitleLine'>激活友言插件</div><div class='clear'></div></h3>
                   <p>安装成功后，请在"<strong>插件</strong>"中启用它之后在WordPress控制面板的左侧的评论里选择“友言评论系统“。登录您在友言的帐号，并在设置代码中点击"保存设置"后即可正常使用社交评论系统。
                   </p>
                   <h2>完全社交化设置步骤</h2> 
                   <div class="introTotalSNS">
                   <div class="introTotalSNSTitle">完成设置后，网站会获得三种社交特性：</div>
<div class="introTotalSNSLine">1.博客文章自动同步至您的官方微博。</div>
<div class="introTotalSNSLine">2.网友在官方微博的评论自动同步至您的网站。</div>
<div class="introTotalSNSLine">3.网站的评论者将转发文章到评论者的微博。</div>

                   </div>
                   <h3><div class='itemTitleNum'>1</div><div class='itemTitleLine'>获得新浪微博APPKEY</div><div class='clear'></div></h3>
                   <p>登录您的官方微博帐号后，打开<a href="http://open.weibo.com/website.php" target="_blank" class="pluginDowload">新浪微博开放平台</a>，在右侧点击申请Appkey按钮，填写网站基本信息表格后，在”<strong>我的应用</strong>“中获得网站对应的App key与App secret。</p>                   
                   <h3><div class='itemTitleNum'>2</div><div class='itemTitleLine'>设置友言绑定</div><div class='clear'></div></h3>
                  <p> 在Wordpress的友言设置界面中找到”<strong>绑定SNS</strong>”标签栏，打开后输入Appkey与Secretkey，选择保存Appkey。再点击”绑定新浪微博”按钮，绑定至刚申请App key的官方帐号。（注意一定要按照先输入Appdkey与Secretkey再绑定的顺序来操作）</p> 
                  <p>至此您应当可以流畅的使用友言评论系统了，如果要绑定腾讯微博，操作有绑定新浪微博步骤一致，祝您使用愉快。<br /><br />如在使用过程中出现任何问题，欢迎随时发邮件给我们help@uyan.cc</p>

               </div>
           </div>
           <div class="clear"></div>
        </div>   
    </div>
</div>
<div id="installPlugin">
    <div class="navigationInstall">
        <a class="breadHomeItem" onclick="changeInstallPluginNav('all',this)">全部功能组件</a><span class="breadArrow"> > </span>
        <span id="currentBreadItem"></span>
        <div class="clear"></div>
    </div>
    <div id="prePaneForDom">
        <a class="itemCard commentHotItem" alt="全站评论热榜" onClick="changeInstallPluginNav('hot',this)"></a>
        <a class="itemCard commentTimeItem" alt="全站最新评论" onClick="changeInstallPluginNav('new',this)"></a>
        <a class="itemCard articleHotItem" alt="全站文章热榜" onClick="changeInstallPluginNav('hotArticle',this)"></a>
        <a class="itemCard articleTimeItem" alt="全站最新文章" onClick="changeInstallPluginNav('newArticle',this)"></a>
        <a class="itemCard commentAmountItem" alt="评论记数" onClick="changeInstallPluginNav('amount',this)"></a>
		<a class="itemCard SSOItem" alt="评论记数" onClick="changeInstallPluginNav('sso',this)"></a>
        <div class="clear"></div>
    </div>
    <div id="amountCommentWrapper">
        <div class="introCommentAmount">如果您需要将评论的数量显示在您的文章列表或其它任何需要的地方，请按照如下步骤安装评论数记数组件。</div>
        <h3 class="introductionAmountTitle">A.添加获取评论量Javascript代码</h3>
        <div class="introCommentAmount">请将下方框体内的js代码嵌入至网站代码的最后，理想的位置是在页面的结尾标签&lt;/body&gt;之前。</div>
        <div id="showCodePane">        
            <div class="codePaneWindow">            
                <div class="designPaneTop"></div>
                <div class="designPaneMid">
                <textarea rows="5" wrap="off" id="text0" onclick="select()" class="getCodePaneAmount">&lt;!-- UY BEGIN --&gt;
&lt;script language="javascript" src="http://uyan.cc/jquery.ui/jquery-1.4.2.min.js"&gt;&lt;/script&gt; 
&lt;script language="javascript" charset="utf-8" src="http://uyan.cc/js/countFrame.js" defer&gt;
&lt;/script&gt;
&lt;!-- UY END --&gt;</textarea>
                <div class="designPaneCodeArrow"></div>
            </div>
            </div>
        </div>
        <h3 class="introductionAmountTitle">B.修改需显示评论量的标签</h3>
        <div class="introCommentAmount">使用评论数量标签，您需要添加一个包含文章页面链接的&lt;a&gt;标签，并拥有一个友言标识字段uyan_identify，友言系统会自动将其修正为文章的评论数量。<br/>
请注意wordpress的页面，该url应该为wordpress的短链接形式，即 http://www.abc.com/?p=123 样式。<br/>
添加的标签如下</div>
        <code class="introCodeWrapper">
                &lt;a href="http://uyan.cc/test.html" uyan_identify="true" &gt;0条评论&lt;/a&gt;
        </code>	
    </div>
	<div id="ssoInstallWrapper">
		
		<div class="introductionTitle" style="padding-top:10px; margin-bottom:0; padding-bottom:2px;">通过单点登录功能，您的用户可以使用您的网站帐号系统登录友言评论。</div>
<!--		<div class="notiIntroSSO">如果您的网站并没有独立的帐号系统，您将不需要使用单点登录功能。</div>-->
		<div class="ssoIntroTitle"><strong>为实现单点登录功能，您将需要：</strong><br/>
		<span>A.在友言评论框前插入一段js代码<br/></span>
		<span>B.在您的网站登录页面中插入一段js代码<br/></span>
		<span>C.加入登录后的处理逻辑代码<br/></span>
		</div>
		<div class="introductionTitle" style="padding-top:20px;">A.在友言评论框前插入一段js代码</div>  
		<div class="introSSOCode">
		请在添加的友言评论框js代码前加入如下代码，以使友言评论系统中出现您的网站系统的登录按钮。<br/>
		<strong>代码中的变量请根据自己网站的情况修改(所有变量需要用双引号包含):</strong><br/>
		name:"填写自己网站名";<br/>
		button:"登录使用的长款按钮图片地址";<br/>
		icon:"登录使用的短款按钮图片地址";<br/>
		url:"您网站的登录页面地址";<br/>
		logout:"您网站的退出地址";<br/>
		width:"弹出登录窗口宽度";<br/>
		height:"弹出登录窗口高度";	<br/>		
		</div>  
		<div class="codePaneWindow">            
                <div class="designPaneTop"></div>
                <div class="designPaneMid">
                <textarea rows="5" wrap="off" id="text0" onclick="select()" class="getCodePaneAmount">
&lt;script language="javascript" &gt;
var youyan_config = {
    sso : {
          name:   "youyan",
          button:  "http://uyan.cc/images/doubanBind.png",
          icon:     "http://example.com/favicon.png",
          url:        "http://uyan.cc",
          logout:  "http://uyan.cc/",
          width:   "800",
          height:  "400"
    }
};
&lt;/script&gt;
</textarea>
                <div class="designPaneCodeArrow"></div>
            </div>
        </div>
		<div class="introductionTitle" style="padding-top:25px;">B.在您的网站登录页面中插入一段js代码</div>
		<div class="introSSOCode">
		在您的网站登录页面中需要加入一段传输数据的js代码。
		</div>  
		<div class="codePaneWindow">            
                <div class="designPaneTop"></div>
                <div class="designPaneMid">
                <textarea rows="5" wrap="off" id="text0" onclick="select()" class="getCodePaneAmount">
&lt;script language="javascript" src=" http://uyan.cc/easyXDM/easyXDM.min.js" &gt;
var sso_socket = new easyXDM.Socket({
    swf: " http://uyan.cc/easyXDM/easyxdm.swf"
  });
&lt;/script&gt;
</textarea>
                <div class="designPaneCodeArrow"></div>
            </div>
         </div>		
		<div class="introductionTitle" style="padding-top:25px;">C.加入登录后的处理逻辑代码</div>
		<div class="introSSOCode">
		在您的用户登录后的页面中加入逻辑代码，将用户数据回调至友言评论系统中。<br/>
		代码需要加到登录后触发的页面中，您可以通过一定的判断机制将来自评论框的用户登录请求与直接的登录请求区分开，用户的数据将在加密后传送给评论系统。<br/><br/>
		<div class="inputSSOWrapper">
		<div class="inputSSOIntro">
			<div class="inputSSOItem">sso标识名(英文)</div> <div id="inputSSOAlert"></div>
			<input type="text" class="ssoInput" id='sso_name' />
			<input type="button" class="ssoButton" value="提交" onclick="sumbitSSO()" />
			<div class="clear"></div>
		</div>

		</div><br/>
		<strong>以php为例:</strong><br/>
		sso_name: "您的网站标识字符串，请在上方框体中申请后更替(必填)";<br/>
		id: "用户在您的网站中的标识数字，用户id目前仅支持数字(必填)";<br/>
		username: "用户在您网站中的用户名(必填)";<br/>
		email: "用户在您网站中的邮箱(可选)";<br/>
		profile_img: "用户在您网站中的头像地址(可选)";<br/>	
		link: "用户在您网站中的个人页面地址(可选)";<br/>		
		</div>  
		<div class="codePaneWindow">            
                <div class="designPaneTop"></div>
                <div class="designPaneMid">
                <textarea rows="5" wrap="off" id="text0" onclick="select()" class="getCodePaneAmount">

&lt;script language="javascript" src=" http://uyan.cc/easyXDM/easyXDM.min.js" &gt; &lt;/script&gt 
&lt;?php
      $sso_callback_data = array(
        'sso_name' => 'sample',
        'id' => $userId,
        'username' => $userNick,
        'email' => $userEmail,
        'profile_img' => $userProfileImage,
	'link' => $userLink
      );
?&gt;

&lt;script type="text/javascript"&gt
sso_socket.postMessage('&lt;?php echo json_encode($sso_callback_data)?&gt;');
&lt;/script&gt
</textarea>
                <div class="designPaneCodeArrow"></div>
            </div>
         </div>				
	</div>
    <div id="hotInstallWrapper">
        <div class="introductionTitle">将下面代码复制到网站中，即可生成网站的评论热榜</div>  
        <div id="showCodePane">        
            <div class="codePaneWindow">            
                <div class="designPaneTop"></div>
                <div class="designPaneMid">
                <textarea class="getCodePane" onClick="select()" id="text0" wrap="off" rows="5"><!-- UY BEGIN -->
<div id="uyan_list_hotness_frame"></div>
<script type="text/javascript" id="UYScriptHotness" src="http://uyan.cc/js/iframe_hotness_list.js?UYUserId=<?php echo $_SESSION['uid']?>&rankType=hotness" async=""></script>
<!-- UY END --></textarea>
                <div class="designPaneCodeArrow"></div>
            </div>
            </div>
        </div>
        <div class="settingWrapper">
            <div class="pluginSettingTitleWhole">榜单设置</div>
            <div class="settingPluginItem">
                <div class="editFrameTitle">榜单标题</div>					
                <input type="text" class="pluginSettingTitleInput" id="hotCommentTitleSetting" value="<?php echo $titleCommentHot;?>"/>
            </div>
            <div class="settingPluginItem">
                <div class="editFrameTitle">显示条数</div>
                <input type="text" class="pluginSettingInput" id="hotCommentSetting" value="<?php echo $_SESSION['domain_data']['commentHotAmount'];?>"/>
            </div>
            <div class="settingPluginItem">
                <div class="editFrameTitle">框体宽度</div>
                <div class="editFramContainer"><input type="radio" name="commentHotWidthRadio" id="commentHotWidthRadio" class="widthSetRadio" value="0" onClick="$('#commentHotWidthRadioPixel').css({'display':'none'});$('.commentHotWidthRadioPixel').css({'display':'none'});" checked /><div class="introTextRadio">自适应</div><input type="radio" name="commentHotWidthRadio" id="commentHotWidthRadioDIY" class="widthSetRadio" value="1" onClick="$('#commentHotWidthRadioPixel').css({'display':'block'});$('.commentHotWidthRadioPixel').css({'display':'block'});" /><div class="introTextRadio">定义宽度</div><input type="text" name="commentHotWidthRadioPixel" id="commentHotWidthRadioPixel" /><div class="commentHotWidthRadioPixel">像素</div><div class="clear"></div></div>
            </div>	
            <div class="settingPluginItem">
                    <div class="editFrameTitle">超过期限不再显示于热榜</div>
                    <select id="selectDateCommentLast" name="selectDateCommentLast">
                            <option selected="selected" value="-1">永远显示</option>
                            <option value="3">3天</option>
                            <option value="15">15天</option>
                            <option value="30">30天</option>
                            <option value="60">60天</option>
                            <option value="180">180天</option>
                    </select>
            </div>
            <div class="settingPluginItem">
                    <div class="editFrameTitle">评论者头像</div>
                    <div class="editFramContainer">
                    <input type="radio" name="hotCommentSettingRadio" id="showCommentPhotoHot" class="digRadio" value="1"  checked />
                    <div class="introTextRadio digPositionChange">显示</div>
                    <input type="radio" name="hotCommentSettingRadio" id="hideCommentPhotoHot" class="digRadio" value="0"  />
                    <div class="introTextRadio">隐藏</div>
                    <div class="clear"></div>
                </div>
            </div>
            <?php if($verify==2){?>
            <a class="submitAllSettingEdit showCodeBTN" id="hotCommentSav" >保存设置</a>
            <span class="showCodeVerify">请在验证域名后保存 <a href="http://uyan.cc/index.php/youyan_check_domain">验证域名</a></span>
            <?php }else{ ?>
            <a class="submitAllSettingEdit showCodeBTN" id="hotCommentSav" onclick="saveAmount('hotCommentSetting');changeSettingBTNstate(this,'hotCommentSav')">保存设置</a>
            <?php }?>
            <div class="clear"></div>
        </div>

    </div>

    <div id="newInstallWrapper">
        <div class="introductionTitle">将下面代码复制到网站中，即可生成网站最新评论榜</div>  
        <div id="showCodePane">        
            <div class="codePaneWindow">            
                <div class="designPaneTop"></div>
                <div class="designPaneMid">
                <textarea class="getCodePane" onClick="select()" id="text0" wrap="off" rows="5"><!-- UY BEGIN -->
<div id="uyan_list_time_frame"></div>
<script type="text/javascript" id="UYScriptTime" src="http://uyan.cc/js/iframe_time_list.js?UYUserId=<?php echo $_SESSION['uid']?>&rankType=time" async=""></script>
<!-- UY END --></textarea>
                <div class="designPaneCodeArrow"></div>
            </div>
            </div>
        </div>  
        <div class="settingWrapper">
            <div class="pluginSettingTitleWhole">榜单设置</div>

                <div class="settingPluginItem">
                    <div class="editFrameTitle">榜单标题</div>					
                    <input type="text" class="pluginSettingTitleInput" id="timeCommentTitleSetting" value="<?php echo $titleCommentTime;?>"/>
                </div>

            <div class="settingPluginItem">	
                <div class="editFrameTitle">显示条数</div>
                <input type="text" class="pluginSettingInput" id="timeCommentSetting" value="<?php echo $_SESSION['domain_data']['commentTimeAmount'];?>"/>
            </div>
            <div class="settingPluginItem">
                <div class="editFrameTitle">框体宽度</div>
                <div class="editFramContainer"><input type="radio" name="commentTimeWidthRadio" id="commentTimeWidthRadio" class="widthSetRadio" value="0" onClick="$('#commentTimeWidthRadioPixel').css({'display':'none'});$('.commentTimeWidthRadioPixel').css({'display':'none'});" checked /><div class="introTextRadio">自适应</div><input type="radio" name="commentTimeWidthRadio" id="commentTimeWidthRadioDIY" class="widthSetRadio" value="1" onClick="$('#commentTimeWidthRadioPixel').css({'display':'block'});$('.commentTimeWidthRadioPixel').css({'display':'block'});" /><div class="introTextRadio">定义宽度</div><input type="text" name="commentTimeWidthRadioPixel" id="commentTimeWidthRadioPixel" /><div class="commentTimeWidthRadioPixel">像素</div><div class="clear"></div></div>
            </div>	
            <div class="settingPluginItem">
                    <div class="editFrameTitle">评论者头像</div>
                    <div class="editFramContainer">
                    <input type="radio" name="timeCommentSettingRadio" id="showCommentPhotoTime" class="digRadio" value="1"  checked />
                    <div class="introTextRadio digPositionChange">显示</div>
                    <input type="radio" name="timeCommentSettingRadio" id="hideCommentPhotoTime" class="digRadio" value="0"  />
                    <div class="introTextRadio">隐藏</div>
                    <div class="clear"></div>
                </div>
            </div>
            <?php if($verify==2){?>
            <a class="submitAllSettingEdit showCodeBTN" id="timeCommentSav" >保存设置</a>
            <span class="showCodeVerify">请在验证域名后保存 <a href="http://uyan.cc/index.php/youyan_check_domain">验证域名</a></span>
            <?php }else{ ?>
            <a class="submitAllSettingEdit showCodeBTN" id="timeCommentSav" onclick="saveAmount('timeCommentSetting');changeSettingBTNstate(this,'timeCommentSav')">保存设置</a>
            <?php }?>
            <div class="clear"></div>
        </div>
    </div>
    <div id="newArticleInstallWrapper">
        <div class="introductionTitle">将下面代码复制到网站中，即可生成网站最新文章榜</div>  
        <div id="showCodePane">        
            <div class="codePaneWindow">            
                <div class="designPaneTop"></div>
                <div class="designPaneMid">
                <textarea class="getCodePane" onClick="select()" id="text0" wrap="off" rows="5"><!-- UY BEGIN -->
<div id="uyan_list_article_time_frame"></div>
<script type="text/javascript" id="UYScriptArticleTime" src="http://uyan.cc/js/iframe_article_time_list.js?UYUserId=<?php echo $_SESSION['uid']?>&rankType=time" async=""></script>
<!-- UY END --></textarea>
                <div class="designPaneCodeArrow"></div>
            </div>
            </div>
        </div> 
        <div class="settingWrapper">
            <div class="pluginSettingTitleWhole">榜单设置</div>
            <div class="settingPluginItem">
                    <div class="editFrameTitle">榜单标题</div>					
                    <input type="text" class="pluginSettingTitleInput" id="timeArticleTitleSetting" value="<?php echo $titleArticleTime;?>"/>
            </div>
            <div class="settingPluginItem">
                <div class="editFrameTitle">显示条数</div>
                <input type="text" class="pluginSettingInput" id="timeArticleSetting" value="<?php echo $_SESSION['domain_data']['articleTimeAmount'];?>"/>
            </div>
            <div class="settingPluginItem">

                <div class="editFrameTitle">框体宽度</div>
                <div class="editFramContainer"><input type="radio" name="articleTimeWidthRadio" id="articleTimeWidthRadio" class="widthSetRadio" value="0" onClick="$('#articleTimeWidthRadioPixel').css({'display':'none'});$('.articleTimeWidthRadioPixel').css({'display':'none'});" checked /><div class="introTextRadio">自适应</div><input type="radio" name="articleTimeWidthRadio" id="articleTimeWidthRadioDIY" class="widthSetRadio" value="1" onClick="$('#articleTimeWidthRadioPixel').css({'display':'block'});$('.articleTimeWidthRadioPixel').css({'display':'block'});" /><div class="introTextRadio">定义宽度</div><input type="text" name="articleTimeWidthRadioPixel" id="articleTimeWidthRadioPixel" /><div class="articleTimeWidthRadioPixel">像素</div><div class="clear"></div></div>
            </div>
            <?php if($verify==2){?>
            <a class="submitAllSettingEdit showCodeBTN" id="timeArticleSav" >保存设置</a>
            <span class="showCodeVerify">请在验证域名后保存 <a href="http://uyan.cc/index.php/youyan_check_domain">验证域名</a></span>
            <?php }else{ ?>
            <a class="submitAllSettingEdit showCodeBTN" id="timeArticleSav" onclick="saveAmount('timeArticleSetting');changeSettingBTNstate(this,'timeArticleSav')">保存设置</a>
            <?php }?>
            <div class="clear"></div>

        </div> 
    </div>
    <div id="hotArticleInstallWrapper">
        <div class="introductionTitle">将下面代码复制到网站中，即可生成网站全部文章的热榜</div>  
        <div id="showCodePane">        
            <div class="codePaneWindow">            
                <div class="designPaneTop"></div>
                <div class="designPaneMid">
                <textarea class="getCodePane" onClick="select()" id="text0" wrap="off" rows="5"><!-- UY BEGIN -->
<div id="uyan_list_article_hotness_frame"></div>
<script type="text/javascript" id="UYScriptArticleHotness" src="http://uyan.cc/js/iframe_article_hotness_list.js?UYUserId=<?php echo $_SESSION['uid']?>&rankType=hotness" async=""></script>
<!-- UY END --></textarea>
                <div class="designPaneCodeArrow"></div>
            </div>
            </div>
        </div> 
        <div class="settingWrapper">
            <div class="pluginSettingTitleWhole">榜单设置</div>
            <div class="settingPluginItem">
                <div class="editFrameTitle">榜单标题</div>					
                <input type="text" class="pluginSettingTitleInput" id="hotArticleTitleSetting" value="<?php echo $titleArticleHot;?>"/>
            </div>
            <div class="settingPluginItem">
                <div class="editFrameTitle">显示条数</div>					
                <input type="text" class="pluginSettingInput" id="hotArticleSetting" value="<?php echo $_SESSION['domain_data']['articleHotAmount'];?>"/>
            </div>			
            <div class="settingPluginItem">
                    <div class="editFrameTitle">框体宽度</div>
                    <div class="editFramContainer"><input type="radio" name="articleHotWidthRadio" id="articleHotWidthRadio" class="widthSetRadio" value="0" onClick="$('#articleHotWidthRadioPixel').css({'display':'none'});$('.articleHotWidthRadioPixel').css({'display':'none'});" checked /><div class="introTextRadio">自适应</div><input type="radio" name="articleHotWidthRadio" id="articleHotWidthRadioDIY" class="widthSetRadio" value="1" onClick="$('#articleHotWidthRadioPixel').css({'display':'block'});$('.articleHotWidthRadioPixel').css({'display':'block'});" /><div class="introTextRadio">定义宽度</div><input type="text" name="articleHotWidthRadioPixel" id="articleHotWidthRadioPixel" /><div class="articleHotWidthRadioPixel">像素</div><div class="clear"></div></div>
                </div>
            <div class="settingPluginItem">
                    <div class="editFrameTitle">超过期限不再显示于热榜</div>
                    <select id="selectDateArticleLast" name="selectDateArticleLast">
                            <option selected="selected" value="-1">永远显示</option>
                            <option value="3">3天</option>
                            <option value="15">15天</option>
                            <option value="30">30天</option>
                            <option value="60">60天</option>
                            <option value="180">180天</option>
                    </select>
            </div>
            <?php if($verify==2){?>
            <a class="submitAllSettingEdit showCodeBTN" id="hotArticleSav">保存设置</a>
            <span class="showCodeVerify">请在验证域名后保存 <a href="http://uyan.cc/index.php/youyan_check_domain">验证域名</a></span>
            <?php }else{ ?>
            <a class="submitAllSettingEdit showCodeBTN" id="hotArticleSav" onclick="saveAmount('hotArticleSetting');changeSettingBTNstate(this,'hotArticleSav')">保存设置</a>
            <?php }?>
            <div class="clear"></div>
        </div>  
    </div>


</div>
<div id="spamWrapper">
<div class="spamTitle">限制敏感词</div>
<div class="spamIntro">包含敏感词的评论会显示在待审核类别中。请将您需要过滤的敏感词输入在下面，系统已经自带大多数敏感词，仅需填写格外的部分。<br/>(词与词之间用空格分割)</div>
<div class="spamWordsWrapper">
<textarea name="spamWords" id="spamWords" class="spamWords"></textarea>
<div class="actionPaneForSpam">
<?php if($verify==2){?>
    <a class="submitAllSettingEdit showCodeBTN" style="float:left;display:block;margin:5px 0 0 15px;" id="spamSav" >保存设置</a>
            <span class="showCodeVerify">请在验证域名后保存 <a href="http://uyan.cc/index.php/youyan_check_domain">验证域名</a></span>
<?php }else{ ?>
<a class="submitAllSettingEdit showCodeBTN" style="float:none;display:block;margin:5px 0 0 15px;" id="spamSav" onclick="saveSpam();changeSettingBTNstate(this,'spamSav')">保存设置</a>
<?php }?>
<div class="clear"></div></div>
</div>

<div class="spamTitle" style="border-top:none;">黑名单</div>
<div class="spamIntro">您可以通过输入“用户名”,“邮箱”,“IP地址”来限制这些用户的评论，他们的评论将显示在垃圾评论中。</div>
<div class="blackListWrapper">
<div class="blackListItem" style="border-top:1px solid #d0d0d0">
    <div class="blackValue" style="font-weight:normal">黑名单</div>
    <div class="blackType">类别</div>
    <div class="blackControl" style="cursor:text;color:#000;">操作</div>
    <div class="clear"></div>
</div>
<?php if($verify!=2){?>
<div class="blackListContainer">

</div>
<?php }?>
</div>
<div class="actionPaneForSpam">
<?php if($verify==2){?>
            <a class="submitAllSettingEdit showCodeBTN" style="float:left;display:block;margin:5px 0 0 15px;" id="spamSav">添加</a>
            <span class="showCodeVerify">请在验证域名后保存 <a href="http://uyan.cc/index.php/youyan_check_domain">验证域名</a></span>
<?php }else{ ?>
<a class="submitAllSettingEdit showCodeBTN" style="float:none;display:block;margin:5px 0 0 15px;" id="spamSav" onclick="addSpam(); ">添加</a>
<?php }?>
</div>
<div class="clear"></div></div>


<div id="exampleWrapper">
<div class="feedWrapper">
    <div class="designPaneWindow">
         <div class="designPaneTop"></div>
         <div class="designPaneMid" id="showMid">
            <!-- UY BEGIN -->
            <div id="uyan_frame"></div>
            <script type="text/javascript" id="UYScript" src="http://uyan.cc/js/iframe.js?UYUserId=10" async=""></script>
            <!-- UY END -->     
         </div>             
    </div>
    <div class="feedRightIntro">
        <div class="feedIntroLine">您可以在左侧试用评论功能或是写下反馈，您的意见是对我们莫大的支持。<br/><br/>友言客服邮箱 help@uyan.cc <br/></div>
    </div>
    <div class="clear"></div>
</div>
</div>

</div>    
</div>
<div id="addSpam" >
<a class="close" href="#" id="closediagSpam"></a>
<div class="addSpamTitle">添加黑名单</div>

<div class="addSpamLine">
<div class="addSpamLeft">选择类别</div>
<select name="selectSpamType" id="selectSpam">
    <option value="email">Email</option>
    <option value="ip">IP</option>
</select>
<div class="clear"></div>
</div>

<div class="addSpamLine">
<div class="addSpamLeft">内容</div>
<input type="text" class="spamValue" name="spamValue" id="spamValue" />
<div class="clear"></div>
</div>
<input type="submit" class="addBlackSubmit" onclick="addBlackItem()" value="添加"><span class="spamAlert">请输入格式正确的邮箱</span><div class="clear"></div>
</div>

          <script language="javascript" type="text/javascript">
          $("#addSpam").ready
          (
            function()
            {
              spamPane=new Boxy($("#addSpam"), {
                modal: false,
                  show: false
              });	
            }
)

  <?php if(isset($_SESSION['uid'])){?>
  UYUserID = '<?php echo $_SESSION['uid'];?>';<?php }?>
  if(OP_SELECTED_IDX =='')
    $('#selectItemAmount')[0].selectedIndex = 3;
  else
    $('#selectItemAmount')[0].selectedIndex = OP_SELECTED_IDX;

if(OP_WIDTH == '' || OP_WIDTH < 0 ){
  $("input[name='widthRadio'][value=0]").attr("checked",true);
}
else{
  $("input[name='widthRadio'][value=1]").attr("checked", true);
  $('#pixelWidth').css({'display':'block'});$('.IntroText').css({'display':'block'});
  $('#pixelWidth').val(OP_WIDTH);
}

if(OP_LIMIT == '' || OP_LIMIT < 0){
  $("input[name='limitRadio'][value='0']").attr("checked",true);
}
else{
  $("input[name='limitRadio'][value='1']").attr("checked",true);
  $('#limitNumber').css({'display':'block'});$('.limitIntroText').css({'display':'block'});
  $("#limitNumber").val(OP_LIMIT);
}

if(OP_STYLE == 0)
  $("input[name='digRadio'][value='0']").attr("checked",true);
else
  $("input[name='digRadio'][value='1']").attr("checked",true);

if(OP_DIG != ''){
  $('.upAl').html(OP_DIG);
  $('#digName').val(OP_DIG);
}

if(OP_DIGDOWN != ''){
  $('.downAl').html(OP_DIGDOWN);
  $("#digDownName").val(OP_DIGDOWN);
}

if(OP_MAIL_NOTIFY <= 0){
  moreEmail('less');
}
else{
  $("#checkAlertEmail").attr('checked', true);
  moreEmail('more');
  $("#emailAmount").val(OP_MAIL_NOTIFY);
}

if(OP_DEL_STYLE == 0)
  $("input[name='delRadio'][value='0']").attr("checked",true);
else
  $("input[name='delRadio'][value='1']").attr("checked",true);

if(OP_DESC_WORD != '')
  $("#titleWords").val(OP_DESC_WORD);

if(OP_DEFAULT_SORT == 0){
  $("input[name='sortRadio'][value='0']").attr("checked",true);
}
else
  $("input[name='sortRadio'][value='1']").attr("checked",true);

$("#domain_name").val(OP_DOMAIN_NAME);
$("#sso_name").val(OP_SSO_NAME);
$("#anon_url").val(OP_ANON_URL);



if(OP_STYLE_NUM == 3){
  $("input[name='selectStyleRadio'][value='0']").attr("checked", true);
}else{
  $("input[name='selectStyleRadio'][value='1']").attr("checked", true);
}

if(OP_BUTTON_STYLE == 3){
  $("input[name='selectBTNRadio'][value='3']").attr("checked", true);
  $("input[name='topLoginBTNRadio'][value='1']").attr("checked", true);
  $("#topBTNRankContainer").show();
  $("#topBTNStyleContainer").show();
}else if(OP_BUTTON_STYLE == 2){
  $("input[name='selectBTNRadio'][value='2']").attr("checked", true);
  $("input[name='topLoginBTNRadio'][value='1']").attr("checked", true);
  $("#topBTNRankContainer").show();
  $("#topBTNStyleContainer").show();
}else if(OP_BUTTON_STYLE == 1){
  $("input[name='selectBTNRadio'][value='1']").attr("checked", true);
  $("input[name='topLoginBTNRadio'][value='1']").attr("checked", true);
  $("#topBTNRankContainer").show();
  $("#topBTNStyleContainer").show();
}else{
  $("input[name='topLoginBTNRadio'][value='0']").attr("checked", true);
  $("#topBTNRankContainer").hide();
  $("#topBTNStyleContainer").hide();
}
//auto hide login bar
if(OP_AUTOBAR_STYLE == 1){
  $("input[name='topLoginRadio'][value='1']").attr("checked", true);
}else{
  $("input[name='topLoginRadio'][value='0']").attr("checked", true);
} 
//reply position
if(OP_REPLYPOSITION_STYLE == 1){
  $("input[name='replyPositionRadio'][value='1']").attr("checked", true);
}else{
  $("input[name='replyPositionRadio'][value='0']").attr("checked", true);
} 
//reply position
$("#selectReplyItemAmount").val(OP_REPLYNUM_STYLE);
//emotion state
if(OP_EMOTION_STYLE==1){
  $("input[name='emotionRadio'][value='1']").attr("checked", true);	
}else{
  $("input[name='emotionRadio'][value='0']").attr("checked", true);	
}
//community box state
if(OP_COMMUNITY_STYLE==1){
  $("input[name='comunityRadio'][value='1']").attr("checked", true);		
}else{
  $("input[name='comunityRadio'][value='0']").attr("checked", true);		
}
if(OP_COMMENTHOTHEAD_STYLE==1){
  $("input[name='hotCommentSettingRadio'][value='1']").attr("checked", true);		
}else{
  $("input[name='hotCommentSettingRadio'][value='0']").attr("checked", true);		
}
if(OP_COMMENTTIMEHEAD_STYLE==1){
  $("input[name='timeCommentSettingRadio'][value='1']").attr("checked", true);		
}else{
  $("input[name='timeCommentSettingRadio'][value='0']").attr("checked", true);		
}
//sns message
$("#sns_message").val(OP_MESSAGESNS_STYLE);
//send
if(OP_IMAGESTYLE_STYLE==1){
  $("input[name='snsWithPhoto'][value='1']").attr("checked", true);	
}else{
  $("input[name='snsWithPhoto'][value='0']").attr("checked", true);	
}
$("#selectDateCommentLast").val(OP_COMMENTHOTPERIOD_STYLE);
$("#selectDateArticleLast").val(OP_ARTICLEHOTPERIOD_STYLE);

//veryfy
if(OP_VERYFYCHECK_STYLE==1){
  $("input[name='checkCommentRadio'][value='1']").attr("checked", true);	
}else{
  $("input[name='checkCommentRadio'][value='0']").attr("checked", true);	
}

if(OP_COMMENTTIMEWIDTH_STYLE==-1 ){
  $("input[name='commentTimeWidthRadio'][value='0']").attr("checked", true);
  $("#commentTimeWidthRadioPixel").hide();
  $(".commentTimeWidthRadioPixel").hide();
}else{
  $("input[name='commentTimeWidthRadio'][value='1']").attr("checked", true);
  $("#commentTimeWidthRadioPixel").val(OP_COMMENTTIMEWIDTH_STYLE);
}
if(OP_COMMENTHOTWIDTH_STYLE==-1 ){
  $("input[name='commentHotWidthRadio'][value='0']").attr("checked", true);
  $("#commentHotWidthRadioPixel").hide();
  $(".commentHotWidthRadioPixel").hide();
}else{
  $("input[name='commentHotWidthRadio'][value='1']").attr("checked", true);
  $("#commentHotWidthRadioPixel").val(OP_COMMENTHOTWIDTH_STYLE);
}
if(OP_ARTICLEHOTWIDTH_STYLE==-1 ){
  $("input[name='articleHotWidthRadio'][value='0']").attr("checked", true);
  $("#articleHotWidthRadioPixel").hide();
  $(".articleHotWidthRadioPixel").hide();
}else{
  $("input[name='articleHotWidthRadio'][value='1']").attr("checked", true);
  $("#articleHotWidthRadioPixel").val(OP_ARTICLEHOTWIDTH_STYLE);
}
if(OP_ARTICLETIMEWIDTH_STYLE==-1 ){
  $("input[name='articleTimeWidthRadio'][value='0']").attr("checked", true);
  $("#articleTimeWidthRadioPixel").hide();
  $(".articleTimeWidthRadioPixel").hide();
}else{
  $("input[name='articleTimeWidthRadio'][value='1']").attr("checked", true);
  $("#articleTimeWidthRadioPixel").val(OP_ARTICLETIMEWIDTH_STYLE);
}
if(OP_PROFILEBAR_STYLE==1 ){
  $("input[name='profileRadio'][value='1']").attr("checked", true);	
}else{
  $("input[name='profileRadio'][value='0']").attr("checked", true);	
}

if(OP_SHOWSCOREITEM_STYLE==1 ){
  $("input[name='selectStarBTNRadio'][value='1']").attr("checked", true);
  $(".selectForceAction").show();
}else{
  $("input[name='selectStarBTNRadio'][value='0']").attr("checked", true);
  $(".selectForceAction").hide();
}
if(OP_FORCESTAR_STYLE==1 ){
  $("#selectForceVote").attr('checked', true);
}else{
  $("#selectForceVote").attr('checked', false);
}
buildAccountOrderList(OP_ACCOUNT_ORDER);

$("#appkey").val(SINA_APP_KEY);
$("#secret").val(SINA_APP_SECRETE);

<?php if(isset($_SESSION['uyan_remote'])){ ?>
/*var getHeight = function(){
  return document.body.clientHeight || document.body.offsetHeight || document.body.scrollHeight;
};

var preHeight = getHeight();
var checkHeight = function(){
  var currentHeight = getHeight();
  if(currentHeight != preHeight){
    parent.socket.postMessage(currentHeight);
    preHeight = currentHeight;
  }
  setTimeout(checkHeight,500);
};
setTimeout(checkHeight,500);

window.onload = function(){
  parent.socket.postMessage(document.body.clientHeight || document.body.offsetHeight || document.body.scrollHeight);
};*/
<?php }?>

</script>
