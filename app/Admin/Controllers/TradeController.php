<?php

namespace App\Admin\Controllers;

use App\Models\DictType;
use App\Models\Trade;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class TradeController extends Controller
{
    use ModelForm;

    /**
     * @var array
     */
    private $bitList = [];

    public function __construct()
    {
        $list = DictType::where(['is_delete' => 1])->get(['id', 'name']);
        foreach ($list as $item) {
            $this->bitList[$item['id']] = $item['name'];
        }
    }

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Trade::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->bit_price('单价');
            $grid->bit_amount('数量');
            $grid->column('exchange_type','交易类型')->display(function ($exchange_type) {
                return $exchange_type == 1 ? '买入' : '卖出';
            });
            $grid->bit_price_total('总金额');
            $grid->dictType()->name('币种名称');
            $grid->create_time('创建时间');
            $grid->update_time('更新时间');

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
            });

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('dict_type_id')->radio($this->bitList);
                $filter->equal('exchange_type')->radio([
                    1 => '买入',
                    2 => '卖出',
                ]);
            });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Trade::class, function (Form $form) {
            $exchangeType = [
                1 => '买入',
                2 => '卖出',
            ];
            $form->display('id', 'ID');
            $form->select('dict_type_id', '币种')->options($this->bitList);
            $form->select('exchange_type', '交易类型')->options($exchangeType);
            $form->number('bit_price', '交易单价');
            $form->number('bit_amount', '交易数量');
        });
    }
}
