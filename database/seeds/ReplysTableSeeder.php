<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\User;
use App\Models\Topic;

class ReplysTableSeeder extends Seeder
{
    public function run()
    {
        $fake = app(\Faker\Generator::class);

        $user_ids = User::all()->pluck('id')->toArray();

        $topic_ids = Topic::all()->pluck('id')->toArray();

        $replys = factory(Reply::class)
            ->times(1000)
            ->make()
            ->each(function ($reply, $index) use ($fake, $user_ids, $topic_ids) {
                $reply->user_id = $fake->randomElement($user_ids);
                $reply->topic_id = $fake->randomElement($topic_ids);
            });

        Reply::insert($replys->toArray());
    }

}

