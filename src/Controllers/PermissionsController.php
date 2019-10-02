<?php

namespace JaguarJack\CatchAdmin\Controllers;

use JaguarJack\CatchAdmin\Requests\AdminPermissions\CreateRequest;
use JaguarJack\CatchAdmin\Requests\AdminPermissions\UpdateRequest;
use JaguarJack\CatchAdmin\Models\AdminPermissions;
use JaguarJack\CatchAdmin\Service\Common\TreeService;
use Illuminate\Http\Request;

/**
 * Class PermissionsController
 * @package JaguarJack\CatchAdmin\Http\Controllers\Admin
 */
class PermissionsController extends Controller
{
    protected $permissions;

    /**
     * PermissionsController constructor.
     * @param AdminPermissions $permissions
     */
    public function __construct(AdminPermissions $permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * 权限列表
     *
     * @time 2019年09月16日
     * @param Request $request
     * @param TreeService $treeService
     * @return array
     */
    public function index(Request $request, TreeService $treeService)
    {
        return $this->success($treeService->setItems($this->permissions->getList($request->all()))->tree());
    }

    /**
     * 新增权限
     *
     * @time 2019年09月16日
     * @param CreateRequest $request
     * @return array
     */
    public function store(CreateRequest $request)
    {
        return $this->success($this->permissions->store($request->all()));
    }

    /**
     * 获取权限
     *
     * @time 2019年09月16日
     * @param $id
     * @return array
     */
    public function show($id)
    {
        return $this->success($this->permissions->findBy($id));
    }

    /**
     * 更新权限
     *
     * @time 2019年09月16日
     * @param $id
     * @param UpdateRequest $request
     * @return array
     */
    public function update($id, UpdateRequest $request)
    {
        return $this->success($this->permissions->updateBy($id, $request->all()));
    }

    /**
     * 删除权限
     *
     * @time 2019年09月16日
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        return $this->success($this->permissions->deleteBy($id));
    }

    /**
     * 获取所有权限
     *
     * @time 2019年09月17日
     * @return array
     */
    public function getAllPermissions()
    {
        return $this->success($this->permissions->getAll());
    }

    /**
     * 获取路由列表
     *
     * @time 2019年10月01日
     * @return array
     */
    public function getRouteList()
    {
        $routes = app('router')->getRoutes();
        $routeList = [];
        foreach ($routes as $route) {
            $action = $route->getAction();
            $namespace = $action['namespace'];
            [$controller, $action] = explode('@', str_replace($namespace . '\\', '', $action['controller']));
            $routeList[$namespace][$controller][] = [
                'controller' => $controller,
                'action'     => $action,
                'uri'        => $route->uri(),
                'method'     => $route->methods()[0]
            ];
        }

        return $this->success($routeList);
    }
}
