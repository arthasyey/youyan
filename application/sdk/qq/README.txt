====================PHP SDKʹ��˵��====================
������ֻ��Ҫ���������˵���޸ļ��д��룬�Ϳ�������վ��ʵ�֡�QQ��¼�����ܡ�
1. ��ɡ�QQ��¼��׼������(http://wiki.opensns.qq.com/wiki/%E3%80%90QQ%E7%99%BB%E5%BD%95%E3%80%91%E5%87%86%E5%A4%87%E5%B7%A5%E4%BD%9C)�еĵ�1-2����

2. ʹ��ǰ���޸� comm/config.php �е���������
	$_SESSION["appid"];
	$_SESSION["appkey"];
	$_SESSION["callback"];  

3. ��ҳ�����QQ��½��ť
	<a href="#" onclick='toQzoneLogin()'><img src="img/qq_login.png"></a>

4. ҳ����Ҫ��js����
	<script>
		function toQzoneLogin()
		{
			var A=window.open("oauth/redirect_to_login.php","TencentLogin","width=450,height=320,menubar=0,scrollbars=1, resizab
			le=1,status=1,titlebar=0,toolbar=0,location=1");
		} 
	</script>

5. SDK��ʹ��session�������Ҫ����Ϣ��Ϊ������վ���ڶ����������ͬһ����������ͬ��������ɵ�session�޷��������⣬�뿪���߰��ձ�SDK��comm/session.php�е�ע�Ͷ�session.php���б�Ҫ���޸ģ��Խ����2�����⡣


====================��ǰ�汾��Ϣ====================
��ǰ�汾��beta_V1.4

�������ڣ�2011-08-09

�ļ���С��23.9 K 


====================�޸���ʷ====================
V1.4  ������add_share�ӿڵ�ʾ�����룬ȥ���˲���֧�ֵĽӿ�add_feeds��ʾ������
V1.3  ֧������������session��֧�ֿ����������session
V1.2  ��������־�ӿڵ�SDK������ע�͹淶��
V1.1  �޸�php�Ͱ汾��֧��hash_hmac���������⡣
V1.0  beta���һ�淢����



====================�ļ��ṹ��Ϣ====================
comm�ļ��У�
	config.php:�����ļ������ô�����еĺ����
	util.php:  ������OAuth��֤�����л��õ��Ĺ��÷���
        session.php: ֧������������session��֧�ֿ����������session��

oauth�ļ��У�
	get_request_token.php: ��ȡ��ʱtoken
	redirect_to_login.php����Ӧ��¼��ť�¼��������û���ת��QQ��¼��Ȩҳ
	get_access_token����ȡ����Qzone����Ȩ�޵�access_token���洢��ȡ������Ϣ������������ʻ���openid�İ��߼�

user�ļ��У�
	get_user_info.php����ȡ�û���Ϣ

share�ļ��У�
        add_share.php����һ����̬��feeds��ͬ����QQ�ռ��У�չ�ָ�����
        

photo�ļ��У�
	add_album.php�� ��ȡ��¼�û�������б�
	list_album.php����¼�û��������
	upload_pic.php����¼�û��ϴ���Ƭ

blog�ļ��У�        
	add_blog.php����¼�û�����һƪ����־

img�ļ��У�
	QQ��¼ͼ�꣬�����н��������ͼƬ��Ϊ��ťͼ��



====================��ϵ����====================
QQ��¼������http://connect.opensns.qq.com/
��������ʹ�ù��������κ�����ͽ��飬�뷢�ʼ���connect@qq.com ���з�����
���⣬��Ҳ����ͨ����ҵQQ�����룺800030681��ֱ����QQ�ġ�������ϵ�ˡ���������뼴�ɿ�ʼ�Ի�����ѯ��

