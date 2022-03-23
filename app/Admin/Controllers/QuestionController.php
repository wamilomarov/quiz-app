<?php

namespace App\Admin\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Str;

class QuestionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Questions';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(): Grid
    {
        $grid = new Grid(new Question());

        $grid->model()->latest();

        $grid
            ->disableRowSelector()
            ->disableExport()
            ->disableColumnSelector()
            ->disableBatchActions()
            ->filter(function (Grid\Filter $filter) {
                $filter->disableIdFilter();
                $filter->like('text');
                $filter->in('type')->checkbox(Quiz::TYPES);
            });

        $grid->column('text', __('Text'))->display(function ($question) {
            return Str::limit($question, 150);
        });
        $grid->column('type', __('Type'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id): Show
    {
        $show = new Show(Question::query()->findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('text', __('Text'));
        $show->field('type', __('Type'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form(): Form
    {
        $form = new Form(new Question());

        $form
            ->tab('Question', function (Form $form) {
                $form->textarea('text', __('Text'));
                $form->select('type', __('Type'))->options(Quiz::TYPES);
            })
            ->tab('Answers', function (Form $form) {
                $form->hasMany('answers', 'Answers', function (Form\NestedForm $form) {
                    $form->textarea('text')->rows(3);
                    $form->switch('is_correct');
                });
            });


        return $form;
    }
}
