<?php
namespace JaguarJack\CatchAdmin\Http\Controllers;

use JaguarJack\CatchAdmin\Exceptions\FailedException;
use JaguarJack\CatchAdmin\Http\Requests\Roles\CreateRequest;
use JaguarJack\CatchAdmin\Models\AdminPermissions;
use JaguarJack\CatchAdmin\Models\AdminRoles;
use JaguarJack\CatchAdmin\Service\Common\TreeService;
use Illuminate\Http\Request;

/**
 * Class RolesController
 * @package JaguarJack\CatchAdmin\Http\Controllers\Admin
 */
class RolesController extends Controller
{
    protected $roles;

    /**
     * RolesController constructor.
     * @param AdminRoles $adminRoles
     */
    public function __construct(AdminRoles $adminRoles)
    {
        $this->roles = $adminRoles;
    }

    /**
     * roles list
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request): array
    {
        return $this->paginate($this->roles->getList($request->all()));
    }

    /**
     * create list
     *
     * @param CreateRequest $request
     * @return array
     */
    public function store(CreateRequest $request): array
    {
        return $this->success($this->roles->store($request->all()));
    }

    /**
     * find role
     *
     * @param $id
     * @return array
     */
    public function show($id): array
    {
        return $this->success($this->roles->findBy($id));
    }

    /**
     * update role
     *
     * @param $id
     * @param CreateRequest $request
     * @return array
     */
    public function update($id, CreateRequest $request): array
    {
        return $this->success($this->roles->updateBy($id, $request->all()));
    }


    /**
     * delete role
     *
     * @param $id
     * @return array
     */
    public function destroy($id): array
    {
        if ($this->roles->deleteBy($id)) {
            $this->roles->detachPermissions($id);
            return $this->success();
        }

        throw new FailedException('删除失败');
    }

    /**
     * 获取角色权限
     *
     * @time 2019年09月17日
     * @param $id
     * @return array
     */
    public function getRolePermission($id)
    {
        return $this->success($this->roles->getPermissions($id)->pluck('id'));
    }

    /**
     * 分配权限
     *
     * @time 2019年09月17日
     * @param Request $request
     * @return array
     */
    public function attachPermissions(Request $request)
    {
        $roleId = $request->post('role_id');

        $permissionIds = explode(',', $request->post('permissions'));

        $this->roles->detachPermissions($roleId);

        $this->roles->attachPermissions($roleId, $permissionIds);

        return $this->success();
    }

    /**
     * 获取角色权限
     *
     * @time 2019年09月19日
     * @param $id
     * @param AdminPermissions $permissions
     * @param TreeService $treeService
     * @return array
     */
    public function getRolePermissions($id, AdminPermissions $permissions, TreeService $treeService)
    {
        return $this->success([
            'permissions' => $treeService->setItems($permissions->getAll())->tree(),
            'rolePermissions' => $this->roles->getPermissions($id)->pluck('id'),
        ]);
    }

    /**
     * 获取全部角色
     *
     * @time 2019年09月24日
     * @return array
     */
    public function getRoles()
    {
        return $this->success($this->roles->get());
    }

}
