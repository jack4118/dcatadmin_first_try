<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Member;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class MemberController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Member(), function (Grid $grid) {
            // $grid->model()->where('sex', '=', 1);
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('age')->sortable();

            $grid->column('thumb', 'Image')->display(function ($src) {
                return "<img src=".$src." style='width:140px;height:120px;' />";
            });

            $directors = [
                0 => 'Female',
                1 => 'Male'
            ];

            $grid->column('sex')->display(function ($type) use($directors) {
                return array_key_exists($type, $directors) ? $directors[$type] : '';
            });

            $grid->column('logo');
            $grid->column('status', 'Status')->switch();


            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            // $grid->disableCreateButton();
            // $grid->disableViewButton();
            // $grid->disableEditButton();
            // $grid->disableDeleteButton();
            // $grid->disableActions();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('name');
                $filter->equal('sex')->select([0 => 'Female', 1 => 'Male']) -> default(1);
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Member(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('logo');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Member(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('logo');

            // if($form->isCreating()){

            // }

            // if($form->isEditing()){

            // }

            // $form->saving(function (Form $form){

            // });

            // $form->saved(function (Form $form, $result){

            // });

            // $form->deleted(function (Form $form, $result){

            // });

            $form->hidden('status');
            $form->hidden('speciality');

            $form->display('thumb', 'Image')->with(function ($value) {
                return "<img src=".$value." />";
            });

            $form->editor('self_introduction');

            if($form->isEditing()){
                $form->currency('price')->customFormat(function ($price){
                    return $price/100;
                });
            }else{
                $form->currency('price');
            }

            // $form->saving(function (Form $form) {
            //     $form->price = (float)str_replace(",","",$form->price) * 100;

            //     $type = array_key_exists('type', $_POST) ? $_POST['type'] : 0;

            //     $arr = [];
            //     if($type == 1){
            //         $type1 = array_key_exists('type1', $_POST) ? $_POST['type1'] : 0;
            //         $arr[] = $type1;
            //     }else if($type == 2){
            //         $type2 = array_key_exists('type1', $_POST) ? $_POST['type2'] : 0;
            //         $type3 = array_key_exists('type1', $_POST) ? $_POST['type3'] : 0;
            //         $arr[] = $type2;
            //         $arr[] = $type3;
            //     }
                
            //     // echo $_POST['state'] . $_POST['city'];
            //     // exit();

            //     $form->speciality = json_encode($arr);
            // });

            // $form->saving(function (Form $form) {
            //     $form->deleteInput('type1');
            //     $form->deleteInput('type2');
            //     $form->deleteInput('type3');
            // });

            // $form->select('type', 'Classes')
            //     ->when(1, function (Form $form){
            //         $form->text('type1');
            //     })
            //     ->when(2, function (Form $form){
            //         $form->text('type2');
            //         $form->text('type3');
            //     })
            // ->options([1 => 'First Classes', 2 => 'Second Classes'])->default(1);

            // $form->html(function () {
            //     return View("area", ['sun1' => 1, 'sun2' => 2]);
            // }, 'Area');

            $form->select('sex')->options([0 => 'Female', 1 => 'Male']);
            // $form->disableHeader();
            $form->footer(function ($footer) {
                // $footer->disableReset();
                
                // $footer->disableSubmit();
                
                // $footer->disableViewCheck();
                
                // $footer->disableEditingCheck();
                
                // $footer->disableCreatingCheck();
            });

            $form->tools(function (Form\Tools $tools) {
                $tools->disableList();

            });
            $form->display('created_at');
            $form->display('updated_at');

        });
    }
}
