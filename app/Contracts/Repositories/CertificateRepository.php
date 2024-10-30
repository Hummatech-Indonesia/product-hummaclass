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
        if ($data['user_course_id']) {
            return $this->model->updateOrCreate(
                ['user_course_id' => $data['user_course_id']],
                $data
            );
        } else {
            return $this->model->updateOrCreate(
                ['user_event_id' => $data['user_event_id']],
                $data
            );
        }
    }
    /**
     * Method show
     *
     * @param mixed $id [explicite description]
     *
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id);
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

    /**
     * showWithCourse
     *
     * @param  mixed $id
     * @return mixed
     */
    public function showWithCourse(mixed $id): mixed
    {
        return $this->model->query()->where('user_course_id', $id)->firstOrFail();
    }
    public function showWithEvent(mixed $id): mixed
    {
        return $this->model->query()->where('user_event_id', $id)->firstOrFail();
    }
}
