<?php
namespace JaguarJack\CatchAdmin\Controllers;

use Illuminate\Http\Request;
use JaguarJack\CatchAdmin\Models\Articles;
use JaguarJack\CatchAdmin\Requests\Article\CreateRequest;
use JaguarJack\CatchAdmin\Requests\Article\UpdateRequest;

class ArticlesController extends Controller
{
    protected $articles;

    public function __construct(Articles $articles)
    {
        $this->articles = $articles;
    }

    public function index(Request $request){}

    /**
     * 新增
     *
     * @time 2019年09月29日
     * @param CreateRequest $request
     * @return array
     */
    public function store(CreateRequest $request)
    {
        return $this->success($this->articles->store($request->all()));
    }

    /**
     * 展示
     *
     * @time 2019年09月29日
     * @param $id
     * @return array
     */
    public function show($id)
    {
        return $this->success($this->articles->findBy($id));
    }

    /**
     * 更新
     *
     * @time 2019年09月29日
     * @param $id
     * @param UpdateRequest $request
     * @return array
     */
    public function update($id, UpdateRequest $request)
    {
        return $this->success($this->articles->updateBy($id, $request->all()));
    }

    /**
     * 删除
     *
     * @time 2019年09月29日
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        return $this->success($this->articles->deleteBy($id));
    }
}
