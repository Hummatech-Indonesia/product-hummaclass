<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\BlogInterface;
use App\Contracts\Interfaces\DiscussionInterface;
use App\Contracts\Interfaces\EventDetailInterface;
use App\Contracts\Interfaces\EventInterface;
use App\Contracts\Interfaces\RegisterInterface;
use App\Contracts\Interfaces\UserInterface;
use App\Enums\UserRoleEnum;
use App\Helpers\UserHelper;
use App\Models\Blog;
use App\Models\Discussion;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\User;
use App\Traits\Datatables\UserDatatable;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DiscussionRepository extends BaseRepository implements DiscussionInterface
{
    public function __construct(Discussion $discussion)
    {
        $this->model = $discussion;
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
    /**
     * Method getWhere
     *
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function getWhere(Request $request, array $data): mixed
    {
        return $this->model->query()
            ->when($request->latest == true, function ($model) use ($request) {
                $model->orderBy('created_at', 'DESC');
            })
            ->when($request->oldest == true, function ($model) use ($request) {
                $model->orderBy('created_at', 'ASC');
            })
            ->when($request->answered == true, function ($model) use ($request) {
                $model->whereHas('discussionAnswers');
            })
            ->when($request->unanswered == true, function ($model) use ($request) {
                $model->whereDoesntHave('discussionAnswers');
            })
            ->when($request->tags, function ($model) use ($request) {
                $model->whereRelation('discussionTags.tag', 'name', $request->tag);
            })
            ->when($request->search, function ($model) use ($request) {
                $model->where('discussion_title', 'LIKE', "%$request->search%") ?? $model->where('discussion_question', 'LIKE', "%$request->search%");
            })
            ->where($data)
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
