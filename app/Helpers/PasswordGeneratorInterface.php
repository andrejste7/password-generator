<?php

namespace App\Helpers;

interface PasswordGeneratorInterface {
    /**
     * Any password generator must include generating
     * function that accepts password length and it
     * affixes list
     *
     * @param int $length
     * @param array|null $affix_list
     * @return array
     */
    public function generate(int $length, null|array $affix_list): array;

    /**
     * Password generator must validate the length
     * and password affix list before performing
     * any action
     *
     * @param int $length
     * @param array|null $affix_list
     * @return array
     */
    public function validate(int $length, null|array $affix_list): array;
}
