<?php

namespace App\Contracts\Repositories\Auth;

use App\Contracts\Interfaces\Auth\UserInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class UserRepository extends BaseRepository implements UserInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }
    /**
     * Method search
     *
     * @param Request $request [explicite description]
     *
     * @return mixed
     */
    public function search(Request $request): mixed
    {
        return $this->model->query()->where('email', '!=', 'admin@gmail.com')->get();
    }
    /**
     * Method customPaginate
     *
     * @param Request $request [explicite description]
     * @param int $pagination [explicite description]
     *
     * @return LengthAwarePaginator
     */
    public function customPaginate(Request $request, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->query()->when($request->name, function ($query) use ($request) {
            $query->whereLike('name', $request->name);
        })->where('email', '!=', 'admin@gmail.com')->fastPaginate($pagination);
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
}