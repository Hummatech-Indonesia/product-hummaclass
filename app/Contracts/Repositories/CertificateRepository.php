<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\BlogInterface;
use App\Contracts\Interfaces\CertificateInterface;
use App\Contracts\Interfaces\EventDetailInterface;
use App\Contracts\Interfaces\EventInterface;
use App\Contracts\Interfaces\FaqInterface;
use App\Contracts\Interfaces\RegisterInterface;
use App\Contracts\Interfaces\UserInterface;
use App\Enums\UserRoleEnum;
use App\Helpers\UserHelper;
use App\Models\Blog;
use App\Models\Certificate;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\Faq;
use App\Models\User;
use App\Traits\Datatables\UserDatatable;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CertificateRepository extends BaseRepository implements CertificateInterface
{
    public function __construct(Certificate $certificate)
    {
        $this->model = $certificate;
    }
    public function get(): mixed
    {
        return $this->model
            ->whereHas('userCourse', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->get();
    }
    /**
     * Method store
     *
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->query()->create($data);
    }
    /**
     * Method update
     *
     * @param mixed $id [explicite description]
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        return $this->model->query()->findOrFail($id)->update($data);
    }
}