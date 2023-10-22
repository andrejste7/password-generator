<?php

namespace App\Helpers;

use http\Exception\InvalidArgumentException;

class PasswordGenerator implements PasswordGeneratorInterface
{
    const LOWER_CASE = "abcdefghijklmnopqrstuvwxyz";
    const UPPER_CASE = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const NUMBERS = "1234567890";

    private array $available_symbols = [];

    /**
     * Validate input and perform password generation
     *
     * @param int $length
     * @param array|null $affix_list
     * @return array
     */
    public function generate(int $length, null|array $affix_list): array
    {
        $return_data = [
            "success" => true,
            "error_list" => [],
            "password" => ""
        ];

        $error_list = $this->validate($length, $affix_list);
        if (count($error_list) > 0) {
            $return_data['success'] = false;
            $return_data['error_list'] = $error_list;
            return $return_data;
        }

        $this->getAvailableSymbols($affix_list);
        $random_string = $this->generateRandomSymbols($length);
        $unique_password = $this->ensureOneSymbolOfEachSet($random_string);
        $return_data['password'] = str_shuffle($unique_password);

        return $return_data;
    }

    /**
     * Validates input of password generator
     *
     * @param int $length
     * @param array|null $affix_list
     * @return array
     */
    public function validate(int $length, null|array $affix_list): array
    {
        $error_list = [];
        $max_length = 0;

        if ($length < 6) {
            $error_list['length_error'] = "Password must be at least 6 symbols long";
            return $error_list;
        }

        if (!isset($affix_list)) {
            $error_list['empty_affix_list'] = "Can not generate password with no affixes selected";
            return $error_list;
        }

        if (in_array('numbers', $affix_list)) {
            $max_length += strlen(self::NUMBERS);
        }

        if (in_array('upper_case', $affix_list)) {
            $max_length += strlen(self::UPPER_CASE);
        }

        if (in_array('lower_case', $affix_list)) {
            $max_length += strlen(self::LOWER_CASE);
        }

        if ($length > $max_length) {
            $error_list['length_exceeded'] = "Can not generate password of unique symbols since given password length exceeds amount of unique symbols";
        }

        return $error_list;
    }

    /**
     * Iterate over available symbols to ensure that
     * every required symbol is present in generated
     * string at least once
     *
     * @param string $random_string
     * @return string
     */
    private function ensureOneSymbolOfEachSet(string $random_string): string
    {
        foreach ($this->available_symbols as $type => $set) {
            switch ($type) {
                case "numbers":
                    if (!preg_match('~[0-9]+~', $random_string)) {
                        $position = mt_rand(0, strlen($random_string) - 1);
                        $random_string[$position] = str_shuffle(self::NUMBERS)[0];
                    }
                    break;
                case "upper_case":
                    if (!preg_match('~[A-Z]+~', $random_string)) {
                        $position = mt_rand(0, strlen($random_string) - 1);
                        $random_string[$position] = str_shuffle(self::UPPER_CASE)[0];
                    }
                    break;
                case "lower_case":
                    if (!preg_match('~[a-z]+~', $random_string)) {
                        $position = mt_rand(0, strlen($random_string) - 1);
                        $random_string[$position] = str_shuffle(self::LOWER_CASE)[0];
                    }
                    break;
                default:
                    throw new InvalidArgumentException();
            }
        }

        return $random_string;
    }

    /**
     * Initial random string generation
     *
     * @param int $length
     * @return string
     */
    private function generateRandomSymbols(int $length): string
    {
        return substr(str_shuffle(join('', array_values($this->available_symbols))), 0, $length);
    }

    /**
     * Determines which sets of symbols to take
     * to perform random string generation
     *
     * @param array $affix_list
     * @return void
     */
    private function getAvailableSymbols(array $affix_list): void
    {
        $available_symbols = [];

        if (in_array('numbers', $affix_list)) {
            $available_symbols['numbers'] = self::NUMBERS;
        }

        if (in_array('upper_case', $affix_list)) {
            $available_symbols['upper_case'] = self::UPPER_CASE;
        }

        if (in_array('lower_case', $affix_list)) {
            $available_symbols['lower_case'] = self::LOWER_CASE;
        }

        $this->available_symbols = $available_symbols;
    }
}
