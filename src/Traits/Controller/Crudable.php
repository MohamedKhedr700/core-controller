<?php

namespace Raid\Core\Modules\Traits\Controller;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Raid\Core\Action\Actions\Contracts\Crud\CreateActionInterface;
use Raid\Core\Action\Actions\Contracts\Crud\DeleteActionInterface;
use Raid\Core\Action\Actions\Contracts\Crud\FindActionInterface;
use Raid\Core\Action\Actions\Contracts\Crud\ListActionInterface;
use Raid\Core\Action\Actions\Contracts\Crud\PatchActionInterface;
use Raid\Core\Action\Actions\Contracts\Crud\UpdateActionInterface;
use Raid\Core\Model\Models\Contracts\ModelInterface;
use Raid\Core\Request\Exceptions\UnvalidatedRequestException;

trait Crudable
{
    /**
     * Store a newly created resource in storage.
     *
     * @throws AuthorizationException|UnvalidatedRequestException
     */
    public function storeResource(Request $request, CreateActionInterface $createAction): JsonResponse
    {
        $createAction->authorize();

        $data = $request->onlyValidated();

        $createAction->execute($data);

        $message = $this->getResponseMessage($createAction->action());

        return $this->success($message);
    }

    /**
     * Display a listing of the resource.
     *
     * @throws AuthorizationException|UnvalidatedRequestException
     */
    public function listResources(Request $request, ListActionInterface $listAction): JsonResponse
    {
        $listAction->authorize();

        $filters = $request->onlyValidated();

        $paginate = $request->boolean('page', true) != 0;

        $resources = $listAction->execute($filters, ['*'], $paginate);

        $transformedResources = $this->fractalCollection($resources, $this->getTransformer());

        return $this->success('', $transformedResources);
    }

    /**
     * Show the specified resource.
     *
     * @throws AuthorizationException
     */
    public function showResource(ModelInterface $id, FindActionInterface $findAction): JsonResponse
    {
        $findAction->authorize($id);

        $resource = $findAction->execute($id);

        $transformedResource = $this->fractalItem($resource, $this->getTransformer());

        return $this->success('', $transformedResource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws AuthorizationException|UnvalidatedRequestException
     */
    public function updateResource(Request $request, ModelInterface $id, UpdateActionInterface $updateAction): JsonResponse
    {
        $updateAction->authorize($id);

        $data = $request->onlyValidated();

        $updateAction->execute($id, $data);

        $message = $this->getResponseMessage($updateAction->action());

        return $this->success($message);
    }

    /**
     * Patch the specified resource in storage.
     *
     * @throws AuthorizationException|UnvalidatedRequestException
     */
    public function patchResource(Request $request, ModelInterface $id, PatchActionInterface $patchAction): JsonResponse
    {
        $patchAction->authorize($id);

        $data = $request->onlyValidated();

        $patchAction->execute($id, $data);

        $message = $this->getResponseMessage($patchAction->action());

        return $this->success($message);
    }

    /**
     * Delete the specified resource from storage.
     *
     * @throws AuthorizationException
     */
    public function deleteResource(ModelInterface $id, DeleteActionInterface $deleteAction): JsonResponse
    {
        $deleteAction->authorize($id);

        $deleteAction->execute($id);

        $message = $this->getResponseMessage($deleteAction->action());

        return $this->success($message);
    }
}
