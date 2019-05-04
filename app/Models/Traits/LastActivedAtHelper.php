<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/2 0002
 * Time: 21:03
 */

namespace App\Models\Traits;


use App\Models\User;
use Carbon\Carbon;
use Redis;

trait LastActivedAtHelper
{
    protected $hash_prefix = 'larabbs_last_active_at_';
    protected $user_prefix = 'user_';

    public function recordLastActivedAt()
    { // 获取今天的日期
        $date = Carbon::now()->toDateString();

        // Redis 哈希表的命名，如：larabbs_last_actived_at_2017-10-21
        $hash = $this->hash_prefix . $date;

        // 字段名称，如：user_1
        $field = $this->user_prefix . $this->id;

        // 当前时间，如：2017-10-21 08:35:15
        $now = Carbon::now()->toDateTimeString();

        // 数据写入 Redis ，字段已存在会被更新
        Redis::hSet($hash, $field, $now);
    }

    public function syncUserActivedAt()
    {
        $yester_date = Carbon::now()->toDateString();

        $hash = $this->hash_prefix . $yester_date;

        $dates = Redis::hGetAll($hash);

        foreach ($dates as $id => $date) {
            $user_id = str_replace($this->user_prefix, '', $id);
            if ($user = User::find($user_id)) {
                $user->last_actived_at = $date;
                $user->save();
            }
        }

        Redis::del($hash);
    }

    public function getLastActivedAtAttribute($value)
    {
        // 获取今日对应的哈希表名称
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        // 字段名称，如：user_1
        $field = $this->getHashField();

        // 三元运算符，优先选择 Redis 的数据，否则使用数据库中
        $datetime = Redis::hGet($hash, $field) ? : $value;

        // 如果存在的话，返回时间对应的 Carbon 实体
        if ($datetime) {
            return new Carbon($datetime);
        } else {
            // 否则使用用户注册时间
            return $this->created_at;
        }
    }

    public function getHashFromDateString($date)
    {
        // Redis 哈希表的命名，如：larabbs_last_actived_at_2017-10-21
        return $this->hash_prefix . $date;
    }

    public function getHashField()
    {
        // 字段名称，如：user_1
        return $this->field_prefix . $this->id;
    }
}