<?php
namespace JaguarJack\CatchAdmin\Controllers;

use Illuminate\Http\Request;
use JaguarJack\CatchAdmin\Models\ArticleCategory;
use JaguarJack\CatchAdmin\Requests\Article\UpdateRequest;
use JaguarJack\CatchAdmin\Requests\ArticleCategory\CreateRequest;

class ArticleCategoryController extends Controller
{
    protected $category;

    public function __construct(ArticleCategory $category)
    {
        $this->category = $category;
    }

    public function index(Request $request)
    {}

    /**
     * 新增
     *
     * @time 2019年09月29日
     * @param CreateRequest $createRequest
     * @return array
     */
    public function store(CreateRequest $createRequest)
    {
        return $this->success($this->category->store($createRequest->all()));
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
        return $this->success($this->category->updateBy($id, $request->all()));
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
        return $this->success($this->category->findBy($id));
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
        return $this->success($this->category->deleteBy($id));
    }
}
