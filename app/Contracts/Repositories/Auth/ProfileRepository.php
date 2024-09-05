<?php

namespace App\Contracts\Repositories\Auth;

use App\Contracts\Interfaces\Auth\ProfileInterface;
use App\Contracts\Interfaces\Course\CategoryInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Category;
use App\Models\User;

class ProfileRepository extends BaseRepository implements ProfileInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
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
        return $this->model->findOrFail($id)->update($data);
    }

    public function show(mixed $id): mixed
    {
        return $this->model->findOrFail($id);
    }
}
