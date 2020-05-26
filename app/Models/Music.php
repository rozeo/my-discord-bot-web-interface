<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    const POSTFIX = ['bytes', 'KB', 'MB', 'GB'];

    public function getSize(): string {
        $size = $this->size;

        foreach (self::POSTFIX as $postfix) {
            if ($size < 1024) {
                return sprintf('%.2f %s', $size, $postfix);
            }

            $size /= 1024;
        }

        return sprintf('%.2f %s', $size * 1024, self::POSTFIX[count(self::POSTFIX) - 1]);
    }
}
