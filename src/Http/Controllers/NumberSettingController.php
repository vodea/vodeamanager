<?php

namespace Vodeamanager\Core\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Vodeamanager\Core\Models\NumberSetting;
use Vodeamanager\Core\Http\Requests\NumberSettingCreateRequest;
use Vodeamanager\Core\Http\Requests\NumberSettingUpdateRequest;
use Vodeamanager\Core\Utilities\Facades\ExceptionService;
use Vodeamanager\Core\Utilities\Traits\RestCoreController;

class NumberSettingController extends Controller
{
    use RestCoreController {
        RestCoreController::__construct as private __restConstruct;
    }

    public function __construct(NumberSetting $repository)
    {
        $this->repository = $repository;
        $this->__restConstruct();
    }

    public function store(NumberSettingCreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $this->repository->create($request->only($this->fillable));

            $data->numberSettingComponents()->sync($request->get('number_setting_components') ?? []);

            DB::commit();

            if ($request->wantsJson()) {
                return ($this->show($request, $data->id))->additional([
                    'success' => true,
                    'message' => 'Data created.'
                ]);
            }

            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->wantsJson()) {
                return ExceptionService::responseJson($e);
            }

            return ExceptionService::response($e);
        }
    }

    public function update(NumberSettingUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $data = $this->repository->findOrFail($id);
            $data->fill($request->only($this->fillable));
            $data->save();

            $data->numberSettingComponents()->sync($request->get('number_setting_components') ?? []);

            DB::commit();

            if ($request->wantsJson()) {
                return ($this->show($request, $data->id))->additional([
                    'success' => true,
                    'message' => 'Data created.'
                ]);
            }

            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->wantsJson()) {
                return ExceptionService::responseJson($e);
            }

            return ExceptionService::response($e);
        }
    }

}
