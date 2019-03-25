<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class Common extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }



    public static function colors()
    {

    	return ['blue', 'yellow', 'red', 'magenta', 'green', 'violet', 'gray', 'brown', 'purple', 'orange'];

    } 


    public static function format_date($date)
    {

        return date('F d, Y', strtotime($date));
    }



    public static function format_currency($value)

    {

        $value =number_format($value,2);

        $value = "$".$value;

            return $value;

    }





}// end class

