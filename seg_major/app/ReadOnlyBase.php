<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class ReadOnlyBase
{
    //
    protected $array = [];

    /**
     * @return array
     */
    public function all()
    {
        return $this->array;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get( $key )
    {
        return $this->array[$key];
    }
}