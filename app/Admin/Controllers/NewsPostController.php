<?php

namespace App\Admin\Controllers;

use App\Models\NewsPost;
use App\Models\PostCategory;
use App\Models\Utils;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;

class NewsPostController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'News posts';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new NewsPost());

        Utils::checkEventRegustration();

        $grid->disableFilter();
        $grid->disableBatchActions();
        $grid->quickSearch('title')->placeholder('Search by Event Title');
        $grid->model()->orderBy('id', 'desc');

        $grid->column('created_at', __('Regisetered'))->display(
            function ($x) {
                return Utils::my_date($x);
            }
        )->sortable();
        $grid->column('title', __('Post Title'))->sortable();


        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(NewsPost::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('title', __('Title'));
        $show->field('details', __('Details'));
        $show->field('user_id', __('Administrator id'));
        $show->field('post_category_id', __('Post category id'));
        $show->field('views', __('Views'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new NewsPost());

        $form->select('post_category_id', __('Post category'))
            ->options(function () {
                return PostCategory::all()->pluck('name', 'id');
            })->rules('required');

        $form->image('photo', __('Thumbnail'))->rules('required');
        $form->text('title', __('Title'))->rules('required');
        $form->textarea('description', __('Post description'))->rules('required');
        $form->quill('details', __('Post Details'))->rules('required');
        $form->hidden('user_id', __('Administrator id'))
            ->default(Auth::user()->id);


        $form->hidden('views', __('Views'))->default(0);

        return $form;
    }
}
