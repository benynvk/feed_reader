<?php

namespace App\Http\Controllers;

use App\Category;
use App\Feed;
use App\Http\Requests\FeedRequest;
use \Illuminate\Support\Facades\Session;

class FeedController extends Controller
{
    private $limit = 20;

    private $feedModel;
    private $categoryModel;

    public function __construct()
    {
        $this->feedModel = new Feed();
        $this->categoryModel = new Category();
    }

    /**
     * Feed list screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $title = 'Feed List';
        $categories = $this->categoryModel->all();

        $conditions = [];
        $categoryID = request('category_id');
        if (!empty($categoryID)) {
            $conditions[] = ['category_id', $categoryID];
        }
        $feeds = $this->feedModel->with('category')
            ->where($conditions)
            ->orderBy('updated_at', 'desc')
            ->paginate($this->limit);

        if (request('page') > $feeds->lastPage()) {
            abort(404);
        }

        return view('feed.index', compact('title', 'categories', 'feeds', 'categoryID'));
    }

    /**
     * Create feed screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Create Feed';
        $categories = $this->categoryModel->all();

        return view('feed.create', compact('title', 'categories'));
    }

    /**
     * Create feed process
     *
     * @param FeedRequest $request Form request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(FeedRequest $request)
    {
        $feed = new Feed($request->input());
        $feed->save();
        Session::flash('success', "Create new feed successfully !");

        return redirect(route('feeds.index'));
    }

    /**
     * Feed details screen
     *
     * @param int $id Feed id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function show($id)
    {
        $title = 'Feed Detail';
        $feed = $this->feedModel->find($id);
        if (empty($feed)) {
            return abort(404);
        }

        $categories = $this->categoryModel->all();

        return view('feed.show', compact('title', 'categories', 'feed'));
    }

    /**
     * Edit feed screen
     *
     * @param int $id Feed id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function edit($id)
    {
        $title = 'Feed Edit';
        $feed = $this->feedModel->find($id);
        if (empty($feed)) {
            return abort(404);
        }

        $categories = $this->categoryModel->all();

        return view('feed.edit', compact('title', 'categories', 'feed'));
    }

    /**
     * Edit feed process
     *
     * @param FeedRequest $request Form request
     * @param int $id Feed id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function update(FeedRequest $request, $id)
    {
        $feed = $this->feedModel->find($id);
        if (empty($feed)) {
            return abort(404);
        }
        $feed->fill($request->input())->save();

        Session::flash('success', "Edit feed successfully !");

        return redirect(route('feeds.show', $id));
    }

    /**
     * Delete feed process
     *
     * @param int $id Feed id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $feed = $this->feedModel->find($id);
        if (!empty($feed)) {
            $feed->delete();
            Session::flash('success', "Delete feed ID {$id} successfully !");
        }

        return redirect(route('feeds.index'));
    }
}
