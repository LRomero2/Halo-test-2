<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Activity;

class ActivityController extends Controller
{

	public function index(Request $request) {
		$activityrecords = Activity::getAll();

		return view('activity.index', compact('activityrecords'));
	}

	public function create(Request $request) {
		return view('activity.create');
	}

	public function store(Request $request) {

		$request->validate([
			'task_code' => 'required',
			'activity_date' => 'required',
			'team_code' => 'required',
			'contract_code' => 'required',
			'outputs.*' => 'required|numeric',
		]);

		Activity::createOne([
			'task_code' => $request->task_code,
			'activity_date' => $request->activity_date,
			'team_code' => $request->team_code,
			'contract_code' => $request->contract_code,
			'outputs' => $request->outputs,
		]);

		return redirect()->route('activity.index')->with('status', 'New activity record created');
	}

	public function edit(Request $request, $activityId) {
		$activity = Activity::getOne($activityId);

		abort_unless($activity, 404);

		return view('activity.edit', compact('activity'));
	}

	public function update(Request $request, $activityId) {

		$activity = Activity::getOne($activityId);

		$request->validate([
			'task_code' => 'required',
			'activity_date' => 'required',
			'team_code' => 'required',
			'contract_code' => 'required',
			'outputs.*' => 'required|numeric',
		]);

		$activity->task_code = $request->task_code;
		$activity->activity_date = $request->activity_date;
		$activity->team_code = $request->team_code;
		$activity->contract_code = $request->contract_code;
		$activity->outputs = $request->outputs;
		$activity->saveOne();

		return redirect()->route('activity.index');
	}

}

public function __clone(): void 
{
	$activity = Activity::getOne($activityId);
	$this->id = activityId('Activity');

	return view('activity.clone', compact('activity'));
}

public function copy(Request $request, $activityId) {

	$activity = Activity::getOne($activityId);

	$request->validate([
		'task_code' => 'required',
		'activity_date' => 'required',
		'team_code' => 'required',
		'contract_code' => 'required',
		'outputs.*' => 'required|numeric',
	]);

	$activity->task_code = $request->task_code;
	$activity->activity_date = $request->activity_date;
	$activity->team_code = $request->team_code;
	$activity->contract_code = $request->contract_code;
	$activity->outputs = $request->outputs;
	$activity->saveOne();

	return redirect()->route('activity.index');
}

}
