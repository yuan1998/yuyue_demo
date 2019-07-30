## Yuyue_demo

### 开发环境
    * PHP >= 7.1.3
    * MySql >= 5.7.8
    * laravel 5.8
    

### 工具
- 前端
    * npm
- 后端
    * composer

### install
> 先配置根目录的 .env 文件 , 参照.env.example
```
$ cp .env.example .env
```
> 安装依赖
```
$ npm i
$ comporse install
$ php artisan key:generate
$ php artisan migrate --seed
$ npm run build 
```
> 测试
```
$ php artisan serve 
```
