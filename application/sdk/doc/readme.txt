本SDK由Edison tsai和Tom Wang合作开发，

一、目录树
D:.
|   RenRenClient.class.php		api操作类，请求调用api、处理响应都在该类中进行
|   requires.php				SDK包含文件，使用该SDK前，先在您的项目中引入该文件
|   RESTClient.class.php		rest操作类，是RenRenClient、RenRenOauth的共同基类
|   RenRenOauth.class.php		oauth操作类
|   config.inc.php				配置文件，API_KEY、API_SECRET、CALLBACK在该文件中设置
|
+---example						实例目录，访问1_authorize.php，按页面中的链接一路点击即可
|   +---oauth
|   |       2_callback.php
|   |       4_sessionkey.php
|   |       1_authorize.php
|   |       3_accesstoken.php
|   |
|   \---api
|           5_api.php
|
\---doc							
        classes.uml				类图uml文件
        classes.jpg				类图jpeg文件
        readme.txt				

二、实例使用方法
（1）、设置hosts，添加“127.0.0.1       www.example.com example.com”。
hosts位置：“C:/windows/system32/drivers/etc/hosts”（windows）、“/etc/hosts”（linux）。
设置hosts为方便本地调试。

（2）、申请应用
地址：http://app.renren.com/developers/createapp

（3）、设置应用属性
地址：http://app.renren.com/developers/app/130705/settings
有两个地方需要注意：
a、“高级设置”中的“授权回调地址”设置为“http://www.example.com/renren-api-php-sdk/example/oauth/2_callback.php”（根据您的实际情况设置）。
b、“网站信息”中的“网站URL”设置为“http://www.example.com”，“网站根域名”设置为“example.com”（这些都是根据前面hosts设置而设置的，请根据您的实际情况设置）。

（4）、设置配置文件(config.inc.php)
配置文件中大部分不需要改动
a、$config->CALLBACK = 'http://www.example.com/renren-api-php-sdk/example/oauth/2_callback.php'; //回调地址，注意和您申请的应用的“授权回调地址”一致。
b、$config->APIKey		= '32149c3fcce84f4dbb16d27a3a9e4d63';	//你的API Key，请到您申请的应用中查看。
c、$config->SecretKey	= '6e671bd6b85d42b4bc23b1a31c6c2fd1';	//你的API 密钥，请到您申请的应用中查看。

（5）、运行实例
地址：http://www.example.com/renren-api-php-sdk/example/oauth/1_authorize.php（根据您的实际情况可能有所不同）
按页面上的链接一步一步点击，了解oauth到api调用的整个流程。

Happy Programming!
