Board demo
========================


本文件包含有关如何下载，安装，并启动信息 。如需更详细的说明，请参阅[安装][1] 章的文档中。

1) 安装
----------------------------------

当涉及到安装, 你可以按照下列步骤。

### 使用 Composer (*推荐*)

演示 使用 [Composer][2] 来管理依赖关系, 创建一个新的项目使用它。

如果你还没有 Composer，下载它下面的说明 http://getcomposer.org/ 或者只是运行以下命令：

    curl -s http://getcomposer.org/installer | php

Composer 将会安装所有的依赖组件到以下目录 `path/to/install`

### 下载的存档文件

快速测试 demo，你也可以下载压缩包 https://github.com/ffup/demo 

或者是邮件附件中的 demo.zip 并且在 Web 服务器的根目录下它解压。

或者从 git 上获取 https://github.com/ffup/demo.git

如果下载的文件没有 vendor 目录，你还需要安装所有必要的依赖。下载 Composer（见上文），
然后运行 下面的命令：

    php composer.phar install

2) 检查你的系统配置
-------------------------------------

Web 服务器配置（如 Apache）

重写规则
    <IfModule mod_rewrite.c>
        Options +FollowSymlinks
        RewriteEngine On

        # Explicitly disable rewriting for front controllers
        RewriteRule ^app_dev.php - [L]
        RewriteRule ^app.php - [L]

        RewriteCond %{REQUEST_FILENAME} !-f

        # Change below before deploying to production
        #RewriteRule ^(.*)$ /app.php [QSA,L]
        RewriteRule ^(.*)$ /app_dev.php [QSA,L]
    </IfModule>

在开始运行之前，请确保你的本地系统正常配置。

在命令行中执行`check.php`脚本：

    php app/check.php

该脚本返回的`0`一个状态代码，如果满足所有强制性要求， `1`则反之。

从浏览器访问的`config.php`脚本：

    http://localhost/path/to/demo/app/web/config.php

如果你得到任何警告或建议，在移动之前解决这些问题。

设置权限
 
一个常见的​​问题是，app/cache 和 app/logs 目录必须是可写

    APACHEUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data' | grep -v root | head -1 | cut -d\  -f1`
    sudo setfacl -R -m u:"$APACHEUSER":rwX -m u:`whoami`:rwX app/cache app/logs
    sudo setfacl -dR -m u:"$APACHEUSER":rwX -m u:`whoami`:rwX app/cache app/logs
 
3) 配置数据库
--------------------------------
	
在上文页面，你也可以通过点击使用基于 Web 的配置器 
"Configure your Symfony Application online" 链接到配置页面。

在真正开始，你需要配置你的数据库连接信息。按照惯例，
这些信息通常被配置在一个 app/config/parameters.yml 文件：

现在让 Doctrine 创建数据库

    php app/console doctrine:database:create

导入数据

    php app/console doctrine:schema:update --force
    php app/console doctrine:fixtures:load

4) 浏览演示应用
--------------------------------

现在，就可以使用 demo 了。

5) 故障排除及参考
--------------------------------

mysqldump 文件目录

    demo-mysqldump.sql

在无网络链接的情况下需要禁用验证码 `app/config.yml`

    ewz_recaptcha:
        enabled:      false

如果出现错误，错误和异常记录日志

    tail -f app/logs/prod.log
    tail -f app/logs/dev.log


