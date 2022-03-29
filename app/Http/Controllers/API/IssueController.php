<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\IssueService;
use App\Http\Requests\IssueRequest;
use App\Http\Requests\IssueEditRequest;
use App\Models\Issue;

class IssueController extends Controller
{
    protected $service;

    public function __construct(IssueService $service)
    {
        $this->service = $service;
    }

    public function getList(Request $request)
    {
        $list = $this->service->getList($request->filter);
        $options = $this->service->getOptions();

        return response()->json([
            'list' => $list,
            'options' => $options
        ]);
    }

    public function store(IssueRequest $request)
    {
        $payload = $request->validated();

        $this->service->create($payload);

        return response()->json([
            'message' => __('Created successfuly!')
        ]);
    }

    public function edit(Issue $issue)
    {
        $issue->status = $issue->getStatus();
        
        return response()->json([
            'issue' => $issue
        ]);
    }

    public function update(IssueEditRequest $request, Issue $issue)
    {
        $payload = $request->validated();

        $this->service->update($issue, $payload);

        return response()->json([
            'message' => __('Updated successfuly!')
        ]);
    }
}
