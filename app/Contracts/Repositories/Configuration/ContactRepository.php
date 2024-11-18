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
     * Method show
     *
     * @return mixed
     */
    public function show(): mixed
    {
        return $this->model->firstOrFail();
    }
    /**
     * Method update
     *
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function update(array $data): mixed
    {
        return $this->show()->update($data);
    }
}
