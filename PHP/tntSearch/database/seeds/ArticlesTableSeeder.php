<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles')->insert([
            [
                'title' => 'Laravel',
                'content' => 'Laravel是一套简洁、优雅的PHP Web开发框架'
            ],
            [
                'title' => 'PHP',
                'content' => 'PHP是一种通用开源脚本语言，PHP是在服务器端执行的脚本语言'
            ]
        ]);
    }
}
