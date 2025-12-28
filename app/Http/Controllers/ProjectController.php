<?php

namespace App\Http\Controllers;

use App\DTO\Models\Project\CreateProjectDTO;
use App\Helpers\JsonResponseWrapperHelper;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\ModifyProjectRequest;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        if (Auth::guard('api')->user()->can('viewAny', Project::class)) {
            return JsonResponseWrapperHelper::SuccessResponse(
                Project::where('organization_id', Auth::guard('api')->getOrganizationId())->get()
            );
        }
        return JsonResponseWrapperHelper::ErrorResponse(code: Response::HTTP_FORBIDDEN);
    }

    public function store(CreateProjectRequest $request): JsonResponse
    {
        $validatedCreateProjectRequestData = $request->validated();
        if (Auth::guard('api')->user()->can('create', Project::class)) {
            $project = Project::create(CreateProjectDTO::fromPayload($validatedCreateProjectRequestData)->toArray());
            return JsonResponseWrapperHelper::SuccessResponse($project);
        }
        return JsonResponseWrapperHelper::ErrorResponse(code: Response::HTTP_FORBIDDEN);
    }

    public function show(ModifyProjectRequest $request)
    {

    }

    public function update(ModifyProjectRequest $request)
    {

    }

    public function destroy(ModifyProjectRequest $request)
    {

    }

    public function setStatus()
    {

    }
}
