## CatchAdmin

### 安装

```bash
composer require jaguarjack/catch-admin
```
#### 完成
- [x] 后台登录
- [x] 权限管理
- [x] Database 管理
- [x] 操作日志
- [x] 后台的安装 & 卸载
- [x] 数据备份 & 导入
#### TODO
- [ ] 文章管理
- [ ] 
- [ ]

#### 后台命令
安装
```bash
php artisan catch:install
``` 
卸载
```bash
php artisan catch:uninstall
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
 备份
 ```bash
 php artisan catch:backup
 ```
 导入
```bash
php artisan catch:import
``` 
