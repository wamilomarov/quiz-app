<?php

namespace App\Admin\Controllers;

use App\Models\Quiz;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Carbon;

class QuizController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Quiz History';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(): Grid
    {
        $grid = new Grid(new Quiz());
        $grid->model()->withCount('unansweredQuestions')->latest();

        $grid
            ->disableBatchActions()
            ->disableCreateButton()
            ->disableActions()
            ->disableRowSelector()
            ->disableColumnSelector()
            ->filter(function (Grid\Filter $filter) {
                $filter->disableIdFilter();
                $filter->like('first_name');
                $filter->like('last_name');
                $filter->like('email');
                $filter->in('type')->checkbox(Quiz::TYPES);
            });

        $grid->column('uuid', __('Uuid'));
        $grid->column('type', __('Type'));
        $grid->column('first_name', __('First name'));
        $grid->column('last_name', __('Last name'));
        $grid->column('email', __('Email'));
        $grid->column('total_score', __('Total score'));
        $grid->column('submitted_at', __('Submitted at'))->display(function ($dateTime) {
            return Carbon::parse($dateTime)->format("Y/m/d H:i:s");
        });
        $grid->column('unanswered_questions_count', __('Number of unanswered questions'));

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
        $show = new Show(Quiz::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('uuid', __('Uuid'));
        $show->field('type', __('Type'));
        $show->field('first_name', __('First name'));
        $show->field('last_name', __('Last name'));
        $show->field('email', __('Email'));
        $show->field('total_score', __('Total score'));
        $show->field('submitted_at', __('Submitted at'));
        $show->field('duration', __('Duration'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Quiz());

        $form->text('uuid', __('Uuid'));
        $form->text('type', __('Type'));
        $form->text('first_name', __('First name'));
        $form->text('last_name', __('Last name'));
        $form->email('email', __('Email'));
        $form->number('total_score', __('Total score'));
        $form->datetime('submitted_at', __('Submitted at'))->default(date('Y-m-d H:i:s'));
        $form->time('duration', __('Duration'))->default(date('H:i:s'));

        return $form;
    }
}
