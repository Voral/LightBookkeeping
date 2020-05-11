<?php

use Phinx\Seed\AbstractSeed;

class SampleAccountSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
	    $data = [
		    [
			    'id' => 1,
			    'name' => 'Свои',
			    'short_name' => 'Сво',
			    'left_margin' => 1,
			    'right_margin'=> 6,
		    ],
		    [
			    'id' => 2,
			    'name' => 'Сбербанк',
			    'short_name' => 'СБ',
			    'left_margin' => 2,
			    'right_margin'=> 3,
			    'parent_id' => 1
		    ],
		    [
			    'id' => 3,
			    'name' => 'Расчетный счет',
			    'short_name' => 'Рсч',
			    'left_margin' => 4,
			    'right_margin'=> 5,
			    'parent_id' => 1
		    ],
		    [
			    'id' => 4,
			    'name' => 'Расходы',
			    'short_name' => 'Рсх',
			    'left_margin' => 6,
			    'right_margin'=> 13,
		    ],
		    [
			    'id' => 5,
			    'name' => 'Рабочие',
			    'short_name' => 'Рб',
			    'left_margin' => 7,
			    'right_margin'=> 8,
			    'parent_id' => 4
		    ],
		    [
			    'id' => 6,
			    'name' => 'Бытовые',
			    'short_name' => 'Быт',
			    'left_margin' => 9,
			    'right_margin'=> 12,
			    'parent_id' => 4
		    ],
		    [
			    'id' => 7,
			    'name' => 'Плановые',
			    'short_name' => 'Плн',
			    'left_margin' => 10,
			    'right_margin'=> 11,
			    'parent_id' => 6
		    ],
		    [
			    'id' => 8,
			    'name' => 'Доходы',
			    'short_name' => 'Дхд',
			    'left_margin' => 14,
			    'right_margin'=> 15,
		    ],
		    [
			    'id' => 9,
			    'name' => 'Корректировки',
			    'short_name' => 'Кор',
			    'left_margin' => 16,
			    'right_margin'=> 17,
		    ],
	    ];

	    $tbl = $this->table('account');
	    $tbl->insert($data)->save();
    }
}
