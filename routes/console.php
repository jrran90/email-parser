<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:parse-emails')->everyTenSeconds(); // testing purposes
//Schedule::command('app:parse-emails')->hourly();
