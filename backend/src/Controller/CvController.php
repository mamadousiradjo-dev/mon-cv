<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\CvModel;

final class CvController
{
    public function __construct(private readonly CvModel $model)
    {
    }

    public function show(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($this->model->getCv(), JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    }
}
