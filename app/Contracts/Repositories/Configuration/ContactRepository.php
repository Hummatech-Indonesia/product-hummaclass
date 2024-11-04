<?php

namespace App\Contracts\Repositories\Configuration;

use App\Contracts\Interfaces\Configuration\ContactInterface;
use App\Contracts\Interfaces\Auth\ProfileInterface;
use App\Contracts\Interfaces\Course\CategoryInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Category;
use App\Models\Contact;
use App\Models\User;

class ContactRepository extends BaseRepository implements ContactInterface
{
    public function __construct(Contact $contact)
    {
        $this->model = $contact;
    }

    /**
     * store
     *
     * @param  mixed $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->query()->updateOrCreate(
            ['id' => 1],
            $data
        );
    }

    /**
     * Method get
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()->firstOrFail();
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id);
    }
}
