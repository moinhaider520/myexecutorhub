<?php

namespace App\Observers;

use App\Services\ActivityLogger;
use Illuminate\Database\Eloquent\Model;

class ModelActivityObserver
{
    public function __construct(
        private readonly ActivityLogger $activityLogger
    ) {
    }

    public function created(Model $model): void
    {
        $this->activityLogger->logModelActivity($model, 'created');
    }

    public function updated(Model $model): void
    {
        $this->activityLogger->logModelActivity($model, 'updated');
    }

    public function deleted(Model $model): void
    {
        $this->activityLogger->logModelActivity($model, 'deleted');
    }
}
