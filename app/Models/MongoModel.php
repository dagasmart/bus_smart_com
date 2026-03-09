<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; // 关键：继承自 MongoDB 的 Model

class MongoModel extends Model
{
    // 选择连接数据库 /config/database.php
    protected $connection = 'mongodb';
    // 数据集合表
    protected string $collection = 'admin';
    // 数据结构字段
    protected $fillable = ['guid', 'first_name', 'family_name', 'email', 'address'];



}
