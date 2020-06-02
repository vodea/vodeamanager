<?php

namespace Vodeamanager\Core\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Vodeamanager\Core\Entities\FileLog;
use Vodeamanager\Core\Http\Requests\FileLogCreateRequest;
use Vodeamanager\Core\Utilities\Facades\ExceptionService;
use Vodeamanager\Core\Utilities\Facades\FileService;
use Vodeamanager\Core\Utilities\Traits\RestCoreController;

class FileManagerController extends Controller
{
    use RestCoreController {
        RestCoreController::__construct as private __restConstruct;
    }

    public function __construct(FileLog $repository)
    {
        $this->repository = $repository;
        $this->resource = FileLog::class;

        $this->__restConstruct();
    }

    public function store(FileLogCreateRequest $request) {
        try {
            DB::beginTransaction();

            $merge = [];

            $uploads = FileService::store($request, 'file', $request->get('disk'), $request->get('path'));
            foreach ($uploads as $name => $path) {
                $merge['photo_name'] = $path->file_name;
                $merge['photo_path'] = 'storage/' . $path->path;
                $merge['photo_storage'] = 'public';
            }

            $request->merge($merge);

            $data = $this->repository->create($request->only($this->fillable));

            DB::commit();

            return ($this->show($request, $data->id))->additional([
                'success' => true,
                'message' => 'Data created.'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return ExceptionService::responseJson($e);
        }
    }
}