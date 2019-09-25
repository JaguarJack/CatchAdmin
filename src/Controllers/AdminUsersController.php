<?php
namespace JaguarJack\CatchAdmin\Controllers;

use JaguarJack\CatchAdmin\Exceptions\FailedException;
use JaguarJack\CatchAdmin\Requests\Admin\AdminUsers\UpdateRequest;
use JaguarJack\CatchAdmin\Requests\Admin\AdminUsers\CreateRequest;
use JaguarJack\CatchAdmin\Models\AdminUsers;
use Illuminate\Http\Request;

/**
 * Class AdminUsersController
 * @package JaguarJack\CatchAdmin\Http\Controllers\Admin
 */
class AdminUsersController extends Controller
{
    protected $adminUsers;

    /**
     * AdminUsersController constructor.
     * @param AdminUsers $adminUsers
     */
    public function __construct(AdminUsers $adminUsers)
    {
        $this->adminUsers = $adminUsers;
    }

    /**
     * get user list
     *
     * @time 2019年09月10日
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->paginate($this->adminUsers->getList($request->all()));
    }

    /**
     * create user
     *
     * @time 2019年09月10日
     * @param CreateRequest $request
     * @return mixed
     */
    public function store(CreateRequest $request)
    {
        $userId = $this->adminUsers->store($request->all());

        $this->adminUsers->attachRoles($userId, $request->post('selectRoles'));

        return $this->success($userId);
    }

    /**
     * find user
     *
     * @time 2019年09月10日
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->success($this->adminUsers->findBy($id));
    }

    /**
     * update user
     *
     * @time 2019年09月10日
     * @param $id
     * @param UpdateRequest $request
     * @return mixed
     */
    public function update($id, UpdateRequest $request)
    {
        if ($this->adminUsers->updateBy($id, $request->all())) {
            $this->adminUsers->detachRoles($id);
            $this->adminUsers->attachRoles($id, $request->post('selectRoles'));
            return $this->success();
        }
        throw new FailedException('更新失败');
    }

    /**
     * delete user
     *
     * @time 2019年09月10日
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        if ($this->adminUsers->deleteBy($id)) {
            $this->adminUsers->detachRoles($id);
            $this->success();
        }

        throw new FailedException('删除失败');
    }

    /**
     * 获取用户角色
     *
     * @time 2019年09月17日
     * @param $userId
     * @return array
     */
    public function getRoles($userId)
    {
        return $this->success($this->adminUsers->getRoles($userId)->pluck('id'));
    }
}
