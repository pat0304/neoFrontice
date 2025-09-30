<?php

namespace App\Traits;

trait CrudAction
{
    public function crud()
    {
        return [
            $this->create(),
            $this->read(),
            $this->update(),
            $this->delete(),
        ];
    }
    public function create()
    {
        return "{$this->value}.create";
    }
    public function read()
    {
        return "{$this->value}.read";
    }
    public function update()
    {
        return "{$this->value}.update";
    }
    public function delete()
    {
        return "{$this->value}.delete";
    }
}
