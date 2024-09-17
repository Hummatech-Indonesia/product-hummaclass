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

    /**
     * Method get
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()->firstOrFail();
    }
}
