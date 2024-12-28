<?php

namespace App\Http\Controllers;

use App\Core\Application\Category\Action\CreateCategoryAction;
use App\Core\Application\Category\Action\DeleteCategoryAction;
use App\Core\Application\Category\Action\ListCategoriesAction;
use App\Core\Application\Category\Action\GetCategoryByNameAction;
use App\Core\Application\Category\Action\UpdateCategoryAction;
use App\Core\Application\Category\DTO\Create\InCreateCategory;
use App\Core\Application\Category\DTO\List\InListCategories;
use App\Core\Application\Category\DTO\Update\InUpdateCategory;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index(Request $request, ListCategoriesAction $action): JsonResponse
    {
        $result = $action->execute(InListCategories::from($request));

        return $this->ok('Categories returned successfully!', $result);
    }

    public function create(CreateCategoryRequest $request, CreateCategoryAction $action): JsonResponse
    {
        $result = $action->execute(InCreateCategory::from($request));

        return $this->created('Category created successfully!', $result);
    }

    public function update(string $id, UpdateCategoryRequest $request, UpdateCategoryAction $action): JsonResponse
    {
        $data = $request->validated();
        $data['id'] = $id;

        $result = $action->execute(InUpdateCategory::from($data));

        return $this->ok('Category updated successfully!', $result);
    }

    public function getByName(string $name, GetCategoryByNameAction $action): JsonResponse
    {
        $result = $action->execute($name);

        return $this->ok('Category found successfully!', $result);
    }

    public function delete(string $id, DeleteCategoryAction $action): Response
    {
        $action->execute($id);

        return $this->noContent();
    }
}
