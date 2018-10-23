# Dysis
自用wordpress主题，极简主义响应式设计。


## 特性
- 特色相册
- 特色ajax评论
- 内容导航
- 总结不出来了，自己看吧

## 其他
* github上的终于同步到最新了
* 根据个人喜好继续更新
* 懒得写教程
* 不提供技术支持
* 尚未完善，建议二次开发不建议直接使用

## 使用说明

### 菜单

不支持自定义菜单（我嫌麻烦，没写），左侧菜单是以代码形式直接写在header.php里的。

![wordpress theme Dysis](http://yexiqingxi.com/img/dysis/dysis_1.png)

如有需要，请自行增删改减，内置[Font Awesome](http://fontawesome.io/)。

### 相册

新建一个相册分类，别名为`gallery`。

该分类下新建文章，选择文章形式为“相册”，文章标题即为相册标题，内容选择添加媒体-创建相册并添加，摘要为相册描述。

`functions.php` 里有两个地方需要手动改动，不然首页及归档页面不会正常显示的

![dysis](http://yexiqingxi.com/img/dysis/dysis_2.png)

![wordpress theme Dysis](http://yexiqingxi.com/img/dysis/dysis_3.png)

打开 `functions.php` ，找到上两处地方，把红圈里的数字替换为所创建的相册的分类的id。

**注意：每个相册的文章都需要设置特色图片，首页和归档页显示都是调用的特色图片（怎么设置，自行百度）。**

### 小说

后台的添加小说功能添加的只是单本小说名目，详细章节内容并不是像其他文章一样存储在数据库里，而是直接写在txt文本里，放在 `wp-content/novel/[小说别名] ` 的文件夹下，如图所示：

![wordpress theme Dysis](http://yexiqingxi.com/img/dysis/dysis_4.png)

所以，首先要在 `wp-content` 下面创建一个 `novel` 文件夹，然后再创建一个以小说别名命名的文件夹，把小说每一章放在一个 `txt` 文本里，以数字命名（数字一定要连着）。

前台小说章节页面是通过ajax从这个目录下面调取章节。

**注意：**

这个功能是根据我个人写作习惯制成，所以不支持章节名字，不利于搜索引擎收录，也不敢保证使用AJAX调用文档会不会有什么安全性或是兼容性上的问题。
