<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\ChallengeInterface;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ChallengeRepository extends BaseRepository implements ChallengeInterface
{
    public function __construct(Challenge $challenge)
    {
        $this->model = $challenge;
    }

    public function get(): mixed
    {
        return $this->model->query()->where('user_id', auth()->user()->id)->get();
    }
    
    public function customPaginate(Request $request, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->query()
            ->where('user_id', auth()->user()->id)
            ->when($request->search, function($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->search . '%')
                    ->orWhereRelation('classroom', 'name', 'LIKE', '%' . $request->search . '%')
                    ->orWhereRelation('classroom.school', 'name', 'LIKE', '%' . $request->search . '%');
            })  
            ->fastPaginate($pagination);
    }

    public function getByClassroom(Request $request, string $classroomSlug, mixed $data, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->query()
            ->whereRelation('classroom', 'slug', $classroomSlug)
            ->when($request->classroom, function($query) use ($request){
                $query->where('classroom_id', $request->classroom);
            })->when($request->status == "finish" , function($query) use ($data){
                $query->whereHas('challengeSubmits', function($query) use ($data){
                    $query->where($data);
                });
            })->when($request->status == "not_finish" , function($query) use ($data){
                $query->whereHas('challengeSubmits', function($query) use ($data){
                    $query->where($data);
                });
            })->when($request->sort == "newest", function ($query) {
                $query->orderBy('start_date', 'desc');
            })
            ->when($request->sort == "oldest", function ($query) {
                $query->orderBy('end_date', 'asc'); 
            })
            ->fastPaginate($pagination);
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

    public function showWithSlug(string $slug): mixed
    {
        return $this->model->query()->where('slug', $slug)->first();
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
    public function delete(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id)->delete();
    }
}
