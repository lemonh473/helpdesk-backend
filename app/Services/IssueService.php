<?php

namespace App\Services;

use App\Models\Issue;

class IssueService
{
    protected $model;

    public function __construct(Issue $model)
    {
        $this->model = $model;
    }

    public function getList(?int $filter)
    {
        $role = auth()->user()->userRole->role ?? 1;
        $list = $this->model
            ->when($filter, function ($query) use ($filter) {
                $query->where('status', $filter);
            })
            ->when($role === 2, function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->paginate(50)
            ->through(function ($issue, $key) {
                $issue->status = $issue->getStatus();
          
                return $issue;
            });

        return $list;
    }

    private function processPayload(array $payload): array
    {
        if (auth()->user()) {
            $payload['user_id'] = auth()->user()->id;
        }

        return $payload;
    }

    public function create(array $payload) 
    {
        $payload = $this->processPayload($payload);

        $this->model->create($payload);
    }

    public function update(Issue $issue, array $payload) 
    {
        $issue->update($payload);
    }

    public function getOptions()
    {
        return $this->model->getStatuses();
    }
}
