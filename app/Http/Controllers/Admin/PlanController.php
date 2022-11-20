<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Plans\StorePlanRequest;
use App\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        $limit = request()->input('limit', 10);
        $plans = Plan::tableFilter()->paginate($limit, ['*'], 'plans');

        if (request()->ajax()) {
            return $this->sendResponse(view('admin.plans.table')->with('plans', $plans)->render());
        }
        $durations = Plan::DURATIONS;

        return view('admin.plans.index')->with('durations', $durations)->with('plans', $plans);
    }

    public function create()
    {
        $plan = null;
        $durations = Plan::DURATIONS;

        return view('admin.plans.edit')
            ->with('plan', $plan)
            ->with('durations', $durations);
    }

    public function store(StorePlanRequest $request)
    {
        $data = $request->validated();
        $data['creatad_by'] = request()->user()->id;

        $plan = Plan::create($data);

        return $this->sendResponse($plan, t('plan added successfully'));
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();

        return $this->sendResponse([], t('plan deleted successfully.'));
    }


    public function edit(Plan $plan)
    {
        $durations = Plan::DURATIONS;

        return view('admin.plans.edit')
            ->with('plan', $plan)
            ->with('durations', $durations);
    }

    public function update(StorePlanRequest $request, Plan $plan)
    {
        $data = $request->validated();
        $plan->update($data);

        return $this->sendResponse($plan, t('plan updated successfully'));
    }
}
