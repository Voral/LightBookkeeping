<?php

use Phinx\Seed\AbstractSeed;

class SampleGroupSeeder extends AbstractSeed
{
	public function run()
	{
		$data = [
			[
				'id' => 1,
				'name' => 'Расходные',
			],
			[
				'id' => 2,
				'name' => 'Накопительные',
			],
			[
				'id' => 3,
				'name' => 'Рабочие',
			],
		];

		$group = $this->table('account_group');
		$group->insert($data)->save();
	}
}
