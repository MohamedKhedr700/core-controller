<?php

namespace Raid\Core\Controller\Traits\Controller;

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

        $createAction->execute($request->passed());

        return $this->success($this->getResponseMessage($createAction->action()));
    }

    /**
     * Display a listing of the resource.
     *
     * @throws AuthorizationException|UnvalidatedRequestException
     */
    public function listResources(Request $request, ListActionInterface $listAction, array $includes = []): JsonResponse
    {
        $listAction->authorize();

        $resources = $listAction->execute(
            $request->passed(),
            ['*'],
            [],
        );

        return $this->success('', $this->transformResources($resources, $includes));
    }

    /**
     * Show the specified resource.
     *
     * @throws AuthorizationException
     */
    public function showResource(string|ModelInterface $id, FindActionInterface $findAction, array $includes = []): JsonResponse
    {
        $findAction->authorize($id);

        $resource = $findAction->execute($id);

        return $this->success('', $this->transformResource($resource, $includes));
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws AuthorizationException|UnvalidatedRequestException
     */
    public function updateResource(Request $request, string|ModelInterface $id, UpdateActionInterface $updateAction): JsonResponse
    {
        $updateAction->authorize($id);

        $updateAction->execute($id, $request->passed());

        return $this->success($this->getResponseMessage($updateAction->action()));
    }

    /**
     * Patch the specified resource in storage.
     *
     * @throws AuthorizationException|UnvalidatedRequestException
     */
    public function patchResource(Request $request, string|ModelInterface $id, PatchActionInterface $patchAction): JsonResponse
    {
        $patchAction->authorize($id);

        $patchAction->execute($id, $request->passed());

        return $this->success($this->getResponseMessage($patchAction->action()));
    }

    /**
     * Delete the specified resource from storage.
     *
     * @throws AuthorizationException
     */
    public function deleteResource(string|ModelInterface $id, DeleteActionInterface $deleteAction): JsonResponse
    {
        $deleteAction->authorize($id);

        $deleteAction->execute($id);

        return $this->success($this->getResponseMessage($deleteAction->action()));
    }
}
