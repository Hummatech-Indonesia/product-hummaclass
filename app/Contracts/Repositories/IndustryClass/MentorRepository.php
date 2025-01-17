<?php

namespace App\Contracts\Repositories\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\MentorInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Enums\RoleEnum;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class MentorRepository extends BaseRepository implements MentorInterface
{
    public function __construct(Mentor $mentor)
    {
        $this->model = $mentor;
    }


    /**
     * Method get
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()->get();
    }

    public function getMentorPaginate(Request $request, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->query()
        ->when($request->mentor, function ($query) use ($request) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'LIKE', '%' .  $request->mentor . '%');
            });
        })->fastPaginate($pagination);
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
        return $this->show($id)->update($data);
    }
    /**
     * Method delete
     *
     * @param mixed $id [explicite description]
     *
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        return $this->show($id)->delete();
    }
}
