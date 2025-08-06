<?php

use App\Models\Project;
use App\Policies\ProjectPolicy;

return [
    Project::class => ProjectPolicy::class,
];
