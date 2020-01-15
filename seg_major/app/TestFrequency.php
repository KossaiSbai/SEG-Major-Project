<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestFrequency extends ReadOnlyBase
{
    protected $array = ['one_week' => 'One Week', 'two_weeks' => 'Two Weeks', 'one_month' => 'One Month','three_months' => 'Three Months', 'six_months' => 'Six Months'];

}
