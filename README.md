## CatchAdmin

### 安装

```bash
composer require jaguarjack/catchAdmin
```

```bash
php artisan vendor:publish
```

会出现选择列表,请选择

```php
JaguarJack\CatchAdmin\CatchAdminServiceProvider
```

#### 完成
- [x] 后台登录
- [x] 权限管理
- [x] Database 管理
- [x] 操作日志
#### TODO
- [ ] 
- [ ] 
- [ ]

#### 后台命令
安装
```bash
php artisan catchAdmin:install
``` 
卸载
```bash
php artisan catchAdmin:uninstall
```
发布 Migration
```bash
php artisan vendor:publish --tag=catchMigration
```
发布 Seed
```bash
php artisan vendor:push --tag=catchSeed
```
执行 Migration
```bash
php artisan migrate --path=--path=database/migrations/catchAdmin/
```
填充
```bash
php artisan db:seed --class=CatchAdminSeeder
```
> ps: 这个命令之前需要执行 composer dump-autoload
