# RBMS 零售管理系统
零售管理系统，前端基础结合php开发，是一个数据库系统课程项目

## 项目概述
本项目实现了简单的零售业务管理，包括了客户端界面，和后台管理界面。客户端和后台管理员账户分离，并不通用，账户信息存放于数据库中

## 功能清单
### 登录界面
1. 使用customers表格中的cid作为username登录客户端
2. 使用mysql中的帐号作为username和password登录后台管理系统
3. 实现按钮，可以切换客户端或后台登录

### 客户端界面
1. 登录后，显示products表格中的各商品信息，以商品卡片的形式分产品显示
2. 用户可以点击购买商品，购买时候需要输入相应的信息，购买后页面信息相应修改
3. 用户提交订单后，针对pur、cid、eid、pid、qty的填写是否正确给出相应提示消息
4. 查询用户自身历史订单记录列表

### 后台管理界面
1. 登录后，显示界面，将实验中的6个表格分组显示（分为系统设置：logs；项目表格：customers、 employees、 products、 suppliers；订单管理：purchases），分别点击表格名称显示
对应表格内容。 除此之外， 表格中还有增、 删、 改的功能
1. products表格区别于其他表格，存在按钮可以查询商品月度销售情况
2. 可以在后台向purchases插入新数据，表示新订单的提交
3. 各项操作成功与否，给出相应的消息提示
4. purchases 表格中，删除数据实现退货操作，相应表格数据进行修改（Ps：未完成）
5. Ps：logs表格为操作记录表格，不可做增、删、改操作

## 项目体验
[项目体验地址](http://134.175.125.45/db-ex4/login.html)
* 客户端帐号：c000
* 客户端密码：空(不输入密码直接登录)
* 后台帐号：test
* 后台管理密码：pass

## 部分界面展示
登录界面

<img src="https://note.youdao.com/yws/api/personal/file/70927CC46B1E45E997067D13AFF28599?method=download&shareKey=b079ab3e91b1de3cb60ba09952fbef7b">

客户端界面

<img src="https://note.youdao.com/yws/api/personal/file/1C19A6F01BC949A681C26C8E1A69AADA?method=download&shareKey=8f709d26456ecfdbc6381791ab06f88f">

后台管理界面

<img src="https://note.youdao.com/yws/api/personal/file/518DCF6716BF4E988A7C7FA6477369D1?method=download&shareKey=bfe1be0b37b53f395dd2fbab575386a0">

## 项目开源
本项目是数据库系统课程项目，用于学习交流练习，如有问题请提交 [issue](https://github.com/youyingjie114/db-rbms/issues)



